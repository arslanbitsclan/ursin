<!DOCTYPE html>
<html lang="en">
<body>
    <script>
$(function() {
  $('input[name="activity_date"]').daterangepicker({
    "singleDatePicker": true,
    minDate: new Date()
  });
});
</script>
  <header class="header-area">
    <div class="container">
      <div class="logo-area">
        <a href="https://edtools.io/apps/"><img src="<?php echo base_url(); ?>appci/assets/entries/images/logo.png" alt="Logo"></a>
      </div>
      <div class="menu-area">
        <nav>
          <ul>
             <li id="wh-item"><a href="<?php echo base_url('entries/Homework'); ?>">Homework</a></li> 
              <li id="ex-item"><a href="<?php echo base_url('entries/Exams'); ?>">Exams</a></li>
              <li id="ms-item"><a href="<?php echo base_url('entries/Messages'); ?>">Messages</a></li>
              <li id="lk-item"><a href="<?php echo base_url('entries/Link'); ?>">Links</a></li>
              <li id="cl-item"><a id="cl-active" href="<?php echo base_url('entries/Calendar'); ?>">Calendar</a></li>
              
              <li class="drp-itm" id="mr-item"><a href="">More<i class="fas fa-angle-down"></i></a>
              <ul>
                <li><a target="_blank" href="https://www.edtools.io/overdue">Open Task</a></li>
                <li><a target="_blank" href="https://www.edtools.io/checklist">Checklist</a></li>
                <li><a target="_blank" href="https://edtools.io/entries/Absent">Absent</a></li>
                <li><a target="_blank" href="https://edtools.io/settings/Student">Settings</a></li>
              </ul>
            </li>
            <li id="ques-mark"><a class="ques-mark"  href="#"><img src="<?php echo base_url(); ?>appci/assets/entries/images/question.png" alt=""></a></li>

          </ul>
        </nav>
      </div>
    </div>
  </header>

   <form  action="<?php echo base_url('entries/Calendar/manage'); ?>" method="POST" onsubmit="return checkvalidation_calendar();">
  <section class="class-selection calender-cl-sel">
    <div class="container">
      <div class="custom-select">
         <?php if(!isset($selectclass)){?>
                   <select name="class_id" id="class_id_calendar">
                      <option value="">Select Class</option>
                        <?php foreach ($classes as $key => $class) { ?>
                                <option value="<?=$class['_id']?>" <?php if($class['standard'] == 1){ echo 'selected';}else{ if($key == 0){ echo 'selected'; } } ?> >
                                  <?=$class['class_name']?>
                                </option>
                        <?php } ?>
                    </select>
                <?php }else{ ?>
                  <select name="class_id" id="class_id_calendar">
                    <option value="">Select Class</option>
                      <?php foreach ($classes as $key => $class) { ?>
                              <option value="<?=$class['_id']?>" <?php if($selectclass == $class['_id']){ echo 'selected';} ?> >
                                <?=$class['class_name']?>
                              </option>
                      <?php } ?>
                  </select>
        <?php }?>
      </div>
    </div>
      <script type="text/javascript">
            loadclasswithreload();
            function loadclasswithreload(){
                            var clsid = document.getElementById("class_id_calendar").value;
                            $.ajax({
                                method:'post',
                                url: base_url+'entries/Calendar/get_calendar_data',
                                data:{class_id:clsid},
                                dataType:'json',
                                success:function(res){
                                  if(res.status){
                                    $('#calendarbox').html(res.data);
                                    if(res.messageaccess == '1'){
                                      $("#activelink").attr("href", "<?php echo base_url() ?>settings/Student/student/"+clsid);
                                        $('#accesserror').show();  
                                      }else{
                                        $('#accesserror').hide();  
                                      }
                                  }else{
                                     
                                  }
                                 
                                }
                              });

            }
            </script>

  </section>
   <section style="display: none;" id='accesserror'>
        <div class="container">
        <div style="padding: 20px; background-color: red; color:white">
          Calendar entries are not shown for this class in the students dashboard. Please activate it in the settings <a id="activelink" target="_blank" href="<?php echo base_url() ?>settings/Student/student"> click here</a>. 
        </div>
        <br/>
      </div>
 </section>
  <section class="form-area calender-form">
    <div class="container">
      <h1 class="typer">Publish an event</h1>
     
        <label for="title">Title</label>
        <input type="text" maxlength="800"  name="title" id="title" placeholder="Enter title" required="required">
        <label for="date">Date</label>
        <input id="datepicker" type='text' name="activity_date" class="js-form-control" placeholder="Enter date" required="required">
        <label for="descrption">Description</label>
        <textarea name="description" maxlength="800" id="descrption1" cols="30" rows="6" placeholder="Write event details" required="required"></textarea>
         <p>
          <input type="checkbox" style="float: none !important" name="publishforall" value="1" id="check" >  Publish to all my classes <br/>
              <input type="checkbox"  id="recipient_identifier1"  onclick="show_otherchekbox(this)" name="visibleforparents" value="2" style="width: 15px;"> Visible for parents only
         </p>
             
        <div style="margin-left: 30px; display: none;" id="idofmailcheckbox">
            <p>
              <input type="checkbox" style="float: none !important" id="check" name="possibilityofregister" value="mail"> Possibility to register<br/>

              <input type="checkbox" style="width: 15px;" id="check" name="emailsendofall" value="mail">
              Mail notification to all parents   
            </p>
        </div>
        <button id="send">Send</button>
      
    </div>
  </section>
  </form>
  <section class="bottom-area calender-bottom" id="calendarbox">
    
  </section>
  <footer class="footer-area">
    <div class="container">
      <p>Calendar entries are automatically deleted after the due date.</p>
    </div>
  </footer>



