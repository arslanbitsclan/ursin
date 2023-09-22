
<body>
  <header class="header" id="hthree">
    <div class="container">
      <div class="logo-area">
        <a href="https://edtools.io/apps/"><img src="appci/assets/images/logo_black_medium.png" alt=""></a>
      </div>
      <nav>
        <ul>
          <li><a href="<?php echo base_url('settings/Classes'); ?>">Manage Classes</a></li>
          <li><a href="<?php echo base_url('settings/Student'); ?>">Manage Students</a></li>
          <li class="active"><a href="<?php echo base_url('settings/student/Student'); ?>">Students Page</a></li>
        </ul>
      </nav>
      <div class="help-icon">
        <div class="guidez3rdpjs-modal" data-key="nd0ga72aaa-2cli7qwh7d" data-mtype="g"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d9/Icon-round-Question_mark.svg/768px-Icon-round-Question_mark.svg.png" alt="info" width="20" height="20"></div>
        <script src="https://sdk.fleeq.io/fleeq-sdk-light.js"></script>
      </div>
    </div>
  </header>
  <?php if(empty($classes)){ ?>
   <section class="dashboard" style="text-align: center;">
    <div class="container">
      <span>Please create a class first</span><br>
     <a href="<?php echo base_url('settings/Classes'); ?>">Click Here.</a>
    </div>
  </section>
    
  <?php }else{ ?>
  <section class="dashboard">
    <div class="container">
      <span>Students Dashboard</span>
      <p class="t">Set which tool students can see in their dashboard</p>

      
<!--       <div class="drb">
        <select name="standart_class">
          <?php foreach ($classes as $class) { ?>
            <option <?php if($class['standard'] == 1){ echo "selected"; } ?> value="<?=$class['_id']?>"><?=$class['class_name']?></option>
          <?php } ?>
        </select>
      </div> -->

    <section class="dropdown-box" style="margin-left: -10% !important; margin-top: 0% !important;">
    <div class="container">
      <span>Select main class:</span>
     
        <div class="drb">

          <?php if(!isset($selectclass)){?>
                  <select name="standart_class" required>
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $class) { ?>
                    <option <?php if($class['standard'] == 1){ echo "selected"; } ?> value="<?=$class['_id']?>"><?=$class['class_name']?></option>
                    <?php } ?>
                  </select> 
           <?php }else{ ?>
             <select name="standart_class" required>
                  <option value="">Select Class</option>
                  <?php foreach ($classes as $class) { ?>
                  <option <?php if($selectclass == $class['_id']){ echo "selected"; } ?> value="<?=$class['_id']?>"><?=$class['class_name']?></option>
                  <?php } ?>
                </select>
            <script type="text/javascript">
               var class_id = $("[name='standart_class']").val();
                  $.ajax({
                    type: "POST",
                    url: base_url+'settings/Classes/options',
                    data:{class_id:class_id},
                    success: function(res){
                      $("#option-panel").html(res);
                    }
                  });
            </script>
            <?php } ?>
        </div>

    </div>
  </section>
      <div id="option-panel">
       <?php 
       if(!empty($class_tools[0]) && isset($class_tools[0])){
       ksort($class_tools[0]['show_tools']);
       $valueArray = array_slice($class_tools[0]['show_tools'],0,11);


       $nameArray = array(
        array("name"=>"Overdue Task","img"=>"appci/assets/images/icon_tasks.png"),
        array("name"=>"Messages to Class","img"=>"appci/assets/images/icon_messages.png"),
        array("name"=>"Weblink","img"=>"appci/assets/images/icon-url.png"),
        array("name"=>"Exam Dates","img"=>"appci/assets/images/icon_exam.png"),
        array("name"=>"Homework","img"=>"appci/assets/images/icon-collection.png","sub"=>1),
        array("name"=>"Calendar","img"=>"appci/assets/images/icon-calendar.png"),
        array("name"=>"Checklist","img"=>"appci/assets/images/icon_checklist.png"),
        array("name"=>"Solution Keys","img"=>"appci/assets/images/icon_solution.png"),
        array("name"=>"Sick Notifications","img"=>"appci/assets/images/icon_ill.png"),
        array("name"=>"Library","img"=>"appci/assets/images/icon-library.png"),
        array("name"=>"Files","img"=>"appci/assets/images/icon-file.png")
      );

       $options_array = array();
       foreach ($nameArray as $k=> $value) {
        array_push($options_array,array("name"=>$value['name'],"img"=>$value['img'],"value"=>$valueArray[$k]));
      }

      foreach ($options_array as $k1 => $v1) {
        $checked = "";
        if($v1['value'] == 1){
          $checked = "checked";
        }
        if($v1['name'] == "Homework"){ 
          ?>

          <div class="dabo">
            <div class="dabo-wrap">

              <div class="dash">
                <div class="debo-icon"><img src="<?=$v1['img']?>" alt=""></div>
                <div class="ht">
                  <h4 class="t"><?=$v1['name']?></h4>
                </div>
                <div class="sw">
                  <label class="switch">
                    <input type="checkbox" value="1" id="homework" name="option" data-index = "<?=$k1?>" <?=$checked?>>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              
              <?php
              $bottom = "";
              $display ="";
              if($v1['value'] == 2){
                $bottom = "checked";
                $display = "block";
              }
              if($v1['value'] == 1){
                $bottom = "";
                $display = "none";
              }

              ?>
              <div class="dash dash-second" style="display: <?=$display ?>">
                <div class="debo-icon"><img src="appci/assets/images/icon-collection.png" alt=""></div>
                <div class="ht">
                  <h4 class="t">Homework for absent students</h4>
                </div>
                <div class="sw">
                  <label class="switch">
                    <input type="checkbox" value="1" data-index = "<?=$k1?>" id="homework-second" <?=$bottom?>>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              
              
            </div>
          </div>
        <?php }else{ ?>
          <div class="dabo">
            <div class="dabo-wrap">

              <div class="dash">
                <div class="debo-icon"><img src="<?=$v1['img']?>" alt=""></div>
                <div class="ht">
                  <h4 class="t"><?=$v1['name']?></h4>
                </div>
                <div class="sw">
                  <label class="switch">
                    <input type="checkbox" value="<?=$v1['value']?>" name="option" data-index = "<?=$k1?>"  <?=$checked?>>
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>


              
            </div>
          </div>
          <?php 
        }
      }
    }

      ?> 
      
      

    </div>
    
    


    
  </div>
</section>
<?php } ?>