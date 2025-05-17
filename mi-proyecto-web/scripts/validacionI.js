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

    // Agregar validación para el formulario - extraer solo los números antes de enviar
    form.addEventListener('submit', function(submitEvent) {
        // Asegurarse de que solo se envíen números en los campos de teléfono y celular
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