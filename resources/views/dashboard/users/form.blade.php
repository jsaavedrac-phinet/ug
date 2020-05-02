@extends('templates.dashboard')
@section('title',$data['title'])

@section('tab-parent')
<a class="active" href="{{ route('user.index') }}" title="">Lista de Usuarios</a>
@endsection
@section('content')
<div class="header-content">
    <div class="title-content">{{ $data['title'] }}</div>
</div>
<div class="body-content">
    <form action="{{ $data['action'] }}" class="form">
        @method($data['method'])
        <div class="data-option">
            <label for="full_name">Nombre Completo</label>
            <input type="text" name="full_name" id="full_name"
                value="{{$data['array']  ? $data['array']->full_name : ''}}" {{ $data['view'] ? 'disabled' : '' }}>
        </div>
        <div class="data-option">
            <label for="dni">DNI</label>
            <input type="text" name="dni" class="integer" id="dni"
                value="{{$data['array']  ? $data['array']->dni : ''}}" {{ $data['view'] ? 'disabled' : '' }}>
        </div>
        <div class="data-option">
            <label for="phone">Tel&eacute;fono</label>
            <input type="text" name="phone" class="integer" id="phone"
                value="{{$data['array']  ? $data['array']->phone : ''}}" {{ $data['view'] ? 'disabled' : '' }}>
        </div>
        <div class="data-option">
            <label for="bank_account_number">Cuenta Bancaria</label>
            <input type="text" name="bank_account_number" id="bank_account_number"
                value="{{$data['array']  ? $data['array']->bank_account_number : ''}}"
                {{ $data['view'] ? 'disabled' : '' }}>
        </div>
        <div class="data-option">
            <label for="user">Usuario</label>
            <input type="text" name="user" id="user"
                value="{{$data['array']  ? $data['array']->user : ''}}" {{ $data['view'] ? 'disabled' : '' }}>
        </div>
        @if (!$data['view'])
        <div class="data-option">
            <label for="password">Clave</label>
            <input type="password" name="password" id="password"
                value="{{$data['array']  ? $data['array']->password : ''}}" {{ $data['view'] ? 'disabled' : '' }}>
        </div>
        @endif


        @if (Auth::user()->role != 'superadmin')
        <input type="hidden" name="role" value="sponsored">
        <input type="hidden" name="group_id" value="{{ Auth::user()->group->id }}">
        <input type="hidden" name="sponsor_id" value="{{ Auth::user()->id }}">
        @else
        <input type="hidden" name="sponsor_id" value="">
            @if (!$data['view'])
            @if (Auth::user()->role !== 'sponsored')
            <div class="data-option">
                <label for="role">Rol</label>
                <select name="role" id="role">
                    <option value="admin" {{ ($data['array'] && $data['array']->role == 'admin' ? 'selected="selected"' : ''  ) }}>Administrador</option>
                    <option value="superadmin" {{ ($data['array'] && $data['array']->role == 'superadmin' ? 'selected="selected"' : ''  ) }}>Super Administrador</option>
                </select>
            </div>
            <div class="data-option">
                <label for="group_id">Grupo</label>
                <select name="group_id" id="group_id">
                    <option value="">SELECCIONA UN GRUPO</option>
                    @foreach ($data['groups'] as $group)
                    <option value="{{$group->id}}" {{ ($data['array'] && $data['array']->group_id == $group->id ? 'selected="selected"' : ''  ) }}>{{$group->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @if ( $data['array'] && $data['array']->role == 'sponsored' && $data['method'] == 'PUT')
            <div class="data-option">
                <label for="state">Estado</label>
                <select name="state" id="state">
                    <option {{ ($data['array'] && $data['array']->state == 'registered' ? 'selected="selected"' : ''  ) }} value="registered">REGISTRADO</option>
                    <option {{ ($data['array'] && $data['array']->state == 'payed' ? 'selected="selected"' : ''  ) }} value="payed">PAGÓ</option>
                    <option {{ ($data['array'] && $data['array']->state == 'not-payed' ? 'selected="selected"' : ''  ) }} value="not-payed">NO PAGÓ</option>
                    <option {{ ($data['array'] && $data['array']->state == 'return-1' ? 'selected="selected"' : ''  ) }} value="return-1">RETORNO 1</option>
                    <option {{ ($data['array'] && $data['array']->state == 'not-return-1' ? 'selected="selected"' : ''  ) }} value="not-return-1">NO RETORNO 1</option>
                    <option {{ ($data['array'] && $data['array']->state == 'return-2' ? 'selected="selected"' : ''  ) }} value="return-2">RETORNO 2</option>
                    <option {{ ($data['array'] && $data['array']->state == 'not-return-2' ? 'selected="selected"' : ''  ) }} value="not-return-2">NO RETORNO 2</option>
                    <option {{ ($data['array'] && $data['array']->state == 'return-3' ? 'selected="selected"' : ''  ) }} value="return-3">RETORNO 3</option>
                    <option {{ ($data['array'] && $data['array']->state == 'not-return-3' ? 'selected="selected"' : ''  ) }} value="not-return-3">NO RETORNO 3</option>
                    <option {{ ($data['array'] && $data['array']->state == 'finished' ? 'selected="selected"' : ''  ) }} value="finished">FINALIZADO</option>
                </select>
            </div>
            <input type="hidden" name="role" value="{{ $data['array'] ? $data['array']->role  : '' }}">
            @else

            <input type="hidden" name="state" value="{{ $data['array'] ? $data['array']->state : '' }}">
            @endif
            @else
            <div class="data-option">
                <label for="role">Rol</label>
                <input type="text" name="role"  value="{{$data['array']->role}}" disabled>
            </div>
                @if ($data['array']->role == 'admin')
                    <div class="data-option">
                        <label for="group_id">Grupo</label>
                        <input type="text" name="group_id"  value="{{$data['array']->group ? $data['array']->group->name : ''}}" disabled>
                    </div>
                @endif
            @endif

        @endif




        @if (!$data['view'])

        @if($data['array'] != null)
        <input type="hidden" name="id" value="{{ $data['array']->id }}">
        @endif

        <div class="data-option">
            <button class="btn btn-success" type="submit">GUARDAR</button>
        </div>
        @endif

    </form>
</div>
@endsection
@section('styles')
<style type="text/css">
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color:#999;
        cursor: pointer;
        display: inline-block;
        font-weight: bold;
        margin-right: 2px;
        margin-bottom: 0;
        width: auto;
        font-size: initial;
    }
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #999;
    font-size: initial;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 28px;
        font-size: initial;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {list-style: none;font-size: initial;}
	input,select,textarea{-ms-box-sizing:content-box;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box;}
	.header-content{display: flex; padding:  1em 0; font-size: 1.5em; align-items: flex-end; }
	.header-content .icon-content{margin-right: 0.5em;font-size: 1.4em;}
	.header-content .title-content{letter-spacing: 1px;}
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
	.body-content .user-bg.body-content .form{background: #FFF; border-radius: 4px;box-shadow: 0 2px 10px rgba(0,0,0,.05); height: 300px; padding-bottom: 0 !important;}
	.body-content .user-data{width: calc(100% - 2em); max-width: calc(600px - 2em); padding: 2em 1em;}
	.body-content .user-image{width: calc(100% - 2em); max-width: calc(400px - 2em); padding:2em  1em;}
	.body-content .user-btn{width: calc(100% - 4em); padding: 1em 2em; display: flex; justify-content: flex-end; align-items: center;}
	.body-content .user-btn button{border: none; background: var(--principal);  color: #FFF; padding: 0.5em 1em; border-radius: 4px;}
	.body-content .data-option{width: 100%; display: flex; flex-wrap: wrap; margin-bottom: 1em;}
	.body-content .data-option label{width: 100%; color: #555;margin: 0.5em 0; }
	.body-content .data-option span{color: #777; font-size: 0.8em; margin-bottom: 0.5em; width: 100%;}
	.body-content .data-option input{width: calc(100% - 2em); padding: 0.5em 1em; border-radius: 4px; border: 1px solid var(--principal);}
	.body-content .data-option textarea{width: calc(100% - 2em); padding: 0.5em 1em; border-radius: 4px; border: 1px solid var(--principal); height: 125px; min-height: 125px; max-height: 125px; min-width: calc(100% - 2em); max-width: calc(100% - 2em);}
	.body-content .data-option select{width: calc(100% - 2em); padding: 0.5em 1em; border-radius: 4px; border: 1px solid var(--principal);}
	.body-content .data-option .avatar{width: 100%; height: 200px;}
	.body-content .data-option .avatar picture{width: 100%; height: 100%; display: flex; justify-content: center; align-items: center; border: 1px solid var(--principal);}
	.body-content .data-option .avatar img{width: auto; height: auto; max-width: 150px; max-height: 150px;}
	.body-content .form{background: #FFF; border-radius: 4px;box-shadow: 0 2px 10px rgba(0,0,0,.05); height: auto; padding-bottom: 0 !important; width: calc(100% - 2em); padding:  1em;}
	.body-content .data-option .preview{width: 100%; height: 150px;text-align: center; }
	.body-content .data-option .preview picture{width: 100%; height: 100%;display: flex; justify-content: center; align-items: center;}
	.body-content .data-option .preview picture img{width: auto; height: auto; max-width: 100%; max-height: 100%;}
	.body-content .data-option .btn{border: 0; background: #ccc; color: #666; border-radius: 4px; padding: 0.5em 1em; cursor: pointer;}
	.body-content .data-option .btn-success{background: var(--btn-success); color: #FFF;}
    .yearpicker-items.selected{color: red !important;}
    .yearpicker-items:hover {color: blue !important;}
</style>

@endsection
@section('scripts')
@if (!$data['view'])

<script>
    function reset_form(){
        $('form.form')[0].reset();
    }
</script>
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ajax.js') }}"></script>
<script>
    function setInputFilter(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    textbox.addEventListener(event, function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  });
}
</script>
<script>
    var integers = document.getElementsByClassName("integer");
    Array.prototype.forEach.call(integers,function(currentValue,index,array){
        setInputFilter(currentValue, function(value) {
        // return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
        return /^\d*\d*$/.test(value); // Allow digits and '.' only, using a RegExp
        });
    } );

</script>
<script>
    $(document).on('keyup','#phone',function(){
        $('#user').val($('#phone').val());
        $('#password').val($('#phone').val());
    });

    $(document).on('change','#role',function(){
        if($('#role').val() == 'superadmin'){
            $('#group_id').val('');
            $('#group_id').attr('disabled',true);
        }else{
            $('#group_id').attr('disabled',false);
        }
    });
</script>
@endif

@endsection
