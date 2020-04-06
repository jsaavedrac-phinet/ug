@extends('templates.dashboard')
@section('title',$data['title'])

@section('content')
<div class="header-content">
    @if (Auth::user()->id != request()->route('user')->id)
    <div class="title-content">Rama de : {{  request()->route('user')->full_name}}</div>
    @else
    <div class="title-content">{{ $data['title']  }}</div>
    @endif
    {{-- <div class="extra-content">
        Estados :
        <ol>
            <li>REGISTRADO : El usuario ha sido registrado pero aun no ha pagado</li>
            <li>PAGO : El usuario ha pagado su registro</li>
            <li>RETORNO 1 : El usuario ha hecho su primera devolucion (50%)</li>
            <li>RETORNO 2 : El usuario ha hecho su segunda devolucion (50%)</li>
            <li>RETORNO 3 : El usuario ha hecho su tercera devolucion (10%)</li>
            <li>NO PAGO : El usuario no pago su registro, y se deshabilito su usuario y a su rama.</li>
            <li>NO RETORNO 1 : El usuario no pago su primer retorno, y se deshabilito su usuario y a su rama.</li>
            <li>NO RETORNO 2 : El usuario no pago su segundo retorno, y se deshabilito su usuario y a su rama.</li>
            <li>NO RETORNO 3 : El usuario no pago su tercer retorno, y se deshabilito su usuario y a su rama.</li>
        </ol>
    </div> --}}
</div>

<div class="body-content" id="container">
    @if ($data['array'])
    {!! $data['array']!!}
	@else
	<h2>NO HAY USUARIOS REGISTRADOS</h2>
	@endif
</div>
<input type="hidden" name="mynodes" id="mynodes" value="{{ json_encode($data['array']) }}">
@endsection
@section('styles')
<style type="text/css">
    .paginado{width: 100%; margin: 1em 0;  display: -ms-flexbox;display: flex; justify-content: center;}
    .pagination {display: -ms-flexbox;display: flex;padding-left: 0;list-style: none;border-radius: .25rem;}
    .page-item:first-child .page-link {margin-left: 0;border-top-left-radius: .25rem;border-bottom-left-radius: .25rem;}
    .page-item.active .page-link {z-index: 1;color: #fff;background-color: var(--principal);border-color: var(--btn-success);}
    .page-link {position: relative;display: block;padding: .5rem .75rem;margin-left: -1px;line-height: 1.25;color: var(--verde);background-color: #fff;border: 1px solid #dee2e6;}
    .page-item:last-child .page-link {border-top-right-radius: .25rem;border-bottom-right-radius: .25rem;}
    .page-link {position: relative;display: block;padding: .5rem .75rem;margin-left: -1px;line-height: 1.25;color: var(--verde);background-color: #fff;border: 1px solid #dee2e6;}
    .page-link:hover {z-index: 2;color: var(--btn-success);text-decoration: none;background-color: #e9ecef;border-color: #dee2e6;}
	.header-content{display: flex; padding:  1em 0; font-size: 1.5em; align-items: flex-end; flex-wrap: wrap; }
	.header-content .icon-content{margin-right: 0.5em;font-size: 1.4em;}
	.header-content .title-content{letter-spacing: 1px;}
	.header-content .extra-content{letter-spacing: 1px; width: calc(100% - 2em); margin: 2em 1em;font-size: 0.7em;}
	.header-content .extra-content ol li{list-style: none;}
	.header-content .actions-content{margin-left: 2em; display: flex; height:100%; width: auto;}
	.header-content .actions-content a:nth-of-type(n+2){margin-left: 0.5em;}
	.header-content .actions-content a{height: 100%; display: flex; justify-content: space-between; align-items: center; width: auto; color: #FFF; background: #ccc; cursor: pointer; font-size: 0.6em; text-decoration: none; }
	.header-content .actions-content a .icon-action{margin-right: 5px;}
	.header-content .actions-content a .title-action{}
	.header-content .actions-content a.btn{padding: 0.5em 1em; border-radius: 4px;}
	.header-content .actions-content a.btn-add{background: var(--btn-success);}
	.header-content .actions-content a.btn-sort{background: var(--btn-primary);}
	.body-content{width: 100%; height: auto;}
	.body-content form{display: flex; flex-wrap: wrap; justify-content: space-evenly; align-items: flex-start;}
	.body-content .user-bg{background: #FFF; border-radius: 4px;box-shadow: 0 2px 10px rgba(0,0,0,.05); height: 300px; padding-bottom: 0 !important;}
	.body-content .user-data{width: calc(100% - 2em); max-width: calc(600px - 2em); padding: 2em 1em;}
	.body-content .user-image{width: calc(100% - 2em); max-width: calc(400px - 2em); padding:2em  1em;}
	.body-content .user-btn{width: calc(100% - 4em); padding: 1em 2em; display: flex; justify-content: flex-end; align-items: center;}
	.body-content .user-btn button{border: none; background: var(--principal);  color: #FFF; padding: 0.5em 1em; border-radius: 4px;}
	.body-content .data-option{width: 100%; display: flex; flex-wrap: wrap; margin-bottom: 1em;}
	.body-content .data-option label{width: 100%; color: #555;margin: 0.5em 0; }
	.body-content .data-option span{color: #777; font-size: 0.8em; margin-bottom: 0.5em;}
	.body-content .data-option input{width: calc(100% - 2em); padding: 0.5em 1em; border-radius: 4px; border: 1px solid var(--principal);}

	.body-content .data-option .avatar{width: 100%; height: 200px;}
	.body-content .data-option .avatar picture{width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; border: 1px solid var(--principal);}
	.body-content .data-option .avatar img{width: auto; height: auto; max-width: 150px; max-height: 150px;}
	button:disabled,
	button[disabled]{background-color: #cccccc !important;color: #666666 !important;cursor: not-allowed;}

	table{width: 100%;}
	table th{padding: 0.1em 0.5em; text-align: center; background: var(--principal); color:  #FFF;}
	table td{padding: 0.1em 0.5em; text-align: center; background: #FFF; color: #444; cursor: default;}
	table .imagen{width: calc(118px - 2em); height: calc(60px - 1em); text-align: center;}
	table td picture{height: 60px; width: 118px; display: flex; justify-content: center; align-items:center; background: #FFF;}
	table td picture img{width: auto; height: auto; max-width: 118px; max-height:60px;}
	table caption{padding: 0.5em 0; font-weight: bold; font-size: 1.4em;}
	table td.acciones{display: flex; flex-wrap: wrap; justify-content: space-evenly; align-items: center; width: auto; overflow: hidden; height: 60px;}
	table td.acciones form{width: auto; height: auto;}
	table td .btn{border:none; padding: 0em 1em; background: transparent; cursor: pointer; text-decoration: none; color: #555; width: auto; height: auto;font-size: 15px; height: 30px;display: flex;justify-content: center;align-items: center; border-radius: 6px;}
	table td .btn-add{background: var(--btn-success); color: #FFF;}
    table td .btn-view{background: var(--btn-view); color: #FFF;}
	table td .btn-edit{background: var(--btn-primary); color: #FFF;}
	table td .btn-delete{background: var(--btn-danger); color: #FFF;}
    table td .btn-sections{background: gold; color: #FFF;}
    table td .btn-flag{background: #333; color: #FFF;}
	table td .btn span{margin-right: 0.2em;}





</style>
<style>
#container{max-width: 100%; overflow-y: auto; display: flex; justify-content: flex-start; align-items: flex-start;}

.tree,
.tree ul,
.tree li {
    list-style: none;
    margin: 0;
    padding: 0;
    position: relative;
}

.tree {
    margin: 0 auto;
    text-align: center;
}

.tree,
.tree ul {
    display: table;
}

.tree ul {
    width: 100%;
}

.tree li {
    display: table-cell;
    padding: .5em 0;
    vertical-align: top;
}

.tree li:before {
    outline: solid 1px var(--principal);
    content: "";
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}

.tree li:first-child:before {
    left: 50%;
}

.tree li:last-child:before {
    right: 50%;
}

.tree code,
.tree span {
    border: solid .1em var(--principal);
    border-radius: .2em;
    display: inline-block;
    margin: 0 .2em .5em;
    padding: .5em .7em;
    position: relative;
}

.tree span a{text-decoration: none;color: #333;}
.tree span .actions{display: flex; justify-content: space-evenly;}

.tree span .btn{border:none; padding: 0em 1em; background: transparent; cursor: pointer; text-decoration: none; color: #555; width: auto; height: auto;font-size: 15px; height: 30px;display: flex;justify-content: center;align-items: center; border-radius: 6px;}
.tree span .btn:nth-of-type(n+2){margin-left: 0.3em;}
.tree span .btn-add{background: var(--btn-success); color: #FFF;}
.tree span .btn-view{background: var(--btn-view); color: #FFF;}
.tree span .btn-edit{background: var(--btn-primary); color: #FFF;}
.tree span .btn-delete{background: var(--btn-danger); color: #FFF;}
.tree span .btn-sections{background: gold; color: #FFF;}
.tree span .btn-flag{background: #333; color: #FFF;}
.tree span .btn span{margin-right: 0.2em;}

.tree span.registered{background: var(--bg-registered); color: var(--color-registered);}
.tree span.payed{background: var(--bg-payed); color: var(--color-payed) }
.tree span.not-payed{background: var(--bg-not-payed); color: var(--color-not-payed) }
.tree span.return-1{background: var(--bg-return-1); color: var(--color-return-1) }
.tree span.not-return-1{background: var(--bg-not-return-1); color: var(--color-not-return-1) }
.tree span.return-2{background: var(--bg-return-2); color: var(--color-return-2);}
.tree span.not-return-2{background: var(--bg-not-return-2); color: var(--color-not-return-2);}
.tree span.return-3{background: var(--bg-return-3); color: var(--color-return-3);}
.tree span.not-return-3{background: var(--bg-not-return-3); color: var(--color-not-return-3);}
.tree span.completed{background: var(--bg-completed); color: var(--color-completed);}

.tree ul:before,
.tree code:before,
.tree span:before {
    outline: solid 1px var(--principal);
    content: "";
    height: .5em;
    left: 50%;
    position: absolute;
}

.tree ul:before {
    top: -.5em;
}

.tree code:before,
.tree span:before {
    top: -.55em;
}

.tree>li {
    margin-top: 0;
}

.tree>li:before,
.tree>li:after,
.tree>li>code:before,
.tree>li>span:before {
    outline: none;
}
</style>
<link rel="stylesheet" href="{{asset('plugins/flag-icon-css-master/css/flag-icon.min.css')}}" media="none" onload="if(media!='all')media='all'">
<noscript><link rel="stylesheet" href="{{asset('plugins/flag-icon-css-master/css/flag-icon.min.css')}}"></noscript>


@endsection
@section('scripts')

<script type="text/javascript" src="{{ asset('js/ajax.js') }}"></script>

@endsection
