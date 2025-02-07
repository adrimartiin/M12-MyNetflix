document.addEventListener("DOMContentLoaded", function(){
    var inputBusqueda = document.getElementById('search');
    fetch('../private/gest_users.php')
    .then(function(response) {
        if(response.ok){
            console.log('Hola');
        } else {
            console.log ('Ha habido un error con la respuesta HTTP');
        }
    })
    .catch(function(error) {
        console.log('Error:', error);
    
    })
})


