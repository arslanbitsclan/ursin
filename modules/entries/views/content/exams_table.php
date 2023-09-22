
 <?php
  uasort($mesagedata, function($a, $b) {
    return strtotime($a['exam_date']) - strtotime($b['exam_date']);
  });
 ?>
    <div class="container">
       <h1>Exam in <?php echo $classname; ?>

        <?php if(!  empty($connectedclass)){ ?>  
          <div style="float:right; font-size: 12px; color:gray">
            <input type="checkbox" id='examncheckbox_teachers' name="" <?php if(isset($checkboxchecked)){ echo 'checked';  } ?> onclick="load_alldata_exams('<?php echo $idofclass ?>')" ></div> 
          <div style="float:right; font-size: 12px; color:gray;margin-top: 3px;">Show all teachers  
          </div> 
        <?php }else{ ?>
          <a href="<?php echo base_url(); ?>settings/Classes/settings/<?php echo $idofclass; ?>" target="_blank"> <div style="float:right; font-size: 12px; color:gray">Connect to another teacher</div> </a>
        <?php }?>
        </h1>
      <nav>
        <ul>
          <?php  if(isset($mesagedata)){ 
            foreach ($mesagedata as $key => $value) {
              //$value['teachers_name'] == get_teacher_id()
              
              $date = date_create($value['exam_date']);
              $value['exam_date'] =  date_format($date,"Y-m-d");
              if($value['exam_date'] >= date('Y-m-d')){


              ?>

          <li>
            <div class="message">
              <table style="width: 100%; <?php if(isset($value[0])){?> color:gray; <?php } ?> ">
                <tr>
                   <td><?php echo $value['exam_date']; ?></td>
                   <td><?php echo $value['subject']; ?></td>
                   <td>
                       <?php 
                        if(isset($checkboxchecked) &&  isset($value[0]) ){
                           echo '  ('.$value['teachers_name'].')';
                         }
                        ?>
                    <?php echo $value['description']; ?></td>
                  <td>
                    <?php if(!isset($value[0])){?>
                         <button style="color:none;border: none; padding: 0" class="delete delete-exam" data-id="<?php echo $idofclass; ?>" 
                          data-check='<?php if(isset($checkboxchecked)){echo $checkboxchecked; } ?>'  data-key="<?php echo $key ?>" >&#10007;</button>
                    <?php } ?>
                  </td>
                </tr>
              </table>
            </div>
          </li>

          <?php } } }?> 
        </ul>
      </nav>
    </div>

