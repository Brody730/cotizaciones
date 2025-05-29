// Funciones generales de JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Validación de formularios
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Validación básica de campos requeridos
            const requiredInputs = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });
            
            // Validación de contraseñas coincidentes
            if (form.id === 'register-form' || form.id === 'reset-password-form') {
                const password = form.querySelector('#password');
                const confirmPassword = form.querySelector('#confirm_password');
                
                if (password && confirmPassword && password.value !== confirmPassword.value) {
                    confirmPassword.classList.add('is-invalid');
                    isValid = false;
                    alert('Las contraseñas no coinciden');
                }
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
    
    // Mostrar/ocultar contraseña
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    });
    
    // Cálculo dinámico de cotización
    if (document.getElementById('cotizador-form')) {
        const cotizadorForm = document.getElementById('cotizador-form');
        const resultadoCotizacion = document.getElementById('resultado-cotizacion');
        
        function calcularCotizacion() {
            const tipoServicio = document.getElementById('tipo_servicio').value;
            const complejidad = document.getElementById('complejidad').value;
            const plazo = document.getElementById('plazo').value;
            
            if (tipoServicio && complejidad && plazo) {
                // Precios base por tipo de servicio
                const preciosBase = {
                    'diseno_web': 500,
                    'analisis_datos': 800,
                    'marketing_digital': 400,
                    'desarrollo_app': 1000
                };
                
                // Multiplicadores por complejidad
                const multiplicadores = {
                    'basico': 0.8,
                    'intermedio': 1.0,
                    'avanzado': 1.5,
                    'personalizado': 2.0
                };
                
                // Ajuste por plazo (menos tiempo = más costo)
                const ajustePlazo = 1 + (30 / plazo);
                
                const precio = preciosBase[tipoServicio] * multiplicadores[complejidad] * ajustePlazo;
                
                resultadoCotizacion.innerHTML = `
                    <div class="alert alert-info">
                        <h4>Estimación de precio:</h4>
                        <p><strong>Total:</strong> $${precio.toFixed(2)}</p>
                        <small>Esta es una estimación preliminar. El precio final puede variar.</small>
                    </div>
                `;
            } else {
                resultadoCotizacion.innerHTML = '';
            }
        }
        
        cotizadorForm.addEventListener('change', calcularCotizacion);
        calcularCotizacion(); // Ejecutar al cargar la página
    }
});

// Función para mostrar notificaciones
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 500);
    }, 5000);
}