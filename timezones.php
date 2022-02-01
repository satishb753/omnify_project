<?php

// $url = 'https://github.com/kennethllamasares/laravel-timezones/blob/master/resources/timezones.json';
$file = __DIR__.'\\database\\seeders\\timezones.json';
$timezonesJSON = file_get_contents($file);

$timezones = json_decode($timezonesJSON, true);

$b = array();
$c = array();
$result = array();
$b = array_values($timezones[0]);

$b_length=count($b);

for($i=0;$i<$b_length;$i++){
    array_push($c, array_values($b[$i]));
}

// var_dump(array_values($b[0][0]));
// var_dump($b[0][0]);

$c = $b[0][0];
$c_length = count($c);
$d = array_values($c);
$d_length = count($d);
for($i=0;$i<$d_length; $i++){
    var_dump($d[$i]);
}









// $a = array();
// for($i=0; count($timezones); $i++){
//     var_dump($timezones[$i]);
// }

// var_dump(count($timezones));
// $a = array_keys($timezones[0]);
// var_dump(array_values($a));
// var_dump($a[0]);
// for($i=0; count(array_keys($timezones[$i])); $i++){
//     array_push($a, array_keys($timezones[$i]));
// }


// var_dump($a[0]);
// for($i=0; count($a); $i++){
//     var_dump($a[$i]);
// }

?>