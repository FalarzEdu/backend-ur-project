export default class FlashMessage {
    static create(message, type) {
        const div = document.createElement("div");
        div.classList.add("alert-message", `alert-${type}`);
        div.textContent = message;
        document.body.appendChild(div);
        setTimeout(() => {
            div.remove();
        }, 5000);
    }
    static removeAll() {
        const flashMessages = document.querySelectorAll(".alert-message");
        flashMessages.forEach((message) => {
            message.remove();
        });
    }
}
//# sourceMappingURL=FlashMessage.js.map