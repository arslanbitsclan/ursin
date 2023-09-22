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
              <li id="lk-item"><a id="ln-active" href="<?php echo base_url('entries/Link'); ?>">Links</a></li>
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

 <form action="<?php echo base_url('entries/Link/manage'); ?>" method="POST" onsubmit="return checkvalidation_links();">
  <section class="class-selection link-cl-sel">
    <div class="container">
      <div class="custom-select">

         <?php if(!isset($selectclass)){?>
            <select name="class_id" id="clasid_link">
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
          <select name="class_id" id="clasid_link">
            <option value="">Select Class</option>
            <?php foreach ($classes as $key => $class) { ?>
              <option value="<?=$class['_id']?>" 
                        <?php if($selectclass == $class['_id']){ echo 'selected';} ?> >
              <?=$class['class_name']?></option>
            <?php } ?>
        </select>
        <?php }?>
      </div>
    </div>
  </section>
<script type="text/javascript">

  

  function loadlinkforblew(){
              var urlid = document.getElementById("urlid").value;
              var url = urlid.substring(0, 3);
              if(url == 'www'){   
                        $("#urlid").keyup(function(){
                           $('#linkofurl').attr("href", 'http://' + this.value);
                        });
              }else{
                      $("#urlid").keyup(function(){
                            $('#linkofurl').attr("href", this.value);
                      });
              }
  }

loadclasswithreload();
function loadclasswithreload(){
        var clsid = document.getElementById("clasid_link").value;
        $.ajax({
            method:'post',
            url: base_url+'entries/Link/get_link_data',
            data:{class_id:clsid},
            dataType:'json',
            success:function(res){
              if(res.status){
                  $('#linkbox').html(res.data);
                  if(res.messageaccess == "1"){
                    $('#accesserror').show();  
                    $("#activelink").attr("href", "<?php echo base_url() ?>settings/Student/student/"+clsid);
                  }else{  
                     $('#accesserror').hide();  
                  }
              }else{
                 
              }
             
            }
          });

}
</script>
<section style="display: none;" id='accesserror'>
        <div class="container">
        <div style="padding: 20px; background-color: red; color:white">
         Weblinks are not shown for this class in the students dashboard. Please activate it in the settings. <a id="activelink" href="<?php echo base_url() ?>settings/Student/student" target="_blank"> click here</a>. 
        </div>
        <br/>
      </div>
 </section>

  <section class="form-area link-form">
    <div class="container">
      <h1 class="typer">Publish a weblink</h1>
 
        <label for="url">URL</label>
        <input type="text" maxlength="400" name="url" onkeyup="loadlinkforblew()" id="urlid" placeholder="Enter a valid url">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" placeholder="Enter title" required="required">
        <label for="description">Description</label>
        <textarea maxlength="400"  name="description" id="description" cols="30" rows="6" placeholder="Please describe" required="required"></textarea>
        <input type="checkbox" id="check" value="publish" name="publishforall">
        <label id="check-text" for="check">Publish to all my classes</label>
        <div class="form-bottom-selection">
          <div class="selection-part">
            <select name="category" id="" required>
               <option value="">Select Category</option>
               <option value="classroom">Classroom</option>
               <option value="homework">Homework</option>
               <option value="leisure_time">Leisure time</option>
               <option value="learning">Learning</option>
               <option value="parents">Parents(only)</option>
               <option value="school">School</option>
               <option value="tools">Tools</option>
               <option value="various">Various</option>
            </select>
          </div>
          <div class="selection-part">
                    <div class="form-input form-input-icon" >
                      <div class="get-and-preview">
                               
                          <button style="width: 100%;padding: 5px 7px;font-size: 18px;border-radius: 50px;border: 4px solid #fff;background: #94427f;color: #fff;" type="button" id="GetIconPicker" data-iconpicker-input="input#IconInput" data-iconpicker-preview="i#IconPreview">Select Icon</button>
                      </div>
                            <div class="export">
                                <input type="hidden" id="IconInput" value="fas fa-pencil-alt" name="icon" required placeholder="Hidden etc. input for icon classname" autocomplete="off" spellcheck="false" />
                            </div>
                      </div>

            <div class="color-bar">
              <ul>
                <input type="hidden" name="color" id='colorset'>
                <li><a href="javascript:void(0)"  onclick="changecolor('#00AEEF')">
                    <div id="clr-ptr" class="color-box"></div>
                  </a></li>
                <li><a href="javascript:void(0)"  onclick="changecolor('#EC008C')">
                    <div id="clr-alg" class="color-box"></div>
                  </a></li>
                <li><a href="javascript:void(0)"  onclick="changecolor('#F37121')">
                    <div id="clr-carrot" class="color-box"></div>
                  </a></li>
                <li><a href="javascript:void(0)"  onclick="changecolor('#25408F')">
                    <div id="clr-mblue" class="color-box"></div>
                  </a></li>
                <li><a href="javascript:void(0)"  onclick="changecolor('#A42780')">
                    <div id="clr-amet" class="color-box"></div>
                  </a></li>
                <li><a href="javascript:void(0)"  onclick="changecolor('#B3C935')">
                    <div id="clr-org" class="color-box"></div>
                  </a></li>
              </ul>
            </div>
          </div>

          <div class="selection-part">
            <div class="icon-box" id='setboxcolor'>
              <a id='linkofurl' target="_blank"> 
                  <div class="icon-preview" data-toggle="tooltip" title="Preview of selected Icon">
                    <i id="IconPreview" style="font-size: 35px; padding: 16px; color: white;" class="fas fa-pencil-alt"></i>
                  </div>
              </a>
            </div>
          </div>
        </div>
                        

        <button type="submit" id="send">Send</button>
     
    </div>
  </section>
   </form>
   <script type="text/javascript">
    function getRndInteger(min, max) {
      return Math.floor(Math.random() * (max - min)) + min;
    }
    setTimeout(function(){
         // var randunique = Math.floor(Math.random() * (600 - 0 + 1) + 0);
         // var randnumber2 = Math.floor(Math.random() * (randunique - 0 + 1) + 0);
        
          var random = Math.floor((Math.random() * 600) + 1);
          var randnumber2 = Math.round(random);
          if(randnumber2 < 100){
            changecolor('#00AEEF');
          }else if(randnumber2 < 200){
            changecolor('#EC008C');
          }else if(randnumber2 < 300){
            changecolor('#F37121');
          } else if(randnumber2 < 400){
            changecolor('#25408F');
          } else if(randnumber2 < 500){
            changecolor('#A42780');
          } else if(randnumber2 < 600){
            changecolor('#B3C935');
          }   
     }, 2000);
    // changecolor('#B3C935');

    function randomIntFromInterval(min, max) { // min and max included 
      return Math.floor(Math.random() * (max - min + 1) + min);
    } 
  </script>
  <section class="bottom-area link-bottom" id='linkbox'>
    
  </section>
  <footer class="footer-area">
    <div class="container">
      <p>Students can access your links from anywhere, even from home. The Student Dashboard takes them to the clearly arranged link page, which can also be set up as a browser start page. This simplifies working with online tools and prevents mistyping. </p>
    </div>
  </footer>

 
