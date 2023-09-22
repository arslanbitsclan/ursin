
<body>
  <script>
$(function() {
  var minDate = new Date();
minDate.setDate(minDate.getDate() + 1);
  $('input[name="date"]').daterangepicker({
    "singleDatePicker": true,
     "minDate": minDate
  });
  $('input[name="date"]').val('');



  if($('input[name="date"]').val() == ''){
      $("#emptydate").hide();
  }else{
    $("#emptydate").show();
  }
});

function butnshow(){
    if($('input[name="date"]').val() == ''){
      $("#emptydate").hide();
  }else{
    $("#emptydate").show();
  }
}

function emptydatehide(){
  $('input[name="date"]').val('');

   if($('input[name="date"]').val() == ''){
      $("#emptydate").hide();
  }else{
    $("#emptydate").show();
  }
  
}
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
              <li id="ex-item"><a href="<?php echo base_url('entries/Exams'); ?>">Exams</a></li>
              <li id="ms-item"><a id="meg-active" href="<?php echo base_url('entries/Messages'); ?>">Messages</a></li>
              <li id="lk-item"><a href="<?php echo base_url('entries/Link'); ?>">Links</a></li>
              <li id="cl-item"><a href="<?php echo base_url('entries/Calendar'); ?>">Calendar</a></li>
            
            <li class="drp-itm" id="mr-item"><a href="">More<i class="fas fa-angle-down"></i></a>
              <ul>
                <li><a target="_blank" href="https://www.edtools.io/overdue">Open Task</a></li>
                <li><a target="_blank" href="https://www.edtools.io/checklist">Checklist</a></li>
                <li><a target="_blank" href="https://edtools.io/entries/Absent">Absent</a></li>
                <li><a target="_blank" href="https://edtools.io/settings/Student/student">Settings</a></li>
              </ul>
            </li>
            <li id="ques-mark"><a class="ques-mark" href="#"><img src="<?php echo base_url(); ?>appci/assets/entries/images/question.png" alt=""></a></li>
          </ul>
        </nav>
      </div>
    </div>
  </header>

<form action="<?php echo base_url('entries/Messages/manage'); ?>" onsubmit="return checkvalidation_message()" method="POST">
    <section class="class-selection message-select">

      <div class="container">
            <div class="custom-select">
           <?php if(!isset($selectclass)){?>
                  <select name="class_id" id="clasid">
                    <option value="" selected="">Select Class</option>
                      <?php foreach ($classes as $key => $class) { ?>
                          <option value="<?=$class['_id']?>" 
                            <?php if($class['standard'] == 1){ echo 'selected';}else{ 
                              if($key == 0){ echo 'selected'; } 
                            } ?> >
                              <?=$class['class_name']?>
                          </option>
                      <?php } ?>
                  </select>       
           <?php }else{ ?>
              <select name="class_id" id="clasid">
                <option value="" selected="">Select Class</option>
                  <?php foreach ($classes as $key => $class) { ?>
                      <option value="<?=$class['_id']?>" 
                        <?php if($selectclass == $class['_id']){ echo 'selected';} ?> >
                          <?=$class['class_name']?>
                      </option>
                  <?php } ?>
              </select>
            <?php } ?>
            </div>
      </div>
            <script type="text/javascript">
            loadclasswithreload();
            function loadclasswithreload(){
                var clsid = document.getElementById("clasid").value;
                $.ajax({
                    method:'post',
                    url: base_url+'entries/Messages/get_messages_data',
                    data:{class_id:clsid},
                    dataType:'json',
                    success:function(res){
                      if(res.status){
                        $('#messagebox').html(res.data);
                        if(res.messageaccess == '1'){
                          $('#accesserror').show(); 
                          $("#activelink").attr("href", "<?php echo base_url() ?>settings/Student/student/"+clsid);
                        }else{
                          $('#accesserror').hide();  
                        }

                        if(res.messagelimit != ''){
                          $('#limiterror').html(res.messagelimit);  
                          $('#limiterrorhide').hide();
                        }else{
                          $('#limiterror').html('');  
                          $('#limiterrorhide').show();
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
            Messages are not shown for this class in the students dashboard. Please activate it in the settings <a href="<?php echo base_url() ?>settings/Student/student" target="_blank" id='activelink'> click here</a>. 
          </div>
      </div>
      <br/>
</section>
    <section class="form-area message-form">
      <div class="container" >
        <div id='limiterrorhide'>
        <h1 class="typer">Create a new message</h1>
       
       
          <label for="title">Title</label>
          <input type="text" id="title" maxlength="200" name="title" placeholder="Enter title" required>
          <label for="date" style="display: block">Date of delation</label>
          <input id="datepicker" onchange="butnshow()" type='text' name="date" style="display: inline" class="js-form-control" placeholder="Optional expiration date" value="">
          <button type="button" id='emptydate' onclick="emptydatehide()" style="background-color: none; border:none; margin-left: -36px; mar">X</button>
          <label for="message" style="display: block">Message</label>
          <textarea name="message" id="message" cols="30" maxlength="800" rows="6" placeholder="Write your message" required></textarea>
            <p>
              <input type="checkbox" style="float: none !important" name="publichallclass" value="1" style="width: 15px;">  Publish to all my classes <br/>
              <input type="checkbox"  id="recipient_identifier1" onclick="showmailcheckbox(this)" name="recipient_identifier" value="2" style="width: 15px;">  Visible for parents only
            </p>
          <!--   <p><input type="radio" id="male" name="gender" value="male" style="width: 15px;">  Mail notification to all parents</p> -->

         
          

          <!-- <input type="radio" id="check" name="recipient_identifier" value="0">
          <label id="check-text" for="check">Publish to all my classes</label> -->

          <!-- <input type="radio" id="check" name="recipient_identifier" value="1">
          <label id="check-text" for="check">Visible for parents only</label>-->
          <div style="margin-left: 30px; display: none;" id="idofmailcheckbox">
            <input type="checkbox" id="check" name="emailsendofall" value="mail">
            <label id="check-text" for="check">Mail notification to all parents</label> 
          </div>

          <button type="submit" id="send">Send</button>
       
      </div>
      </div>
       <center><label  id='limiterror'> </label></center>

    </section>
  

</form>
   

  <section class="bottom-area message-cont" id="messagebox">
    <div class="container">
      <nav>
        <ul>
          <?php if(isset($messagesdata)){ foreach (uksort($messagesdata) as $key => $value) {?>
            
        
          <?php } }?>
        </ul>
      </nav>
    </div>
  </section>

<footer class="footer-area message-footer">
    <div class="container">
      <p>Keep your messages up to date and relevant at all times. Therefore, the number of messages is limited to 5 (gold) or 20 (diamond). Here you can update subscriptions.</p>
    </div>
</footer>


   


