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
</head>
<body>

<main>
    <div class="container mt-4">
        <div class="card mb-4">
            <div class="card-body">
                <!-- Grid row -->
                <div class="row">
                    <!-- Grid column -->
                    <div class="col-md-12">
                        <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">
                            Deal: {{ $deal['Deal_Name'] }}</h2>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->


                @foreach($tasks as $task)
                    @if($loop->index % 2 == 0)
                        <div class="card-deck mt-4">
                    @endif

                            <div class="col-sm-6">
                                <div class="card">
                                    <h5 class="card-header text-center">{{ $task['Subject'] }}</h5>
                                    <div class="card-body">
                                        <form>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label text-sm-right">Priority</label>
                                                <div class="col-sm-9">
                                                    <input type="text" readonly class="form-control-plaintext text-center"
                                                           id="staticEmail"
                                                           value="{{ $task['Priority'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label text-sm-right">Due
                                                    Date</label>
                                                <div class="col-sm-9">
                                                    <input type="text" readonly class="form-control-plaintext text-center"
                                                           id="staticEmail"
                                                           value="{{ $task['Due_Date'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label text-sm-right">Status</label>
                                                <div class="col-sm-9">
                                                    <input type="text" readonly class="form-control-plaintext text-center"
                                                           id="staticEmail"
                                                           value="{{ $task['Status'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail" class="col-sm-3 col-form-label text-sm-right">Task
                                                    Owner</label>
                                                <div class="col-sm-9">
                                                    <input type="text" readonly class="form-control-plaintext text-center"
                                                           id="staticEmail"
                                                           value="{{ $task['Owner']['name'] }}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="staticEmail"
                                                       class="col-sm-3 col-form-label text-sm-right">Subject</label>
                                                <div class="col-sm-9">
                                                    <input type="text" readonly class="form-control-plaintext text-center"
                                                           id="staticEmail"
                                                           value="{{ $task['Subject'] }}">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                    @if($loop->index % 2 != 0 ||$loop->index == $loop->count-1)
                        </div>
                    @endif

                @endforeach





            </div>

        </div>
        <div class="mt-4">
            <button type="button" class="btn btn-secondary" id="back" onclick="location.href='{{ route('home') }}'">Назад</button>
        </div>
    </div>
</main>

</body>
</html>