@extends('templates.dashboard')
@section('title','Inicio')
@section('styles')
<style type="text/css">
.bienvenida{width: 100%; height: calc(100vh - 112px); text-align: center; display: flex; justify-content: center; align-items: center; flex-wrap: wrap; color: var(--verde_logo);}
</style>
@endsection
@section('content')
<div class="bienvenida">
<div>
    <h1>Debes depositar a :{{ Auth::user()->whoToPay()->full_name }}</h1>

    <h2>Cuenta Bancaria : {{Auth::user()->whoToPay()->bank_account_number }}</h2>
    <h2>Tel&eacute;fono : {{Auth::user()->whoToPay()->phone }}</h2>

</div>
</div>

@endsection
@section('scripts')

<script type="text/javascript" src="{{ asset('js/ajax.js') }}"></script>
@endsection
