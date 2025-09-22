

function addProducto(id, token, cantidad = 1) {

    let url = 'clases/carrito.php'
    let formData = new FormData() //creo un objeto vacio, quesimula un formulario html
    //que luego vas a mandar en la peticion fetch
    formData.append('id', id); // append lo agrega el final, con Append agregas la clave valor dentro de ese formData
    formData.append('token', token);
    formData.append('cantidad', cantidad);


    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors' //cors permite hacer peticiones a otro dominio
    }).then(response => {
        //  console.log("respnse", response);

        if (!response.ok) {
            throw new Error("Error HTTP:" + response.status);
        }
        return response.text();
    })
        .then(data => {
            // console.log("Respuesta del servidor:", data);
            if (data.ok) {
                let elemento = document.getElementById('num_cart')
                elemento.innerHTML = data.numero;
                console.log("Elemento :", data.numero);

            }
        })
        .catch(error => {
            console.error("Error en el fetch", error);
        })
}