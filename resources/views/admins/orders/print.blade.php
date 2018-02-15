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
    padding: 10mm;
    margin: 10mm auto;
    border: 1px #D3D3D3 solid;
    border-radius: 5px;
    background: white;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
.subpage {
    height: 257mm;
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

.single-label {
    width: 100%;
    min-height: 40mm !important;
    max-height: 40mm !important;
    height: 40mm !important;
    margin-bottom: 2mm;
}
</style>

<div class="book">
    @foreach($data as $modelChunk)
    <div class="page">
        <div class="subpage">
            @foreach($modelChunk as $model)
            <div class="single-label" style="border: 1px solid black; position: relative">
                <div style="float:left; width: 33.3%; border: 1px solid black; overflow: hidden; height: 100%;">
                    <h3 style="margin:0 0 10px 0; background: rgba(0,0,0,0.2); padding-left:10px;">Pengirim</h3>
                    <div style="font-size: 12px; padding-left:10px; position:relative;">
                        @if($model->is_dropship)
                        {{ $model->shipper_name }}
                        <br>
                        <small>{{$model->shipper_phone}}</small>
                        <br>
                        <small>{{ $model->shipper_email }}</small>
                        @else
                        <figure>
                            <figcaption style="text-align:center; padding:5px; font-size:12px">
                                <b>Clouwny</b>
                            </figcaption>
                            <img width="50"src="{{ asset('images/logo.png') }}" alt="" style="left:50%; transform: translateX(-50%); position:absolute;">
                        </figure>
                        @endif
                    </div>
                </div>
                <div style="float:left; width: 66.6%; border: 1px solid black; overflow: hidden; height: 100%;">
                    <h3 style="margin:0 0 10px 0; background: rgba(0,0,0,0.2); padding-left:10px;">Penerima</h3>
                    <div style="font-size: 12px; padding-left:10px;">
                        {{ $model->receiver_name }} | {{ $model->receiver_phone }}
                        <br>
                        {{ $model->receiver_province . ', ' . $model->receiver_city . ', ' . $model->receiver_district}}
                        <br>
                        {{ $model->receiver_address }}
                        <br>
                        {{ $model->receiver_zipcode }}
                        <br>
                        <b>Items: </b>
                        <br>
                        @foreach($model->orderItems()->get() as $item)
                            {{ $item->product()->first()->name }}
                            <b>({{$item->size}})</b>
                            |
                            <span style="color: #ff7474;">
                                {{ $item->product()->first()->variants(function ($q) use ($item) { $q->where('id', '=', $item->product_variant_id); })->first()->name }}
                            </span>
                            |
                            Qty: {{ $item->amount }}
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>    
    </div>
    @endforeach
</div>