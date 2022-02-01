<?php

// $url = 'https://github.com/kennethllamasares/laravel-timezones/blob/master/resources/timezones.json';
$file = __DIR__.'\\database\\seeders\\timezones.json';
$timezonesJSON = file_get_contents($file);

$timezones = json_decode($timezonesJSON, true);

for($i=0;$i<count($timezones);$i++) {
    $b[] = array_values($timezones[$i]);
    $names[] = array_keys($timezones[$i]);
}

// var_dump(array_keys($b[0])); //$b[0] is array(1) with array(3) with array(2)

for($i=0;$i<count($b);$i++){
     for($j=0;$j<count($b[$i]);$j++){
        for($k=0;$k<count($b[$i][$j]);$k++){
            $values[] = $b[$i][$j][$k]["value"];
            $labels[] = $b[$i][$j][$k]["label"];
        }
    }
}

// var_dump($c);
// var_dump($d);

for($i=0;$i<count($names);$i++){
    for($j=0;$j<count($names[$i]);$j++){
        $difference[] = $names[$i][$j];
    }
}
// var_dump($difference);
var_dump($names);

?>