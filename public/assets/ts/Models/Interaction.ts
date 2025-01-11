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

    public static toggleDisplayBlock(element: HTMLElement): void
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

    public static hide(element: HTMLElement): void
    {
        element.classList.remove("flex");
        element.classList.remove("block");
        element.classList.add("hidden");
    }

    public static selectButton(button: HTMLElement): void
    {
        const button_parent = button.parentElement;
        const buttons = button_parent?.querySelectorAll(".btn-choice");

        if (!buttons) return;

        buttons.forEach(element => {
            element.classList.remove("active-btn");
        });

        button.classList.add("active-btn");
    }

    public static selectProggressive(element: HTMLElement, element_name: string): void
    {   
        if (!element || !element.parentElement) return;
        const element_parent = element.parentElement.parentElement!;
        const elements = element_parent.querySelectorAll(
            "." + element_name
        );
        elements.forEach(element => 
        {
            element.classList.remove("fa-solid");
            element.classList.add("fa-regular");
        });
        for (let i = 1; i <= Number(element.getAttribute("data-value")); i++) 
        {
            const activating_element = document.querySelector(`.${element_name}-${i}`);
            activating_element?.classList.remove("fa-regular");
            activating_element?.classList.add("fa-solid");
        } 
    }

    /* PRIVATE METHODS #################################### */

}