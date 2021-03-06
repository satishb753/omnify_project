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
        <form style="margin-top: 100px;">
            @csrf
            <div class="form-group" id="append_user_id">
                <label for="exampleInputEmail1">Please input user_id value(s)</label><br>
                <div class="add_user_id btn btn-primary" id="add_user_id">Click to add more than one user_id fields</div>
                <label for="exampleInputEmail1">(Duplicate entries will be automatically removed)</label>
                <input type="number" class="form-control user_id" id="user_id_1" aria-describedby="user_id" placeholder="user_id">
            </div>
            <div class="form-group">
                <label for="reservation_timestamp_local"></label>
                <input type="datetime-local" step=1 class="form-control" id="reservation_timestamp_local">
            </div>
            <div type="text" class="btn btn-primary" id="submit">Submit</div>
        </form>
    </div>


    <script>
        var user_id_length = $('.user_id').length;
        $( "#add_user_id" ).click(()=>{
            var user_id_length = $('.user_id').length;
            $('#append_user_id').append( `<div class="user_id_wrapper"><input type="number" class="form-control user_id" name="user_id_${user_id_length+1}" id="user_id_${user_id_length+1}" aria-describedby="emailHelp" placeholder="user_id #${user_id_length+1}"><div class="btn btn-sm btn-warning user_id_remove" id="user_id_remove">Click to remove</div></div>` );
        });

        $( document ).on("click", "#user_id_remove",()=>{
            $("#user_id_remove").closest(".user_id_wrapper").remove();
        });

        $("#submit").click(()=>{
            var userIds = [];
            $(".user_id").each((idx, el)=>{
                id = parseInt($(el).val());
                if( !isNaN(id)  ) {
                    userIds.push(id);
                }
            });

            var dateAndTime = $("#reservation_timestamp_local").val(); 
            let reservationDateInLOCAL = ((new Date(dateAndTime)).getTime())/1000;

            var dateAndTimeInUTC = (new Date(dateAndTime)).toUTCString().substr(0, 25);
            let reservationDateInUTC = ((new Date(dateAndTimeInUTC)).getTime())/1000;

            let _token   = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ url("/api/reservation/create") }}',
                type: 'POST',
                data: { 
                    "data" : {
                        "_token" : _token,
                        "user_ids" : userIds,
                        "reservation_datetime" : [reservationDateInUTC],
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
        });

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