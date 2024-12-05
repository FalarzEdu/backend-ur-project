export default class Interaction {
    static toggleDisplay(element) {
        if (element.classList.contains("hidden")) {
            element.classList.remove("hidden");
            element.classList.add("block");
        }
        else {
            element.classList.remove("block");
            element.classList.add("hidden");
        }
    }
}
//# sourceMappingURL=Interaction.js.map