export class Fecha {

    fechaActual() {
        const fechaActual = new Date();
        const year = fechaActual.toLocaleString("default", { year: "numeric" });
        const mes = fechaActual.toLocaleString("default", { month: "2-digit" });
        const dia = fechaActual.toLocaleString("default", { day: "2-digit" });
    
        const fechaFormateada = `${year}-${mes}-${dia}`
    
        return fechaFormateada;
    }

    limitarFechasDisponibles(input) {
        input.value = this.fechaActual();
        input.setAttribute('min', this.fechaActual());
    }
}