document.addEventListener('DOMContentLoaded', () => iniciarApp());

function iniciarApp() {
    buscarPorFecha();
    eliminarCita();
}

function buscarPorFecha() {
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', (e)=> {
        const fecha = e.target.value;

        if(fecha) {
            window.location = `?fecha=${fecha}`;
        }
    })
}

function eliminarCita() {
    const formularioEliminar = document.querySelectorAll('form.eliminar-cita');
    if (!formularioEliminar.length) return;

    formularioEliminar.forEach(formulario => {
        formulario.addEventListener('submit', e => {
            e.preventDefault();

            Swal.fire({
                title: 'Borrar cita?',
                text: "No prodras recuperar esta cita",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0da6f3',
                cancelButtonColor: '#cb0000',
                confirmButtonText: 'Borrar'
                }).then((result) => {
                if (result.isConfirmed) {

                    Swal.fire(
                        'Borrando',
                        'La cita se esta borrando.',
                    )
                    setTimeout(()=>{
                    formulario.submit();
                    }, 1000)
                }
                })
        })
    })
}