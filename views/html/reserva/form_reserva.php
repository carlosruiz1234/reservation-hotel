<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Reserva - Hotel Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>css/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="<?= SITE_URL ?>index.php">🏨 Hotel Paradise</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <span class="nav-link text-warning fw-bold">
                        👤 <?= $_SESSION['usuario']['name'] . ' ' . $_SESSION['usuario']['last_name'] ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a href="<?= SITE_URL ?>index.php?action=logout"
                       class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">

    <a href="<?= SITE_URL ?>index.php?action=dashboard" class="btn-volver d-inline-block mb-4">
        ← Volver al dashboard
    </a>

    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="form-card">

                <h3 class="text-center mb-1 fw-bold">🛎️ Crear reserva</h3>
                <p class="text-center text-muted mb-4">Completa los datos para tu reservación</p>

                <?php if(isset($_SESSION['errors']['general'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['errors']['general'] ?></div>
                <?php endif; ?>

                <form action="<?= SITE_URL ?>index.php?action=crearReserva" method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Habitación</label>
                        <select name="tipo_habitacion"
                            class="form-select <?= isset($_SESSION['errors']['tipo_habitacion']) ? 'is-invalid' : '' ?>">
                            <option value="">-- Selecciona una habitación --</option>
                            <?php foreach($habitaciones as $hab): ?>
                                <option value="<?= $hab['num_habitacion'] ?>"
                                    <?= (($_SESSION['old']['tipo_habitacion'] ?? '') == $hab['num_habitacion']) ? 'selected' : '' ?>>
                                    Hab. <?= $hab['num_habitacion'] ?> — <?= $hab['categoria'] ?> — $<?= number_format($hab['precio'], 0, ',', '.') ?>/noche — Max <?= $hab['max_personas'] ?> personas
                                </option>
                            <?php endforeach; ?>
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
                                value="<?= $_SESSION['old']['fecha_entrada'] ?? '' ?>"
                                min="<?= date('Y-m-d') ?>">
                            <?php if(isset($_SESSION['errors']['fecha_entrada'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['fecha_entrada'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fecha de salida</label>
                            <input type="date" name="fecha_salida"
                                class="form-control <?= isset($_SESSION['errors']['fecha_salida']) ? 'is-invalid' : '' ?>"
                                value="<?= $_SESSION['old']['fecha_salida'] ?? '' ?>"
                                min="<?= date('Y-m-d') ?>">
                            <?php if(isset($_SESSION['errors']['fecha_salida'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['fecha_salida'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Número de personas</label>
                        <input type="number" name="num_personas"
                            class="form-control <?= isset($_SESSION['errors']['num_personas']) ? 'is-invalid' : '' ?>"
                            placeholder="Ej: 2" min="1" max="10"
                            value="<?= $_SESSION['old']['num_personas'] ?? '' ?>">
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
                                    <?= (($_SESSION['old']['id_metodo_pago'] ?? '') == $metodo['id']) ? 'selected' : '' ?>>
                                    <?= $metodo['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(isset($_SESSION['errors']['id_metodo_pago'])): ?>
                            <div class="invalid-feedback"><?= $_SESSION['errors']['id_metodo_pago'] ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn-reservar">
                        Confirmar reserva
                    </button>

                </form>

                <?php
                    unset($_SESSION['errors']);
                    unset($_SESSION['old']);
                    unset($_SESSION['success']);
                ?>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
