<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar - Hotel Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>css/styles.css">
</head>
<body class="bg-light">

<!--barar de nav -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="<?= SITE_URL ?>index.php">🏨 Hotel Paradise</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="<?= SITE_URL ?>index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser"
                       class="btn btn-outline-light btn-sm">Registrarse</a>
                </li>
                <li class="nav-item">
                    <a href="<?= SITE_URL ?>index.php?action=getFormLoginUser"
                       class="btn btn-purple btn-sm text-dark fw-bold">Ingresar</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- este es el form -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <h3 class="text-center fw-bold mb-1"> Iniciar sesión</h3>
                    <p class="text-center text-muted mb-4">Ingresa a tu cuenta para reservar</p>

                    
                    <?php if(isset($_SESSION['errors']['general'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['errors']['general'] ?></div>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
                    <?php endif; ?>

                    <form action="<?= SITE_URL ?>index.php?action=loginUser" method="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo electrónico</label>
                            <input type="email" name="email" class="form-control"
                                placeholder="correoejemplo@gmail.com"
                                value="<?= $_SESSION['old']['email'] ?? '' ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Contraseña</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="tu contraseña">
                        </div>

                        <button type="submit" class="btn btn-purple w-100 py-2 fw-bold">
                            Ingresar
                        </button>

                        <p class="text-center mt-3 text-muted small">
                            ¿No tienes cuenta?
                            <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser" class="btn btn-purple-sign fw-bold">Regístrate gratis</a>
                        </p>

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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
