// Función para animar los elementos con la clase "rojo" (bajo stock)
function animarBajoStock() {
    $(".rojo").each(function() {
      $(this).animate({backgroundColor: '#FFAAAA'}, 500)
             .animate({backgroundColor: 'transparent'}, 500);
    });
  }
  
  // Función para animar los elementos con la clase "proximo" (fecha próxima de mantenimiento)
  function animarProximoMantenimiento() {
    $(".proximo").each(function() {
      $(this).animate({backgroundColor: '#FFFFAA'}, 500)
             .animate({backgroundColor: 'transparent'}, 500);
    });
  }
  
  // Ejecutar las animaciones al cargar la página
  $(document).ready(function() {
    animarBajoStock();
    animarProximoMantenimiento();
  });