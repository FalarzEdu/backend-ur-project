const open = document.getElementById("open");
const close = document.getElementById("close");
const lista = document.getElementById("lista");

open.onclick = () => {
  lista.style.display = "block";
};

close.onclick = () => {
  lista.style.display = "none";
};
