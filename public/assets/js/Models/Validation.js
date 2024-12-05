export default class Validation {
    constructor(element) {
        this.element = element;
        const pattern = element.getAttribute("pattern");
        this.regex = pattern ? new RegExp(pattern) : undefined;
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
        this.setValidField();
    }
    testRegex() {
        var _a;
        const ELEMENT_VAL = (this.element.value);
        if (!((_a = this.regex) === null || _a === void 0 ? void 0 : _a.test(ELEMENT_VAL))) {
            return false;
        }
        ;
        return true;
    }
    setInvalidField(message) {
        if (!this.element.nextElementSibling) {
            return;
        }
        const INVALID_FIELD = this.element.nextElementSibling;
        INVALID_FIELD.classList.remove("invisible");
        INVALID_FIELD.classList.add("visible");
        INVALID_FIELD.innerText = message;
    }
    setValidField() {
        if (!this.element.nextElementSibling) {
            return;
        }
        const VALID_FIELD = this.element.nextElementSibling;
        VALID_FIELD.classList.remove("visible");
        VALID_FIELD.classList.add("invisible");
    }
}
//# sourceMappingURL=Validation.js.map