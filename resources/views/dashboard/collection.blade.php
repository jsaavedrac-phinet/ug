@extends('templates.dashboard')
@section('title',$data['title'])

@section('content')
<div class="header-content">
    @if (Auth::user()->role == 'admin' && Auth::user()->group)
    <div class="title-content">{{ $data['title']  }} del Grupo: {{ Auth::user()->group->name }}</div>
    @else
    <div class="title-content">{{ $data['title']  }}</div>
    @endif
</div>
<div class="body-content">
	@if (count($data['array']) >0)
	<table>
		<thead>
			<tr>
                <th>NOMBRE</th>
                <th>
                    TELEFONO
                </th>
                <th>
                    PAG&Oacute;?
                </th>
                <th>
                    FECHA LIMITE
                </th>

				<th width="50%" >ACCIONES</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($data['array'] as  $key =>$item)
			<tr>
                <td style="text-overflow:ellipsis; overflow:hidden">
                    {!! $item->full_name !!}
                </td>
                <td>
                    {{ $item->phone }}
                </td>

                <td>
                    <form action="{{ route('payment', $item->id) }}">
                        @method('POST')
                        <button class="btn" type="submit"><i class="fas fa-toggle-{{ $item->payment() ? 'on' : 'off'  }}"></i></button>
					</form>
                </td>
                <td>
                    {{ $item->limitToPay()  }}
                </td>
				<td class="acciones">
                    <a class="btn btn-view" href="{{ route('user.show', $item->id) }}"><i class="fas fa-eye"></i></a>
 				</td>
			</tr>
			@endforeach

		</tbody>
    </table>
    @if (gettype($data['array']) != 'array')
    <div class="paginator">
		{{ $data['array']->links() }}
	</div>
    @endif

	@else
	<h2>NO HAY USUARIOS PARA COBRAR, REVISA TU RAMA</h2>
	@endif
</div>
@endsection
@section('styles')
<style type="text/css">
.paginator{width: 100%; margin: 1em 0;  display: -ms-flexbox;display: flex; justify-content: center;}
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
	.header-content .extra-content{letter-spacing: 1px; width: 100%; margin: 2em 0;}
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
<link rel="stylesheet" href="{{asset('plugins/flag-icon-css-master/css/flag-icon.min.css')}}" media="none" onload="if(media!='all')media='all'">
<noscript><link rel="stylesheet" href="{{asset('plugins/flag-icon-css-master/css/flag-icon.min.css')}}"></noscript>
@endsection
@section('scripts')

<script type="text/javascript" src="{{ asset('js/ajax.js') }}"></script>
@endsection
