export default class Interaction
{

    /* PUBLIC METHODS ##################################### */

    public static toggleDisplay(element: HTMLElement): void
    {
        if (element.classList.contains("hidden"))
        {
            element.classList.remove("hidden");
            element.classList.add("block");
        }
        else
        {
            element.classList.remove("block");
            element.classList.add("hidden");
        }
    }

    /* PRIVATE METHODS #################################### */

}