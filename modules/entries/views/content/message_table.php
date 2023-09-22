<?php
if(isset($mesagedata)){ 
  $totalcount = count($mesagedata);
  $mesagesortdata = array();
  foreach ($mesagedata as $key => $value) {
      $mesagesortdata[$totalcount-1] = $mesagedata[$totalcount-1];
      $totalcount--;
  }
}
$mesagedata = $mesagesortdata;
 ?>
</pre>
  <section class="bottom-area message-cont">
    <div class="container">
      
      <h1>Message for <?php echo $classname; ?> 

      <?php if(!empty($connectedclass)){ ?>  
         <div style="float:right; font-size: 12px; color:gray">
          <input type="checkbox" id='checkboxconnectcls' <?php if(isset($checkboxchecked)){ echo 'checked';  } ?> onclick="load_alldata_teacher('<?php echo $idofclass ?>')"  >
          </div>
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
              //$value['teachers_id'] == get_teacher_id()
              if(true){ ?>
          <li>
            <div class="message">
              <div class="container">

                <table style="width: 100%; <?php if(isset($value[0])){?> color:gray; <?php } ?> " >
                  <tr>
                    <td>
                      <?php if(isset($value['recipient_identifier'])) {
                          if($value['recipient_identifier'] == '2') {?>
                            <div style="color:gray; display: inline"> Only for parents:</div>
                         <?php  }} ?>
                      <div style="display: inline"><?php echo $value['title']; ?></div>

                       <?php 
                        if(isset($checkboxchecked) &&  isset($value[0]) ){
                           echo '  ('.$value['teachers_name'].')';
                         }
                        ?>

                    </td>
                    <td></td>
                    <td><?php if(isset($value['creation_date'])){ echo $value['creation_date']; }?></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="3" ><?php echo $value['message']; ?></td>
                    <td>
                      <?php if(!isset($value[0])){?>
                         <button style="color:none;border: none; padding: 0" class="delete delete-message"   data-id="<?php echo $idofclass; ?>" 
                            data-check='<?php if(isset($checkboxchecked)){echo $checkboxchecked; } ?>' data-key="<?php echo $key ?>" >&#10007;</button>
                       <?php } ?>
                      </td>
                  </tr>
                </table>
              </div>
            </div>
          </li>
         
          <?php } } }?> 
        </ul>
      </nav>
    </div>
  </section>
