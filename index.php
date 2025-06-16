<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JenVA - Asistencia Virtual</title>
    <!-- importa Bootstrap CSS desde Content Delivery Network -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Tu hoja de estilos principal -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <div class="container">
            <!-- Marca / Logo -->
            <a class="navbar-brand" href="index.php">JenVA</a>
            <!-- Botón para pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Enlaces de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Enlace al centro de soporte -->
                    <li class="nav-item"><a class="nav-link" href="soporte.php">Soporte</a></li>
                    <!-- Enlace a login -->
                    <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
                    <!-- Enlace a registro -->
                    <li class="nav-item"><a class="nav-link" href="register.php">Registrarse</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Cabecera principal -->
    <!-- custom-header: define fondo con degradado/color -->
    <header class="custom-header text-white text-center py-5">
        <div class="container">
            <h1>Bienvenido a JenVA</h1>
            <p>Tu asistente virtual para optimizar tu tiempo y gestionar tus tareas administrativas.</p>
        </div>

    </header>
    <!-- Sección de servicios -->
    <div class="container text-center mt-5">
        <h2>Nuestros Servicios</h2>
        <p>Consulta y contrata asistencia virtual a medida.</p>
    <!-- Ejemplos de tarjetas de servicio -->
        <section class="container my-5">
    <h3 class="text-center mb-4">Ejemplos de servicios que gestionamos por ti</h3>
    <div class="row g-4">

        <!-- Tarjeta 1 -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-0 position-relative">
                <img src="img/agenda.png" class="card-img" alt="Agenda">
                 <!-- Superposición oscura con texto al fondo -->
                <div class="card-img-overlay d-flex flex-column justify-content-end p-3" style="background: rgba(0,0,0,0.4);">
                    <h5 class="card-title">Gestión de Agenda</h5>
                    <p class="card-text">Organizamos tu calendario, citas y reuniones importantes.</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2 -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-0 position-relative">
                <img src="img/reservas.png" class="card-img" alt="Reservas">
                <div class="card-img-overlay d-flex flex-column justify-content-end p-3" style="background: rgba(0,0,0,0.4);">
                    <h5 class="card-title">Reservas y Viajes</h5>
                    <p class="card-text">Coordinamos hoteles, vuelos y eventos por ti.</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta 3 -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-0 position-relative">
                <img src="img/facturas.png" class="card-img" alt="Facturación">
                <div class="card-img-overlay d-flex flex-column justify-content-end p-3" style="background: rgba(0,0,0,0.4);">
                    <h5 class="card-title">Facturación</h5>
                    <p class="card-text">Gestionamos emisión, control y seguimiento de facturas.</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta 4 -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-0 position-relative">
                <img src="img/domiciliaciones.png" class="card-img" alt="Domiciliaciones">
                <div class="card-img-overlay d-flex flex-column justify-content-end p-3" style="background: rgba(0,0,0,0.4);">
                    <h5 class="card-title">Domiciliaciones</h5>
                    <p class="card-text">Nos encargamos de tus gestiones bancarias periódicas.</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta 5 -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-0 position-relative">
                <img src="img/citas.png" class="card-img" alt="Citas">
                <div class="card-img-overlay d-flex flex-column justify-content-end p-3" style="background: rgba(0,0,0,0.4);">
                    <h5 class="card-title">Gestión de Citas</h5>
                    <p class="card-text">Concertamos y confirmamos tus citas médicas o personales.</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta 6 -->
        <div class="col-md-4">
            <div class="card bg-dark text-white border-0 position-relative">
                <img src="img/tramites.png" class="card-img" alt="Trámites">
                <div class="card-img-overlay d-flex flex-column justify-content-end p-3" style="background: rgba(0,0,0,0.4);">
                    <h5 class="card-title">Tramitación Administrativa</h5>
                    <p class="card-text">Rellenamos formularios, presentamos documentos y más.</p>
                </div>
            </div>
        </div>

    </div>
</section>
        <!-- Llamada a la acción: registro -->
        <a href="register.php" class="btn btn-primary">Regístrate ahora</a>
    </div>
    <!-- Pie de página -->
    <footer class="custom-footer text-center py-3 mt-5">
        <!-- Incrusta el footer común (p. ej. links legales) -->
        <?php include("includes/footer.php"); ?>
    </footer>
    <!-- Bootstrap JS Bundle (Popper + JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>