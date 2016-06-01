<?php

session_start();

require_once 'config.php';

$reg_user = new UserClass();

$infouser = $reg_user->infoUser($id_session,$email_session);

if(isset($_POST) && !empty($_POST)) {

  if (file_exists($_FILES['upload']['tmp_name']) || is_uploaded_file($_FILES['upload']['tmp_name'])) {
    $extAllow =  array('gif','png' ,'jpg');
    $fileUpload = $_FILES['upload']['name'];
    $getExt = pathinfo($fileUpload, PATHINFO_EXTENSION);

    if(!in_array($getExt,$extAllow)) {
      echo "ext";
      exit();
    }

    if (!file_exists('../assets/img/users/' . $infouser['email'])) {
      mkdir('../assets/img/users/' . $infouser['email']);
    }
    
    move_uploaded_file($_FILES['upload']['tmp_name'], '../assets/img/users/'. $infouser['email'] . '/' . $_FILES['upload']['name']);
    $pictureUser = $infouser['email'] . '/' . $_FILES['upload']['name'];

  } else {

    $pictureUser = $infouser['picture'];

  }

    if ($_POST['timezone'] == "") {
      $getTimezone =  $infouser['timezone'];
    } else {
      $postTimezone = explode("|",$_POST['timezone']);
      $getTimezone = trim($postTimezone[0]);
    }
    
    $reg_user->editUser($getTimezone, $pictureUser, $email_session);
    echo "done";

}
