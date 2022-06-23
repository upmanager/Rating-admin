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
        text-align: center
    }
</style>

<body>
    <table width="100%" cellspacing="0" cellpadding="8">
        <tr>
            <th colspan="4" style="font-size: 24px; text-align:center">
                {{$facility->name}}
            </th>
        </tr>
        <tr>
            <th rowspan="2" style="width: 60px;">No</th>
            <th rowspan="2" style="width:1000px">متطلبات</th>
            <th colspan="2">نقاط التقييم</th>
        </tr>
        <tr>
            <th style="width:100px">نتيجة</th>
            <th style="width:100px">المحقق</th>
        </tr>
        @foreach ($cats_data as $item)
        <tr>
            @if ($item['cat'])
            <td colspan="2" style="text-align:right; font-size:14px;"> {!! $item['title'] !!}</td>
            <td></td>
            <td></td>
            @else
            <td>{{$item['index']}}</td>
            <td>{!! $item['title'] !!}</td>
            <td>{{$item['max']}}</td>
            <td>{{$item['score']}}</td>
            @endif
        </tr>
        @endforeach
        <tr>
            <td colspan="2">المجموع النهائي</td>
            <td>{{$total}}</td>
            <td>{{$res_total}}</td>
        </tr>
        <tr>
            <td colspan="2">The Ratio</td>
            @php
            $ratio = number_format(($res_total/$total * 100 ), 1, '.', '');
            @endphp
            <td colspan="2">{{ $ratio }}%</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 20px">Evaluation Result</td>
            <td colspan="2" style="font-size: 20px">
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
</body>

</html>