<?php 

session_start();

require_once 'includes/config.php';

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

$eventTitle = '';
$eventDescript = '';
$eventStartDate = '';
$eventEndDate = '';
$eventStarttime = '';
$eventEndtime = '';
$eventCode = '';
$eventAction = '';


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

            <div class="col-event col-lg-4 col-md-4 col-sm-12 col-xs-12"><!-- block pending -->
              <div class="info-box blue-bg">
                <i class="fa fa-clock-o"></i>
                <div class="count"><span id="pending"></span></div>
                <div class="title">Pending reminders</div>           
              </div><!--/.info-box-->     
            </div><!-- block pending -->


            <div class="col-event col-lg-4 col-md-4 col-sm-12 col-xs-12"><!-- block finish -->
              <div class="info-box blue-bg">
                <i class="fa fa-flag-checkered"></i>
                <div class="count"><span id="finish"></span></div>
                <div class="title">Finish reminders</div>           
              </div><!--/.info-box-->     
            </div><!-- block finish -->


            <div class="col-event col-lg-4 col-md-4 col-sm-12 col-xs-12"><!-- block total -->
              <div class="info-box blue-bg">
                <i class="fa fa-bell"></i>
                <div class="count"><span id="total"></span></div>
                <div class="title">Total reminders</div>           
              </div><!--/.info-box-->     
            </div><!-- block total -->

          </div>
        </div>
      </div>

      <div class="row"><!-- calendar -->
        <div id="calendar" class="col-md-12"></div>
      </div><!-- calendar -->

      <div class="modal_calendar modal fade"><!-- modal calendar -->
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
              <span>Reminder: </span><span class="title"></span>
            </div>
            <div id="modalBody" class="modal-body modal-reminder">
              <span><i class="fa fa-info" aria-hidden="true"></i> Description: </span><span class="description"></span><br/>
              <span><i class="fa fa-clock-o" aria-hidden="true"></i> Start date: </span><span class="start-time"></span><br/>
              <span><i class="fa fa-clock-o" aria-hidden="true"></i> End date: </span><span class="end-time"></span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div><!-- modal calendar -->
      
    </section>
  </section>
</section>
<?php include 'footer.php'; ?>
</body>
</html>
