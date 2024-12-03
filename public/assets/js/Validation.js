export default class Validation {
    constructor(element) {
        this.element = element;
        const pattern = element.getAttribute("pattern");
        this.regex = pattern ? new RegExp(pattern) : undefined;
    }
    testRegex() {
        var _a, _b;
        const ELEMENT_VAL = ((_a = this.element.getAttribute("value")) !== null && _a !== void 0 ? _a : "");
        if ((_b = this.regex) === null || _b === void 0 ? void 0 : _b.test(ELEMENT_VAL)) {
            return true;
        }
        ;
        return false;
    }
    runValidation(message = "Campo inválido!") {
        if (!this.element.value) {
            this.setInvalidField("Este campo não pode estar vazio!");
            return;
        }
        if (!this.testRegex()) {
            this.setInvalidField(message);
            return;
        }
    }
    setInvalidField(message) {
        if (!this.element.nextElementSibling) {
            return;
        }
        const INVALID_FIELD = this.element.nextElementSibling;
        INVALID_FIELD.classList.add("visible");
        INVALID_FIELD.innerText = message;
    }
}
//# sourceMappingURL=Validation.js.map