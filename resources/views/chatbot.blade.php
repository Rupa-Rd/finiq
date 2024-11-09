<!-- resources/views/chatbot.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinIQ - Financial IQ</title>
    <link rel="stylesheet" href="http://158.247.243.239/css/chatbot.css">
    <link rel="preconnect" href="http://fonts.googleapis.com">
<link rel="preconnect" href="http://fonts.gstatic.com" crossorigin>
<link href="http://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz@0,6..96;1,6..96&family=Della+Respira&family=Faculty+Glyphic&family=Marhey:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>
<div class="chat-container">
    <h1>FinIQ</h1>
    <div id="chat-box" class="chat-box">
        <center><p>Smart Money, Smarter You – Powered by <strong>FinIQ</strong></p></center>
    </div>
    <div class="input-area">
        <textarea id="userMessage" placeholder="Type your message..."></textarea>
        <button onclick="sendMessage()">Send</button>
    </div>
</div>

<script>
    function sendMessage() {
        const userMessage = document.getElementById('userMessage').value;

        // Add user message to chat box aligned to the right
        const chatBox = document.getElementById('chat-box');
        const userBubble = `<div class="message user-message">${userMessage}</div>`;
        chatBox.innerHTML += userBubble;

        // Clear the input field
        document.getElementById('userMessage').value = '';

        // Fetch AI response
        fetch('http://158.247.243.239/api/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: userMessage })
        })
        .then(response => response.json())
        .then(data => {
            // Add AI response to chat box aligned to the left
            if (data.response) {
                const botBubble = `<div class="message bot-message">${data.response}</div>`;
                chatBox.innerHTML += botBubble;
                chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the latest message
            } else {
                chatBox.innerHTML += `<div class="message bot-message">Error: ${data.error || 'Unknown error'}</div>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
</body>
</html>
