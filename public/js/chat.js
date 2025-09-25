const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault(); // Prevenir recarga de la página
};

form.querySelector("button").onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = ""; // Limpiar el campo de entrada
                scrollToBottom();
            }
        }
    };
    let formData = new FormData(form);
    xhr.send(formData);
};

// Cargar mensajes automáticamente
setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                chatBox.innerHTML = xhr.responseText;
                scrollToBottom();
            }
        }
    };
    let formData = new FormData();
    formData.append("incoming_id", incoming_id);
    xhr.send(formData);
}, 500);