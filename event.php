<?php

session_start();

include 'includes/config.php';

$reg_user = new UserClass();

// Comprobando si el usuario esta logueado
if(!$reg_user->is_logged_in()) {
  $reg_user->redirect('index.php');
  die();
}

$infouser = $reg_user->infoUser($id_session,$email_session);

$event = new EventReminder();
$eventNumP = $event->getEventStatusNum($code_session, $email_session, "Pending");
$eventNumF = $event->getEventStatusNum($code_session, $email_session, "Finish");
$eventNumT = $event->getEventStatusNum($code_session, $email_session, "Total");


$eventP = $event->getEventPerStatus($code_session, $email_session, "Pending");
$eventF = $event->getEventPerStatus($code_session, $email_session, "Finish");
$eventT = $event->getEventPerStatus($code_session, $email_session, "Total");

$stngConvert = new EncryptPass();

$tzConvert = new TimeZone();

$random = new RandomKey();

$codeEvent = $random->randomKey();

//Para editar un event. Si no las variables son vacias.
if(isset($_GET['action']) && !empty($_GET['action']) && !empty($_GET['codvent'])) {

  $codeEvent = $stngConvert->encrypt_decrypt('decrypt', $_GET['codvent']);
  $idEvent = $event->getEventID($codeEvent,$email_session);
  $eventCode = $idEvent['code'];
  $eventTitle = $idEvent['title'];
  $eventDescript = $idEvent['description'];
  $eventStart = explode(" ", $idEvent['start']);
  $eventEnd = explode(" ", $idEvent['end']);
  $eventStartDate = date("m/d/Y", strtotime(str_replace('-', '/', $eventStart[0])));
  $eventEndDate = date("m/d/Y", strtotime(str_replace('-', '/', $eventEnd[0])));
  $eventStarttime = date("H:i", strtotime($tzConvert->convertDateToTzUser($eventStart[1], $idEvent['timezone'])));
  $eventEndtime = date("H:i", strtotime($tzConvert->convertDateToTzUser($eventEnd[1], $idEvent['timezone'])));
  $eventAction = $_GET['action'];

  if ($_GET['action'] == "del") {
      
      $event->removeEvent($codeEvent, $eventCode, $email_session);
      header("Location: event.php?del");
      die();
  }

} else {

  $eventTitle = '';
  $eventDescript = '';
  $eventStartDate = '';
  $eventEndDate = '';
  $eventStarttime = '';
  $eventEndtime = '';
  $eventCode = '';
  $eventAction = '';

}

?>

<!DOCTYPE html>
<html lang="en">
<?php include 'header.php' ?>
<body>
  <section id="container" >
    <?php include 'menu-top.php' ?>
    <?php include 'menu-left.php' ?>
    <section id="main-content">
      <section class="wrapper">

        <div class="row">
          <div class="col-lg-12 main-chart">
           <div class="row mtbox block-reminders">

            <div class="col-event col-lg-4 col-md-4 col-sm-4 col-xs-4">
              <div class="info-box blue-bg">
                <i class="fa fa-clock-o"></i>
                <div class="count"><span id="pending"></span></div>
                <div class="title">Pending reminders</div>           
              </div><!--/.info-box-->     
            </div>


            <div class="col-event col-lg-4 col-md-4 col-sm-4 col-xs-4">
              <div class="info-box blue-bg">
                <i class="fa fa-flag-checkered"></i>
                <div class="count"><span id="finish"></span></div>
                <div class="title">Finish reminders</div>           
              </div><!--/.info-box-->     
            </div>


            <div class="col-event col-lg-4 col-md-4 col-sm-4 col-xs-4">
              <div class="info-box blue-bg">
                <i class="fa fa-bell"></i>
                <div class="count"><span id="total"></span></div>
                <div class="title">Total reminders</div>           
              </div><!--/.info-box-->     
            </div>

          </div>
        </div>
      </div>
      <?php include 'includes/alert_message.php' ?>
      <div class="header-pending"><h4>Pending reminders</h4></div>
      <div class="row">
        <div class="col-lg-12 main-chart">
          <div class="row mtbox event-pending">
            <div class="title-pending title-pending-header col-md-1 col-ms-1 col-xs-1">#Number</div>
            <div class="title-pending title-pending-header col-md-2 col-ms-2 col-xs-2">Title</div>
            <div class="title-pending title-pending-header col-md-3 col-ms-3 col-xs-3">Description</div>
            <div class="title-pending title-pending-header col-md-2 col-ms-2 col-xs-2">Start</div>
            <div class="title-pending title-pending-header col-md-2 col-ms-2 col-xs-2">Status</div>
            <div class="title-finish title-finish-header col-md-2 col-ms-2 col-xs-2">Action</div>
          </div>

          <?php

            foreach ($eventP as $value) {
            $idConvert = $stngConvert->encrypt_decrypt('encrypt',$value["eventCode"]);
            $timeConvert = $tzConvert->convertDateToTzUser($value['start'], $value['timezone']);
          ?>
          <div class="row mtbox-2 event-pending-item">
            <div class="title-pending col-md-1 col-ms-1 col-xs-1"><?= $value["id"] ?></div>
            <div class="title-pending col-md-2 col-ms-2 col-xs-2"><?= $value["title"] ?></div>
            <div class="title-pending col-md-3 col-ms-3 col-xs-3"><?= $value['description'] ?></div>
            <div class="title-pending col-md-2 col-ms-2 col-xs-2"><?= $timeConvert ?></div>
            <div class="title-pending col-md-2 col-ms-2 col-xs-2"><strong> <i class="fa fa-clock-o"></i> Pending</strong></div>
            <div class="title-finish col-md-2 col-ms-2 col-xs-2"><a href="event.php?action=edit&codvent=<?= $idConvert ?>">Edit</a> | <a href="event.php?action=del&codvent=<?= $idConvert ?>">Remove</a></div>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="header-finish"><h4>Finish reminders</h4></div>
      <div class="row">
        <div class="col-lg-12 main-chart">
          <div class="row mtbox event-finish">
            <div class="title-finish title-finish-header col-md-1 col-ms-1 col-xs-1">#Number</div>
            <div class="title-finish title-finish-header col-md-2 col-ms-2 col-xs-2">Title</div>
            <div class="title-finish title-finish-header col-md-3 col-ms-3 col-xs-3">Description</div>
            <div class="title-finish title-finish-header col-md-2 col-ms-2 col-xs-2">End</div>
            <div class="title-pending title-pending-header col-md-4 col-ms-4 col-xs-4">Status</div>
          </div>

          <?php foreach ($eventF as $value) { ?>
          <div class="row mtbox-2 event-finish-item">
            <div class="title-finish col-md-1 col-ms-1 col-xs-1"><?= $value["id"] ?></div>
            <div class="title-finish col-md-2 col-ms-2 col-xs-2"><?= $value["title"] ?></div>
            <div class="title-finish col-md-3 col-ms-3 col-xs-3"><?= $value['description'] ?></div>
            <div class="title-finish col-md-2 col-ms-2 col-xs-2"><?= $value['end'] ?></div>
            <div class="title-pending col-md-4 col-ms-4 col-xs-4"><strong> <i class="fa fa-clock-o"></i> Finish</strong></div>
          </div>
          <?php } ?>
        </div>
      </div>
    </section>
  </section>
</section>
<div class="footer-event">
  <?php include 'footer.php' ?>
</div>
</body>
</html>
