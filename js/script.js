// Puedes agregar aquí funciones generales de JavaScript que se usen en toda la aplicación

// Ejemplo: función para mostrar/ocultar un elemento
function mostrarOcultar(id) {
    var elemento = document.getElementById(id);
    if (elemento.style.display === "none") {
      elemento.style.display = "block";
    } else {
      elemento.style.display = "none";
    }
  }
  
  // Ejemplo: función para enviar una petición AJAX
  function enviarPeticionAJAX(url, datos, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        callback(this.responseText);
      }
    };
    xhr.send(datos);
  }