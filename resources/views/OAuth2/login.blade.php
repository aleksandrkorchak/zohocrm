<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>

    <title>Laravel</title>


    <style>
        body, html {
            background: #dcdddf;
            height: 100%;
        }

        .container {
            width: 400px;
        }

        h1 {
            color: #563D64;
            text-align: center;
            font: bold 28px Helvetica, Arial, sans-serif;
            line-height: 20px;
            margin: 10px 0 30px;
        }
    </style>

</head>
<body>


<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <form class="col-12" method="post" action="">
            @csrf
            <h1>Авторизация</h1>
            <div class="form-group">
                <input type="text" class="form-control" id="id" name="client_id" placeholder="ID" value="1000.N7X450QI25CM28642BQPC3IQ5JXTLE">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="secret" name="client_secret" placeholder="Secret" value="e4667066e5b97e7f871787f4686806b013b268aed1">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>


</body>
</html>
