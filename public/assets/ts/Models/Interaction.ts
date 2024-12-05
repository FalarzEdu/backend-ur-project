export default class Interaction
{

    /* PUBLIC METHODS ##################################### */

    public static toggleDisplayFlex(element: HTMLElement): void
    {        
        if (element.classList.contains("hidden"))
        {
            element.classList.remove("hidden");
            element.classList.add("flex");
        }
        else
        {
            element.classList.remove("flex");
            element.classList.add("hidden");
        }
    }

    /* PRIVATE METHODS #################################### */

}