import Interaction from "../Models/Interaction.js";

function mostrar_campos_pertinentes()
{

    Interaction.hide(
        document.querySelector("#danos-a-saude")!
    );
    Interaction.hide(
        document.querySelector("#avaliacao-feedback")!
    );

    const choice: HTMLInputElement = document.querySelector("#feedback-type-select")!;
    switch(choice.value) 
    {
        case "complaint":
            Interaction.toggleDisplayBlock(
                document.querySelector("#danos-a-saude")!
            );
            break;
        case "compliment":
            Interaction.toggleDisplayBlock(
                document.querySelector("#avaliacao-feedback")!
            );
            break;
        default:
            return;
    }
}

document.querySelector("#feedback-type-select")?.addEventListener(
    "change", function() 
    {
        mostrar_campos_pertinentes();
    } 
);

const stars = document.querySelectorAll(".rating-star");
stars.forEach(element => 
{
    element.addEventListener("click", function(event: Event)
    {
        Interaction.selectProggressive(event.target as HTMLElement, "rating-star");
    });
});

window.addEventListener("load", function() 
    {
        mostrar_campos_pertinentes();

        const buttons = document.querySelectorAll(".btn-choice");
        buttons.forEach(element => 
        {
            element.addEventListener("click", function(event: Event) 
            {
                Interaction.selectButton(event.target as HTMLElement);
            });
        });
    }
);

