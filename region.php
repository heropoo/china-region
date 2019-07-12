<?php

$lines = file('./region.txt');

$dst = [];
foreach ($lines as $line) {
    if (strpos($line, ' ') >= 6) {
        $province_arr = explode(' ', $line);

        $province_code = trim($province_arr[0]);
        $province = [
            'code' => $province_code,
            'name' => trim($province_arr[1]),
            'cities' => []
        ];
        unset($city);
    } else if (strpos($line, ' ') === 0 && strpos($line, '  ') !== 0) {
        $line = str_replace('  ', ' ', $line);
        $line = str_replace('  ', ' ', $line);
        $line = str_replace('  ', ' ', $line);

        $city_arr = explode(' ', $line);
        $city_code = trim($city_arr[1]);
        $city = [
            'code' => $city_code,
            'name' => trim($city_arr[2]),
            'areas' => []
        ];
    }else{
        $line = str_replace('  ', ' ', $line);
        $line = str_replace('  ', ' ', $line);
        $line = str_replace('  ', ' ', $line);

        $area_arr = explode(' ', $line);
        $area_code = trim($area_arr[1]);
        $city['areas'][$area_code] = [
            'code' => $area_code,
            'name' => trim($area_arr[2]),
        ];
    }

    if(isset($city)){
        $province['cities'][$city_code] = $city;
    }

    $dst['provinces'][$province_code] = $province;
}

file_put_contents('./region.json', json_encode($dst, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

foreach ($dst['provinces'] as $province_code => $province){
    foreach ($province['cities'] as $city){
        if(empty($city['areas'])){
            $city_code = $city['code'];
            $dst['provinces'][$province_code]['cities'][$city_code]['areas'] = [
                'code'=> strval($city_code + 1),
                'name'=>'市辖区'
            ];
        }
    }
}

file_put_contents('./region.json', json_encode($dst, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
