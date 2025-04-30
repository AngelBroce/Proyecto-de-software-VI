document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('employeeForm');

    // Validar que solo se ingresen letras en nombres y apellidos
    const textInputs = ['nombre1', 'nombre2', 'apellido1', 'apellido2', 'apellido_casada'];
    textInputs.forEach(id => {
        const input = document.querySelector(`input[name="${id}"]`);
        input.addEventListener('input', function() {
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        });
    });

    // Habilitar apellido de casada si es femenino, casada y selecciona "Sí"
    const usaAcSelect = document.querySelector('select[name="usa_ac"]');
    const generoSelect = document.querySelector('select[name="genero"]');
    const apellidoCasadaInput = document.querySelector('input[name="apellido_casada"]');
    apellidoCasadaInput.disabled = true;

    function toggleApellidoCasada() {
        const estadoCivilSelect = document.querySelector('select[name="estado_civil"]');
        if (usaAcSelect.value === '1' && generoSelect.value === '0' && estadoCivilSelect.value === '1') {
            apellidoCasadaInput.disabled = false;
        } else {
            apellidoCasadaInput.disabled = true;
            apellidoCasadaInput.value = '';
        }
    }

    usaAcSelect.addEventListener('change', toggleApellidoCasada);
    generoSelect.addEventListener('change', toggleApellidoCasada);
    const estadoCivilSelect = document.querySelector('select[name="estado_civil"]');
    estadoCivilSelect.addEventListener('change', toggleApellidoCasada);

    const telefonoInput = document.querySelector('input[name="telefono"]');
    const celularInput = document.querySelector('input[name="celular"]');
    
    function formatWithMask(mask, value) {
        let formatted = '';
        let i = 0;
    
        for (const char of mask) {
            if (char === '#') {
                if (value[i]) {
                    formatted += value[i];
                    i++;
                } else {
                    break;
                }
            } else {
                if (i < value.length) {
                    formatted += char;
                }
            }
        }
    
        return formatted;
    }
    
    function handleInput(event, mask) {
        const input = event.target;
        const start = input.selectionStart;
        const rawValue = input.value.replace(/\D/g, '');
        const formatted = formatWithMask(mask, rawValue);
        input.value = formatted;
    
        // Mover el cursor automáticamente al final del valor ingresado
        setTimeout(() => {
            input.setSelectionRange(formatted.length, formatted.length);
        }, 0);
    }
    
    telefonoInput.addEventListener('input', function (e) {
        handleInput(e, '###-####');
    });
    
    celularInput.addEventListener('input', function (e) {
        handleInput(e, '####-####');
    });
    
    // Validar campos obligatorios al enviar el formulario
    form.addEventListener('submit', function(event) {
        const requiredFields = [
            'tipo_sangre', 'f_nacimiento', 'provincia', 'distrito', 'corregimiento', 'cargo', 'nacionalidad', 'f_contratacion'
        ];

        let isValid = true;

        requiredFields.forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            event.preventDefault();
            alert('Por favor, complete todos los campos obligatorios.');
        }
    });
});