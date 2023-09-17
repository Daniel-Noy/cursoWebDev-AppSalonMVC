import { Api } from "./Api.js";
import { Cita } from "./Cita.js"
import { UI } from "./UI.js";


export function eliminarCita(id) {
    Swal.fire({
        title: 'Quieres Eliminar esta Cita?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
            if (result.isConfirmed) {
                Cita.eliminarCita(id)
                .then((res) => {
                    if(res.res) {
                        Swal.fire('Cita Eliminada', '', 'success');
                        const cita = document.querySelector(`#${id}`);
                        cita.remove();
                    } else {
                        Swal.fire('Hubo un error al borrar la cita', '', 'error');
                    }
                })
                
            }
        })
    }

export async function buscarCitas(fecha) {
    const ui = new UI;
    const api = new Api;
    const fechaInput = document.querySelector('#fecha');
    
    const citas = await api.obtenerCitas(fecha);
    if(citas) {
        fechaInput.disabled = true;
        ui.mostrarLoader();
        ui.mostrarCitas(citas);
    
        fechaInput.disabled = false;
    }
}