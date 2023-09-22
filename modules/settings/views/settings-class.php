

<body class="manage-sub">
  <header class="header header-area section-header" id="hone">
    <div class="container">
      <div class="logo-area">
        <a href="https://edtools.io/apps/"><img src="appci/assets/images/logo_black_medium.png" alt=""></a>
      </div>
      <div class="close-button">
        <a href="<?php echo base_url('settings/Classes'); ?>"><img src="appci/assets/images/cancel.svg" class="img-svg"></a>
      </div>
    </div>
    <div class="heading-text">
      <h1>Settings for <span><?php echo $class[0]['class_name']; ?></span></h1>
    </div>
  </header>
  <section class="connection-section">
    <div class="container">
      <div class="heading-bar">
        <table>
          <tr>
            <td>
              <h3>Connect to another class</h3>
            </td>
            <td><a class="ques-mark" href="#"><img src="appci/assets/images/question.png" alt=""></a></td>
          </tr>
        </table>
      </div>
      <div class="icon-bar">
        <ul>
          <li><a href="#"><img src="appci/assets/images/icon-calendar.png" alt=""></a></li>
          <li><a href="#"><img src="appci/assets/images/icon_exam.png" alt=""></a></li>
          <li><a href="#"><img src="appci/assets/images/icon_homework.png" alt=""></a></li>
          <li><a href="#"><img src="appci/assets/images/icon_ill.png" alt=""></a></li>
          <li><a href="#"><img src="appci/assets/images/icon_messages.png" alt=""></a></li>
          <li><a href="#"><img src="appci/assets/images/icon_tasks.png" alt=""></a></li>
        </ul>
      </div>
      <div class="section-text">
        <p>Would you like to see the messages, homework, exams and calendar entries of another teacher sent to the same class? Then connect your class accounts.</p> 
        <p>Ask the other teacher for the class code of that class and enter it below. To also give the other teacher permission to see your entries, you can tell her your class code.</p>
      </div>
    </div>
  </section>
  <section class="input-section">
    <div class="container">
      <h3>1) Give this class-code to the other teacher: <span><?php echo $class[0]['classcode']; ?></span></h3>
      <h3>2) ... and enter the code you were given by the other teacher:</h3>
      <form method="POST" action="<?php echo base_url('settings/Classes/connect_class'); ?>">
        <table>
          <tr>
            <td><input class="in" type="text" name="code" placeholder="Enter code given by the other teacher"></td>
            <td><input type="submit" value="Connect"></td>
          </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo $class[0]['_id']; ?>">
      </form>
      <?php if(!empty($class[0]['connectedclass'])){ ?>
      <div class="connt-class">
        <h3>Connected Classes</h3>
        <table>
          <?php foreach ($class[0]['connectedclass'] as $k1 => $v1) {
              $class_info = class_info($v1);
              if(!empty($class_info)){
           ?>
            <tr>
            <td><?=$class_info['class_name']?></td>
            <td><?=$class_info['teacher_name']?></td>
            <td><a class="delete delete-connected-class" data-id = "<?php echo $class_info['_id']; ?>" data-index = "<?=$k1?>">&#10007;</a></td>
          </tr>
          <?php }
        } ?>
          
        </table>
      </div>
    <?php } ?>
    </div>
  </section>
  <section class="connection-section con-bottom">
    <div class="container">
      <div class="heading-bar">
        <table>
          <tr>
            <td>
              <h3>Shortcuts"Overdue Work"</h3>
            </td>
            <td><a class="ques-mark" href="#"><img src="appci/assets/images/question.png" alt=""></a></td>
          </tr>
        </table>
      </div>
      <div class="icon-bar">
        <ul>
          <li><a href="#"><img src="appci/assets/images/icon-calendar.png" alt=""></a></li>
        </ul>
      </div>
      <div class="section-text">
        <p>In order to be able to enter overdue work more quickly, frequently used formulations can be entered here. They are then available in the app „Overdue work“. Optionally enter the subject, followed by a colon and the open work.</p>
      </div>
    </div>
  </section>
  <section class="input-section">
    <div class="container">
      <form id="class-shortcut"  action="javascript:;">
        <table>
          <tr>
            <td><input class="in" name="shortcut" type="text" placeholder="Subject: Work"></td>
            <td><input type="submit" value="Add"></td>
          </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo $class[0]['_id']; ?>">
        <input type="hidden" name="classcode" value="<?php echo $class[0]['classcode']; ?>">
      </form>

      <?php if(!empty($class[0]['shortcuts'])){ ?>
      <div class="connt-class">
        <h3>Your Shortcuts</h3>
        <table>
          <?php foreach ($class[0]['shortcuts'] as $k => $v) { ?>
            <tr>
              <td><?=$v?></td>
              <td><a class="delete" onclick="delete_shortcut('<?=$class[0]['_id']?>','<?=$v?>',<?=$k?>);">&#10007;</a></td>
            </tr>
          <?php } ?>
          
        </table>
      </div>
      <?php } ?>
    </div>
  </section>



  <section class="input-section" style="margin-top: 70px;">
    <div class="container close-btn-div">
     <div class="button">
      <a href="<?php echo base_url('settings/Classes/'); ?>" type="button" class="close-btn">Close</a>
    </div>
  </div>
</section>


