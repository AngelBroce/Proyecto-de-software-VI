document.addEventListener('DOMContentLoaded', function() {
    // Referencias a elementos
    const searchInput = document.getElementById('searchInput');
    const departmentFilter = document.getElementById('departmentFilter');
    const statusFilter = document.getElementById('statusFilter');
    const sortBy = document.getElementById('sortBy');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const resetFiltersBtn = document.getElementById('resetFilters');
    
    // Botones de acción en la tabla
    const viewButtons = document.querySelectorAll('.btn-icon .bi-eye');
    const editButtons = document.querySelectorAll('.btn-icon .bi-pencil');
    const deleteButtons = document.querySelectorAll('.btn-icon.delete');
    
    // Modales
    const employeeDetailModalElement = document.getElementById('employeeDetailModal');
    const deleteConfirmModalElement = document.getElementById('deleteConfirmModal');

    const employeeDetailModal = new bootstrap.Modal(employeeDetailModalElement);
    const deleteConfirmModal = new bootstrap.Modal(deleteConfirmModalElement);
    
    // Evento para el botón de ver detalles
    viewButtons.forEach(button => {
        button.parentElement.addEventListener('click', function() {
            employeeDetailModal.show();
        });
    });
    
    // Evento para el botón de eliminar
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            deleteConfirmModal.show();
        });
    });
    
    // Búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if(text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Aplicar filtros
    applyFiltersBtn.addEventListener('click', function() {
        const department = departmentFilter.value;
        const status = statusFilter.value;
        const sort = sortBy.value;
        
        // Aquí iría la lógica para filtrar y ordenar los datos
        // En una aplicación real, esto podría ser una llamada AJAX o manipulación del DOM
        
        console.log('Filtros aplicados:', { department, status, sort });
        alert('Filtros aplicados');
    });
    
    // Restablecer filtros
    resetFiltersBtn.addEventListener('click', function() {
        departmentFilter.value = '';
        statusFilter.value = '';
        sortBy.value = 'name';
        searchInput.value = '';
        
        // Restablecer la visualización de todas las filas
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.display = '';
        });
    });
});