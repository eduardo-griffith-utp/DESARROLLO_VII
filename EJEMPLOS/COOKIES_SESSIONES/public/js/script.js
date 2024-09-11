// Script principal para funcionalidades del lado del cliente

document.addEventListener('DOMContentLoaded', function() {
    // Función para ocultar mensajes flash después de 5 segundos
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(function(message) {
        setTimeout(function() {
            message.style.display = 'none';
        }, 5000);
    });

    // Función para confirmar cierre de sesión
    const logoutLink = document.querySelector('a[href="logout.php"]');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            if (!confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                event.preventDefault();
            }
        });
    }

    // Función para aplicar el tema seleccionado
    function applyTheme(theme) {
        document.body.className = theme + '-theme';
    }

    // Verificar si hay una cookie de tema y aplicarla
    const themeCookie = document.cookie.split('; ').find(row => row.startsWith('user_theme='));
    if (themeCookie) {
        const theme = themeCookie.split('=')[1];
        applyTheme(theme);
    }

    // Cambiar el tema cuando se selecciona una nueva opción
    const themeSelect = document.getElementById('theme');
    if (themeSelect) {
        themeSelect.addEventListener('change', function() {
            applyTheme(this.value);
        });
    }
});