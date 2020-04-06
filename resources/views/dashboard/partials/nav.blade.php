<nav class="nav extended">
    <div class="app_name">
        <span>UG</span>
        <span>UG</span>
    </div>
    <ul id="myNav">
        <li>
            <a href="{{ route('home') }}">
                <div class="icono"><i class="fas fa-home"></i></div>
                <div class="nav-titulo">Inicio</div>
            </a>
        </li>
         @if (config('app.debug') == true)
        <li>

            <a href="{{ route('changeDay') }}">
                <div class="icono">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="nav-titulo">Cambiar dia</div>
            </a>
        </li>
        @endif
        @if (Auth()->user()->role == 'superadmin')
        <li>
            <a href="{{ route('colorSetting.index') }}">
                <i class="fas fa-palette"></i>
                <div class="nav-titulo">Colores</div>
            </a>
        </li>
        <li>
            <a href="{{ route('group.index') }}">
                <i class="fas fa-sitemap"></i>
                <div class="nav-titulo">Grupos</div>
            </a>
        </li>
        @endif

        <li>
            <a href="{{ route('user.index') }}">
                <i class="fas fa-users"></i>
                <div class="nav-titulo">Usuarios</div>
            </a>
        </li>
        @if (Auth()->user()->isCollectionDay())
            <li>
                <a href="{{ route('collect') }}">
                    <i class="fas fa-comments-dollar"></i>
                    <div class="nav-titulo">Cobranzas</div>
                </a>
            </li>
        @endif

        @if (Auth()->user()->isMonitorDay())
            <li>
                <a href="{{ route('monitor') }}">
                    <i class="fas fa-user-clock"></i>
                    <div class="nav-titulo">Ayuda a tu rama</div>
                </a>
            </li>
        @endif

        @if (Auth()->user()->isReturnDay())
            <li>
                <a href="{{ route('return') }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <div class="nav-titulo">Devoluci&oacute;n</div>
                </a>
            </li>
        @endif

        <li>
            <a href="{{ route('branch', Auth()->user()->id) }}">
                <i class="fas fa-sitemap"></i>
                <div class="nav-titulo">Mi rama</div>
            </a>
        </li>

        @if (Auth()->user()->role == 'sponsored')
        <li>
            <a href="{{ route('calendar', Auth()->user()->id) }}">
                <i class="fas fa-calendar-alt"></i>
                <div class="nav-titulo">Mi calendario</div>
            </a>
        </li>
        @endif




    </ul>
</nav>
