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
 				</td>
			</tr>
			@endforeach
