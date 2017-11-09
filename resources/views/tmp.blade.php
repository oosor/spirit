<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <?php header('Content-Type: text/html; charset=windows-1251');?>
    {{--<meta charset="utf-8">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

</head>
<body>
<div >
    {!! $data !!}
</div>
</body>
</html>
