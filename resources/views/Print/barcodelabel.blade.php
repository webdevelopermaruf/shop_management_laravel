<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
</head>
@php
    $generatorSVG = new Picqer\Barcode\BarcodeGeneratorSVG();
@endphp
{{-- <body onload="window.print();"--}}
<body>
    <div style="display:flex;justify-content:left;flex-wrap:wrap;">
        @for ($i = 0; $i < $qty; $i++)
        <span style="text-align:center;margin:15px;">
            <div>
                <p style="margin-bottom:2px;"><b style="font-size:14px;font-family:arial;" >{{ $sitename }}</b></p>
                <p style="margin:2px 0px;text-transform:capitalize">{{$product->product_name}}</p>
                <p style="margin:2px 0px;text-transform:capitalize"><b>Price: </b>{{$product->product_sell_price}}</p>
                <span style="text-align:center">
                    {!! $generatorSVG->getBarcode(strval($code), $generatorSVG::TYPE_CODE_128, 2, 40) !!}
                </span>
                <p style="margin:2px 0px;text-transform:capitalize;font-size:14px;font-weight:bold;">{{$product->product_barcode}}</p>
            </div>
        </span>
        @endfor
    </ul>
</body>

</html>
