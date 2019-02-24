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
                        <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">New Task</h2>
                    </div>
                    <!-- Grid column -->

                    <div class="col-md-12">
                        <form method="post" action="{{ route('savetask') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="subject" class="col-sm-2 col-form-label">Subject</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="subject" id="subject"
                                           placeholder="meet" value="Встреча">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dueDate" class="col-sm-2 col-form-label">Due Date</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="dueDate" id="dueDate"
                                           placeholder="" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="priority" class="col-sm-2 col-form-label">Priority</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="priority" id="priority">
                                        @foreach($fields as $field)
                                            @if($field['api_name'] == 'Priority')
                                                @foreach($field['pick_list_values'] as $value)
                                                    <option value="{{ $value['display_value'] }}">{{ $value['display_value'] }}</option>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="owner" class="col-sm-2 col-form-label">Owner</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="owner" id="owner">
                                        @foreach($users as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['full_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="currentIdDeal" value="{{ $currentIdDeal }}">


                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                    <button type="button" class="btn btn-primary"
                                            onclick="location.href='{{ route('home') }}'">Отменить
                                    </button>
                                </div>

                            </div>


                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>