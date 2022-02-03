<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <meta name="_token" content="{{csrf_token()}}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet"></link>
</head>

<body>
    <div class="container">
        
        <a href="{{ url('/validate-reservation') }}">Go to validate reservation page</a>
        
        <form style="margin-top: 100px;" method="POST" action="{{ url('/reservations-settings/create') }}">
            <h3>Modify reservation setting</h3>
            @csrf
            <div class="form-group" style="width:200px;">
                <label for="n">Please input a value for n</label>
                <input type="number" class="form-control" id="n" name="n">
            </div>
            <h4>Please choose a duration (d)</h4>
            <select class="form-select" aria-label="Select TimeZone" id="d" name="d">
                <option value="day" selected>Day</option>
                <option value="week">Week</option>
                <option value="month">Month</option>
            </select>
            <h4>Please pick a group or individual (g)</h4>
            <select class="form-select" aria-label="Select TimeZone" id="g" name="g">
                <option value="individual" selected>Individual</option>
                <option value="group">Group</option>
            </select>
            <h4>Please pick a timezone</h4>        
            <select class="form-select" aria-label="Select TimeZone" id="tz" name="tz">
                <option value="UTC" selected>UTC</option>
                <option value="Asia/Kolkata">Asia/Kolkata</option>
                <option value="America/NewYork">America/NewYork</option>
            </select>
            <br><br>
            <div type="text" class="btn btn-primary" id="submit">Submit</div>
        </form>
    </div>


    <script>
        $("#submit").click(()=>{
            var n = $("#n").val();
            var d = $("#d option:selected").val();
            var g = $("#g option:selected").val();
            var tz = $("#tz option:selected").val();

            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ url("/api/reservation/setting/modify") }}',
                type: 'POST',
                data: { 
                    "data" : {
                        "_token" : _token,
                        "n" : n,
                        "d" : d,
                        "g" : g,
                        "tz" : tz,
                    }
                },
                // contentType: 'application/json; charset=utf-8',
                // dataType: 'json',
                async: false,
                success: function(msg) {
                    toastr.info(msg.message)
                },
                error: function(err) {
                    toastr.info('Please check your input values.')
                }
            });

            toastr.info(n+d+g+tz);
        })
    </script>


    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
    </style>
</body>

</html>