@foreach ($data as $row)
    <tr>
        <td style="padding-bottom: 15px;font-size: 12px;">{{ $loop->iteration }}</td>
        <td style="padding-bottom: 15px;font-size: 12px;">{{ $row->created_at->format('d-m-Y') }}
        </td>
        <td style="padding-bottom: 15px;font-size: 12px;">{{ implode(',', $row->tooth) }}</td>
        <td style="padding-bottom: 15px;font-size: 12px;">{{ $row->treatment }}</td>
        <td style="padding-bottom: 15px;font-size: 12px;">{{ $row->fees }}</td>
        <td style="padding-bottom: 15px;font-size: 12px;">{{ $row->paid }}</td>
    </tr>
@endforeach

<tr style="border-top:1px dashed black;padding: 1% 0 1% 0;border-bottom:1px solid black">
    <td colspan="4" style="font-weight: bold">Total :</td>
    <td style="font-weight: bold">L.E {{ $data->sum('fees') }}</td>
    <td style="font-weight: bold">L.E {{ $data->sum('paid') }}</td>
</tr>
