
 <?php
  uasort($mesagedata, function($a, $b) {
    return strtotime($a['activity_date']) - strtotime($b['activity_date']);
  });
 
 ?>
  <section class="bottom-area message-cont">
    <div class="container">
       <h1>Calendar for <?php echo $classname; ?> 

        <?php if(!empty($connectedclass)){ ?>  
            <div style="float:right; font-size: 12px; color:gray">
              <input type="checkbox" id="calendarcheckbox_teacher" <?php if(isset($checkboxchecked)){ echo 'checked';  } ?> onclick="load_alldata_calendar('<?php echo $idofclass ?>')"></div> 
              <div style="float:right; font-size: 12px; color:gray;margin-top: 3px;">Show all teachers  
          </div> 
        <?php }else{ ?>
          <a href="<?php echo base_url(); ?>settings/Classes/settings/<?php echo $idofclass; ?>" target="_blank"> <div style="float:right; font-size: 12px; color:gray">Connect to another teacher</div> </a>
        <?php }?>
       </h1>

        <div class="message">
          <nav>
            <ul>
            <?php  if(isset($mesagedata)){ 
              
              foreach ($mesagedata as $key1 => $value) {
                //$value['teachers_name'] == get_user_name()
                  
              $date = date_create($value['activity_date']);
              $value['activity_date'] =  date_format($date,"Y-m-d");
              if($value['activity_date'] >= date('Y-m-d')){
                ?>
              <li>
                <table style="width: 100%; <?php if(isset($value[0])){?> color:gray; <?php } ?> " >
                  <tr>
                    <td><?php echo $value['activity_date']; ?></td>
                    <td>

                     <?php if(isset($value['recipient_identifier'])) {
                          if($value['recipient_identifier'] == '2' || $value['recipient_identifier'] == '3') {?>
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
                  </tr>
                  <tr>
                    <td></td>
                    <td><?php echo $value['description']; ?></td>
                    <td>
                        <?php if(!isset($value[0])){?>
                           <button style="color:none;border: none; padding: 0" 
                            class="delete delete-calendar" 
                            data-id="<?php echo $idofclass; ?>" 
                            data-check='<?php if(isset($checkboxchecked)){echo $checkboxchecked; } ?>'
                            data-key="<?php echo $key1 ?>" >&#10007;
                           </button>
                         <?php } ?>
                    </td>
                  </tr>
                </table>
              </li>
            <?php } } }?> 
            </ul>
          </nav>
        </div>
      </div>
  </section>


