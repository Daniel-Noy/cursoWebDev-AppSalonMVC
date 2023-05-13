function iniciarApp(){buscarPorFecha()}function buscarPorFecha(){document.querySelector("#fecha").addEventListener("input",e=>{const n=e.target.value;n&&(window.location="?fecha="+n)})}document.addEventListener("DOMContentLoaded",()=>iniciarApp());
//# sourceMappingURL=buscador.js.map
