<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <style>
        body {
            background-color: {{ $color }};
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-y: hidden;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">
        <p style="font-size: 2rem;">{!! $message !!}!</p>
    </div>
</body>

</html>
