export class UI {
    paso = 1;
    pasoInicial = 1;
    pasoFinal = 3;

     //* Muestra la seccion elegida
    mostrarSeccion() {
        const seccionAnterior = document.querySelector('.seccion.mostrar');
        if(seccionAnterior) {
            seccionAnterior.classList.remove('mostrar');
        }
        
        const seccion = document.querySelector(`#paso-${this.paso}`);
        seccion.classList.add('mostrar');

        // Desmarca el tab anterior si es que existe
        const tabAnterior = document.querySelector('.actual') ?? null;
        if(tabAnterior) {
            tabAnterior.classList.remove('actual');
        }
        
        // Resalta el tab actual
        const tab = document.querySelector(`[data-paso="${this.paso}"]`);
        tab.classList.add('actual');
    }

    //* Hablita los botones para paginar
    botonesPaginador() {
        const paginaAnt = document.querySelector('#anterior');
        const paginaSig = document.querySelector('#siguiente');
    
        if(this.paso === this.pasoInicial) {
            paginaAnt.classList.add('ocultar');
            paginaSig.classList.remove('ocultar');
        } 
        if (this.paso === this.pasoFinal) {
            paginaAnt.classList.remove('ocultar');
            paginaSig.classList.add('ocultar');
        }
        if(this.paso > this.pasoInicial && this.paso < this.pasoFinal) {
            paginaSig.classList.remove('ocultar');
            paginaAnt.classList.remove('ocultar');
        }
        this.mostrarSeccion();
    } 

    paginaAnterior = () => {
        if(this.paso === this.pasoInicial) return;
        this.paso--;
        this.mostrarSeccion();
        this.botonesPaginador();
    }

    paginaSiguiente = () => {
        if(this.paso === this.pasoFinal) return;
        this.paso++;
        this.mostrarSeccion();
        this.botonesPaginador();
    }

    mostrarServicios(servicios) {
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
    
            const seccionServicios = document.querySelector('#servicios');
            seccionServicios.appendChild(servicioDiv);
        })
    }

    mostrarResumen(cita) {
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
        botonReservar.onclick = cita.reservarCita;
        resumenDiv.appendChild(botonReservar);
        }
}