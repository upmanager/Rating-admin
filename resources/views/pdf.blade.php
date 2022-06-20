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
    <div style="padding:20px">
        <h3 style="text-align: center;">{{$facility->name}}</h3>
    </div>
    <table width="100%" cellspacing="0" cellpadding="8">
        <tr>
            <th rowspan="2" style="width: 30px;">No</th>
            <th rowspan="2">متطلبات</th>
            <th colspan="2">نقاط التقييم</th>
        </tr>
        <tr>
            <th style="width:50px">نتيجة</th>
            <th style="width:50px">أقصى</th>
        </tr>
        @foreach ($cats_data as $item)
        <tr>
            @if ($item['cat'])
            <td colspan="2" style="text-align: left"> {{$item['title']}}</td>
            <td></td>
            <td></td>
            @else
            <td>{{$item['index']}}</td>
            <td>{{$item['title']}}</td>
            <td>{{$item['score']}}</td>
            <td>{{$item['max']}}</td>
            @endif
        </tr>
        @endforeach
    </table>
</body>

</html>