<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <form style="margin-top: 100px;">
            <div class="form-group" id="append_user_id">
                <label for="exampleInputEmail1">Please input user_id value(s)</label>
                <div class="add_user_id btn btn-primary" id="add_user_id">Click to add more than one user_id fields</div>
                <input type="text" class="form-control user_id" id="user_id_1" aria-describedby="user_id" placeholder="user_id">
            </div>
            <div class="form-group">
                <label for="reservation_timestamp_utc"></label>
                <input type="datetime-local" step=1 class="form-control" id="reservation_timestamp_utc">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script>
        var user_id_length = $('.user_id').length;
        $( "#add_user_id" ).click(()=>{
            var user_id_length = $('.user_id').length;
            $('#append_user_id').append( `<div class="user_id_wrapper"><input type="text" class="form-control user_id" name="user_id_${user_id_length+1}" id="user_id_${user_id_length+1}" aria-describedby="emailHelp" placeholder="user_id #${user_id_length+1}"><div class="btn btn-sm btn-warning user_id_remove" id="user_id_remove">Click to remove</div></div>` );
        });

        $( document ).on("click", "#user_id_remove",()=>{
            $("#user_id_remove").closest(".user_id_wrapper").remove();
        });

        function convertTZ(date, tzString) {
            return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: tzString}));   
        }

        // usage: Asia/Jakarta is GMT+7
        convertTZ("2012/04/20 10:10:30 +0000", "Asia/Jakarta") // Tue Apr 20 2012 17:10:30 GMT+0700 (Western Indonesia Time)

        // Resulting value is regular Date() object
        const convertedDate = convertTZ("2012/04/20 10:10:30 +0000", "Asia/Jakarta") 
        convertedDate.getHours(); // 17

        // Bonus: You can also put Date object to first arg
        const date = new Date()
        convertTZ(date, "Asia/Jakarta") // current date-time in jakarta.
    </script>
</body>

</html>