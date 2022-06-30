<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100%;
        }

        tr {
            page-break-inside: avoid;
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-row-group;
        }

        th {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            page-break-inside: avoid;
        }

        td {
            padding: 6px;
        }

        .notes-employee {
            width: auto;
            height: auto;
        }

        .col-2 {
            width: 17%;
        }

        .col-1 {
            width: 10%;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .space {
            margin-top: 40px !important;
        }

        .container {
            margin: 0 5%;
        }

        .lunch_break_icon {
            width: 12%;
            margin-left: 5px;
        }

        .break_img {
            background: url('/img/restaurant-eating-set.svg');
            width: 14px;
            background-repeat: no-repeat;
            background-size: contain;
            height: 16px;
            opacity: 9;
            margin-right: 60px;
            float: right;
        }

        body {
            width: auto;
            font-family: Georgia, serif;
            font-size: 14px;
            line-height: 1.42857143;
        }
    </style>
</head>
<body class="size-1140">
    <div class="container-fluid">
        <div class="box-header">
        <img src="data:image/png;base64, {{$logo}}" height="20">
        <h2>Items Barcode Report</h2>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>{{$user->name}}</th>
                        <th>Report Generated</th>
                        <th><?= date("m/d/Y H:i:s") ?></th>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <th>{{$user->email}}</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        @if($items)
            <div class="space">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-1">#</th>
                            <th class="col-3">Item Name</th>
                            <th class="col-2">Barcode</th>
                            <th class="col-1">Readings</th>
                        </tr>
                    </thead>
                    
                    <tbody style="padding: 8px; text-align: left; border-bottom: 2px solid #ddd;">
                        @foreach($items as $index => $item)
                        <tr>
                            <th class="col-1">{{$index + 1}}</th>
                            <th class="col-3"><strong>{{$item->item->product_name}}</strong></th>
                            <th class="col-2">{{$item->item->product_barcode}}</th>
                            <th class="col-1">{{$item->quantity}}</th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>