document.addEventListener('DOMContentLoaded', function () {
    const preloadOverlay = document.getElementById('preload-overlay');
  
    // Verifica si la importación se ha realizado exitosamente
    if (importacionExitosa) {
      preloadOverlay.style.display = 'block';
    }
  });
  