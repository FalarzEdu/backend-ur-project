export default class Validation
{
    private element: HTMLInputElement;
    private regex?: RegExp;

    constructor(
        element: HTMLInputElement,
    )
    {
        this.element = element;
        const pattern = element.getAttribute("pattern");
        this.regex = pattern ? new RegExp(pattern) : undefined;
    }

    /* PUBLIC METHODS ################################################# */

    public runValidation(message: string = "Campo inválido!"): void
    {
        if (!this.element.value)
        {
            this.setInvalidField("Este campo não pode estar vazio!");
            return;
        }
        if (!this.testRegex())
        {
            this.setInvalidField(message);
            return;
        }

        this.setValidField();
    }

    /* PRIVATE METHODS ################################################ */

    private testRegex(): boolean
    {
        const ELEMENT_VAL = (
            this.element.value
        );
        if (!this.regex?.test(ELEMENT_VAL))
        {
            return false;
        };

        return true;
    }

    private setInvalidField(message: string): void
    {
        if (!this.element.nextElementSibling)
        {
            return;
        }
        
        const INVALID_FIELD: HTMLElement = this.element.nextElementSibling as HTMLElement;

        INVALID_FIELD.classList.add("visible");
        INVALID_FIELD.innerText = message;
    }

    private setValidField(): void
    {
        if (!this.element.nextElementSibling)
        {
            return;
        }
        
        const VALID_FIELD: HTMLElement = this.element.nextElementSibling as HTMLElement;

        VALID_FIELD.classList.add("invisible");
        VALID_FIELD.innerText = "";
    }

}