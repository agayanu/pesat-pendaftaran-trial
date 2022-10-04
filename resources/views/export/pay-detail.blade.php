<table>
    <tr>
        <td colspan="14" style="text-align: center"><b>DATA DETAIL PEMBAYARAN</b></td>
    </tr>
</table>
<table>
    <thead>
        @if($dataHeader==='')
        @else
            <tr>
                <th><b>Nomor</b></th>
                <th width="200px"><b>Nama</b></th>
            @foreach($dataHeader as $dh)
                <th width="100px"><b>{{$dh->name}}</b></th>
            @endforeach
            </tr>
        @endif
    </thead>
    <tbody>
        @if($data==='')
        @else
            @foreach($data as $d)
            <tr>
                <td>{{ $d->no_regist }}</td>
                <td>{{ $d->name_regist }}</td>
                @foreach($dataHeader as $dh)
                    @php
                        $columnx = $dh->name;
                        $column = $d->$columnx;
                    @endphp
                    <td>{{ $column }}</td>
                @endforeach
            </tr>
            @endforeach
        @endif
    </tbody>
</table>