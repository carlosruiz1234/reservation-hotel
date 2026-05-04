const docTipo     = document.getElementById('document_type_id');
const docNumero   = document.getElementById('document_number');
const nombre      = document.getElementById('name');
const apellido    = document.getElementById('last_name');
const telefono    = document.getElementById('phone');
const email       = document.getElementById('email');
const password    = document.getElementById('password');
const confirmar   = document.getElementById('confirmar_password');
const btnRegistrar = document.getElementById('btnRegistrar');

function mostrarError(campoId, errorId, mensaje) {
    const campo = document.getElementById(campoId);
    const error = document.getElementById(errorId);
    campo.classList.add('is-invalid');
    campo.classList.remove('is-valid');
    error.textContent = mensaje;
}

function mostrarExito(campoId, errorId) {
    const campo = document.getElementById(campoId);
    const error = document.getElementById(errorId);
    campo.classList.remove('is-invalid');
    campo.classList.add('is-valid');
    error.textContent = '';
}


function validarDocTipo() {
    if (docTipo.value === '') {
        mostrarError('document_type_id', 'error_document_type_id', 'El tipo de documento es requerido');
        return false;
    }
    mostrarExito('document_type_id', 'error_document_type_id');
    return true;
}

function validarDocNumero() {
    const val = docNumero.value.trim();
    if (val === '') {
        mostrarError('document_number', 'error_document_number', 'El número de documento es requerido');
        return false;
    }
    if (!/^[0-9]+$/.test(val)) {
        mostrarError('document_number', 'error_document_number', 'Solo puede contener números');
        return false;
    }
    if (val.length < 10) {
        mostrarError('document_number', 'error_document_number', 'Debe tener al menos 10 dígitos');
        return false;
    }
    if (val.length > 20) {
        mostrarError('document_number', 'error_document_number', 'No puede tener más de 20 caracteres');
        return false;
    }
    mostrarExito('document_number', 'error_document_number');
    return true;
}

function validarNombre() {
    const val = nombre.value.trim();
    if (val === '') {
        mostrarError('name', 'error_name', 'El nombre es requerido');
        return false;
    }
    if (val.length < 3) {
        mostrarError('name', 'error_name', 'Debe tener al menos 3 caracteres');
        return false;
    }
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(val)) {
        mostrarError('name', 'error_name', 'Solo puede contener letras');
        return false;
    }
    mostrarExito('name', 'error_name');
    return true;
}

function validarApellido() {
    const val = apellido.value.trim();
    if (val === '') {
        mostrarError('last_name', 'error_last_name', 'El apellido es requerido');
        return false;
    }
    if (val.length < 3) {
        mostrarError('last_name', 'error_last_name', 'Debe tener al menos 3 caracteres');
        return false;
    }
    if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(val)) {
        mostrarError('last_name', 'error_last_name', 'Solo puede contener letras');
        return false;
    }
    mostrarExito('last_name', 'error_last_name');
    return true;
}

function validarTelefono() {
    const val = telefono.value.trim();
    if (val === '') {
        mostrarError('phone', 'error_phone', 'El teléfono es requerido');
        return false;
    }
    if (!/^[0-9]+$/.test(val)) {
        mostrarError('phone', 'error_phone', 'Solo puede contener números');
        return false;
    }
    if (val.length < 10) {
        mostrarError('phone', 'error_phone', 'Debe tener al menos 10 dígitos');
        return false;
    }
    if (val.length > 10) {
        mostrarError('phone', 'error_phone', 'No puede tener más de 10 dígitos');
        return false;
    }
    mostrarExito('phone', 'error_phone');
    return true;
}

function validarEmail() {
    const val = email.value.trim();
    if (val === '') {
        mostrarError('email', 'error_email', 'El correo es requerido');
        return false;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
        mostrarError('email', 'error_email', 'El correo no es válido');
        return false;
    }
    mostrarExito('email', 'error_email');
    return true;
}

function validarPassword() {
    const val = password.value;
    if (val === '') {
        mostrarError('password', 'error_password', 'La contraseña es requerida');
        return false;
    }
    if (val.length < 6) {
        mostrarError('password', 'error_password', 'Mínimo 6 caracteres');
        return false;
    }
    if (!/[A-Z]/.test(val)) {
        mostrarError('password', 'error_password', 'Debe tener al menos una mayúscula');
        return false;
    }
    if (!/[a-z]/.test(val)) {
        mostrarError('password', 'error_password', 'Debe tener al menos una minúscula');
        return false;
    }
    if (!/[0-9]/.test(val)) {
        mostrarError('password', 'error_password', 'Debe tener al menos un número');
        return false;
    }
    if (!/[^A-Za-z0-9]/.test(val)) {
        mostrarError('password', 'error_password', 'Debe tener al menos un carácter especial (!@#$%...)');
        return false;
    }
    mostrarExito('password', 'error_password');
    return true;
}

function validarConfirmar() {
    const val = confirmar.value;
    if (val === '') {
        mostrarError('confirmar_password', 'error_confirmar_password', 'Confirmar contraseña es requerida');
        return false;
    }
    if (val !== password.value) {
        mostrarError('confirmar_password', 'error_confirmar_password', 'Las contraseñas no coinciden');
        return false;
    }
    mostrarExito('confirmar_password', 'error_confirmar_password');
    return true;
}

function revisarFormulario() {
    const todoOk =
        validarDocTipo()   &&
        validarDocNumero() &&
        validarNombre()    &&
        validarApellido()  &&
        validarTelefono()  &&
        validarEmail()     &&
        validarPassword()  &&
        validarConfirmar();

    btnRegistrar.disabled = !todoOk;
}

docTipo.addEventListener('change', revisarFormulario);
docNumero.addEventListener('blur', revisarFormulario);
docNumero.addEventListener('input', revisarFormulario);
nombre.addEventListener('blur', revisarFormulario);
nombre.addEventListener('input', revisarFormulario);
apellido.addEventListener('blur', revisarFormulario);
apellido.addEventListener('input', revisarFormulario);
telefono.addEventListener('blur', revisarFormulario);
telefono.addEventListener('input', revisarFormulario);
email.addEventListener('blur', revisarFormulario);
email.addEventListener('input', revisarFormulario);
password.addEventListener('blur', revisarFormulario);
password.addEventListener('input', revisarFormulario);
confirmar.addEventListener('blur', revisarFormulario);
confirmar.addEventListener('input', revisarFormulario);



