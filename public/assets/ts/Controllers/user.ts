import Interaction from "../Models/Interaction.js";

const openMenuBtn: HTMLElement = document.getElementById("open-menu")!;
const closeMenuBtn: HTMLElement = document.getElementById("close-menu")!;
const menuList: HTMLElement = document.getElementById("menu-list")!;

const menuButtons = [openMenuBtn, closeMenuBtn];

menuButtons.forEach((button) => 
{
    button.addEventListener("click", () => 
    {
        Interaction.toggleDisplayFlex(menuList);
    });
});
