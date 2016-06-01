/*---LEFT BAR ACCORDION----*/
$(function() {
    $('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
        //        cookie: 'dcjq-accordion-1',
        classExpand: 'dcjq-current-parent'
    });
});

var Script = function() {


    //    sidebar dropdown menu auto scrolling

    jQuery('#sidebar .sub-menu > a').click(function() {
        var o = ($(this).offset());
        diff = 250 - o.top;
        if (diff > 0)
            $("#sidebar").scrollTo("-=" + Math.abs(diff), 500);
        else
            $("#sidebar").scrollTo("+=" + Math.abs(diff), 500);
    });



    //    sidebar toggle

    $(function() {
        function responsiveView() {
            var wSize = $(window).width();
            if (wSize <= 768) {
                $('#container').addClass('sidebar-close');
                $('#sidebar > ul').hide();
            }

            if (wSize > 768) {
                $('#container').removeClass('sidebar-close');
                $('#sidebar > ul').show();
            }
        }
        $(window).on('load', responsiveView);
        $(window).on('resize', responsiveView);
    });

    $('.fa-bars').click(function() {
        if ($('#sidebar > ul').is(":visible") === true) {
            $('#main-content').css({
                'margin-left': '0px'
            });
            $('#sidebar').css({
                'margin-left': '-210px'
            });
            $('#sidebar > ul').hide();
            $("#container").addClass("sidebar-closed");
        } else {
            $('#main-content').css({
                'margin-left': '210px'
            });
            $('#sidebar > ul').show();
            $('#sidebar').css({
                'margin-left': '0'
            });
            $("#container").removeClass("sidebar-closed");
        }
    });

    // custom scrollbar
    $("#sidebar").niceScroll({
        styler: "fb",
        cursorcolor: "#4ECDC4",
        cursorwidth: '3',
        cursorborderradius: '10px',
        background: '#404040',
        spacebarenabled: false,
        cursorborder: ''
    });

    $("html").niceScroll({
        styler: "fb",
        cursorcolor: "#4ECDC4",
        cursorwidth: '6',
        cursorborderradius: '10px',
        background: '#404040',
        spacebarenabled: false,
        cursorborder: '',
        zindex: '1000'
    });

    // widget tools

    jQuery('.panel .tools .fa-chevron-down').click(function() {
        var el = jQuery(this).parents(".panel").children(".panel-body");
        if (jQuery(this).hasClass("fa-chevron-down")) {
            jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200);
        }
    });

    jQuery('.panel .tools .fa-times').click(function() {
        jQuery(this).parents(".panel").parent().remove();
    });


    //    tool tips

    $('.tooltips').tooltip();

    //    popovers

    $('.popovers').popover();



    // custom bar chart

    if ($(".custom-bar-chart")) {
        $(".bar").each(function() {
            var i = $(this).find(".value").html();
            $(this).find(".value").html("");
            $(this).find(".value").animate({
                height: i
            }, 2000)
        })
    }


}();

//jQuery add class .active on menu

$(function() {

    var url = window.location.pathname,
        urlRegExp = new RegExp(url.replace(/\/$/, '') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
    // now grab every link from the navigation
    $('.sidebar-menu a').each(function() {
        // and test its normalized href against the url pathname regexp
        if (urlRegExp.test(this.href.replace(/\/$/, ''))) {
            $(this).addClass('active');
        }
    });

});


$(document).ready(function() {

        $("input:file").change(function (){
             
            var fileName = $(this).val().split('\\')[2];
            $(".filename").html(fileName);
            $(".file-block").css({ "display" : "block" });
            $('.progress-bar').each(function() {
                var bar_value = $(this).attr('aria-valuenow') + '%';                
                $(this).animate({ width: bar_value }, { duration: 2000, easing: 'easeOutCirc' });
            });

        });

        $(".formUser").on('submit',(function(e) {

            $.ajax({
                type: "POST",
                url: "includes/edit_user.php",
                contentType: false,
                cache: false,
                processData:false,
                data: new FormData(this),
                success: function(response){
                    if(response == 'done'){
                        window.location = "account.php?uupdt";
                    } else {
                        window.location = "account.php?error";
                    }
                }
            });
        }));

        $(".form-event-submit").click(function(e){

        var subject = $(".form-subject").val();
        var message = $(".form-message").val();
        var datestart = $(".form-datepicker-start").val();
        var timestart = $(".form-time-start").val();

        var dateend = $(".form-datepicker-end").val();
        var timesend = $(".form-time-end").val();

        var formDateStart = moment(datestart, 'MM/DD/yyyy').format('YYYY-MM-DD') + " " + timestart;
        var formDateEnd = moment(dateend, 'MM/DD/yyyy').format('YYYY-MM-DD') + " " + timesend;

        var code = $(".code").val();
        var action = $(".action").val();

        $.ajax({
            type: "POST",
            url: "includes/add_event.php",
            data: "title="+ subject +"&descr="+ message +"&datestart="+ formDateStart  +"&dateend="+ formDateEnd + "&code=" + code + "&action=" + action,
            success: function(){
                if(action == "") {
                    window.location = "event.php?adde";
                } else if (action == "edit") {
                    window.location = "event.php?mdy";
                }
            }
        });
    }); 

$(".alert-success, .alert-warning, .alert-danger, .alert-info").fadeTo(4000, 900).slideUp(800);

    //Si hacemos click en añadir evento
    $(".add_event").click(function() {
        
        var subject = $(".form-subject").val('');
        var message = $(".form-message").val('');
        var datestart = $(".form-datepicker-start").val('');
        var timestart = $(".form-time-start").val('');
        var dateend = $(".form-datepicker-end").val('');
        var timesend = $(".form-time-end").val('');
        var code = $(".code").val('');
        var action = $(".action").val('');
        
        $('.modal_event').modal();


    });

    //Si la url contiene el parametro de editar un evento
    if(window.location.href.indexOf("action=edit") > -1) {
        $('.modal_event').modal();
    }


    var dateToday = new Date();

    $(".form-datepicker-start").datepicker({ dateFormat: 'yy-mm-dd', mminDate: 0 });

    $(".form-datepicker-end").datepicker({ dateFormat: 'yy-mm-dd', minDate: 0 });

    $(".form-time-start").timepicker({
        'scrollDefault': 'now',
        'timeFormat': 'H:i'
    });

    $(".form-time-end").timepicker({
        'scrollDefault': 'now',
        'timeFormat': 'H:i'
    });

    
    $('#calendar').fullCalendar({
        events: 'classes/EventReminderHander.php',
        editable: false,
        timeFormat: 'H:mm',
        firstDay: 1,
        header: {
            //left: 'prev,next today',
            right: 'today, prev,next'
        },
        droppable: false,
        //displayEventEnd: true,

        eventClick: function(calEvent, jsEvent, view) {
            $('.title').html(calEvent.title);
            $(".start-time").html(moment(calEvent.start).format('MMM Do H:mm A'));
            $(".end-time").html(moment(calEvent.end).format('MMM Do H:mm A'));
            $(".description").html(calEvent.description);
            $('.modal_calendar').modal();
        }
    });
});