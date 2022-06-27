<!DOCTYPE html>
{{-- <html lang="en"> --}}
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
    {{-- <h4 style="position: absolute; right:10px; top:10px; color:#252525">تاريخ التقييم: {{date('d/m/Y', strtotime($created_date))}}</h4> --}}
    {{-- <img src="{{asset('img/logo.png')}}" width="40%" height="120px" style="margin-left: 30%;margin-right: 30%;" /> --}}
    {{-- <div style="padding:20px">
        <h2 style="text-align: center;">{{$facility->name}}</h2>
    </div> --}}
    <table width="100%" cellspacing="0" cellpadding="8">
        @foreach ($data as $item)
        <tr>
            @foreach ($item as $value)
                <td>{{$value}}</td>
            @endforeach
        </tr>
        @endforeach
    </table>
</body>

</html>