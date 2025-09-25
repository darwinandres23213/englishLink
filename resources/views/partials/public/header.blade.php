<!-- Header -->
<header class="header">
    <nav class="navbar">
        <div class="nav-brand">
            <a href="{{ route('welcome') }}">
                <img src="{{ asset('img/logo.png') }}" alt="EnglishLink Logo" class="logo">
                <span>EnglishLink</span>
            </a>
        </div>
        <ul class="nav-menu">
            <li><a href="{{ route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Inicio</a></li>
            <li><a href="{{ route('public.about') }}" class="nav-link {{ request()->routeIs('public.about') ? 'active' : '' }}">Nosotros</a></li>
            <li><a href="{{ route('public.courses') }}" class="nav-link {{ request()->routeIs('public.courses') ? 'active' : '' }}">Cursos</a></li>
            <li><a href="{{ route('public.contact') }}" class="nav-link {{ request()->routeIs('public.contact') ? 'active' : '' }}">Contacto</a></li>
            <li><a href="{{ route('login') }}" class="nav-link login-btn">Ingresar</a></li>
        </ul>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
</header>
