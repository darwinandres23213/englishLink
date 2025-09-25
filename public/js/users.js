const messageIcon = document.getElementById("messageIcon");
const chatIcon = document.getElementById("chatIcon");
const usersWindow = document.getElementById("usersWindow");
const chatWindow = document.getElementById("chatWindow");
const usersList = document.getElementById("usersList");
const chatHeader = document.getElementById("chatHeader");
const chatBox = document.querySelector(".chat-box");
const inputField = document.querySelector(".input-field");
const sendBtn = document.querySelector(".typing-area button");
const scrollToBottomButton = document.getElementById("scrollToBottom");
let selectedUserId = null;
let isUserAtBottom = true; // NUEVA VARIABLE

// Función para alternar la ventana de usuarios (abrir/cerrar)
function toggleUsersWindow() {
    if (usersWindow.style.display === "block") {
        // Si la ventana de usuarios está visible, la ocultamos
        usersWindow.style.display = "none";
    } else {
        // Si la ventana de usuarios está oculta, la mostramos
        usersWindow.style.display = "block";
        loadUsers(); // Cargar la lista de usuarios
    }

    // Asegurarse de que la ventana de chat esté oculta al abrir la ventana de usuarios
    if (chatWindow) {
        chatWindow.style.display = "none";
    }
}

// Asignar el evento de clic a ambos botones
messageIcon.addEventListener("click", toggleUsersWindow); // Ícono de la parte inferior
chatIcon.addEventListener("click", toggleUsersWindow); // Ícono de la parte superior

// Mostrar la ventana de usuarios y ocultar la ventana de chat
document.getElementById("backToUsers").addEventListener("click", function () {
    chatWindow.style.display = "none";
    usersWindow.style.display = "block";
});

// Cerrar la ventana de usuarios
document.getElementById("closeUsers").addEventListener("click", () => {
    usersWindow.style.display = "none";
});

// Cerrar la ventana de chat
document.getElementById("closeChat").addEventListener("click", function () {
    chatWindow.style.display = "none"; // Oculta la ventana de chat
});

// Cargar la lista de usuarios
function loadUsers() {
    fetch("php/get-users.php")
        .then((response) => response.text())
        .then((data) => {
            usersList.innerHTML = data;

            // Agregar evento de clic a cada usuario
            document.querySelectorAll(".user").forEach((user) => {
                user.addEventListener("click", () => {
                    selectedUserId = user.getAttribute("data-id");
                    const userName = user.querySelector("span").textContent;
                    const userImage = user.querySelector("img").src;

                    // Mostrar el chat con el usuario seleccionado
                    chatHeader.innerHTML = `
                        <img src="${userImage}" alt="Imagen de Perfil" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
                        <span>${userName}</span>
                    `;
                    document.querySelector(".incoming_id").value = selectedUserId;
                    usersWindow.style.display = "none";
                    chatWindow.style.display = "block";
                    loadMessages();
                });
            });
        });
}







// Función para desplazarse al final del chat (sin suavidad)
function scrollToBottomInstant() {
    chatBox.scrollTop = chatBox.scrollHeight; // Desplazamiento instantáneo
}

// Función para desplazarse al final del chat (con suavidad)
function scrollToBottomSmooth() {
    chatBox.scrollTo({
        top: chatBox.scrollHeight,
        behavior: 'smooth' // Desplazamiento suave
    });
}

// Mostrar u ocultar el botón "Scroll to Bottom" según la posición del chat
chatBox.addEventListener("scroll", () => {
    const atBottom = chatBox.scrollHeight - chatBox.scrollTop <= chatBox.clientHeight + 10;
    if (atBottom) {
        scrollToBottomButton.style.display = "none"; // Ocultar el botón si estás al final
    } else {
        scrollToBottomButton.style.display = "flex"; // Mostrar el botón si no estás al final
    }
});

// Evento de clic para el botón "Ir al final"
scrollToBottomButton.addEventListener("click", () => {
    scrollToBottomSmooth(); // Desplazar manualmente al final del chat con suavidad
    isUserAtBottom = true;
});

// Reducir la velocidad de desplazamiento con la rueda del mouse
chatBox.addEventListener("wheel", (e) => {
    e.preventDefault(); // Prevenir el desplazamiento predeterminado
    chatBox.scrollTop += e.deltaY * 0.3; // Ajustar la velocidad (0.3 es el factor de reducción)
});

// Cargar mensajes del usuario seleccionado
function loadMessages() {
    if (selectedUserId) {
        // Guardamos la posición actual ANTES de reemplazar el contenido
        const previousScrollTop = chatBox.scrollTop;
        const previousScrollHeight = chatBox.scrollHeight;

        fetch("php/get-chat.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `incoming_id=${selectedUserId}`,
        })
        .then((response) => response.text())
        .then((data) => {
            chatBox.innerHTML = data;

            // Verificar si el usuario estaba al final antes de la actualización
            const wasAtBottom = previousScrollTop + chatBox.clientHeight >= previousScrollHeight - 10;

            if (wasAtBottom) {
                scrollToBottomInstant(); // Desplazamiento instantáneo si estaba al final
                isUserAtBottom = true;
            } else {
                isUserAtBottom = false;
            }
        });
    }
}







// Enviar mensaje
sendBtn.addEventListener("click", (e) => {
    e.preventDefault(); // Prevenir recarga de la página
    const message = inputField.value.trim();
    if (message && selectedUserId) {
        fetch("php/insert-chat.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `incoming_id=${selectedUserId}&message=${encodeURIComponent(message)}`,
        })
            .then(() => {
                inputField.value = "";
                loadMessages();
            });
    }
});

// Actualizar mensajes automáticamente cada 1 segundo
setInterval(() => {
    if (selectedUserId) {
        loadMessages();
    }
}, 1000);

/*// Desplazar automáticamente hacia abajo
function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}*/

