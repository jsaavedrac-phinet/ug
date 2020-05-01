<div class="filter_box">
    <input type="text" name="filter" id="filter" placeholder="Buscar por nombre, dni, telefono, cuenta bancaria">
    <button id="search">Buscar</button>
</div>
<table>

    <thead>
        <tr>
            <th>NOMBRE</th>
            <th>
                ESTADO
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
                {{ $item->getState() }}
            </td>
            <td class="acciones">
                <a class="btn btn-edit" href="{{ route('branch', $item->id) }}" target="_blank"><i class="fas fa-sitemap"></i></a>
                <a class="btn btn-view" href="{{ route('user.show', $item->id) }}" target="_blank"><i class="fas fa-eye"></i></a>
                @if (Auth()->user()->role == 'superadmin')
                <a class="btn btn-edit" href="{{ route('user.edit', $item->id) }}"><i class="fas fa-edit"></i></a>
                <form action="{{ route('user.destroy', $item->id) }}">
                    @method('DELETE')
                    <button class="btn btn-delete" type="submit"><i class="fas fa-trash-alt"></i>&nbsp;</button>
                </form>
                @endif
             </td>
        </tr>
        @endforeach

    </tbody>
</table>
@if (Auth()->user()->role != 'sponsored' && gettype($data['array']) != 'array' )
<div class="paginado">
    {{ $data['array']->links() }}
</div>
@endif
