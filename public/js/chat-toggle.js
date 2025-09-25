// Seleccionar el ícono de chat y la ventana emergente
const chatIcon = document.getElementById("chatIcon");
const chatWindow = document.getElementById("chatWindow");

// Alternar la visibilidad de la ventana de chat al hacer clic en el ícono
chatIcon.addEventListener("click", () => {
    if (chatWindow.style.display === "none" || chatWindow.style.display === "") {
        chatWindow.style.display = "block"; // Mostrar la ventana de chat
    } else {
        chatWindow.style.display = "none"; // Ocultar la ventana de chat
    }
});

// Cerrar la ventana de chat al hacer clic en el botón de cerrar (si existe)
const closeChat = document.getElementById("closeChat");
if (closeChat) {
    closeChat.addEventListener("click", () => {
        chatWindow.style.display = "none";
    });
}