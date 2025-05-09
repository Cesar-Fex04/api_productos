const readline = require('readline');
const fetch = require('node-fetch');

const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
});

rl.question('Escribe el código del producto a buscar: ', (codigo) => {
    const url = `http://localhost/apis/buscar_producto.php?codigo=${encodeURIComponent(codigo)}`;
    console.log(`Consultando: ${url}`);

    fetch(url)
        .then(res => {
            console.log(`Código de respuesta HTTP: ${res.status}`);
            return res.json();
        })
        .then(data => {
            console.log("Respuesta del servidor:");
            console.log(JSON.stringify(data, null, 2));
        })
        .catch(err => {
            console.error("Error al conectarse con la API:");
            console.error(err);
        })
        .finally(() => rl.close());
});


//Ejecutar el script
// node test_api.js