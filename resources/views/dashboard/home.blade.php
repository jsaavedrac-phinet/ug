@extends('templates.dashboard')
@section('title','Inicio')
@section('styles')
<style type="text/css">
.bienvenida{width: 100%; height: calc(100vh - 112px); text-align: center; display: flex; justify-content: center; align-items: center; flex-wrap: wrap; color: var(--verde_logo);}
.bienvenida h1{margin: 1em 0;}
.bienvenida p{font-size: 1.5em; text-align: justify}
</style>
@endsection
@section('content')
<div class="bienvenida">
    <div>
        <h1>Bienvenido(a) al Sistema Web de United Group</h1>

        @if (Auth::user()->isMyPaymentDay() && Auth::user()->role == 'sponsored')
            <p>
                @if ( (\App\Helpers\Dates::today() == 'Martes') || (\App\Helpers\Dates::today() == 'Viernes'))
                Hoy es tu fecha l&iacute;mite de pago.
                <br>
                Tienes hasta las 11 pm para coordinar el pago con :
                @else
                    @if (Auth::user()->registerDay() == 'Lunes' && \App\Helpers\Dates::today() == 'Lunes')
                    <br>
                    Tienes hasta mañana Martes a las 11 pm para coordinar el pago con :
                    @endif
                    @if (Auth::user()->registerDay() == 'Jueves' && \App\Helpers\Dates::today() == 'Jueves')
                    <br>
                    Tienes hasta mañana Viernes a las 11 pm para coordinar el pago con :
                    @endif
                @endif

                <br><br>
                <strong>Nombre : </strong> {{ Auth::user()->whoToPay()->full_name }}<br><br>
                <strong>Tel&eacute;fono :</strong> {{ Auth::user()->whoToPay()->phone }}<br><br>
                <strong>Cuota :</strong> S/. {{ number_format(Auth::user()->group->fee,2) }}<br><br>
                <strong>Cuenta Bancaria :</strong> {{ Auth::user()->whoToPay()->bank_account_number }}<br><br>
                <br><br><br>
                <strong>Si es que no pagas, se dar&aacute; de baja a tu cuenta.</strong>
            </p>
        @endif
    </div>
</div>

@endsection
@section('scripts')

<script type="text/javascript" src="{{ asset('js/ajax.js') }}"></script>
@endsection
