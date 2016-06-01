<?php

session_start();

require_once 'config.php';

$reg_user = new UserClass();

$infouser = $reg_user->infoUser($id_session,$email_session);

$random = new RandomKey();

$codeEvent = $random->randomKey();

$tzConvert = new TimeZone();

$event = new EventReminder();

$stngConvert = new EncryptPass();

$sendEmail = new QuoteEmailClass();


if(isset($_POST) && !empty($_POST)) {
 
  $codeEventE = $_POST['code'];
  $action = $_POST['action'];
  $code = $infouser['code'];
  $email = $infouser['email'];
  $title = $_POST['title'];
  $timezone = $infouser['timezone'];
  $start = $tzConvert->converToTz($_POST['datestart'], $infouser['timezone']);
  $end = $tzConvert->converToTz($_POST['dateend'], $infouser['timezone']);
  $description = $_POST['descr'];

  if(empty($action) && $action == '') {

    $event->addEvent($codeEvent, $code, $email, $title, $timezone, $description, $start, $end);
    $sendEmail->insertEmail($codeEvent, $email, $title, $description, 'Pending', $timezone, $start);

  } else if ($action == 'edit') {

  	$event->editEvent($codeEventE, $email, $title, $timezone, $description, $start, $end);
    $sendEmail->editEmail($codeEventE, $title, $description, $start);

  }

}
