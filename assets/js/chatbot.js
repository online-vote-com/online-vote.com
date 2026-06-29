const icon = document.getElementById("chatbot-icon");
const box = document.getElementById("chatbot");
const close = document.getElementById("close-chat");

icon.onclick = function () {
    box.style.display = "flex";
    icon.style.display = "none";
}

close.onclick = function () {
    box.style.display = "none";
    icon.style.display = "flex";
}

document.getElementById("send").onclick = function () {

    let msg = document.getElementById("message").value;

    if (msg === "") return;

    let body = document.getElementById("chat-body");

    body.innerHTML += `
        <div class="user-message">${msg}</div>
    `;

    fetch("chatbot/reponse.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "message=" + encodeURIComponent(msg)
    })

    .then(r => r.text())
    .then(rep => {

        body.innerHTML += `
            <div class="bot-message">${rep}</div>
        `;

        body.scrollTop = body.scrollHeight;
    });

    document.getElementById("message").value = "";
}