<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GDS | @yield("title", "Accueil")</title>
    <link rel="shortcut icon" href="{{ asset("logo-protection-civile.png") }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/65585b5760.js" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="{{ asset("css/app.css") }}">
</head>
<body class="bg-secondary-subtle">

    @include("partials.nav")

    @error("error")
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>
            {{ $message }}</strong> 
        </div>
        <script>
          $(".alert").alert();
        </script>
    @enderror
    
    <div id="content" class="{{ Route::is("users.index") ? "container-fluide mx-5" : "container" }}">
        @yield('content')
    </div>
    
    @include("partials.footer")   

    @error("message-error")
        <div class="toast-container" id="toastContainer">
            <div class="toast-error" id="errorToast">
                <div class="error-toast-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div class="toast-content">
                    {{ $message }}
                </div>
                <script>
                    setTimeout(() => {
                        const toast = document.getElementById('errorToast');
                        if (toast) {
                            toast.style.animation = 'fadeOut 0.5s ease forwards';
                            setTimeout(() => {
                                toast.remove();
                            }, 500);
                        }
                    }, 3000);
                </script>
            </div>

        </div>
    @enderror

    @if(session()->has("message-success"))
        <div class="toast-container" id="toastContainer">
            <div class="toast-success" id="successToast">
                <div class="success-toast-icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="toast-content">
                    {{ session("message-success") }}
                </div>
                <script>
                    setTimeout(() => {
                        const toast = document.getElementById('successToast');
                        if (toast) {
                            toast.style.animation = 'fadeOut 0.5s ease forwards';
                            setTimeout(() => {
                                toast.remove();
                            }, 500);
                        }
                    }, 3000);
                </script>
            </div>

        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</body>
</html>