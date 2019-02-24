<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/mystyle.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>
    <title>Document</title>

    <script>
        $('button').tooltip();
        // $('#newDeal').onclick();
    </script>

</head>
<body class="hm-gradient">
<main>
    <div class="container mt-4">

        <div class="card mb-4">
            <div class="card-body">
                <!-- Grid row -->
                <div class="row">
                    <!-- Grid column -->
                    <div class="col-md-12">
                        <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">Deals</h2>

                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
                <!--Table-->
                <table class="table">


                    <!--Table head-->
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Задачи</th>
                        <th scope="col">Account Name</th>
                        <th scope="col">Deal Name</th>
                        <th scope="col">Stage</th>
                        <th scope="col">Closing Date</th>
                        <th scope="col">Deal Owner</th>

                    </tr>
                    </thead>
                    <!--Table head-->
                    <!--Table body-->



                    @foreach($data as $deal)
                        <tr>
                            <td>
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-secondary list" title="Просмотр"
                                                onclick="location.href='{{ route('tasks', ['id' => $deal['id']]) }}'"></button>
                                        <button type="button" class="btn btn-secondary add" title="Добавить" onclick="location.href='{{ route('addtask', ['id' => $deal['id']]) }}'"></button>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $deal['Account_Name']['name'] }}</td>
                            <td>{{ $deal['Deal_Name'] }}</td>
                            <td>{{ $deal['Stage'] }}</td>
                            <td>{{ $deal['Closing_Date'] }}</td>
                            <td>{{ $deal['Owner']['name'] }}</td>
                        </tr>
                    @endforeach





                    <!--Table body-->
                </table>
                <div>
                    <button type="button" class="btn btn-secondary" id="newDeal" onclick="window.location='{{ route("newdeal") }}'">Новая сделка</button>
                </div>
                <!--Table-->
            </div>
        </div>
    </div>
</main>
</body>
</html>