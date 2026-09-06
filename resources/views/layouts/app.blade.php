<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('includes.style')
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])

</head>

<body>
    <div id="app">
        @include('includes.language')
        @include('includes.scripts')
        @auth
        <main>
            <div class="container-fluid p-0">
                <div class="row" id="body-row">

                    <!-- Sidebar -->
                    <div id="sidebar-container" class="sidebar-expanded col-md-3 col-lg-2">
                        @include('includes.sidebar')
                    </div>

                    <!-- MAIN content -->
                    <div class="col-md-9 col-lg-10 p-0">
                        {{-- Page header / navbar --}}
                        <div class="page-header d-flex justify-content-between align-items-center">
                            <div class="left-header d-flex align-items-center gap-3">
                                <button type="button" id="mobile-sidebar-btn" class="btn btn-link d-md-none p-0" aria-label="Otvori meni">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <h4>{{ __('Dobrodošli') }} {{ Auth::user()->name }}</h4>
                            </div>
                            <div class="right-header d-flex align-items-center gap-3">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-link p-0 text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-user-circle fa-lg"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('moj-nalog') }}">
                                                <i class="fa fa-user me-2"></i>Moj nalog
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out me-2"></i>Odjava
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <div class="main-container">
                            <div class="container" id="message">
                                @include('includes.message_alert')
                            </div>
                            @include('includes.breadcrumbs')
                            @yield('content')
                        </div>
                    </div>

                </div>
            </div>
        </main>
        @endauth

        @guest
        <div class="col-md-12">
            @yield('content')
        </div>
        @endguest
    </div>
    @yield('content_scripts')
</body>

</html>

<script src="{{ asset('vendor/js-localization/js-localization.js') }}"></script>