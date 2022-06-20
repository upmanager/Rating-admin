<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings</title>
</head>
<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 13px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
        text-align: center
    }
</style>

<body>
    <img src="{{asset('img/logo.png')}}" width="40%" height="120px" style="margin-left: 30%;margin-right: 30%;" />
    <div style="padding:20px">
        <h2 style="text-align: center;">{{$facility->name}}</h2>
    </div>
    <table width="100%" cellspacing="0" cellpadding="8">
        <tr>
            <th rowspan="2" style="width: 30px;">No</th>
            <th rowspan="2">متطلبات</th>
            <th colspan="2">نقاط التقييم</th>
        </tr>
        <tr>
            <th style="width:50px">نتيجة</th>
            <th style="width:50px">المحقق</th>
        </tr>
        @foreach ($cats_data as $item)
        <tr>
            @if ($item['cat'])
            <td colspan="2" style="text-align:right; font-size:18px;"> {!! $item['title'] !!}</td>
            <td></td>
            <td></td>
            @else
            <td>{{$item['index']}}</td>
            <td>{!! $item['title'] !!}</td>
            <td>{{$item['score']}}</td>
            <td>{{$item['max']}}</td>
            @endif
        </tr>
        @endforeach
        <tr>
            <td colspan="2">المجموع النهائي</td>
            <td>{{$res_total}}</td>
            <td>{{$total}}</td>
        </tr>
        <tr>
            <td colspan="2">The Ratio</td>
            @php
            $ratio = number_format(($res_total/$total * 100 ), 1, '.', '');
            @endphp
            <td colspan="2">{{ $ratio }}%</td>
        </tr>
    </table>

    <table style="width:100%; margin-top:50px;">
        <tr style="font-size: 26px;">
            <td>Evaluation Result</td>
            <td>
                @if ($ratio
                <= 80) Fail <br /> 80% أقل من
                @elseif($ratio>= 90)
                Excellent <br />90% أعلي من
                @else
                Average <br /> 80% ~ 90%
                @endif
            </td>
        </tr>
    </table>
    <div style="width:100%; font-size:16px; font-weight:bold; margin-top:50px">
        <div style="width:50%; float:left;">Report preparer: .........................</div>
        <div style="width:50%; float:left;">Kitchen name: .............................</div>
        <br>
        <br>
        <div style="width:50%; float:left;">Signature: ..................................</div>
        <div style="width:50%; float:left;">Signature: ..................................</div>
        <br><br>
        <br><br>
    </div>
</body>

</html>