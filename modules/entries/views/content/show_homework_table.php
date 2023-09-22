<pre>
<?php 

$futuretemp = array();
$counttemp = 0;
if($filterdayval == 'today'){
   $checkfilter = date('m/d/Y');
   foreach ($mesagedata as $key => $value) {
            if($checkfilter == $value['due_date']){
              $futuretemp[$counttemp] = $value;
              $counttemp++;
            }
       }
   $mesagedata = $futuretemp;
}else if($filterdayval == 'tomorrow'){
   $checkfilter = date('m/d/Y',strtotime(' +1 day'));
   foreach ($mesagedata as $key => $value) {
            if($checkfilter == $value['due_date']){
              $futuretemp[$counttemp] = $value;
              $counttemp++;
            }
       }
   $mesagedata = $futuretemp;

}else if($filterdayval == 'future'){
  $checkfilter = date('m/d/Y');
       foreach ($mesagedata as $key => $value) {
            if($value['due_date'] > $checkfilter){
              $futuretemp[$counttemp] = $value;
              $counttemp++;
            }
       }
       $mesagedata = $futuretemp;
}
sort($mesagedata); 
uasort($mesagedata, function($a, $b) {
    return strtotime($a['due_date']) - strtotime($b['due_date']);
 });


//print_r($mesagedata);
?>
</pre>
<div class="container">
      <table class="std-table">
              <?php
                 $datearrt =  array();
                 $dateforday =  array();
                 $count = 0;
                 $subjectary = array();
             foreach ($mesagedata as $key => $value) {
                  if(!in_array($value['due_date'], $dateforday)){
                    $subjectary = array();
                  }
                                    $orgDate = $value['due_date'];  
                                    $day = date("d", strtotime($orgDate)); 
                                    $month = date("F", strtotime($orgDate)); 
                              ?>
                              <?php if(in_array($month, $datearrt)){ ?>
                                  <tr <?php if(!in_array($value['due_date'], $dateforday)){ echo 'class="border-top"'; }?>>
                                    <td></td>
                                    <td><span class="bigfnt"><?php if(!in_array($value['due_date'], $dateforday)){ echo $day; }?></span></td>
                                    <?php if(in_array($value['subject'], $subjectary)){ ?>
                                         <td></td>
                                    <?php }else{ ?>
                                      <td><?php echo $value['subject']; ?></td>
                                    <?php } ?>
                                    <td><?php echo $value['description']; ?></td>
                                  </tr>
                              <?php }else{ ?>
                                  <tr class="border-top">
                                    <td><span class="bigfnt"><?php echo $month; ?></span></td>
                                    <td><span class="bigfnt"><?php echo $day; ?></span></td>
                                    <?php if(in_array($value['subject'], $subjectary)){ ?>
                                        <td></td>
                                    <?php } else{ ?>
                                        <td><?php echo $value['subject']; ?></td>
                                    <?php }?>
                                    <td><?php echo $value['description']; ?></td>
                                  </tr>
                              <?php }?>

                              <?php 
                                       $datearrt[$count] = $month; 
                                       $dateforday[$count] = $value['due_date'];
                                       $count++;
                                       $subjectary[$key] = $value['subject'];
                    }//endloop
                    ?>
      </table>
    </div>
            

