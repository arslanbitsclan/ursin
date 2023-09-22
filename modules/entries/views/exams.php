
<body>
   <script>
$(function() {
  $('input[name="date"]').daterangepicker({
    "singleDatePicker": true,
    "minDate": new Date()
  });
});
</script>
  <header class="header-area .message-header">
    <div class="container">
      <div class="logo-area">
        <a href="https://edtools.io/apps/"><img src="<?php echo base_url(); ?>appci/assets/entries/images/logo.png" alt="Logo"></a>
      </div>
      <div class="menu-area">
        <nav>
          <ul>
            
           <li id="wh-item"><a href="<?php echo base_url('entries/Homework'); ?>">Homework</a></li> 
              <li id="ex-item"><a id="exm-active" href="<?php echo base_url('entries/Exams'); ?>">Exams</a></li>
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
           <li id="ques-mark"><a class="ques-mark" href="#"><img src="<?php echo base_url(); ?>appci/assets/entries/images/question.png" alt=""></a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>

<form action="<?php echo base_url('entries/Exams/manage'); ?>" onsubmit="return checkvalidation_exam()" method="POST">
         <section class="class-selection exam-select">
            <div class="container">
              <div class="custom-select">
                 <?php if(!isset($selectclass)){?>
                    <select name="class_id" id="class_id_exm" >
                  <option value="">Select Class</option>
                  <?php foreach ($classes as $key => $class) { ?>
                          <option value="<?=$class['_id']?>"<?php if($class['standard'] == 1){ echo 'selected';}else{ 
                          if($key == 0){ echo 'selected'; } 
                        } ?> >
                        <?=$class['class_name']?></option>
                 <?php } ?>
                </select>
                <?php }else{ ?>
                  <select name="class_id" id="class_id_exm" >
                  <option value="">Select Class</option>
                  <?php foreach ($classes as $key => $class) { ?>
                          <option value="<?=$class['_id']?>"<?php if($selectclass == $class['_id']){ echo 'selected';}?> >
                        <?=$class['class_name']?></option>
                 <?php } ?>
                </select>
                <?php }?>
              </div>
            </div>
            <script type="text/javascript">
            loadclasswithreload();
            function loadclasswithreload(){
                            var clsid = document.getElementById("class_id_exm").value;
                            $.ajax({
                                method:'post',
                                url: base_url+'entries/Exams/get_exams_data',
                                data:{class_id:clsid},
                                dataType:'json',
                                success:function(res){
                                  if(res.status){
                                    $('#exambox').html(res.data);
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

 <section id='accesserror' style="display: none">
        <div class="container">
        <div style="padding: 20px; background-color: red; color:white">
          Exams are not shown for this class in the students dashboard. Please activate it in the settings <a id="activelink" target="_blank" href="<?php echo base_url() ?>settings/Student/student"> click here</a>. 
        </div>
        <br/>
      </div>
 </section>

          <section class="form-area exam-form">

            <div class="container">
              <h1 class="typer">Announce an exam</h1>
              <form action="">
                <label for="title">Subject</label>
                <input type="text" maxlength="200" id="title" name="subject" placeholder="Enter subject name" required="required">
                <label for="date">Date</label>
                <input id="datepicker" type='text' name="date" class="js-form-control" placeholder="Enter date" required="required">
                <label for="message">Description</label>
                <textarea name="message" maxlength="800" id="message" cols="30" rows="6" placeholder="Please describe" required="required"></textarea>
                <button id="send">Send</button>
              </form>
            </div>
          </section>
</form>
  <section class="bottom-area exam-bottom" id='exambox'>
    
  </section>
   <footer class="footer-area exam-footer">
    <div class="container">
      <p>The dates of exams are automatically deleted after the due date.</p>
    </div>
  </footer>


