<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <style>
        .barcode .number { 
            display: inline-block;
            position: absolute;
            /* letter-spacing: 5px; */
            font-size: 16px;
            /* font-weight: 600; */
            top: 32px;
            left: 9%;
            right: 0;
        }
        .barcode .img {
            display: inline-block;
            vertical-align: middle;
            position: absolute;
            margin-top: -10px;
            /* transform: rotate(90deg) !important;
            -ms-transform: rotate(90deg) !important;
            -moz-transform: rotate(90deg) !important;
            -webkit-transform: rotate(90deg) !important;
            -webkit-transform: rotate(90deg) !important; */
        }
        .barcode img{
            object-fit:cover !important;
        }
    </style>
</head>
<body>
    <div class="barcode">
        <div class="img">
            <img src="data:image/png;base64, {{$bcode}}"><br>
            {{--<p class="number">
                {{$barcode}}
            </p>--}}
        </div>
        <div class="title">

        </div>
    </div>
</body>
</html>