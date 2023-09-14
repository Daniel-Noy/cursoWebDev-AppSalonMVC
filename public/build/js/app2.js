import { Cita } from "./modules/Cita.js";
import { Fecha } from "./modules/Fecha.js";
import { UI } from "./modules/UI.js";

document.addEventListener('DOMContentLoaded', iniciarApp);

const inputId = document.querySelector('#id');
const inputNombre = document.querySelector('#nombre');
const inputFecha = document.querySelector('#fecha');
const inputHora = document.querySelector('#hora');
const paginaAnt = document.querySelector('#anterior');
const paginaSig = document.querySelector('#siguiente');

const ui = new UI;
const fecha = new Fecha;
const cita = new Cita({
    id: inputId.value,
    nombre: inputNombre.value,
    fecha: fecha.fechaActual()
});

function iniciarApp() {
    eventListeners();
    cargarServicios();    
    tabs();

    limitarFechasDisponibles(inputFecha);
    ui.mostrarSeccion();
}

function eventListeners() {
    inputNombre.addEventListener('input', editarNombreCita);
    inputFecha.addEventListener('input', cita.editarFechaCita);
    inputHora.addEventListener('input', cita.editarHoraCita);
    
    paginaAnt.addEventListener('click', ui.paginaAnterior);
    paginaSig.addEventListener('click', ui.paginaSiguiente);
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach( boton => {
        boton.addEventListener('click', (e)=> {
            const boton = e.target;
            ui.paso = parseInt(boton.dataset.paso);
            ui.mostrarSeccion();
            ui.botonesPaginador();
            if(ui.paso === ui.pasoFinal) {
                ui.mostrarResumen(cita);
            }
        })
    })
}

async function obtenerServiciosApi() {
    try {
        const url = `${location.origin}/api/servicios`;
        const res = await fetch(url);
        const servicios = await res.json();
        return servicios;

    }  catch (err) {
        console.log(err);
    }
}

function seleccionarServicios(servicios) {
    const tarjetasServicios = document.querySelectorAll('.servicio');
    tarjetasServicios.forEach(tarjeta => {
        tarjeta.addEventListener('click', (e)=> {
            const servicio = servicios.find(e => e.id === tarjeta.dataset.idServicio);
            cita.seleccionarServicio(e, servicio);
        });
    })
}

async function cargarServicios() {
    const servicios = await obtenerServiciosApi();
    ui.mostrarServicios(servicios);
    seleccionarServicios(servicios);
}

function editarNombreCita() {
    cita.nombre = inputNombre.value.trim()
}

function fechaActual() {
    const fechaActual = new Date();
    const year = fechaActual.toLocaleString("default", { year: "numeric" });
    const mes = fechaActual.toLocaleString("default", { month: "2-digit" });
    const dia = fechaActual.toLocaleString("default", { day: "2-digit" });

    const fechaFormateada = `${year}-${mes}-${dia}`

    return fechaFormateada;
}

function limitarFechasDisponibles() {
    inputFecha.value = fechaActual();
    inputFecha.setAttribute('min', fechaActual());
}