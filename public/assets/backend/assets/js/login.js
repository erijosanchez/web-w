
// Crear más formas flotantes dinámicamente
function createFloatingShapes() {
    const shapes = ['circle', 'rect', 'polygon'];
    const container = document.querySelector('.floating-shapes');

    for (let i = 0; i < 10; i++) {
        const shape = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        const randomShape = shapes[Math.floor(Math.random() * shapes.length)];

        shape.setAttribute('class', 'shape');
        shape.style.left = Math.random() * 100 + '%';
        shape.style.top = Math.random() * 100 + '%';
        shape.style.width = (30 + Math.random() * 30) + 'px';
        shape.style.height = (30 + Math.random() * 30) + 'px';
        shape.setAttribute('viewBox', '0 0 50 50');

        let shapeElement;
        switch (randomShape) {
            case 'circle':
                shapeElement = document.createElementNS("http://www.w3.org/2000/svg", "circle");
                shapeElement.setAttribute('cx', '25');
                shapeElement.setAttribute('cy', '25');
                shapeElement.setAttribute('r', '20');
                break;
            case 'rect':
                shapeElement = document.createElementNS("http://www.w3.org/2000/svg", "rect");
                shapeElement.setAttribute('width', '30');
                shapeElement.setAttribute('height', '30');
                shapeElement.setAttribute('x', '10');
                shapeElement.setAttribute('y', '10');
                break;
            case 'polygon':
                shapeElement = document.createElementNS("http://www.w3.org/2000/svg", "polygon");
                shapeElement.setAttribute('points', '25,5 45,40 5,40');
                break;
        }

        shapeElement.setAttribute('fill', 'rgba(255,255,255,0.2)');
        shape.appendChild(shapeElement);
        container.appendChild(shape);
    }
}

createFloatingShapes();


/* sistema de notificaciones del login de administrador */
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-message');
    
    alerts.forEach(alert => {
        // Eliminar la alerta después de 3 segundos
        setTimeout(() => {
            alert.remove();
        }, 4000);
    });
});

// Toggle password visibility
const passwordToggle = document.querySelector('.password-toggle');
const passwordInput = document.getElementById('password');
let isPasswordVisible = false;

passwordToggle.addEventListener('click', function() {
    isPasswordVisible = !isPasswordVisible;
    
    // Cambiar el tipo de input
    passwordInput.type = isPasswordVisible ? 'text' : 'password';
    
    // Cambiar el ícono
    if (isPasswordVisible) {
        this.innerHTML = `
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        `;
    } else {
        this.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `;
    }
});