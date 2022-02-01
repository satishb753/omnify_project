<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TimeZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $file = __DIR__.'\\timezones.json';
        $timezonesJSON = file_get_contents($file);

        $timezones = json_decode($timezonesJSON, true);

        for($i=0;$i<count($timezones);$i++) {
            $b[] = array_values($timezones[$i]);
            $names[] = array_keys($timezones[$i]);
        }

        for($i=0;$i<count($b);$i++){
            for($j=0;$j<count($b[$i]);$j++){
                for($k=0;$k<count($b[$i][$j]);$k++){
                    $values[] = $b[$i][$j][$k]["value"];
                    $labels[] = $b[$i][$j][$k]["label"];
                }
            }
        }

        for($i=0;$i<count($names);$i++){
            for($j=0;$j<count($names[$i]);$j++){
                $difference[] = $names[$i][$j];
            }
        }

        for($idx=0; $idx<count($values); $idx++){
            \DB::table('timezones')->insert(array(
                $idx => 
                    array(
                        'id' => $idx+1,
                        'name' => $values[$idx],
                        'label' => $labels[$idx],
                        'difference' => substr($labels[$idx],1,9),
                    ),
            ));
        }
    }
}
