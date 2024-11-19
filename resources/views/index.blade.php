<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- Styles / Scripts -->
    </head>
    <body class="font-sans antialiased ">
        <Nav class="h-25 d-flex flex-column align-items-center justify-content-center bg-danger">
            <h1 class="text-white">Aplicación de tareas</h1>
        </Nav>
        <div class="text-bold">
            TAREAS
        </div>
        <div class="container mt-5">
            <h1 class="text-center mb-4">Crear Tarea de Contacto</h1>
            <form action="{{ url('/tareas') }}" method="POST">
                @csrf <!-- Token de seguridad obligatorio en Laravel -->
                <input type="hidden" name="tipo" value="contacto">
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa el nombre" required>
                </div>
        
                <div class="mb-3">
                    <label for="razon" class="form-label">Razón para contactar</label>
                    <input type="text" class="form-control" id="razon" name="razon" placeholder="Motivo para contactar" required>
                </div>
        
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Número de teléfono" required>
                </div>
        
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
                </div>
        
                <button type="submit" class="btn btn-primary">Guardar Tarea</button>
            </form>
        </div>

        <button class="btn btn-danger rounded-circle" style="width: 50px; height: 50px; position: fixed; bottom: 20px; right: 20px;">
            +
        </button>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>
