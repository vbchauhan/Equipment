<?php
$a = ini_get("short_open_tag");
echo $a;
ini_set("short_open_tag","0");
$b = ini_get("short_open_tag");
echo $b;
?>