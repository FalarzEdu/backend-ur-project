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
}
//# sourceMappingURL=Interaction.js.map