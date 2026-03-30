<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Not Found Page</title>
    <link rel="shortcut icon" href="{{ asset("logo-protection-civile.png") }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
</head>
<body>

    <div class="notFound">
            
            <div class="w-100 text-light">
                
                <div class="card-body text-center">
                    <h1 class="h1 display-1 fw-bold mb-0">404</h1>
                    <p class="fs-5">
                        Oups ! La page que vous recherchez est introuvable.
                    </p>
                    <a href="{{ url('/') }}" class="btn btn-lg btn-outline-primary mt-2">Retourne a l'acceuil</a>
                </div>

            </div>

    </div>
    
</body>
</html>
