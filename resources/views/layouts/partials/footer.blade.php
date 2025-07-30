<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Footer</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/foot.css') }}"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/foot.css'])
</head>
<body>
    <div class="d-flex flex-column cyan-blue pt-4">
        <div class="row ps-3 pe-3">
            {{-- footer 1 --}}
            <div class="col-12 col-md-6 d-flex flex-column p-3 gap-3">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <img src="{{asset('images/logo.png')}}" width="40" height="40" class="d-inline-block align-middle">
                    <span class="ms-2 align-middle fs-4 fw-semibold ezpajak-color text-blue fst-italic" style="font-family: Raleway;">EZPajak</span>
                </a>
                <p class="mb-0 w-50">EZPajak menjadi platform pembayaran pajak unggulan melalui panduan ringan buat urus Pajak Kamu. Dibuat khusus dengan bahasa dan tampilan yang relate. Anti kaku, dan tetap profesional.</p>
                <div class="d-flex flex-row gap-4 align-items-center">
                    <img class="w-icon" src="{{ asset('img/ic_baseline-facebook.png') }}" alt="">
                    <img class="w-x" src="{{ asset('img/devicon_twitter.png') }}" alt="">
                    <img class="w-icon" src="{{ asset('img/mdi_instagram.png') }}" alt="">
                    <img class="w-icon" src="{{ asset('img/mdi_linkedin.png') }}" alt="">
                </div>
                <button class="btn border border-2 border-primary rounded-0 p-0 d-flex flex-row gap-4 w-25 align-items-center p-2" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">
                    <p class="ms-2 m-0">Back to top</p>
                    <div class="justify-content-center">
                        <svg width="24" height="12" viewBox="0 0 24 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_543_43)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7109 1.84306L18.3679 7.50006L16.9539 8.91406L12.0039 3.96406L7.05389 8.91406L5.63989 7.50006L11.2969 1.84306C11.4844 1.65559 11.7387 1.55028 12.0039 1.55028C12.2691 1.55028 12.5234 1.65559 12.7109 1.84306Z" fill="#142143"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_543_43">
                            <rect width="12" height="24" fill="white" transform="matrix(0 -1 1 0 0 12)"/>
                            </clipPath>
                            </defs>
                        </svg>
                    </div>

                </button>
            </div>
            {{-- footer 2 --}}
            <div class="col-6 col-md-3 d-flex flex-column p-3">
                <h4>Navigasi Cepat</h4>
                @guest
                    <ul class="ps-0">
                        <li class="list-group-item"><a class="list-group-item" href="/">Home</a></li>
                        <li class="list-group-item"><a class="list-group-item" href="/kuesioner">Kalkulator</a></li>
                        <li class="list-group-item"><a class="list-group-item" href="/login">Login</a></li>
                        <li class="list-group-item"><a class="list-group-item" href="/register">Register</a></li>
                    </ul>
                    @endguest
                @auth
                    <ul class="ps-0">
                        <li class="list-group-item"><a class="list-group-item" href="/">Home</a></li>
                        <li class="list-group-item"><a class="list-group-item" href="/kuesioner">Kalkulator</a></li>
                        <li class="list-group-item"><a class="list-group-item" href="/home">Dashboard</a></li>
                        <li class="list-group-item"><a class="list-group-item" href="/exit">Log Out</a></li>
                    </ul>
                @endauth
            </div>
            {{-- footer 3 --}}
            <div class="col-6 col-md-3 d-flex flex-column p-3">
                <h4>Kontak kami</h4>
                <ul class="ps-0">
                    <li class="list-group-item">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.75033C17.4167 3.87949 16.7042 3.16699 15.8333 3.16699H3.16668C2.29584 3.16699 1.58334 3.87949 1.58334 4.75033V14.2503C1.58334 15.1212 2.29584 15.8337 3.16668 15.8337H15.8333C16.7042 15.8337 17.4167 15.1212 17.4167 14.2503V4.75033ZM15.8333 4.75033L9.50001 8.70866L3.16668 4.75033H15.8333ZM15.8333 14.2503H3.16668V6.33366L9.50001 10.292L15.8333 6.33366V14.2503Z" fill="#142143"/>
                        </svg>
                         ezpajak@gmail.com</li>
                    <li class="list-group-item">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.24083 8.54208C6.38083 10.7825 8.2175 12.6112 10.4579 13.7592L12.1996 12.0175C12.4133 11.8038 12.73 11.7325 13.0071 11.8275C13.8938 12.1204 14.8517 12.2788 15.8333 12.2788C16.2688 12.2788 16.625 12.635 16.625 13.0704V15.8333C16.625 16.2688 16.2688 16.625 15.8333 16.625C8.39958 16.625 2.375 10.6004 2.375 3.16667C2.375 2.73125 2.73125 2.375 3.16667 2.375H5.9375C6.37292 2.375 6.72917 2.73125 6.72917 3.16667C6.72917 4.15625 6.8875 5.10625 7.18042 5.99292C7.2675 6.27 7.20417 6.57875 6.9825 6.80042L5.24083 8.54208Z" fill="#142143"/>
                        </svg>
                        +62 812 345 678</li>
                    <li class="list-group-item">
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.94334 16.4825C9.81414 16.5753 9.65908 16.6252 9.50001 16.6252C9.34094 16.6252 9.18588 16.5753 9.05668 16.4825C5.23372 13.7576 1.17643 8.15258 5.27805 4.10242C6.40407 2.99476 7.9205 2.37431 9.50001 2.375C11.0833 2.375 12.6026 2.99646 13.722 4.10163C17.8236 8.15179 13.7663 13.756 9.94334 16.4825Z" stroke="#142143" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.50002 9.49967C9.91995 9.49967 10.3227 9.33286 10.6196 9.03593C10.9165 8.73899 11.0834 8.33627 11.0834 7.91634C11.0834 7.49642 10.9165 7.09369 10.6196 6.79676C10.3227 6.49982 9.91995 6.33301 9.50002 6.33301C9.08009 6.33301 8.67737 6.49982 8.38043 6.79676C8.0835 7.09369 7.91669 7.49642 7.91669 7.91634C7.91669 8.33627 8.0835 8.73899 8.38043 9.03593C8.67737 9.33286 9.08009 9.49967 9.50002 9.49967Z" stroke="#142143" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        456 Jl. Soekarno Hatta, Jakarta Pusat</li>
                </ul>
            </div>
        </div>
        <hr class="m-0 mb-1 primary">
        <div class="d-flex justify-content-center gap-2">
            <img src="{{ asset('img/ooui_logo-cc.png') }}" alt="">
            <h6 class="fw-light mb-0 pt-1 pb-1">EzPajak UI, All rights reserved</h6>
        </div>
    </div>
</body>
</html>