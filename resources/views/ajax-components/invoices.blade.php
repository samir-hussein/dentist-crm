@foreach ($data as $row)
    <tr>
        <td style="padding-bottom: 15px;font-size: 12px;font-family: cursive">{{ $loop->iteration }}</td>
        <td style="padding-bottom: 15px;font-size: 12px;font-family: cursive">{{ $row->created_at->format('Y-m-d') }}
        </td>
        <td style="padding-bottom: 15px;font-size: 12px;font-family: cursive">{{ $row->treatment }}</td>
        <td style="padding-bottom: 15px;font-size: 12px;font-family: cursive">{{ $row->fees }}</td>
        <td style="padding-bottom: 15px;font-size: 12px;font-family: cursive">{{ $row->paid }}</td>
    </tr>
@endforeach

<tr style="border-top:1px dashed black;padding: 1% 0 1% 0;border-bottom:1px solid black">
    <td colspan="3" style="font-weight: bold">Total :</td>
    <td style="font-weight: bold">L.E {{ $data->sum('fees') }}</td>
    <td style="font-weight: bold">L.E {{ $data->sum('paid') }}</td>
</tr>
