<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EZPajak Navbar</title> <link rel="stylesheet" href="css\bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo.png') }}"  width="40" height="40" class="d-inline-block align-middle">
            <span class="ms-2 align-middle fs-4 fw-semibold ezpajak-color fst-italic">EZPajak</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav me-auto mb-2 mb-lg-0 ms-4"> <a class="nav-link active fs-5 me-3" aria-current="page" href="/">Home</a>
                <a class="nav-link active fs-5" href="/kuesioner">Kalkulator</a>
            </div>

            <div class="navbar-nav gap-3 d-lg-none mt-3">
                <a class="btn btn-outline-primary rounded-0 fs-5 w-100" href="/login">Login</a>
                <a class="btn btn-primary rounded-0 fs-5 w-100" href="/register">Register</a>
            </div>
        </div>

        <div class="navbar-nav gap-2 ms-auto d-none d-lg-flex ">
            <a class="btn btn-outline-primary rounded-0 fs-5 px-3" href="/login">Login</a>
            <a class="btn btn-primary rounded-0 fs-5 px-3" href="/register">Register</a>
        </div>

    </div>
</nav>

    <script src="js\bootstrap.bundle.min.js"></script>
</body>
</html>
