<table>
    <thead>
        <tr>
            <th>LOB</th>
            <th>Penyebab Klaim</th>
            <th>Periode</th>
            <th>Nilai Beban Klaim</th>
        </tr>
    </thead>
    <tbody>
        @foreach($klaim as $item)
        <tr>
            <td>{{ $item->LOB }}</td>
            <td>{{ $item->penyebab_klaim }}</td>
            <td>{{ $item->periode }}</td>
            <td>{{ $item->nilai_beban_klaim }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
