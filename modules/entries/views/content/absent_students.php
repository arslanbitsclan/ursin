
    <div class="container">
      <h2>Who is absent on <?php echo $datetoday; ?> ?</h2>
      <table class="att-table">
                     
          <?php foreach ($students as $key => $value) : 
              $studentdata = student_info($value);
              $mainval = ($key % 3);
              if($mainval == 0){
                echo '<tr>';
                echo '</tr>';
              }
              $classnameofselected = 'bg-green-fill';
              $absentvalues = '';
              $endkeyofabsent = 0;
              $flagicon = '';

              if(isset($studentdata['absent']) && !empty($studentdata['absent']) ){
                    foreach ($studentdata['absent'] as $key => $value) {
                         if($value['date'] == date('yy-m-d')){
                              $endkeyofabsent = array_keys($studentdata['absent']);
                              $absentvalues = $studentdata['absent'][end($endkeyofabsent)];
                             
                                  if($absentvalues['flag'] == 1){
                                    $classnameofselected = 'bg-red-fill';
                                    $flagicon = 1;
                                  }elseif($absentvalues['flag'] == 2){
                                    $classnameofselected = 'bg-red-empty';
                                    $flagicon = 2;
                                  }elseif($absentvalues['flag'] == 3){
                                    $classnameofselected = 'bg-green-fill';
                                    $flagicon = '';
                                  }
                              $endkeyofabsent = end($endkeyofabsent);
                          }
                    }
              }else{
                      $endkeyofabsent = 0;
              }
            ?>
              <td class="">
                <ul class="flip-box  <?php echo $classnameofselected; ?>" data-studentid='<?php echo $studentdata['_id']; ?>' data-studentkey='<?php echo $endkeyofabsent; ?>'>
                  <li><span><?php if(@$flagicon == 1 || @$flagicon == 2){?><i class="fas fa-times"></i><?php }else{ ?> <i class="fas fa-check"></i> <?php } ?></span>
                  </li>
                  <li><span ><?php echo $studentdata['student_name']; ?></span></li>
                </ul>
              </td>
          <?php endforeach; ?>
         
      </table>
    </div>

  <script>
    $(document).ready(function() {

        
      $(".flip-box").click(function() {
        
        if ($(this).hasClass("bg-green-fill") ) {
            
              $(this).addClass("bg-red-fill");
              $(this).removeClass("bg-red-empty");
              $(this).removeClass("bg-green-fill");
              $(this).children('li').children('span').children('i').removeClass("fa-check");
              $(this).children('li').children('span').children('i').addClass("fa-times"); 
              abset_mark($(this).attr("data-studentid"), 1, $(this).attr("data-studentkey"));
          
        } else if ($(this).hasClass( "bg-red-fill" )) {
          $(this).addClass("bg-red-empty");
          $(this).removeClass("bg-red-fill");
          $(this).removeClass("bg-green-fill");
          abset_mark($(this).attr("data-studentid"), 2, $(this).attr("data-studentkey"));
          
        } else if ($(this).hasClass( "bg-red-empty" )){
          
          $(this).addClass("bg-green-fill");
          $(this).removeClass("bg-red-empty");
          $(this).removeClass("bg-red-fill");
          $(this).children('li').children('span').children('i').addClass("fa-check");
          $(this).children('li').children('span').children('i').removeClass("fa-times");
          abset_mark($(this).attr("data-studentid"), 3, $(this).attr("data-studentkey"));
       
        }

      });
    });

  </script>