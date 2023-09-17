export class Api {
    obtenerCitas = async (fecha)=> {
        if(fecha === '') return;
        const url = '/api/citas';
        try {

            const data = new FormData();
            data.append('fecha', fecha);

            const req = await fetch(url, {
                method: 'POST',
                body: data
            });
            const res = await req.json();
            const citas = res.body;

            return citas;
        } catch (error) {
            console.log(error);
        }
    }
}