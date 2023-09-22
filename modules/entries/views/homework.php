  <script>
$(function() {
  $('input[name="due_date"]').daterangepicker({
    "singleDatePicker": true,
    minDate: new Date()
  });
});
</script>
<body>
  <header class="header-area">
    <div class="container">
      <div class="logo-area">
        <a href="https://edtools.io/apps/"><img src="<?php echo base_url(); ?>appci/assets/entries/images/logo.png" alt="Logo"></a>
      </div>
      <div class="menu-area">
        <nav>
          <ul>
            <li class="drp-itm" id="wh-item"><a id="hw-active" href="<?php echo base_url('entries/Homework'); ?>">Homework <i class="fas fa-angle-down"></i></a>
              <ul>
                <li><a target="_blank" href="<?php echo base_url('entries/Showhomework'); ?>">Show on frontscreen</a></li>
                <li><a target="_blank" href="<?php echo base_url('entries/Absent'); ?>">Who is absent?</a></li>
              </ul>
            </li>
              <li id="ex-item"><a href="<?php echo base_url('entries/Exams'); ?>">Exams</a></li>
              <li id="ms-item"><a href="<?php echo base_url('entries/Messages'); ?>">Messages</a></li>
              <li id="lk-item"><a  href="<?php echo base_url('entries/Link'); ?>">Links</a></li>
              <li id="cl-item"><a href="<?php echo base_url('entries/Calendar'); ?>">Calendar</a></li>
            
            <li class="drp-itm" id="mr-item"><a href="">More<i class="fas fa-angle-down"></i></a>
              <ul>
                <li><a target="_blank" href="https://www.edtools.io/overdue">Open Task</a></li>
                <li><a target="_blank" href="https://www.edtools.io/checklist">Checklist</a></li>
                <li><a target="_blank" href="https://edtools.io/entries/Absent">Absent</a></li>
                <li><a target="_blank" href="https://edtools.io/settings/Student">Settings</a></li>
              </ul>
            </li>
            <li id="ques-mark"><a class="ques-mark" target="_blank" href="#"><img src="<?php echo base_url(); ?>appci/assets/entries/images/question.png" alt=""></a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>

<form action="<?php echo base_url('entries/Homework/manage'); ?>" onsubmit="return checkvalidation_homework()" method="POST">
  <section class="class-selection hw-selt">
         
    <div class="container">
      <div class="custom-select">

        <?php if(!isset($selectclass)){?>
          <select name="class_id" id="clasid_homework">
          <option value="">Select Class</option>
          <?php foreach ($classes as $key => $class) { ?>
                <option value="<?=$class['_id']?>" 
                        <?php if($class['standard'] == 1){ echo 'selected';}else{ 
                          if($key == 0){ echo 'selected'; } 
                        } ?> >
              <?=$class['class_name']?></option>
          <?php } ?>
        </select>
        <?php }else{ ?>
          <select name="class_id" id="clasid_homework">
          <option value="">Select Class</option>
          <?php foreach ($classes as $key => $class) { ?>
                <option value="<?=$class['_id']?>" 
                        <?php if($selectclass == $class['_id']){ echo 'selected';} ?> >
              <?=$class['class_name']?></option>
          <?php } ?>
        </select>
        <?php }?>
      </div>

<script type="text/javascript">
loadclasswithreload();
function loadclasswithreload(){
        var clsid = document.getElementById("clasid_homework").value;
        $.ajax({
            method:'post',
            url: base_url+'entries/Homework/get_homework_data',
            data:{class_id:clsid},
            dataType:'json',
            success:function(res){
              if(res.status){
                  $('#homeworkbox').html(res.data);

                  if(res.messageaccess == 0){
                    $(".activelink").attr("href", "<?php echo base_url() ?>settings/Student/student/"+clsid);
                    $('#accesserror').show();  
                  }else if(res.messageaccess == 2){
                    $(".activelink").attr("href", "<?php echo base_url() ?>settings/Student/student/"+clsid);
                    $('#accesserrorgreen').show();  
                    $('#accesserror').hide(); 
                  }else{
                    $('#accesserrorgreen').hide(); 
                    $('#accesserror').hide();   
                  }
              }else{
                 
              }
             
            }
          });

}
</script>

      <div class="sec-left-btn">
        <ul>
          <li>
             <div class="tooltip">
          <a href="<?php echo base_url('entries/Showhomework'); ?>" target="_blank">Show on Frontscreen</a>
           <span class="tooltiptext">Show the students the homework so that they can transfer it to their agenda.</span>
          </div>
        </li>
        <li >
           <div class="tooltippdf">
             <a href="<?php echo base_url('entries/Absent'); ?>" target="_blank"><i class="fas fa-thermometer-three-quarters"></i></a>
             <span class="tooltiptextpdf">Who is absent and should see this homeworks in his dashboard?</span>
           </div>
        </li>
        </ul>
      </div>
   
  </section>
  
   <section style="display: none;" id='accesserror'>
        <div class="container">
        <div style="padding: 20px; background-color: red; color:white">
          Homework is not shown for this class in the students  dashboard. Please activate it in the settings<a class="activelink" href="<?php echo base_url() ?>settings/Student/student" target="_blank"> click here</a>. 
        </div>
        <br/>
      </div>
   </section>

   <section style="display: none;" id='accesserrorgreen'>
        <div class="container">
        <div style="padding: 20px; background-color: green; color:white">
          Only absent students can view the homework entries. Changes can be made in the settings<a class="activelink" href="<?php echo base_url() ?>settings/Student/student" target="_blank"> click here</a>. 
        </div>
        <br/>
      </div>
   </section>

  <section class="form-area homework-form">
    <div class="container">
      <h1 class="typer">Give Homework</h1>
        <label for="title">Subject</label>
        <input type="text" maxlength="300" name="subject" id="title" placeholder="Enter subject name" required="required">
        <label for="datepicker">Date</label>
        <input id="datepicker" name="due_date" class="js-form-control" placeholder="Enter date" required="required">
        <label for="task">Task</label>
        <textarea name="description" maxlength="300" id="task" cols="30" rows="6" placeholder="Please describe" required="required"></textarea>
        <button class="hw-send" id="send">Send</button>
    
    </div>
  </section>
</form>
  <section class="bottom-area hw-bottom">
    <div class="container">
      <div class="homework-btn">
        <nav>
          <ul>
            <li id="wh-item">
              <div class="tooltip">
                <a target="_blank" href="<?php echo base_url('entries/Showhomework'); ?>">Show on Frontscreen</a>
                <span class="tooltiptext">Show the students the homework so that they can transfer it to their agenda.</span>
              </div>
            </li>
          </ul>
        </nav>
        <br/><br/>
      </div>
        <div id="homeworkbox">

           
        </div>
    </div>
  </section>
  <footer class="footer-area">
    <div class="container">
      <p>Homework is automatically deleted five days after the due date. Students only see their upcoming and current homework in their dashboard.</p>
    </div>
  </footer>


