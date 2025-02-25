export default class FlashMessage
{
    public static create(
        message: string, 
        type: "success" | "danger"
    ): void
    {
        const div = document.createElement("div");
        div.classList.add("alert-message", `alert-${type}`);
        div.textContent = message;
        document.body.appendChild(div);

        // const element = document.querySelector(".alert-message");
        setTimeout(() => {
            div.remove();
        }, 5000);
    }

    public static removeAll(): void
    {
        const flashMessages = document.querySelectorAll(".alert-message");

        flashMessages.forEach((message) => 
            {
                message.remove();
            }
        );
    }
}