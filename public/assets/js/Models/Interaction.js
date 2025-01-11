export default class Interaction {
    static toggleDisplayFlex(element) {
        if (element.classList.contains("hidden")) {
            element.classList.remove("hidden");
            element.classList.add("flex");
        }
        else {
            element.classList.remove("flex");
            element.classList.add("hidden");
        }
    }
    static toggleDisplayBlock(element) {
        if (element.classList.contains("hidden")) {
            element.classList.remove("hidden");
            element.classList.add("block");
        }
        else {
            element.classList.remove("block");
            element.classList.add("hidden");
        }
    }
    static hide(element) {
        element.classList.remove("flex");
        element.classList.remove("block");
        element.classList.add("hidden");
    }
    static selectButton(button) {
        const button_parent = button.parentElement;
        const buttons = button_parent === null || button_parent === void 0 ? void 0 : button_parent.querySelectorAll(".btn-choice");
        if (!buttons)
            return;
        buttons.forEach(element => {
            element.classList.remove("active-btn");
        });
        button.classList.add("active-btn");
    }
    static selectProggressive(element, element_name) {
        if (!element || !element.parentElement)
            return;
        const element_parent = element.parentElement.parentElement;
        const elements = element_parent.querySelectorAll("." + element_name);
        elements.forEach(element => {
            element.classList.remove("fa-solid");
            element.classList.add("fa-regular");
        });
        for (let i = 1; i <= Number(element.getAttribute("data-value")); i++) {
            const activating_element = document.querySelector(`.${element_name}-${i}`);
            activating_element === null || activating_element === void 0 ? void 0 : activating_element.classList.remove("fa-regular");
            activating_element === null || activating_element === void 0 ? void 0 : activating_element.classList.add("fa-solid");
        }
    }
}
//# sourceMappingURL=Interaction.js.map