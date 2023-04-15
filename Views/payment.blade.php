<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="text-align: center">
    @if( $response['status'] )
        <h5>SUCCESS</h5>
    @else
        <h5>FAILED</h5>
    @endif

    <h3> {{ $response['message'] }} </h3>
</body>
</html>