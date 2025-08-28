// Basic JS helpers
export function confirmAction(message) {
  return window.confirm(message || '¿Confirmar acción?');
}

export function setActiveNav(pathname) {
  const links = document.querySelectorAll('header nav a');
  links.forEach(a => {
    if (a.getAttribute('href') && pathname.endsWith(a.getAttribute('href'))) {
      a.classList.add('active');
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  setActiveNav(window.location.pathname);
});

