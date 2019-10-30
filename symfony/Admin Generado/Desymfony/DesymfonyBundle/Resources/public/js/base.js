

window.onload = function(){

    contenedor = document.getElementById("contenedor");

    contenedor.onclick = function (evento) {

        if(evento.target == contenedor) {
            if (window.getComputedStyle(contenedor, "").width == "900px")
                contenedor.style.width = "700px";
            else
                contenedor.style.width = "900px"
        }
    }

}
