<!-- resources/views/chatbot.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Chatbot</h1>
    <div id="chat-container">
        <!-- Chat messages will be appended here -->
    </div>
    
    <div>
        <textarea id="userMessage" placeholder="Type your message here..."></textarea>
        <button onclick="sendMessage()">Send</button>
    </div>
    <div id="chatResponse" style="margin-top: 10px; padding: 10px; border: 1px solid #ddd;"></div>

    <script>
        function sendMessage() {
    const userMessage = document.getElementById('userMessage').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/api/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ message: userMessage })
    })
    .then(response => {
        // Ensure response is JSON
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        return response.json();
    })
    .then(data => {
        const chatResponseDiv = document.getElementById('chatResponse');
        if (data.response) {
            chatResponseDiv.innerText = data.response;
            console.log("Chatbot response:", data.response);
        } else {
            chatResponseDiv.innerText = 'An error occurred: ' + (data.error || 'Unknown error');
            console.error("Error:", data.error || 'Unknown error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        document.getElementById('chatResponse').innerText = 'An unexpected error occurred.';
    });
}

    </script>
</body>
</html>
