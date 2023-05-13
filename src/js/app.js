let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', ()=> {
    iniciarApp();
})

function iniciarApp() {
    mostrarSeccion();   //* Muestra la seccion inicial al entrar a la app

    tabs();             //* Cambia la seccion cuando se presionan los tabs
    botonesPaginador(); //* Agrega o quita los botones del paginador
    paginaSiguiente();  //* Cambia a la pagina sig
    paginaAnterior();   //* Cambia a la pagina anterior
    
    consultarAPI();     //* Consulta la API del Backend

    idCliente();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();

    mostrarResumen();
}

function mostrarSeccion() {
    const seccionAnterior = document.querySelector('.seccion.mostrar');
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }
    
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    // Desmarca el tab anterior si es que existe
    const tabAnterior = document.querySelector('.actual') ?? null;
    if(tabAnterior) {
        tabAnterior.classList.remove('actual');
    }
    
    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');

    botones.forEach( boton => {
        boton.addEventListener('click', (e)=> {
            const boton = e.target;
            paso = parseInt(boton.dataset.paso);
            mostrarSeccion();
            botonesPaginador();

        })
    })
}

function botonesPaginador() {
    const paginaAnt = document.querySelector('#anterior');
    const paginaSig = document.querySelector('#siguiente');

    if(paso === pasoInicial) {
        paginaAnt.classList.add('ocultar');
        paginaSig.classList.remove('ocultar');
    } 
    if (paso === pasoFinal) {
        paginaAnt.classList.remove('ocultar');
        paginaSig.classList.add('ocultar');

        mostrarResumen();
    }
    if(paso > pasoInicial && paso < pasoFinal) {
        paginaSig.classList.remove('ocultar');
        paginaAnt.classList.remove('ocultar');
    }
    mostrarSeccion();
} 


function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', ()=> {
        if(paso === pasoInicial) return;

        paso--;
        botonesPaginador();
    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', ()=> {
        if(paso === pasoFinal) return;

        paso++;
        botonesPaginador();
    })
}

async function consultarAPI() {

    try {
        const url = `${location.origin}/api/servicios`;
        const res = await fetch(url);
        const servicios = await res.json();
        mostrarServicios(servicios)


    }  catch (err) {
        console.log(err);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('DIV');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);
        servicioDiv.onclick = ()=> {
            seleccionarServicio(servicio)
        };

        const seccionServicios = document.querySelector('#servicios');
        seccionServicios.appendChild(servicioDiv);
    })
}

function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    
    if(servicios.some( agregado => agregado.id === id )) {
        cita.servicios = servicios.filter( agregado => agregado.id !== id)
        divServicio.classList.remove('seleccionado');
    } else {
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}

function idCliente() {
    const inputId = document.querySelector('#id');
    cita.id = inputId.value;
}

function nombreCliente() {
    const inputNombre = document.querySelector('#nombre');
    inputNombre.addEventListener('change', e => {
        cita.nombre = inputNombre.value;
    })
    cita.nombre = inputNombre.value;
}

function seleccionarFecha() {
    const fechaFormateada = formatearFecha();
    cita.fecha = fechaFormateada;

    const inputFecha = document.querySelector('#fecha');
    inputFecha.value = fechaFormateada;
    inputFecha.setAttribute('min', fechaFormateada);

    
    inputFecha.addEventListener('change', (e)=> {
        const dia = new Date(e.target.value).getDay();
        
        if ( [5,6].includes(dia) ) {
            e.target.value = '';
            mostrarAlerta("Los sabados y domingos no abrimos", "error");
        } else {
            cita.fecha = e.target.value;
        }
    })
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener( 'change', e => {

        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];

        if( parseInt(hora) < 10 || parseInt(hora) > 18 ) {
            e.target.value = '';
            mostrarAlerta('Abrimos a las 10:00 AM y cerramos a las 06:00 PM', 'error');
        } else {
            cita.hora = horaCita;
        }

    })
}

function mostrarResumen() {
    const resumenDiv = document.querySelector('#paso-3 .resumen');
    
    while (resumenDiv.firstChild) {
        resumenDiv.removeChild(resumenDiv.firstChild)
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        const aviso = document.createElement('H2');
        aviso.className = "aviso";
        aviso.textContent = "Llena todos los datos para continuar";
        
        resumenDiv.appendChild(aviso);

        return
    }    
    
    const {nombre, fecha, hora, servicios} = cita;
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = "Resumen de servicios";
    resumenDiv.appendChild(headingServicios);
    let totalServicios = 0;

    servicios.forEach( servicio => {
        const {precio, nombre} = servicio;
        const servicioDiv = document.createElement('DIV');
        servicioDiv.className = "contenedor-servicio";

        const nombreServicio = document.createElement('P');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        resumenDiv.appendChild(servicioDiv);
        totalServicios += parseFloat(precio);

    })

    const fechaObj = new Date(fecha);
    const dia = fechaObj.getDate() + 2;
    const mes = fechaObj.getMonth();
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));
    const fechaFormateada = fechaUTC.toLocaleDateString('es-MX', {
        weekday: 'long',
        day: '2-digit',
        year: 'numeric',
        month: 'long'
    })

    const total = document.createElement('P');
    total.innerHTML = `<span>Total:</span> $${totalServicios}`;
    resumenDiv.appendChild(total);

    const headingCita = document.createElement('H3');
    headingCita.textContent = "Resumen de la cita";
    resumenDiv.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span class="resaltado">Nombre:</span> ${nombre}`;
    resumenDiv.appendChild(nombreCliente);
    
    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span class="resaltado">Fecha:</span> ${fechaFormateada}`;
    resumenDiv.appendChild(fechaCita);
    
    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span class="resaltado">Hora:</span> ${hora}hrs`;
    resumenDiv.appendChild(horaCita);

    const botonReservar = document.createElement('BUTTON');
    botonReservar.className = 'boton';
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;
    resumenDiv.appendChild(botonReservar);
}

async function reservarCita() {
    const {id, fecha, hora, servicios} = cita;
    const idServicios = servicios.map(servicio => servicio.id);

    const datos = new FormData();
    datos.append('usuarioId', id);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('servicios', idServicios);

    try {
        // Peticion hacia la api
        const url = `${location.origin}/api/citas`;
        const res = await fetch(url, {
            method: 'POST',
            body: datos
        })

        const resultado = await res.json();
        if(resultado.resultado) {
            Swal.fire(
                'Cita creada',
                'Se ha agendado tu cita correctamente',
                'success'
            ).then(()=> {
                window.location.reload();
            })
        }
    } catch (err) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita'
        })
}
}

function formatearFecha() {
    const fechaActual = new Date();
    const year = fechaActual.toLocaleString("default", { year: "numeric" });
    const mes = fechaActual.toLocaleString("default", { month: "2-digit" });
    const dia = fechaActual.toLocaleString("default", { day: "2-digit" });

    const fechaFormateada = `${year}-${mes}-${dia}`

    return fechaFormateada;
}

function mostrarAlerta(mensaje, tipo) {
    const alertaAnterior = document.querySelector('.alerta');
    if( alertaAnterior ) return;

    const alerta = document.createElement('DIV');
    alerta.className = `alerta ${tipo}`;
    alerta.textContent = mensaje

    const formulario = document.querySelector('.formulario');
    formulario.appendChild(alerta)

    setTimeout(()=> {
        alerta.remove();
    }, 5000)
}
