
<div class="modal_event modal fade"><!-- modal add event -->
  <div class="modal-dialog-add-event">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
        <center><span> Add new reminder</span></center>
      </div>
      <div id="modalBody" class="modal-body modal-reminder ">
      <form id="form-event" class="form-event" method="POST"> 
        <p>Subject:</p><input type="text" name="subject" placeholder="Subject" value="<?= $eventTitle ?>"name="subject" autocomplete="off" class="form-control form-subject placeholder-no-fix" maxlength="35">
        <p>Message:</p><input type="text" name="message" placeholder="Message" value="<?= $eventDescript ?>" name="message" autocomplete="off" class="form-control form-message placeholder-no-fix" maxlength="85">
        <br/>
        <div class="input-date col-md-3 col-xs-3 col-ms-3">
          <p>Date start: <input type="text" value="<?= $eventStartDate ?>" class="form-datepicker form-datepicker-start"></p>
        </div>
        <div class="input-time col-md-3 col-ms-3 col-xs-3">
          <p>Time start: <input type="text" value="<?= $eventStarttime ?>" class="form-time form-time-start"></p>
        </div>
        <div class="input-date col-md-3 col-ms-3 col-xs-3">
          <p>Date end: <input type="text" value="<?= $eventEndDate ?>" class="form-time form-datepicker-end"></p>
        </div>
        <div class="input-time col-md-3 col-ms-3 col-xs-3">
          <p>Time end: <input type="text" value="<?= $eventEndtime ?>" class="form-time form-time-end"></p>
        </div>
        <input type="hidden" name="code" class="code" value="<?= $codeEvent ?>">
        <input type="hidden" name="action" class="action" value="<?= $eventAction ?>">
      </form>
      </div>
      <br/><br/>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-default form-event-submit" data-dismiss="modal">Submit</button>
      </div>

    </div>
  </div>
</div><!-- modal add event -->

<footer class="site-footer<?php if($_SERVER['REQUEST_URI'] == '/dashboard.php') {  echo '-dashboard'; } ?>">
  <div class="text-center">
    2016 -  MyReminders.io
    <a href="index.html#" class="go-top">
      <i class="fa fa-angle-up"></i>
    </a>
  </div>
</footer>
<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery-1.8.3.min.js"></script>
<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="assets/js/jquery.sparkline.js"></script>
<script src="assets/js/jquery.animateNumber.min.js"></script>
<script src="assets/js/moment.js"></script>
<script src="assets/js/fullcalendar/fullcalendar.min.js"></script>
<script src="assets/js/bootstrap-datepicker.min.js"></script>
<script src="assets/js/jquery.timepicker.min.js"></script>
<script src="assets/js/jquery.fileupload.js"></script>


<!--common script for all pages-->
<script src="assets/js/common-scripts.js"></script>

<script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="assets/js/gritter-conf.js"></script>

<!--script for this page-->
<script src="assets/js/sparkline-chart.js"></script>    
<script src="assets/js/zabuto_calendar.js"></script>

<script type="text/javascript">
  $('#pending').animateNumber({ number: <?php if(isset($eventNumP)) { echo $eventNumP; } else { echo '0'; } ?> });
  $('#finish').animateNumber({ number: <?php if(isset($eventNumF)) { echo $eventNumF; } else { echo '0'; } ?> });
  $('#total').animateNumber({ number: <?php if(isset($eventNumT)) { echo $eventNumT; } else { echo '0'; } ?> });
</script>

<script type="text/javascript">
//$(document).ready(function () {
  //var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            //title: 'Welcome to Dashgum!',
            // (string | mandatory) the text inside the notification
            //text: 'Hover me to enable the Close Button. You can hide the left sidebar clicking on the button next to the logo. Free version for <a href="http://blacktie.co" target="_blank" style="color:#ffd777">BlackTie.co</a>.',
           //// (string | optional) the image to display on the left
           // image: 'assets/img/ui-sam.jpg',
            // (bool | optional) if you want it to fade out on its own or just sit there
          //  sticky: true,
            // (int | optional) the time you want it to be alive for before fading out
          //  time: '',
            // (string | optional) the class name you want to apply to that specific message
          //  class_name: 'my-sticky-class'
         // });

  //return false;
//});
</script>