<table border="1">
    <thead>
        <tr>
            <th>Pengirim</th>
            <th colspan="2">Data Penerima</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="7" valign="top" style="padding:5px">
                <img width="80"src="{{ asset('images/logo.png') }}" alt="">
                <p style="padding:5px; font-size:20px">Clouwny</p>
            </td>
            <td style="padding:5px; font-size:20px">Nama: </td>
            <td style="padding:5px; font-size:20px">{{ $model->receiver_name }}</td>
        </tr>
        <tr>
            <td style="padding:5px; font-size:20px">Telp.: </td>
            <td style="padding:5px; font-size:20px">{{ $model->receiver_phone }}</td>
        </tr>
        <tr>
            <td style="padding:5px; font-size:20px">Alamat: </td>
            <td style="padding:5px; font-size:20px">
                {{ $model->receiver_province . ', ' . $model->receiver_city . ', ' . $model->receiver_district}}
                <br>
                {{ $model->receiver_address }}
                <br>
                {{ $model->receiver_zipcode }}
            </td>
        </tr>
    </tbody>
</table>