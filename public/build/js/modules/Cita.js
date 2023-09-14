export class Cita {
    idUsuario;
    nombre;
    fecha;
    hora;
    servicios = [];

    constructor(args = {id, nombre, fecha}) {
        this.idUsuario = args.id;
        this.nombre = args.nombre;
        this.fecha = args.fecha
    }

    seleccionarServicio =({currentTarget}, servicio) => {
        const id = currentTarget.dataset.idServicio;
        
        if(this.servicios.some( agregado => agregado.id === servicio.id )) {
            this.servicios = this.servicios.filter( agregado => agregado.id !== id)
            currentTarget.classList.remove('seleccionado');
        } else {
            this.servicios = [...this.servicios, servicio];
            currentTarget.classList.add('seleccionado');
        }
    }

    editarFechaCita = ({target}) => {
        const dia = new Date(target.value).getDay();
        const diasDescanso = [5, 6];
    
        if( diasDescanso.includes(dia) ) {
            target.value = fechaActual();
            // mostrarAlerta("Los sabados y domingos no abrimos", "error");
            return;
        }
    
        this.fecha = target.value;
        console.log(this);
    }

    editarHoraCita = ({target}) => {
        const horaCita = target.value;
        const hora = horaCita.split(':')[0];
    
        if( parseInt(hora) < 10 || parseInt(hora) > 18 ) {
            target.value = '';
            // mostrarAlerta('Abrimos a las 10:00 AM y cerramos a las 06:00 PM', 'error');
            return;
        } 
    
        this.hora = horaCita;
    }

    reservarCita = async ()=> {
        const idServicios = this.servicios.map(servicio => servicio.id);
        const datos = new FormData();
        datos.append('usuarioId', this.idUsuario);
        datos.append('fecha', this.fecha);
        datos.append('hora', this.hora);
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
            console.log(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Hubo un error al guardar la cita'
            })
        }
    }
}