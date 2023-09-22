<pre><?php //asort($mesagedata);  ?>
<?php
//$price = array_column($mesagedata, 'category');
//array_multisort($price, SORT_ASC, $mesagedata);
$sortinglist = array("classroom", "homework", "leisure_time", "learning", "parents", "school", "tools", "various",'');
$sorted = array();
foreach ($sortinglist as $key => $sorting) {
        asort($mesagedata);
        foreach ($mesagedata as $k => $data) {
              if($sorting == $data['category'])
              {
                  $sorted[$k] = $data;
              }
        }
}


$mesagedata = $sorted;
?>

</pre>
<div class="container">
      <h1>Links for <?php echo $classname; ?>
        <?php if(!empty($connectedclass)){ ?>  
              <div style="float:right; font-size: 12px; color:gray"> 
                <input type="checkbox" name="" id='linkcheckbox_teacher' <?php if(isset($checkboxchecked)){ echo 'checked';  } ?> onclick="load_alldata_links('<?php echo $idofclass ?>')" ></div> 
              <div style="float:right; font-size: 12px; color:gray;margin-top: 3px;">Show all teachers  
          </div> 
          <?php }else{ ?>
            <a href="<?php echo base_url(); ?>settings/Classes/settings/<?php echo $idofclass; ?>" target="_blank"> <div style="float:right; font-size: 12px; color:gray">Connect to another teacher</div> </a>
          <?php }?>
       </h1>
      <nav>
        <ul>

    <?php  if(isset($mesagedata)){ 
        $datearrt =  array();
        $count = 0;
      foreach ($mesagedata as $key => $value) {
        //$value['teachers_id'] == get_teacher_id()
        if(true){
        ?>
          <li>
            <div class="message message-link">
              <div class="container">
                  <?php if(!in_array($value['category'], $datearrt)){ ?>
                      <h3 class="form-h-text">Category
                       <?php echo @str_replace('_',' ',$value['category']); ?></h3>
                  <?php } ?>
                <div class="table-cont">
                  <?php      
                     if(strpos($value['url'], 'http') !== false){
                          $urlfind = $value['url'];
                      } else{
                          $urlfind = 'http://'.$value['url'];
                      }       
                  ?>
                  <a href="<?php echo $urlfind; ?>" target="_blank">
                      <div class="box-left-icon">
                        <?php
                        if(!empty($value['color'])){
                         $col = $value['color'];  
                       }else{
                          $col = "#00AEEF";  
                       }?>
                        <div class="icon-box" style="background: <?php echo $col; ?>;">
                          <i style="font-size: 35px; padding: 18px; color: white;" class="<?php echo $value['icon']; ?>"></i>
                        </div>
                      </div>
                  </a>

                  <div class="box-table">
                    <a href="<?php echo $urlfind; ?>" target="_blank">
                    <span style='<?php if(isset($value[0])){?> color:gray; <?php } ?>'><?php echo $value['title']; ?>

                      <?php 
                        if(isset($checkboxchecked) &&  isset($value[0]) ){
                           echo '  ('.$value['teachers_name'].')';
                         }
                        ?>
                        </span>
                    </a>
                      
                    

                    <table style="width: 85%; <?php if(isset($value[0])){?> color:gray; <?php } ?> ">
                      <tr>
                        <td><?php echo $value['description']; ?></td>
                        <td> 
                          <?php if(!isset($value[0])){?>
                             <button style="color:none;border: none; padding: 0" class="delete delete-links" data-id="<?php echo $idofclass; ?>"
                              data-check='<?php if(isset($checkboxchecked)){echo $checkboxchecked; } ?>'  
                              data-key="<?php echo $key ?>" >&#10007;</button>
                          <?php }else{?>
                              <div style="width: 30px;height: 30px">&nbsp;</div>
                          <?php }?>
                       </td>
                      </tr>
                    </table>


                  </div>
                </div>
              </div>
            </div>
          </li>
    <?php
                 $datearrt[$count] = $value['category']; 
                 $count++;
     } }
      } ?>



        </ul>
      </nav>
    </div>

