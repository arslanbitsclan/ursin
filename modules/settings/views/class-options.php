<?php 
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

?> 
