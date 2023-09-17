import { Fecha } from "./modules/Fecha.js";
import { buscarCitas } from "./modules/funciones.js";

document.addEventListener('DOMContentLoaded', iniciarAdmin);

const fechaInput = document.querySelector('#fecha');

const fecha = new Fecha;

async function iniciarAdmin() {
    fechaInput.value = fecha.fechaActual();
    buscarCitas(fechaInput.value);

    fechaInput.addEventListener('change', ()=> {
        buscarCitas(fechaInput.value);
    })
}