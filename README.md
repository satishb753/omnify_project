## Notes

<p>Date is converted to UTC seconds passed since 1 January 1970</p>
<p>Group or Individual based distinction was not required to be applied because the data was being sent as an array to which we can simply iterate over to apply our logic in the backend application</p>


### ReservationController.php holds the backend logic

<p>Please open '/app/Http/Controllers/ReservationController.php' to view backend logic</p>


### frontend views are inside of modify-settings.blade.php and validate-reservation.blade.php

<p>The aforementioned two files are inside of 'resources/views' directory</p>

## web.php and api.php hold the listings of routes and their respective controllers

### Database tables have prefix txz_ hence it may take some time to setup in local environment. Please make sure to make required adjustments