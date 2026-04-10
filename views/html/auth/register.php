<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Hotel Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>/css/styles.css">
</head>
<body class="bg-light">

<!--barra de nav -->
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

<!-- form  -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">

                    <h3 class="text-center fw-bold mb-1">🏨 Crear cuenta</h3>
                    <p class="text-center text-muted mb-4">Regístrate para hacer tus reservaciones</p>

                    <?php if(isset($_SESSION['errors']['general'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['errors']['general'] ?></div>
                    <?php endif; ?>

                    <form action="<?= SITE_URL ?>index.php?action=registerUser" method="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tipo de documento</label>
                            <select name="document_type_id"
                                class="form-select <?= isset($_SESSION['errors']['document_type_id']) ? 'is-invalid' : '' ?>">
                                <option value="">-- Selecciona --</option>
                                <option value="1" <?= (($_SESSION['old']['document_type_id'] ?? '') == '1') ? 'selected' : '' ?>>Cédula de Ciudadanía</option>
                                <option value="2" <?= (($_SESSION['old']['document_type_id'] ?? '') == '2') ? 'selected' : '' ?>>Tarjeta de Identidad</option>
                                <option value="3" <?= (($_SESSION['old']['document_type_id'] ?? '') == '3') ? 'selected' : '' ?>>Pasaporte</option>
                            </select>
                            <?php if(isset($_SESSION['errors']['document_type_id'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['document_type_id'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Número de documento</label>
                            <input type="text" name="document_number"
                                class="form-control <?= isset($_SESSION['errors']['document_number']) ? 'is-invalid' : '' ?>"
                                placeholder="Ej: 1234567890"
                                value="<?= $_SESSION['old']['document_number'] ?? '' ?>">
                            <?php if(isset($_SESSION['errors']['document_number'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['document_number'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nombre</label>
                                <input type="text" name="name"
                                    class="form-control <?= isset($_SESSION['errors']['name']) ? 'is-invalid' : '' ?>"
                                    placeholder="Tu nombre"
                                    value="<?= $_SESSION['old']['name'] ?? '' ?>">
                                <?php if(isset($_SESSION['errors']['name'])): ?>
                                    <div class="invalid-feedback"><?= $_SESSION['errors']['name'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Apellido</label>
                                <input type="text" name="last_name"
                                    class="form-control <?= isset($_SESSION['errors']['last_name']) ? 'is-invalid' : '' ?>"
                                    placeholder="Tu apellido"
                                    value="<?= $_SESSION['old']['last_name'] ?? '' ?>">
                                <?php if(isset($_SESSION['errors']['last_name'])): ?>
                                    <div class="invalid-feedback"><?= $_SESSION['errors']['last_name'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Teléfono -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="text" name="phone"
                                class="form-control <?= isset($_SESSION['errors']['phone']) ? 'is-invalid' : '' ?>"
                                placeholder="Ej: 3001234567"
                                value="<?= $_SESSION['old']['phone'] ?? '' ?>">
                            <?php if(isset($_SESSION['errors']['phone'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['phone'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo electrónico</label>
                            <input type="email" name="email"
                                class="form-control <?= isset($_SESSION['errors']['email']) ? 'is-invalid' : '' ?>"
                                placeholder="correo@ejemplo.com"
                                value="<?= $_SESSION['old']['email'] ?? '' ?>">
                            <?php if(isset($_SESSION['errors']['email'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['email'] ?></div>
                            <?php endif; ?>
                        </div>


                        <div class="mb-4">
                            <label class="form-label fw-semibold">Contraseña</label>
                            <input type="password" name="password"
                                class="form-control <?= isset($_SESSION['errors']['password']) ? 'is-invalid' : '' ?>"
                                placeholder="Mínimo 6 caracteres">
                            <?php if(isset($_SESSION['errors']['password'])): ?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['password'] ?></div>
                            <?php endif; ?>
                        </div>

                        <div  class="mb-5">
                            <label class="form-label fw-semibold">Confirmar Contraseña</label>
                            <input type="password" name="confirmar-password"
                            class="form-control <?= isset($_SESSION['errors']['confirmar-password']) ? 'is-invalid' : '' ?>"
                            placeholder="confirmar contraseña">
                            <?php if(isset($_SESSION['errors']['confirmar-password'])):?>
                                <div class="invalid-feedback"><?= $_SESSION['errors']['confirmar-password'] ?></div>
                            <?php endif; ?>
                        </div>  

                        <input type="hidden" name="role_id" value="2">

                        <button type="submit" class=" btn-purple w-100 py-2 fw-bold">
                            Crear cuenta
                        </button>

                        <p class="text-center mt-3 text-muted small">
                            ¿Ya tienes cuenta?
                            <a href="<?= SITE_URL ?>index.php?action=getFormLoginUser" class="btn-purple-sign fw-bold">Ingresar</a>
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
