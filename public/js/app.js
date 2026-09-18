document.addEventListener('DOMContentLoaded', () => {
  const btnStatus = document.getElementById('btn-status');
  const statusCard = document.getElementById('status-card');
  const clockElement = document.getElementById('clock');

  function updateClock() {
    const now = new Date();
    clockElement.textContent = now.toLocaleTimeString();
  }

  setInterval(updateClock, 1000);
  updateClock();

  btnStatus.addEventListener('click', () => {
    statusCard.classList.toggle('hidden');
    if (!statusCard.classList.contains('hidden')) {
      btnStatus.textContent = 'Ocultar Estado';
    } else {
      btnStatus.textContent = 'Verificar Estado del Servidor';
    }
  });
});
