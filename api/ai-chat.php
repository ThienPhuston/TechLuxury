<?php
header("Content-Type: application/json; charset=utf-8");
session_start();

// Load Database & Config
$project_root = str_replace('\\', '/', realpath(dirname(dirname(__FILE__))));
require_once $project_root . '/includes/db.php';

// Retrieve request body
$input = json_decode(file_get_contents('php://input'), true);
$message = isset($input['message']) ? trim($input['message']) : '';
$history = isset($input['history']) ? $input['history'] : [];

if (empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Nội dung tin nhắn không được để trống.']);
    exit;
}

// 1. Fetch products list from DB for AI Context
$products = [];
try {
    $stmt = $conn->query("
        SELECT p.name, p.price, p.stock, p.category, p.specs, b.display_name AS brand 
        FROM products p 
        LEFT JOIN brands b ON p.brand_id = b.id
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Silent fail or fallback
}

// 2. Detect order code (e.g. TL-1234) to query DB
$order_details = null;
if (preg_match('/TL-\d+/i', $message, $matches)) {
    $order_code = strtoupper($matches[0]);
    try {
        $order_stmt = $conn->prepare("SELECT * FROM orders WHERE order_code = ?");
        $order_stmt->execute([$order_code]);
        $order = $order_stmt->fetch(PDO::FETCH_ASSOC);
        if ($order) {
            $items_stmt = $conn->prepare("SELECT product_name, price, quantity FROM order_items WHERE order_id = ?");
            $items_stmt->execute([$order['id']]);
            $items = $items_stmt->fetchAll(PDO::FETCH_ASSOC);
            $order_details = [
                'code' => $order['order_code'],
                'customer' => $order['customer_name'],
                'phone' => $order['phone'],
                'address' => $order['address'],
                'payment_method' => $order['payment_method'],
                'total' => $order['total_amount'],
                'status' => $order['status'],
                'date' => $order['created_at'],
                'items' => $items
            ];
        }
    } catch (PDOException $e) {
        // Silent fail
    }
}

// 3. Build System Instruction for Gemini
$system_instruction = "Bạn là trợ lý ảo AI cao cấp và thân thiện của cửa hàng công nghệ TECHLUXURY (chuyên cung cấp Laptop, Điện thoại, Phụ kiện cao cấp chính hãng).
Nhiệm vụ của bạn là tư vấn sản phẩm, so sánh thông số, hỗ trợ kiểm tra đơn hàng và chọn mua sản phẩm phù hợp ngân sách của khách hàng một cách chuyên nghiệp, thanh lịch và tin cậy.

Dưới đây là thông tin sản phẩm thực tế đang kinh doanh tại cửa hàng (luôn ưu tiên gợi ý các sản phẩm này):
";

foreach ($products as $p) {
    $specs = !empty($p['specs']) ? " - Cấu hình: " . $p['specs'] : "";
    $stock_status = $p['stock'] > 0 ? "Còn hàng (kho: " . $p['stock'] . ")" : "Hết hàng";
    $system_instruction .= "- " . $p['name'] . " (thương hiệu " . $p['brand'] . ", danh mục " . $p['category'] . "): Giá " . number_format($p['price'], 0, '', '.') . "đ. Trạng thái: " . $stock_status . $specs . "\n";
}

if ($order_details) {
    $system_instruction .= "\nThông tin đơn hàng khách hàng vừa hỏi truy vấn được từ hệ thống:\n";
    $system_instruction .= "- Mã đơn hàng: " . $order_details['code'] . "\n";
    $system_instruction .= "- Khách hàng: " . $order_details['customer'] . " (SĐT: " . $order_details['phone'] . ")\n";
    $system_instruction .= "- Địa chỉ nhận hàng: " . $order_details['address'] . "\n";
    $system_instruction .= "- Phương thức thanh toán: " . strtoupper($order_details['payment_method']) . "\n";
    $system_instruction .= "- Tổng thanh toán: " . number_format($order_details['total'], 0, '', '.') . "đ\n";
    $system_instruction .= "- Trạng thái vận chuyển/thanh toán: " . $order_details['status'] . "\n";
    $system_instruction .= "- Thời gian đặt hàng: " . $order_details['date'] . "\n";
    $system_instruction .= "- Chi tiết mặt hàng:\n";
    foreach ($order_details['items'] as $item) {
        $system_instruction .= "  + " . $item['product_name'] . " (Số lượng: " . $item['quantity'] . ", Đơn giá: " . number_format($item['price'], 0, '', '.') . "đ)\n";
    }
} else {
    $system_instruction .= "\nNếu khách hàng hỏi về một đơn hàng cụ thể, hãy lịch sự nhắc họ cung cấp mã đơn hàng (định dạng TL-xxxx, ví dụ: TL-1234) để bạn tra cứu.\n";
}

$system_instruction .= "\nNGUYÊN TẮC TRẢ LỜI:
1. Bạn CHỈ giới thiệu các sản phẩm thực tế có trong danh sách trên. Tuyệt đối không bịa đặt sản phẩm khác.
2. Trả lời bằng tiếng Việt, dùng đại từ nhân xưng phù hợp (ví dụ: 'TechLuxury', 'Dạ', 'Quý khách').
3. Sử dụng Markdown để định dạng câu trả lời đẹp mắt: xuống dòng, in đậm tên sản phẩm/giá tiền để khách dễ đọc.
4. Nếu sản phẩm hết hàng, tư vấn sản phẩm thay thế cùng phân khúc còn hàng.";

// 4. Send request to Gemini or Fallback to Smart Mock Mode
$api_key = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : '';

if (empty($api_key)) {
    // --- SMART MOCK MODE (FALLBACK) ---
    $reply = handleMockChat($message, $products, $order_details);
    echo json_encode([
        'status' => 'success',
        'reply' => $reply,
        'mode' => 'demo'
    ]);
    exit;
}

// --- CALL GEMINI API VIA CURL ---
// Prepare history contents for Gemini API (Gemini expects messages in 'contents' parameter)
$contents = [];

// Append history
foreach ($history as $msg) {
    $role = (isset($msg['role']) && $msg['role'] === 'user') ? 'user' : 'model';
    $text = isset($msg['text']) ? $msg['text'] : '';
    if (!empty($text)) {
        $contents[] = [
            'role' => $role,
            'parts' => [['text' => $text]]
        ];
    }
}

// Append current user message
$contents[] = [
    'role' => 'user',
    'parts' => [['text' => $message]]
];

$payload = [
    'contents' => $contents,
    'systemInstruction' => [
        'parts' => [['text' => $system_instruction]]
    ],
    'generationConfig' => [
        'temperature' => 0.7,
        'maxOutputTokens' => 1200
    ]
];

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $api_key;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Allow localhost environment connections without certificate issues

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($response === false || $http_code !== 200) {
    // If external call fails due to connection or invalid key, gracefully fallback to mock
    $mock_reply = handleMockChat($message, $products, $order_details);
    $error_msg = !empty($error) ? $error : "HTTP Code $http_code";
    echo json_encode([
        'status' => 'success',
        'reply' => $mock_reply . "\n\n*(Lưu ý: Hệ thống vừa chuyển sang chế độ Demo do kết nối tới Gemini API gặp sự cố hoặc API Key không hợp lệ: " . htmlspecialchars($error_msg) . ")*",
        'mode' => 'demo-fallback'
    ]);
    exit;
}

$res_data = json_decode($response, true);
$reply = "";
if (isset($res_data['candidates'][0]['content']['parts'][0]['text'])) {
    $reply = $res_data['candidates'][0]['content']['parts'][0]['text'];
} else {
    $reply = "Dạ, TechLuxury xin lỗi vì hệ thống gặp gián đoạn nhỏ khi xử lý câu trả lời. Quý khách có thể thử lại hoặc gửi câu hỏi khác nhé.";
}

echo json_encode([
    'status' => 'success',
    'reply' => $reply,
    'mode' => 'live'
]);

/**
 * Smart Local Mock Bot Fallback
 */
function handleMockChat($msg, $products, $order_details) {
    $msg_lower = mb_strtolower($msg, 'UTF-8');
    
    // 1. Order status requested
    if ($order_details) {
        $reply = "### 📦 Thông tin đơn hàng **" . $order_details['code'] . "**\n\n";
        $reply .= "- **Khách hàng**: " . $order_details['customer'] . "\n";
        $reply .= "- **Địa chỉ nhận**: " . $order_details['address'] . "\n";
        $reply .= "- **Trạng thái**: 🔔 **" . $order_details['status'] . "**\n";
        $reply .= "- **Tổng tiền**: **" . number_format($order_details['total'], 0, '', '.') . "đ**\n";
        $reply .= "- **Sản phẩm đã mua**:\n";
        foreach ($order_details['items'] as $item) {
            $reply .= "  + " . $item['product_name'] . " x" . $item['quantity'] . "\n";
        }
        $reply .= "\nĐơn hàng đang được xử lý trong hệ thống của **TechLuxury**. Quý khách cần hỗ trợ thêm vui lòng liên hệ hotline: **0794923325**.";
        return $reply;
    }
    
    if (strpos($msg_lower, 'đơn hàng') !== false || strpos($msg_lower, 'kiểm tra đơn') !== false) {
        return "Dạ, để kiểm tra trạng thái đơn hàng, quý khách vui lòng cung cấp mã đơn hàng cụ thể (ví dụ: **TL-1234** hoặc mã có sẵn của quý khách) để hệ thống tra cứu lập tức.";
    }

    // 2. Specific product search
    $matched_products = [];
    foreach ($products as $p) {
        if (mb_strpos(mb_strtolower($p['name'], 'UTF-8'), $msg_lower) !== false || 
            mb_strpos(mb_strtolower($p['category'], 'UTF-8'), $msg_lower) !== false ||
            mb_strpos(mb_strtolower($p['brand'], 'UTF-8'), $msg_lower) !== false) {
            $matched_products[] = $p;
        }
    }
    
    if (!empty($matched_products)) {
        $reply = "Dạ, TechLuxury tìm thấy các sản phẩm liên quan đến yêu cầu của quý khách:\n\n";
        foreach ($matched_products as $p) {
            $specs = !empty($p['specs']) ? " (" . $p['specs'] . ")" : "";
            $status = $p['stock'] > 0 ? "Còn hàng" : "Hết hàng";
            $reply .= "- **" . $p['name'] . "** - Giá: **" . number_format($p['price'], 0, '', '.') . "đ** | *" . $status . "*" . $specs . "\n";
        }
        $reply .= "\nQuý khách muốn xem chi tiết hay thêm sản phẩm nào vào giỏ hàng ạ?";
        return $reply;
    }

    // 3. Price-based queries
    if (strpos($msg_lower, 'dưới') !== false || strpos($msg_lower, 'tầm giá') !== false || strpos($msg_lower, 'triệu') !== false) {
        // Find price numbers
        preg_match_all('/\d+/', $msg_lower, $price_matches);
        if (!empty($price_matches[0])) {
            $limit_million = intval($price_matches[0][0]);
            $limit_price = $limit_million * 1000000;
            if ($limit_million < 1000) { // e.g. "30 triệu"
                $suggested = [];
                foreach ($products as $p) {
                    if ($p['price'] <= $limit_price) {
                        $suggested[] = $p;
                    }
                }
                if (!empty($suggested)) {
                    $reply = "Dạ, trong tầm giá dưới **" . number_format($limit_price, 0, '', '.') . "đ**, TechLuxury đề xuất các sản phẩm sau:\n\n";
                    foreach (array_slice($suggested, 0, 4) as $p) {
                        $reply .= "- **" . $p['name'] . "** - Giá: **" . number_format($p['price'], 0, '', '.') . "đ** (" . $p['specs'] . ")\n";
                    }
                    return $reply;
                }
            }
        }
    }

    // 4. Default greetings / guides
    return "Dạ chào quý khách! Tôi là **TechLuxury AI Assistant**.\n\n" .
           "Hiện tại hệ thống AI đang ở chế độ **Demo** (chưa cấu hình API Key thực tế). Tuy nhiên, tôi vẫn có thể hỗ trợ quý khách:\n" .
           "1. Tìm kiếm và giới thiệu sản phẩm (ví dụ: gõ '*Macbook*', '*iPhone 16*', '*Phụ kiện*')\n" .
           "2. Tra cứu trạng thái đơn hàng (ví dụ: gõ mã đơn hàng '**TL-1234**' nếu bạn đã tạo đơn)\n\n" .
           "Quý khách có thể cấu hình **Gemini API Key** tại file `admin/config/config.php` để kích hoạt trợ lý AI thông minh toàn diện!";
}
