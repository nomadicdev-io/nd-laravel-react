@if(!empty($audit))
<table class="table table-bordered table-hover" style="width:100%">
    @if(!empty($audit->old_values))
        <tr>
        <td colspan="2"> Old data</td>
        </tr>
        @foreach($audit->old_values as $attribute  => $value)                                 
            <tr>
                <td><b>{{ ucwords(str_replace('_',' ',$attribute))}}</b></td>
                <td>{{ $value }}</td>
            </tr>                                  
        @endforeach
    @endif
    @if(!empty($audit->new_values))
        <tr>
            <td colspan="2"> New data</td>
        </tr>
        @foreach($audit->new_values as  $attribute  => $data)
            <tr>
                <td><b>{{ ucwords(str_replace('_',' ',$attribute))}}</b></td>
                <td>{{ $data }}</td>
            </tr>
        @endforeach
    @endif
</table>
@endif