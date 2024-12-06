import Validation from "../Models/Validation.js";
const INPUTS = document.querySelectorAll("input");
INPUTS.forEach((element) => {
    element.addEventListener("blur", function (event) {
        const thisElm = event.currentTarget;
        const user_email = new Validation(thisElm);
        user_email.runValidation();
    });
});
//# sourceMappingURL=login.js.map