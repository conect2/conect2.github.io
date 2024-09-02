// script.js

document.addEventListener('DOMContentLoaded', function() {
    const chatbot = document.getElementById('chatbot');
    const openChatButton = document.getElementById('open-chat');
    const minimizeButton = document.getElementById('minimize-btn');
    const userInput = document.getElementById('user-input');
    const sendButton = document.getElementById('send-btn');
    const chatContent = document.getElementById('chat-content');
    const chatbotButtonContainer = document.getElementById('chatbot-button');

    // Mostrar el chatbot
    openChatButton.addEventListener('click', function() {
        chatbot.classList.remove('chatbot-hidden');
        chatbot.classList.add('chatbot-visible');
        chatbotButtonContainer.classList.add('hidden'); // Ocultar el botón de chat
    });

    // Minimizar el chatbot
    minimizeButton.addEventListener('click', function() {
        if (chatbot.classList.contains('chatbot-visible')) {
            chatbot.classList.remove('chatbot-visible');
            chatbot.classList.add('chatbot-hidden');
            chatbotButtonContainer.classList.remove('hidden'); // Mostrar el botón de chat
        } else {
            chatbot.classList.remove('chatbot-hidden');
            chatbot.classList.add('chatbot-visible');
            chatbotButtonContainer.classList.add('hidden'); // Ocultar el botón de chat
        }
    });

    // Enviar un mensaje
    sendButton.addEventListener('click', async function() {
        const message = userInput.value.trim();
        if (message) {
            const userMessage = document.createElement('p');
            userMessage.textContent = `Tú: ${message}`;
            chatContent.appendChild(userMessage);
            userInput.value = '';

            // Enviar mensaje al backend y obtener respuesta
            try {
                const response = await fetch('http://localhost/api/max.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                const botResponse = document.createElement('p');
                botResponse.textContent = `Max: ${data.response}`;
                chatContent.appendChild(botResponse);
                chatContent.scrollTop = chatContent.scrollHeight; // Desplazar hacia abajo
            } catch (error) {
                const botResponse = document.createElement('p');
                botResponse.textContent = `Max: Ocurrió un error al procesar tu mensaje.`;
                chatContent.appendChild(botResponse);
            }
        }
    });

    // Enviar mensaje al presionar Enter
    userInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            sendButton.click();
        }
    });
});
