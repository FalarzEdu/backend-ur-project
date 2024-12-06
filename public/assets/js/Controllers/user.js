import Interaction from "../Models/Interaction.js";
const openMenuBtn = document.getElementById("open-menu");
const closeMenuBtn = document.getElementById("close-menu");
const menuList = document.getElementById("menu-list");
const menuButtons = [openMenuBtn, closeMenuBtn];
menuButtons.forEach((button) => {
    button.addEventListener("click", () => {
        Interaction.toggleDisplayFlex(menuList);
    });
});
//# sourceMappingURL=user.js.map