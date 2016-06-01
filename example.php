<?php

session_start();

include 'includes/config.php';

$time = new TimeZone();
$result = $time->converToTz('12:00:00', 'Europe/Madrid');
echo $result;


?>





