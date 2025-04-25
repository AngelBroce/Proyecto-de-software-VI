document.addEventListener("DOMContentLoaded", () => {
    // Referencias a elementos
    const searchInput = document.getElementById("searchInput")
    const departmentFilter = document.getElementById("departmentFilter")
    const statusFilter = document.getElementById("statusFilter")
    const sortBy = document.getElementById("sortBy")
    const applyFiltersBtn = document.getElementById("applyFilters")
    const resetFiltersBtn = document.getElementById("resetFilters")
  
    // Botones de acción en la tabla
    const viewButtons = document.querySelectorAll(".view-details")
    const editButtons = document.querySelectorAll(".btn-icon .bi-pencil")
    const deleteButtons = document.querySelectorAll(".btn-icon.delete")
  
    // Modales
    const employeeDetailModalElement = document.getElementById("employeeDetailModal")
    const deleteConfirmModalElement = document.getElementById("deleteConfirmModal")
  
    // Inicializar modales si existen
    let employeeDetailModal, deleteConfirmModal
  
    if (employeeDetailModalElement) {
      employeeDetailModal = new bootstrap.Modal(employeeDetailModalElement)
    }
  
    if (deleteConfirmModalElement) {
      deleteConfirmModal = new bootstrap.Modal(deleteConfirmModalElement)
    }
  
    // Evento para el botón de ver detalles
    if (viewButtons) {
      viewButtons.forEach((button) => {
        button.addEventListener("click", function () {
          const cedula = this.getAttribute("data-cedula")
          if (cedula) {
            cargarDetallesEmpleado(cedula)
          }
          if (employeeDetailModal) {
            employeeDetailModal.show()
          }
        })
      })
    }
  
    // Evento para el botón de eliminar
    if (deleteButtons) {
      deleteButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
          e.stopPropagation()
          if (deleteConfirmModal) {
            deleteConfirmModal.show()
          }
        })
      })
    }
  
    // Búsqueda en tiempo real
    if (searchInput) {
      searchInput.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase()
        const rows = document.querySelectorAll("tbody tr")
  
        rows.forEach((row) => {
          const text = row.textContent.toLowerCase()
          if (text.includes(searchTerm)) {
            row.style.display = ""
          } else {
            row.style.display = "none"
          }
        })
      })
    }
  
    // Aplicar filtros
    if (applyFiltersBtn) {
      applyFiltersBtn.addEventListener("click", () => {
        const department = departmentFilter ? departmentFilter.value.toLowerCase() : ""
        const status = statusFilter ? statusFilter.value.toLowerCase() : ""
        const sort = sortBy ? sortBy.value : "name"
  
        // Filtrar filas según los criterios seleccionados
        const rows = document.querySelectorAll("tbody tr")
  
        rows.forEach((row) => {
          // Obtener valores de las celdas
          const departmentCell = row.querySelector("td:nth-child(4)")
          const statusCell = row.querySelector("td:nth-child(8) .status-badge")
  
          // Verificar si las celdas existen
          const departmentText = departmentCell ? departmentCell.textContent.toLowerCase() : ""
          const statusText = statusCell ? statusCell.textContent.toLowerCase() : ""
  
          // Aplicar filtros
          const departmentMatch = department === "" || departmentText.includes(department)
          const statusMatch = status === "" || statusText === status
  
          // Mostrar u ocultar fila según los filtros
          if (departmentMatch && statusMatch) {
            row.style.display = ""
          } else {
            row.style.display = "none"
          }
        })
  
        // Ordenar filas según el criterio seleccionado
        if (sort !== "") {
          ordenarTabla(sort)
        }
      })
    }
  
    // Función para ordenar la tabla
    function ordenarTabla(criterio) {
      const tabla = document.querySelector("table")
      const tbody = tabla.querySelector("tbody")
      const filas = Array.from(tbody.querySelectorAll("tr"))
  
      // Definir índices de columnas para cada criterio
      const indices = {
        name: 1, // Nombre
        id: 0, // ID
        department: 3, // Departamento
        date: 5, // Fecha contratación
      }
  
      // Ordenar filas
      filas.sort((a, b) => {
        // Obtener el índice de la columna a ordenar
        const indice = indices[criterio]
  
        // Obtener valores de las celdas
        const valorA = a.querySelector(`td:nth-child(${indice + 1})`).textContent.toLowerCase()
        const valorB = b.querySelector(`td:nth-child(${indice + 1})`).textContent.toLowerCase()
  
        // Ordenar según el tipo de dato
        if (criterio === "date") {
          // Convertir fechas a objetos Date para comparación
          const fechaA = new Date(valorA)
          const fechaB = new Date(valorB)
          return fechaA - fechaB
        } else if (criterio === "id") {
          // Ordenar numéricamente
          return Number.parseInt(valorA) - Number.parseInt(valorB)
        } else {
          // Ordenar alfabéticamente
          return valorA.localeCompare(valorB)
        }
      })
  
      // Limpiar tbody
      while (tbody.firstChild) {
        tbody.removeChild(tbody.firstChild)
      }
  
      // Añadir filas ordenadas
      filas.forEach((fila) => {
        tbody.appendChild(fila)
      })
    }
  
    // Restablecer filtros
    if (resetFiltersBtn) {
      resetFiltersBtn.addEventListener("click", () => {
        if (departmentFilter) departmentFilter.value = ""
        if (statusFilter) statusFilter.value = ""
        if (sortBy) sortBy.value = "name"
        if (searchInput) searchInput.value = ""
  
        // Restablecer la visualización de todas las filas
        const rows = document.querySelectorAll("tbody tr")
        rows.forEach((row) => {
          row.style.display = ""
        })
      })
    }
  
    // Función para cargar los detalles de un empleado
    function cargarDetallesEmpleado(cedula) {
      if (!cedula) return
  
      // Mostrar indicador de carga
      const detallesContainer = document.getElementById("employeeDetails")
      if (detallesContainer) {
        detallesContainer.innerHTML = `
                  <div class="text-center">
                      <div class="spinner-border text-primary" role="status">
                          <span class="visually-hidden">Cargando...</span>
                      </div>
                      <p>Cargando información del empleado...</p>
                  </div>
              `
      }
  
      // Hacer una petición AJAX para obtener los detalles del empleado
      fetch(`obtener_empleado.php?cedula=${cedula}`)
        .then((response) => {
          if (!response.ok) {
            throw new Error(`Error en la respuesta del servidor: ${response.status}`)
          }
          return response.json()
        })
        .then((data) => {
          if (data.error) {
            console.error("Error:", data.error)
            if (detallesContainer) {
              detallesContainer.innerHTML = `
                              <div class="alert alert-danger">
                                  Error: ${data.error}
                              </div>
                          `
            }
            return
          }
  
          const empleado = data.empleado
  
          // Actualizar los elementos del modal con los datos del empleado
          if (detallesContainer) {
            // Iniciales para el avatar
            const iniciales = (
              empleado.nombre1.charAt(0) + (empleado.apellido1 ? empleado.apellido1.charAt(0) : "")
            ).toUpperCase()
  
            // Actualizar elementos del modal
            document.getElementById("employeeInitials").textContent = iniciales
            document.getElementById("employeeName").textContent =
              `${empleado.nombre1} ${empleado.nombre2 || ""} ${empleado.apellido1} ${empleado.apellido2 || ""}`
            document.getElementById("employeePosition").textContent = empleado.cargo_nombre || "No asignado"
  
            const statusBadge = document.getElementById("employeeStatus")
            statusBadge.textContent = empleado.estado_texto
            statusBadge.className = "status-badge " + (empleado.estado == 1 ? "active" : "inactive")
  
            // Información personal
            document.getElementById("employeeCedula").textContent = empleado.cedula
            document.getElementById("employeeEmail").textContent = empleado.correo || "No disponible"
            document.getElementById("employeePhone").textContent = empleado.telefono || "No disponible"
            document.getElementById("employeeMobile").textContent = empleado.celular || "No disponible"
            document.getElementById("employeeBirthdate").textContent = empleado.f_nacimiento || "No disponible"
            document.getElementById("employeeGender").textContent = empleado.genero_texto
            document.getElementById("employeeMaritalStatus").textContent = empleado.estado_civil_texto
            document.getElementById("employeeBloodType").textContent = empleado.tipo_sangre || "No especificado"
            document.getElementById("employeeNationality").textContent = empleado.nacionalidad_nombre || "No especificado"
  
            // Información laboral
            document.getElementById("employeeDepartment").textContent = empleado.departamento_nombre || "No asignado"
            document.getElementById("employeePosition2").textContent = empleado.cargo_nombre || "No asignado"
            document.getElementById("employeeHireDate").textContent = empleado.f_contra || "No disponible"
  
            // Dirección
            document.getElementById("employeeProvince").textContent = empleado.provincia_nombre || "No disponible"
            document.getElementById("employeeDistrict").textContent = empleado.distrito_nombre || "No disponible"
            document.getElementById("employeeCorregimiento").textContent =
              empleado.corregimiento_nombre || "No disponible"
            document.getElementById("employeeStreet").textContent = empleado.calle || "No disponible"
            document.getElementById("employeeHouse").textContent = empleado.casa || "No disponible"
            document.getElementById("employeeCommunity").textContent = empleado.comunidad || "No disponible"
          }
        })
        .catch((error) => {
          console.error("Error:", error)
          if (detallesContainer) {
            detallesContainer.innerHTML = `
                          <div class="alert alert-danger">
                              Error al cargar los detalles del empleado: ${error.message}. Por favor, inténtelo de nuevo.
                          </div>
                      `
          }
        })
    }
  })
  