<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- Configuración de la vista en dispositivos móviles para que el diseño sea responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte - JenVA</title>

    <!-- Importación de Bootstrap para el diseño y estilos modernos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css"> <!-- Archivo CSS personalizado -->
</head>
<body>
    <!-- Barra de navegación superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">JenVA</a> <!-- Logo/Nombre de la web -->
            <div class="ml-auto"> <!-- Sección a la derecha con botón de inicio de sesión -->
                <a href="login.php" class="btn btn-outline-light">Iniciar Sesión</a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <!-- Título del centro de soporte -->
        <h2 class="text-center">Centro de Soporte</h2>
        <p class="text-center">Encuentra respuestas a preguntas frecuentes o contáctanos.</p>
        
        <!-- Sección de preguntas frecuentes con acordeón de Bootstrap -->
        <div class="accordion mt-4" id="faqAccordion">
            <!-- Primera pregunta frecuente -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                        ¿Cómo solicito una tarea?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Para solicitar una tarea, debes iniciar sesión y acceder a tu <a href="pages/dashboard.php">panel de cliente</a>.
                    </div>
                </div>
            </div>
            
            <!-- Segunda pregunta frecuente -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        ¿Cómo veo mi historial de tareas?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Puedes ver tu historial iniciando sesión y visitando la sección <a href="pages/historial.php">"Historial de Servicios"</a>.
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de contacto -->
        <h3 class="mt-5 text-center">Contacto</h3>
        <p class="text-center">Si necesitas más ayuda, contáctanos a través de los siguientes medios:</p>
        
        <!-- Lista de opciones de contacto con estilos de Bootstrap -->
        <ul class="list-group w-50 mx-auto">
            <li class="list-group-item"><strong>Email:</strong> informacion@jenva.es</li>
            <li class="list-group-item"><strong>Teléfono:</strong> +34 123 456 789</li>
            <li class="list-group-item"><strong>WhatsApp:</strong> <a href="https://wa.me/34123456789" target="_blank">+34 123 456 789</a></li>
        </ul>
    </div>

    <!-- Inclusión de los scripts de Bootstrap para que funcionen los componentes interactivos -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
