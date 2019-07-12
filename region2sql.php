<?php

$sql = "DROP TABLE IF EXISTS `region`;
CREATE TABLE `region` (
  `code` int(11) NOT NULL COMMENT '行政区划代码',
  `name` varchar(50) NOT NULL COMMENT '地区名称',
  `level` tinyint NOT NULL COMMENT '地区级别：1.省 2.市 3.区(县)',
  `parent` int(11) NOT NULL COMMENT '上级行政区划代码',
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='地区表';\n";

$data = json_decode(file_get_contents('./region.json'), 1);

foreach ($data['provinces'] as $province) {
    $sql .= "INSERT INTO `region`(`code`, `name`, `level`, `parent`) VALUES('{$province['code']}', '{$province['name']}', '1', '0');\n";

    foreach ($province['cities'] as $city) {
        $sql .= "INSERT INTO `region`(`code`, `name`, `level`, `parent`) VALUES('{$city['code']}', '{$city['name']}', '2', '{$province['code']}');\n";

        foreach ($city['areas'] as $area) {
            $sql .= "INSERT INTO `region`(`code`, `name`, `level`, `parent`) VALUES('{$area['code']}', '{$area['name']}', '3', '{$city['code']}');\n";
        }
    }
}

file_put_contents('./region.sql', $sql);

