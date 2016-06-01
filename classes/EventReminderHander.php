<?php 

//Basicamente en esta clase solicitamos desde FullCalendar los datos que estan almacenados en la base de datos. Como los datos
//de la base de datos estan con la hora local del servidor, deberemos de convertir la fecha y tiempo a la hora original del usuario.
session_start();

require_once 'EventReminder.php';
require_once 'TimeZone.php';
require_once 'UserClass.php';

$events = new EventReminder();

$timezone = new TimeZone();

$reg_user = new UserClass();
$infouser = $reg_user->infoUser($_SESSION['userSession'],$_SESSION['emailSession']);

$getJson = $events->getEvents($_SESSION['codeSession'], $_SESSION['emailSession']);

$ObjArray = json_decode($getJson);

foreach ($ObjArray as $key => $value) {
	$timeToTimeZoneStart = $timezone->convertDateToTzUser($value->start, $infouser['timezone']);
	$timeToTimeZoneEnd = $timezone->convertDateToTzUser($value->end, $infouser['timezone']);
	$value->start = $timeToTimeZoneStart;
	$value->end = $timeToTimeZoneEnd;
}

echo json_encode($ObjArray);

?>