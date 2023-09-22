<pre>
<?php
  // asort($mesagedata);
  function sorting($a, $b) {  
    return strtotime($a['due_date']) - strtotime($b['due_date']);
  }

  function sortingforgray($a, $b) {  
    return strtotime($b['due_date']) - strtotime($a['due_date']);
  }

  uasort($mesagedata,"sorting");

  $arrayofsort222 =  array();
  $dateofall = array();
  foreach ($mesagedata as $key => $value1) {
      if(!in_array($value1['due_date'], $dateofall)){
         $dateofall[$key] = $value1['due_date'];
       }
  } 

$sorted = array();
foreach ($dateofall as $key => $sorting) {
        asort($mesagedata);
        foreach ($mesagedata as $k => $data) {
              if($sorting == $data['due_date'])
              {
                  $sorted[$k] = $data;
              }
        }
}
$mesagedata = $sorted;

$mesagedata2 = $sorted;
uasort($mesagedata2,"sortingforgray");
//print_r($mesagedata2);


 ?>
</pre>

    <h1>Homework in <?php echo $classname; ?>

        <?php if(!empty($connectedclass)){ ?>  
          <div style="float:right; font-size: 12px; color:gray">
            <input type="checkbox" id='homeworkcheckbox_teacher' <?php if(isset($checkboxchecked)){ echo 'checked';  } ?> onclick="load_alldata_homework('<?php echo $idofclass ?>')" ></div> 
          <div style="float:right; font-size: 12px; color:gray;margin-top: 3px;">Show all teachers  
          </div> 
        <?php }else{ ?>
          <a href="<?php echo base_url(); ?>settings/Classes/settings/<?php echo $idofclass; ?>" target="_blank"> <div style="float:right; font-size: 12px; color:gray">Connect to another teacher</div> </a>
        <?php }?>
    </h1>

        <div class="message" id="home_work">
          <nav>
            <ul>
                <?php  if(isset($mesagedata)){ 
                   $datearrt =  array();
                   $count = 0;
                 
                 foreach ($mesagedata as $key => $value) {

                  //$value['teachers_id'] == get_teacher_id()
                  if($value['due_date'] >= date('m/d/Y') ){
                   
                   ?>
                        <li>
                            <table style="width: 100%; <?php if(isset($value[0])){?> color:gray; <?php } ?> " >
                              <?php if(in_array($value['due_date'], $datearrt)){ ?>
                                  <tr>
                                      <td></td>
                                      <td><?php echo $value['subject']; ?></td>
                                      <td>
                                        <?php 
                                        if(isset($checkboxchecked) &&  isset($value[0]) ){
                                           echo '  ('.$value['teachers_name'].')';
                                         }
                                        ?>
                                        <?php echo $value['description']; ?>
                                      </td>
                                      <td>
                                        <?php if(!isset($value[0])){?>
                                         <button style="color:none;border: none; padding: 0" class="delete delete-homework" data-id="<?php echo $idofclass; ?>"
                                           data-check='<?php if(isset($checkboxchecked)){echo $checkboxchecked; } ?>'  
                                          data-key="<?php echo $key ?>" >&#10007;</button>
                                          <?php } ?>
                                       </td>
                                  </tr>
                              <?php }else{ ?>
                                  <tr>
                                    <td><?php echo $value['due_date']; ?></td>
                                    <td><?php echo $value['subject']; ?></td>
                                    <td>
                                      <?php 
                                        if(isset($checkboxchecked) &&  isset($value[0]) ){
                                           echo '  ('.$value['teachers_name'].')';
                                         }
                                        ?>  
                                      <?php echo $value['description']; ?>
                                    </td>
                                    <td>
                                   <?php if(!isset($value[0])){?>
                                         <button style="color:none;border: none; padding: 0" class="delete delete-homework" data-id="<?php echo $idofclass; ?>"
                                         data-check='<?php if(isset($checkboxchecked)){echo $checkboxchecked; } ?>'  
                                          data-key="<?php echo $key ?>" >&#10007;</button>
                                    <?php } ?>
                                     </td>
                                  </tr>
                              <?php }?>
                            </table>
                        </li>
                 <?php  
                 $datearrt[$count] = $value['due_date']; 
                 $count++;
                 } // end date con
                 } // end loop
                 } // end empty check
                ?>
            </ul>
          </nav>
        </div>


         <div class="sec-late-homework" id="late-homework">
              <h1>Homework of the last few days</h1>
              <div class="message">
                <nav>
                  <ul>
                  <?php  if(isset($mesagedata)){ 
                    $datearrtlastdy =  array();
                    $countday = 0;
                    foreach ($mesagedata2 as $key => $valueday) {
                      if($valueday['due_date'] < date('m/d/Y')){
                  ?>
                    <li>
                      <table style="width: 100%; ">
                         <?php if(in_array($valueday['due_date'], $datearrtlastdy)){ ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td><?php echo $valueday['subject']; ?></td>
                                <td><?php echo $valueday['description']; ?></td>
                                <td></td>
                              
                            </tr>
                        <?php }else{ ?>
                        <tr>
                          <td><?php echo $valueday['due_date']; ?></td>
                          <td><?php echo $valueday['subject']; ?></td>
                          <td><?php echo $valueday['description']; ?></td>
                          <td></td>
                        </tr>
                        <?php }?>
                      </table>
                    </li>
                 <?php 
                   $datearrtlastdy[$countday] = $valueday['due_date']; 
                   $countday++;
                 } // end date con
                 } // end loop
                 } // end empty check
                 ?>
                  </ul>
                </nav>
              </div>
            </div>
            

