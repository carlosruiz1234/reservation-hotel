<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reserva - Hotel Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="<?= SITE_URL ?>index.php">Hotel Blox</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <span class="nav-link text-warning fw-bold">
                        <?= $_SESSION['usuario']['name'] . ' ' . $_SESSION['usuario']['last_name'] ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a href="<?= SITE_URL ?>index.php?action=logout" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <a href="<?= SITE_URL ?>index.php?action=dashboard" class="btn-volver d-inline-block mb-4">← Volver al dashboard</a>

    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="form-card">

                <h3 class="text-center fw-bold mb-1"> Editar reserva</h3>
                <p class="text-center text-muted mb-4">Modifica los datos de tu reservación</p>

                <?php if(isset($_SESSION['errors']['general'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['errors']['general'] ?></div>
                <?php endif; ?>

                <form action="<?= SITE_URL ?>index.php?action=editarReserva" method="POST">

                    <input type="hidden" name="id" value="<?= $datosReserva['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipo de habitación</label>
                        <select name="id_categoria" id="id_categoria"
                            class="form-select <?= isset($_SESSION['errors']['id_categoria']) ? 'is-invalid' : '' ?>">
                            <option value="">-- Selecciona un tipo --</option>
                            <?php foreach($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= ($cat['id'] == $categoriaActual) ? 'selected' : '' ?>>
                                    <?= $cat['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(isset($_SESSION['errors']['id_categoria'])): ?>
                            <div class="invalid-feedback"><?= $_SESSION['errors']['id_categoria'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Paso 2: Habitación específica (se llena con AJAX) -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Habitación</label>
                        <select name="tipo_habitacion" id="tipo_habitacion"
                            class="form-select <?= isset($_SESSION['errors']['tipo_habitacion']) ? 'is-invalid' : '' ?>">
                            <option value="">-- Cargando habitaciones... --</option>
                        </select>
                        <?php if(isset($_SESSION['errors']['tipo_habitacion'])): ?>
                            <div class="invalid-feedback"><?= $_SESSION['errors']['tipo_habitacion'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha de entrada</label>
                            <input type="date" name="fecha_entrada"
                                class="form-control <?= isset($_SESSION['errors']['fecha_entrada']) ? 'is-invalid' : '' ?>"
                                value="<?= $_SESSION['old']['fecha_entrada'] ?? $datosReserva['fecha_entrada'] ?>">
                            <?php if(isset($_SESSION['errors']['fecha_entrada'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['fecha_entrada'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha de salida</label>
                            <input type="date" name="fecha_salida"
                                class="form-control <?= isset($_SESSION['errors']['fecha_salida']) ? 'is-invalid' : '' ?>"
                                value="<?= $_SESSION['old']['fecha_salida'] ?? $datosReserva['fecha_salida'] ?>">
                            <?php if(isset($_SESSION['errors']['fecha_salida'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['fecha_salida'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Número de personas</label>
                        <input type="number" name="num_personas"
                            class="form-control <?= isset($_SESSION['errors']['num_personas']) ? 'is-invalid' : '' ?>"
                            min="1" max="10"
                            value="<?= $_SESSION['old']['num_personas'] ?? $datosReserva['num_personas'] ?>">
                        <?php if(isset($_SESSION['errors']['num_personas'])): ?>
                            <div class="invalid-feedback"><?= $_SESSION['errors']['num_personas'] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Método de pago</label>
                        <select name="id_metodo_pago"
                            class="form-select <?= isset($_SESSION['errors']['id_metodo_pago']) ? 'is-invalid' : '' ?>">
                            <option value="">-- Selecciona un método --</option>
                            <?php foreach($metodosPago as $metodo): ?>
                                <option value="<?= $metodo['id'] ?>"
                                    <?= (($_SESSION['old']['id_metodo_pago'] ?? $datosReserva['id_metodo_pago']) == $metodo['id']) ? 'selected' : '' ?>>
                                    <?= $metodo['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(isset($_SESSION['errors']['id_metodo_pago'])): ?>
                            <div class="invalid-feedback"><?= $_SESSION['errors']['id_metodo_pago'] ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn-guardar">Guardar cambios</button>

                </form>

                <?php
                    unset($_SESSION['errors']);
                    unset($_SESSION['old']);
                ?>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const selectCategoria  = document.getElementById('id_categoria');
const selectHabitacion = document.getElementById('tipo_habitacion');

const habitacionActual = "<?= $datosReserva['tipo_habitacion'] ?>";

async function cargarHabitaciones(idCategoria, seleccionar) {
    if (!idCategoria) {
        selectHabitacion.innerHTML = '<option value="">-- Primero selecciona un tipo --</option>';
        selectHabitacion.disabled = true;
        return;
    }

    try {
        const response = await fetch(`index.php?action=getHabitacionesPorCategoria&id_categoria=${idCategoria}`);
        const result   = await response.json();
        if (result.ok && result.data.length > 0) {

            selectHabitacion.innerHTML = '<option value="">-- Selecciona una habitación --</option>';
            result.data.forEach(hab => {
                const selected = hab.num_habitacion == seleccionar ? 'selected' : '';
                selectHabitacion.innerHTML += `<option value="${hab.num_habitacion}" ${selected}>
                    Hab. ${hab.num_habitacion} — $${Number(hab.precio).toLocaleString('es-CO')}/noche
                </option>`;
            });
            selectHabitacion.disabled = false;
        } else {
            selectHabitacion.innerHTML = '<option value="">No hay habitaciones disponibles</option>';
            selectHabitacion.disabled = true;
        }

    } catch (error) {
        console.log('Error al cargar habitaciones:', error);
    }
}

window.addEventListener('load', () => {
    const categoriaInicial = selectCategoria.value;
    if (categoriaInicial) {
        cargarHabitaciones(categoriaInicial, habitacionActual);
    }
});

selectCategoria.addEventListener('change', () => {
    cargarHabitaciones(selectCategoria.value, '');
});</script>

</body>
</html>
