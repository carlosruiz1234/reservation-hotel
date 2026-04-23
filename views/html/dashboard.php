<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hotel Paradise</title>
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
                    <a class="nav-link" href="<?= SITE_URL ?>index.php">Inicio</a>
                </li>
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

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success mb-4"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="bienvenida-card mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1>👋 Hola, <?= $_SESSION['usuario']['name'] ?>!</h1>
                <p class="mb-0">Bienvenido a tu panel. Aquí puedes gestionar tus reservaciones.</p>
            </div>
            <a href="<?= SITE_URL ?>index.php?action=getFormReserva" class="btn-crear">
                + Crear reserva
            </a>
        </div>
    </div>

    <div class="reservas-section">
        <h4>📋 Mis reservaciones</h4>

        <?php if(empty($reservas)): ?>
            <div class="sin-reservas">
                <p style="font-size:3rem;">🛎️</p>
                <p>Aún no tienes reservaciones.</p>
                <p>Haz clic en <strong>"+ Crear reserva"</strong> para comenzar.</p>
            </div>

        <?php else: ?>
            <div class="tabla-reservas">
                <table class="table table-borderless mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Habitación</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Personas</th>
                            <th>Método pago</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservas as $reserva): ?>
                            <tr>
                                <td><?= $reserva['id'] ?></td>
                                <td><?= $reserva['tipo_habitacion'] ?></td>
                                <td><?= date('d/m/Y', strtotime($reserva['fecha_entrada'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($reserva['fecha_salida'])) ?></td>
                                <td><?= $reserva['num_personas'] ?> persona(s)</td>
                                <td><?= $reserva['nombre_metodo'] ?></td>
                                <td>
                                    <span class="badge-<?= $reserva['nombre_estado'] ?>">
                                        <?= ucfirst($reserva['nombre_estado']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= SITE_URL ?>index.php?action=getFormEditarReserva&id=<?= $reserva['id'] ?>"
                                       class="btn btn-sm btn-warning me-1">✏️ Editar</a>
                                    <a href="<?= SITE_URL ?>index.php?action=borrarReserva&id=<?= $reserva['id'] ?>"
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('¿Seguro que quieres eliminar esta reserva?')">
                                        🗑️ Borrar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
