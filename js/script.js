var boton = document.getElementById("js-btnImprimir");
if(boton){
  boton.addEventListener("click", function(e){
    e.preventDefault();
    $.ajax({
      url: "gestorCobranzas.php",
      method: "POST",
      processData: true,
      success:function(respuesta){
        alert(respuesta);
        //La url es la que debes de modificar segun tu conveniencia y corresponde al localhost de la pc cliente, por lo que debes de instalar php cualquiera(xampp, wampp, appserver, etc) en la pc local y solo debes de copiar en la carpeta de tu proyecto la carpeta src, autoload.php y ticketVenta.php
        window.location.href="http://localhost:8081/PRACTICANDO/TICKETERA/ticketVenta.php?data="+respuesta;
      }
    });
  });
}