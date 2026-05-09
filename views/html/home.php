<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Paradise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= SITE_URL ?>css/styles.css">
</head>

<body>
<!-- barra  -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="<?= SITE_URL ?>index.php">Hotel blox</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuNav">
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link" href="<?= SITE_URL ?>index.php">Inicio</a>
                </li>
                <?php if(isset($_SESSION['usuario'])): ?>
                    <li class="nav-item">
                        <span class="nav-link text-warning fw-bold">
                             <?= $_SESSION['usuario']['name'] ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a href="<?= SITE_URL ?>index.php?action=dashboard" 
                        class="btn btn-purple btn-sm me-1">
                            Mi dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= SITE_URL ?>index.php?action=logout"
                        class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser"
                        class="btn btn-outline-light btn-sm">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= SITE_URL ?>index.php?action=getFormLoginUser"
                        class="btn btn-warning btn-sm text-dark fw-bold">Ingresar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
 
<!-- carrusel -->
<div id="carruselHotel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carruselHotel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#carruselHotel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#carruselHotel" data-bs-slide-to="2"></button>
    </div>

    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="https://plus.unsplash.com/premium_photo-1733342441106-96a5e23b2c9f?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                 class="d-block w-100" style="height:550px; object-fit:cover; opacity: 0.9;" alt="Hotel Paradise">
            <div class="carousel-caption d-none d-md-block">
                <h2 class= "display-5 fw-bold" style="color: #0D0D0D; text-shadow: 2px 2px 4px rgba(0,0,0,0.6);">Bienvenido a Hotel Paradise</h2>
                <p class="fs-5" style="color: #0D0D0D; text-shadow: 2px 2px 4px rgba(0,0,0,0.6); ">Tu descanso perfecto nos espera</p>
                <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser"
                   class="btn btn-warning btn-lg mt-2 text-dark fw-bold">Reservar ahora</a>
            </div>
        </div>

        <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1720694924759-2a2daaa98987?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                 class="d-block w-100" style="height:550px; object-fit:cover; opacity: 0.9;" alt="Bar">
            <div class="carousel-caption d-none d-md-block">
                <h2 class="display-5 fw-bold"style="color: #ffffff; text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.6);">Servicio Bar</h2>
                <p class="fs-5" style="color: #ffffff; text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.6);">Para disfrutar con los que mas quieres</p>
            </div>
        </div>

        <div class="carousel-item">
            <img src="https://plus.unsplash.com/premium_photo-1764687875096-2667794f2ac5?q=80&w=1632&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                 class="d-block w-100" style="height:550px; object-fit:cover; opacity: 0.9;" alt="Habitaciones">
            <div class="carousel-caption d-none d-md-block">
                <h2 class="display-5 fw-bold"style="color: #ffffff; text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.6);">Habitaciones de lujo</h2>
                <p class="fs-5"style="color: #ffffff; text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.6);">Relájate y disfruta de un alojamiento de primera clase</p>
            </div>
        </div>

    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carruselHotel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carruselHotel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- por que elegirnos  -->
<section class="py-5">
    <div class="container-down">
        <h2 class="text-center fw-bold mb-1" style="font-family:'Georgia',serif;">¿Por qué elegirnos?</h2>
        <p class="text-center text-muted mb-5">Más de 20 años brindando experiencias inolvidables</p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow text-center h-100 p-3">
                    <div class="card-body">
                        <div class="fs-1 mb-3"></div>
                        <h5 class="fw-bold">Habitaciones Premium</h5>
                        <p class="text-muted">Habitaciones amplias con cama king size, TV 4K, minibar y vista al mar.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow text-center h-100 p-3">
                    <div class="card-body">
                        <div class="fs-1 mb-3"></div>
                        <h5 class="fw-bold">Restaurante Gourmet</h5>
                        <p class="text-muted">Cocina internacional preparada por chefs de talla mundial, disponible las 24 horas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow text-center h-100 p-3">
                    <div class="card-body">
                        <div class="fs-1 mb-3"></div>
                        <h5 class="fw-bold">Piscina & Spa</h5>
                        <p class="text-muted">Relájate en nuestra piscina olímpica con tratamientos de lujo personalizados.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- nuestras habitaciones -->
<section class="py-5 bg-light">
    <div class="container-down">
        <h2 class="text-center fw-bold mb-1" style="font-family:'Georgia',serif;">Nuestras Habitaciones</h2>
        <p class="text-center text-muted mb-5">Encuentra la habitación perfecta para ti</p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow h-100">
                    <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=500&h=220&fit=crop"
                         class="card-img-top" style="height:200px; object-fit:cover;" alt="Estándar">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold">Habitación Estándar</h5>
                        <p class="text-muted flex-grow-1">Cómoda y acogedora, perfecta para viajeros de negocios o turistas.</p>
                        <p class="fw-bold fs-5" style="color:#301934;">$80.000 / noche</p>
                        <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser"
                           class="btn btn-purple w-100">Reservar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow h-100">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=500&h=220&fit=crop"
                         class="card-img-top" style="height:200px; object-fit:cover;" alt="Deluxe">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold">Habitación Deluxe</h5>
                        <p class="text-muted flex-grow-1">Espaciosa con vista panorámica, jacuzzi privado y servicio a la habitación.</p>
                        <p class="fw-bold fs-5" style="color:#301934;">$150.000 / noche</p>
                        <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser"
                           class="btn btn-purple w-100">Reservar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow h-100">
                    <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=500&h=220&fit=crop"
                         class="card-img-top" style="height:200px; object-fit:cover;" alt="Suite">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold">Suite Presidencial</h5>
                        <p class="text-muted flex-grow-1">Lo mejor del lujo con sala privada, terraza y mayordomo personal.</p>
                        <p class="fw-bold fs-5" style="color:#301934;">$350.000 / noche</p>
                        <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser"
                           class="btn btn-purple w-100">Reservar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- footer -->
<footer class="bg-purple text-white text-center py-4">
    <p class="mb-0">© 2024 Hotel Paradise  |  Todos los derechos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
