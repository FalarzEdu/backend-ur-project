import Validation from "../Models/Validation.js";

const INPUTS = document.querySelectorAll("input");

INPUTS.forEach(
    (element) => 
    {
    element.addEventListener("blur", function (event: Event) 
    {
        const thisElm = event.currentTarget as HTMLInputElement;
        const user_email = new Validation(thisElm);

        user_email.runValidation();
    });
});
