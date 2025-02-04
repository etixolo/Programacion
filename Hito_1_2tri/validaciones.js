document.addEventListener('DOMContentLoaded', function () {
    // Cargar el archivo JSON de restricciones
    fetch('restricciones.json')
        .then(response => response.json())
        .then(restricciones => {
            // Aplicar las restricciones a los campos del formulario
            aplicarRestricciones(restricciones);
        })
        .catch(error => console.error('Error al cargar restricciones:', error));
});

function aplicarRestricciones(restricciones) {
    const formulario = document.querySelector('form');

    // Aplicar restricciones a cada campo
    for (const campo in restricciones) {
        const input = formulario.querySelector(`[name="${campo}"]`);
        if (input) {
            aplicarRestriccion(input, restricciones[campo]);
        }
    }

    // Validar el formulario antes de enviarlo
    formulario.addEventListener('submit', function (event) {
        if (!validarFormulario(restricciones)) {
            event.preventDefault(); // Evitar el envío si hay errores
        }
    });

    // Restricciones adicionales
    const edadInput = formulario.querySelector('[name="edad"]');
    const planBaseSelect = formulario.querySelector('[name="plan_base"]');
    const paquetesCheckboxes = formulario.querySelectorAll('[name="paquetes[]"]');
    const duracionSelect = formulario.querySelector('[name="duracion"]');

    // Validar en tiempo real
    edadInput.addEventListener('change', validarRestricciones);
    planBaseSelect.addEventListener('change', validarRestricciones);
    duracionSelect.addEventListener('change', validarRestricciones);
    paquetesCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', validarRestricciones);
    });

    function validarRestricciones() {
        const edad = parseInt(edadInput.value);
        const planBase = planBaseSelect.value;
        const duracion = duracionSelect.value;
        const paquetesSeleccionados = Array.from(paquetesCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);

        // Restricción 1: Usuarios menores de 18 años solo pueden contratar el Pack Infantil
        if (edad < 18) {
            paquetesCheckboxes.forEach(checkbox => {
                if (checkbox.value !== 'Infantil') {
                    checkbox.disabled = true;
                    checkbox.checked = false; // Desmarcar otros paquetes
                } else {
                    checkbox.disabled = false;
                }
            });
        } else {
            paquetesCheckboxes.forEach(checkbox => {
                checkbox.disabled = false;
            });
        }

        // Restricción 2: Usuarios del Plan Básico solo pueden seleccionar un paquete adicional
        if (planBase === 'Básico') {
            if (paquetesSeleccionados.length > 1) {
                alert('El Plan Básico solo permite seleccionar un paquete adicional.');
                paquetesCheckboxes.forEach(checkbox => {
                    if (checkbox.checked && paquetesSeleccionados.indexOf(checkbox.value) !== 0) {
                        checkbox.checked = false; // Desmarcar paquetes adicionales
                    }
                });
            }
        }

        // Restricción 3: El Pack Deporte solo puede ser contratado si la duración es de 1 año
        const deporteCheckbox = formulario.querySelector('[name="paquetes[]"][value="Deporte"]');
        if (duracion !== 'Anual' && deporteCheckbox.checked) {
            alert('El Pack Deporte solo puede ser contratado con una duración de 1 año.');
            deporteCheckbox.checked = false; // Desmarcar el Pack Deporte
        }
    }
}

function aplicarRestriccion(input, reglas) {
    if (reglas.required) {
        input.setAttribute('required', true);
    }
    if (reglas.minLength) {
        input.setAttribute('minlength', reglas.minLength);
    }
    if (reglas.maxLength) {
        input.setAttribute('maxlength', reglas.maxLength);
    }
    if (reglas.min) {
        input.setAttribute('min', reglas.min);
    }
    if (reglas.max) {
        input.setAttribute('max', reglas.max);
    }
    if (reglas.type === 'email') {
        input.setAttribute('type', 'email');
    }
    if (reglas.maxSelections && input.type === 'checkbox') {
        input.addEventListener('change', function () {
            const seleccionados = formulario.querySelectorAll(`[name="${input.name}"]:checked`).length;
            if (seleccionados > reglas.maxSelections) {
                alert(`Solo puedes seleccionar un máximo de ${reglas.maxSelections} opciones.`);
                input.checked = false;
            }
        });
    }
}

function validarFormulario(restricciones) {
    let valido = true;
    for (const campo in restricciones) {
        const input = formulario.querySelector(`[name="${campo}"]`);
        if (restricciones[campo].required && !input.value.trim()) {
            alert(`El campo ${campo} es obligatorio.`);
            valido = false;
        }
        if (restricciones[campo].minLength && input.value.length < restricciones[campo].minLength) {
            alert(`El campo ${campo} debe tener al menos ${restricciones[campo].minLength} caracteres.`);
            valido = false;
        }
        if (restricciones[campo].maxLength && input.value.length > restricciones[campo].maxLength) {
            alert(`El campo ${campo} no puede tener más de ${restricciones[campo].maxLength} caracteres.`);
            valido = false;
        }
        if (restricciones[campo].type === 'email' && !validarEmail(input.value)) {
            alert(`El campo ${campo} debe ser un correo electrónico válido.`);
            valido = false;
        }
    }
    return valido;
}

function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}