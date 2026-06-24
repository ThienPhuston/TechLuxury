/**
 * TECHLUXURY AI CHATBOT CONTROLLER
 * Handles floating UI toggle, session persistent chat history, and API communication.
 */
document.addEventListener("DOMContentLoaded", function () {
    // 1. Create and inject chatbot HTML structure into footer if not present
    injectChatbotHTML();

    // 2. Select DOM elements
    const chatBubble = document.getElementById("ai-chat-bubble");
    const chatWindow = document.getElementById("ai-chat-window");
    const chatCloseBtn = document.getElementById("ai-chat-close");
    const chatBody = document.getElementById("ai-chat-body");
    const chatInput = document.getElementById("ai-chat-input");
    const chatSendBtn = document.getElementById("ai-chat-send");
    const suggestionBtns = document.querySelectorAll(".ai-suggest-btn");

    // Path prefix check (find root path relative to page)
    const isSubPage = window.location.pathname.includes("/page/") || window.location.pathname.includes("/Account/") || window.location.pathname.includes("/admin/");
    const apiPath = isSubPage ? "../api/ai-chat.php" : "api/ai-chat.php";

    // Chat memory history
    let chatHistory = [];

    // Load history from session storage if exists
    if (sessionStorage.getItem("techluxury_ai_history")) {
        try {
            chatHistory = JSON.parse(sessionStorage.getItem("techluxury_ai_history"));
            renderHistory();
        } catch (e) {
            chatHistory = [];
        }
    } else {
        // Show default bot welcome message
        showWelcomeMessage();
    }

    // Toggle Chat Panel
    chatBubble.addEventListener("click", () => {
        chatWindow.classList.toggle("active");
        if (chatWindow.classList.contains("active")) {
            chatInput.focus();
            scrollToBottom();
        }
    });

    chatCloseBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        chatWindow.classList.remove("active");
    });

    // Close on escape key
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && chatWindow.classList.contains("active")) {
            chatWindow.classList.remove("active");
        }
    });

    // Submit input triggers
    chatSendBtn.addEventListener("click", submitMessage);
    chatInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            submitMessage();
        }
    });

    // Suggestion chips triggers
    suggestionBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const query = btn.getAttribute("data-query");
            if (query) {
                sendUserMessage(query);
            }
        });
    });

    // Function to submit typed message
    function submitMessage() {
        const text = chatInput.value.trim();
        if (!text) return;
        chatInput.value = "";
        sendUserMessage(text);
    }

    // Process user input
    function sendUserMessage(text) {
        // Add to UI
        appendMessage("user", text);
        scrollToBottom();

        // Add to history
        chatHistory.push({ role: "user", text: text });
        saveHistory();

        // Show typing indicator
        showTypingIndicator();

        // Send API request
        fetch(apiPath, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                message: text,
                history: chatHistory.slice(0, -1) // Send history excluding current message to avoid duplicates
            })
        })
        .then(res => res.json())
        .then(data => {
            removeTypingIndicator();
            if (data.status === "success" && data.reply) {
                appendMessage("bot", data.reply);
                chatHistory.push({ role: "model", text: data.reply });
                saveHistory();
            } else {
                const errMsg = "Dạ, TechLuxury xin lỗi vì hệ thống gặp gián đoạn khi kết nối với máy chủ AI. Quý khách vui lòng thử lại sau ít phút.";
                appendMessage("bot", errMsg);
            }
            scrollToBottom();
        })
        .catch(err => {
            console.error("AI Chat Error:", err);
            removeTypingIndicator();
            appendMessage("bot", "Dạ, kết nối mạng gặp sự cố. Quý khách vui lòng kiểm tra kết nối internet hoặc thử lại nhé.");
            scrollToBottom();
        });
    }

    // Append a single message bubble to the chat container
    function appendMessage(role, text) {
        const msgDiv = document.createElement("div");
        msgDiv.className = `ai-msg ai-msg-${role === 'user' ? 'user' : 'bot'}`;
        
        const bubble = document.createElement("div");
        bubble.className = "ai-msg-bubble";
        
        // Parse markdown formatting for bot responses
        if (role === 'bot') {
            bubble.innerHTML = parseMarkdown(text);
        } else {
            bubble.innerText = text;
        }

        const time = document.createElement("span");
        time.className = "ai-msg-time";
        const now = new Date();
        time.innerText = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

        msgDiv.appendChild(bubble);
        msgDiv.appendChild(time);
        chatBody.appendChild(msgDiv);
    }

    // Typing indicator helpers
    function showTypingIndicator() {
        const indicator = document.createElement("div");
        indicator.className = "ai-msg ai-msg-bot temp-typing";
        indicator.innerHTML = `
            <div class="ai-msg-bubble">
                <div class="ai-typing-indicator">
                    <div class="ai-typing-dot"></div>
                    <div class="ai-typing-dot"></div>
                    <div class="ai-typing-dot"></div>
                </div>
            </div>
        `;
        chatBody.appendChild(indicator);
        scrollToBottom();
    }

    function removeTypingIndicator() {
        const indicator = chatBody.querySelector(".temp-typing");
        if (indicator) {
            indicator.remove();
        }
    }

    // Scroll chat body to bottom
    function scrollToBottom() {
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // Save history array to Session Storage
    function saveHistory() {
        sessionStorage.setItem("techluxury_ai_history", JSON.stringify(chatHistory));
    }

    // Render loaded history on reload
    function renderHistory() {
        chatBody.innerHTML = "";
        chatHistory.forEach(msg => {
            appendMessage(msg.role === "model" ? "bot" : "user", msg.text);
        });
        scrollToBottom();
    }

    // Display default welcome message
    function showWelcomeMessage() {
        chatBody.innerHTML = "";
        const welcome = "Dạ kính chào quý khách! Tôi là **TechLuxury AI Assistant** 🌟.\n\nTôi có thể giúp gì cho quý khách hôm nay?\n- Tìm kiếm cấu hình & tư vấn chọn máy\n- Kiểm tra trạng thái đơn hàng (nhập mã dạng **TL-xxxx**)\n- Đề xuất sản phẩm khuyến mãi và quà tặng đặc quyền.";
        appendMessage("bot", welcome);
    }

    // Simple light-weight markdown parser
    function parseMarkdown(text) {
        let html = text;
        
        // Clean up basic HTML tags to avoid script injections
        html = html.replace(/</g, "&lt;").replace(/>/g, "&gt;");
        
        // Match headings (### or ##)
        html = html.replace(/^### (.*$)/gim, '<h4>$1</h4>');
        html = html.replace(/^## (.*$)/gim, '<h3>$1</h3>');
        html = html.replace(/^# (.*$)/gim, '<h2>$1</h2>');
        
        // Match bold text (**text**)
        html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        
        // Match italics (*text*)
        html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
        
        // Bullet lists
        let lines = html.split('\n');
        let inList = false;
        for (let i = 0; i < lines.length; i++) {
            let line = lines[i].trim();
            if (line.startsWith("- ")) {
                if (!inList) {
                    lines[i] = '<ul><li>' + line.substring(2) + '</li>';
                    inList = true;
                } else {
                    lines[i] = '<li>' + line.substring(2) + '</li>';
                }
            } else {
                if (inList) {
                    lines[i] = '</ul>' + lines[i];
                    inList = false;
                }
            }
        }
        if (inList) {
            lines.push('</ul>');
        }
        html = lines.join('\n');
        
        // Convert plain newlines to <br> unless they're adjacent to structural elements
        html = html.replace(/\n/g, '<br>');
        html = html.replace(/<br><ul>/g, '<ul>');
        html = html.replace(/<\/ul><br>/g, '</ul>');
        html = html.replace(/<br><li>/g, '<li>');
        html = html.replace(/<\/li><br>/g, '</li>');
        html = html.replace(/<br><h4>/g, '<h4>');
        html = html.replace(/<\/h4><br>/g, '</h4>');
        html = html.replace(/<br><h3>/g, '<h3>');
        html = html.replace(/<\/h3><br>/g, '</h3>');
        
        return html;
    }

    // Dynamic HTML injection for chatbot wrapper
    function injectChatbotHTML() {
        if (document.getElementById("ai-chat-bubble")) return; // Already exists
        
        const wrapper = document.createElement("div");
        wrapper.innerHTML = `
            <!-- AI Bubble -->
            <div class="ai-chat-bubble" id="ai-chat-bubble" title="Hỏi trợ lý AI TechLuxury">
                <i class="fas fa-robot"></i>
            </div>
            
            <!-- AI Chat Window -->
            <div class="ai-chat-window" id="ai-chat-window">
                <!-- Header -->
                <div class="ai-chat-header">
                    <div class="ai-chat-header-info">
                        <div class="ai-chat-avatar">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="ai-chat-title-wrapper">
                            <h4>TECHLUXURY AI <span class="ai-chat-status"></span></h4>
                            <span>Hỗ trợ trực tuyến 24/7</span>
                        </div>
                    </div>
                    <button class="ai-chat-close-btn" id="ai-chat-close">&times;</button>
                </div>
                
                <!-- Body (Messages) -->
                <div class="ai-chat-body" id="ai-chat-body"></div>
                
                <!-- Quick Suggestions Chips -->
                <div class="ai-chat-suggestions">
                    <button type="button" class="ai-suggest-btn" data-query="Tư vấn mua Laptop dưới 40 triệu">💻 Laptop &lt; 40tr</button>
                    <button type="button" class="ai-suggest-btn" data-query="iPhone 16 Pro Max giá bao nhiêu và có khuyến mãi gì không?">📱 iPhone 16 Pro Max</button>
                    <button type="button" class="ai-suggest-btn" data-query="Kiểm tra đơn hàng TL-1234">📦 Kiểm tra đơn hàng</button>
                </div>
                
                <!-- Footer (Input field) -->
                <div class="ai-chat-footer">
                    <div class="ai-chat-input-wrapper">
                        <input type="text" id="ai-chat-input" placeholder="Hỏi TechLuxury AI..." autocomplete="off">
                    </div>
                    <button type="button" class="ai-chat-send-btn" id="ai-chat-send">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(wrapper);
    }
});
