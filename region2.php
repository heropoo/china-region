<?php

$data = json_decode(file_get_contents('./region.json'), true);

$dst = [];

foreach ($data['provinces'] as $province_code => $province) {
    $cities = [];
    foreach ($province['cities'] as $city) {
        $areas = [];
        foreach ($city['areas'] as $area){
            $areas[] = $area;
        }
        $city['areas'] = $areas;
        $cities[] = $city;
    }
    $province['cities'] = $cities;
    $dst['provinces'][] = $province;
}

file_put_contents('./region2.json', json_encode($dst, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
