// Validar formulario de agregar/editar activo
function validarActivo() {
    var nombre = document.getElementById("nombre").value;
    var stock = document.getElementById("stock").value;
  
    if (nombre == "") {
      alert("Por favor, ingresa el nombre del activo.");
      return false;
    }
  
    if (stock == "" || stock < 0) {
      alert("Por favor, ingresa un stock válido (mayor o igual a 0).");
      return false;
    }
  
    return true;
  }
  
  // Validar formulario de agregar/editar personal
  function validarPersonal() {
    var nombre = document.getElementById("nombre").value;
  
    if (nombre == "") {
      alert("Por favor, ingresa el nombre del personal.");
      return false;
    }
  
    return true;
  }
  
  // Validar formulario de programar mantenimiento
  function validarMantenimiento() {
    var id_activo = document.getElementById("id_activo").value;
    var fecha_proximo = document.getElementById("fecha_proximo").value;
  
    if (id_activo == "") {
      alert("Por favor, selecciona un activo.");
      return false;
    }
  
    if (fecha_proximo == "") {
      alert("Por favor, ingresa la fecha del próximo mantenimiento.");
      return false;
    }
  
    return true;
  }
  
  // Validar formulario de agregar usuario
  function validarUsuario() {
    var nombre = document.getElementById("nombre").value;
    var correo = document.getElementById("correo").value;
    var contraseña = document.getElementById("contraseña").value;
  
    if (nombre == "") {
      alert("Por favor, ingresa el nombre del usuario.");
      return false;
    }
  
    if (correo == "") {
      alert("Por favor, ingresa el correo electrónico del usuario.");
      return false;
    }
  
    if (contraseña == "") {
      alert("Por favor, ingresa la contraseña del usuario.");
      return false;
    }
  
    return true;
  }