document.addEventListener('DOMContentLoaded', function() {
    // 1. Seleccionar todas las feature cards
    const features = document.querySelectorAll('.feature');
    
    // 2. Efecto de rebote al hacer hover
    features.forEach(feature => {
        // Efecto al pasar el mouse
        feature.addEventListener('mouseenter', function() {
            this.style.animation = 'none'; // Detener animación flotante
            setTimeout(() => {
                this.style.transform = 'translateY(-15px) scale(1.05) rotateX(5deg)';
                this.style.boxShadow = '0 15px 35px rgba(67, 97, 238, 0.3)';
            }, 50);
        });
        
        // Efecto al quitar el mouse
        feature.addEventListener('mouseleave', function() {
            this.style.animation = 'float 4s ease-in-out infinite, glow 6s ease-in-out infinite';
            this.style.transform = '';
            this.style.boxShadow = '0 10px 30px rgba(67, 97, 238, 0.1)';
        });
        
        // 3. Efecto de click (brinco más pronunciado)
        feature.addEventListener('click', function() {
            this.style.transform = 'translateY(-30px) scale(1.1)';
            this.style.boxShadow = '0 20px 40px rgba(67, 97, 238, 0.4)';
            
            setTimeout(() => {
                this.style.transform = 'translateY(-15px) scale(1.05)';
                this.style.boxShadow = '0 15px 35px rgba(67, 97, 238, 0.3)';
            }, 300);
        });
    });
    
    // 4. Animación secuencial al cargar la página
    setTimeout(() => {
        features.forEach((feature, index) => {
            setTimeout(() => {
                feature.style.opacity = '1';
                feature.style.transform = 'translateY(0)';
            }, index * 200); // Retraso escalonado
        });
    }, 500);
    
    // 5. Efecto de iluminación aleatoria
    setInterval(() => {
        const randomFeature = features[Math.floor(Math.random() * features.length)];
        randomFeature.classList.add('highlight');
        
        setTimeout(() => {
            randomFeature.classList.remove('highlight');
        }, 1000);
    }, 3000);
    
    // 6. Rotación de íconos al hacer hover
    const featureIcons = document.querySelectorAll('.feature-icon');
    featureIcons.forEach(icon => {
        icon.addEventListener('mouseenter', function() {
            this.style.transform = 'rotate(10deg) scale(1.2)';
        });
        
        icon.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
    
    // 7. Efecto de onda al hacer click (propaga el efecto a las demás cards)
    features.forEach(feature => {
        feature.addEventListener('click', function() {
            const index = Array.from(features).indexOf(this);
            
            // Propagación del efecto a las cards adyacentes
            if (index > 0) {
                features[index - 1].style.transform = 'translateY(-10px) scale(1.03)';
                setTimeout(() => {
                    features[index - 1].style.transform = '';
                }, 300);
            }
            
            if (index < features.length - 1) {
                features[index + 1].style.transform = 'translateY(-10px) scale(1.03)';
                setTimeout(() => {
                    features[index + 1].style.transform = '';
                }, 300);
            }
        });
    });
});

// Función para animación de scroll (aparecen las cards al hacer scroll)
window.addEventListener('scroll', function() {
    const features = document.querySelectorAll('.feature');
    const windowHeight = window.innerHeight;
    
    features.forEach(feature => {
        const featurePosition = feature.getBoundingClientRect().top;
        const scrollPosition = window.scrollY;
        
        if (featurePosition < windowHeight - 100) {
            feature.style.opacity = '1';
            feature.style.transform = 'translateY(0)';
        }
    });
});