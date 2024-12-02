console.log("novo");

let open = document.getElementById("open");
let close = document.getElementById("close");
let lista = document.getElementById("lista");

open.onclick = () => {
  lista.style.display = "block";
};

close.onclick = () => {
    lista.style.display = "none";
}