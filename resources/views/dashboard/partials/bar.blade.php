<header class="extended">
	<div class="icono-menu">
        <i class="fas fa-caret-left"></i>
	</div>
	<div class="tabs">
		<div class="container-tabs">
			<a  class="active" href="{{ route('home') }}">Dashboard</a>
			@yield('tab-parent')
			<a >@yield('title')</a>
		</div>
	</div>
	<div class="menu-user-container">
		<div class="avatar">
            <span>{!! env('APP_DEBUG') ? "Dia: ".\App\Helpers\Dates::getNameDay(session('day'))."&nbsp;".session('day').'&nbsp;&nbsp;' : '' !!}  Hola, {{ Auth::user()->full_name }}&nbsp; </span>
			<div class="show-menu-user">
                    <i class="fas fa-caret-down"></i>
			</div>
		</div>
		<div class="menu-user">
			<div class="menu-option">
				<a href="{{ route('profile') }}">
					<div class="icono-menu-user">
                            <i class="fas fa-user-circle"></i>
					</div>
					<div class="title-option">
						Perfil
					</div>
				</a>
			</div>
			<div class="menu-option">
				<a class="btn-logout" href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> &nbsp;Cerrar Sesi&oacute;n</a>
			<form id="logout-form" action="{{ route('logout')}}" method="POST" style="display: none;">@csrf</form>
		</div>
	</div>
</div>
</header>
