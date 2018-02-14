<style>
body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: #FAFAFA;
    font: 12pt "Tahoma";
}
* {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
}
.page {
    width: 210mm;
    min-height: 297mm;
    padding: 20mm;
    margin: 10mm auto;
    border: 1px #D3D3D3 solid;
    border-radius: 5px;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
.subpage {
    padding: 1cm;
    border: 5px red solid;
    height: 257mm;
    outline: 2cm #FFEAEA solid;
}

@page {
    size: A4;
    margin: 0;
}
@media print {
    html, body {
        width: 210mm;
        height: 297mm;        
    }
    .page {
        margin: 0;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }
}
</style>

<div class="book">
    <div class="page">
        <div class="subpage">
            @foreach($data as $model)
            <table border="1" style="border-collapse: collapse;">
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
                            <p style="padding:5px; font-size:12px">Clouwny</p>
                        </td>
                        <td style="padding:5px; font-size:12px">Nama: </td>
                        <td style="padding:5px; font-size:12px">{{ $model->receiver_name }}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px; font-size:12px">Telp.: </td>
                        <td style="padding:5px; font-size:12px">{{ $model->receiver_phone }}</td>
                    </tr>
                    <tr>
                        <td style="padding:5px; font-size:12px">Alamat: </td>
                        <td style="padding:5px; font-size:12px">
                            {{ $model->receiver_province . ', ' . $model->receiver_city . ', ' . $model->receiver_district}}
                            <br>
                            {{ $model->receiver_address }}
                            <br>
                            {{ $model->receiver_zipcode }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:5px; font-size:12px">Items: </td>
                        <td style="padding:5px; font-size:12px">
                            @foreach($model->orderItems()->get() as $item)
                                {{ $item->product()->first()->name }}
                                |
                                <span style="color: blue;">
                                    {{ $item->product()->first()->variants(function ($q) use ($item) { $q->where('id', '=', $item->product_variant_id); })->first()->name }}
                                </span>
                                <br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            @endforeach
        </div>    
    </div>
</div>