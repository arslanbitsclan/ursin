
<body class="manage-sub">
  <header class="header header-area section-header" id="hone">
    <div class="container">
      <div class="logo-area">
        <a href="https://edtools.io/apps/"><img src="appci/assets/images/logo_black_medium.png" alt=""></a>
      </div>
      <div class="close-button">

        <a href="<?php echo base_url('settings/Student/'); ?>"><img src="appci/assets/images/cancel.svg" class="img-svg"></a>
      </div>
    </div>
    <div class="heading-text">
      <h1>Settings for <span><?php echo $student[0]['student_name']; ?></span></h1>
    </div>
  </header>
  <section class="connection-section">
    <div class="container">
      <div class="heading-bar">
        <table>
          <tr>
            <td>
              <h3><?php echo $student[0]['student_name']; ?>'s e-mail</h3>
            </td>
            <td><a class="ques-mark" href="#"><img src="appci/assets/images/question.png" alt=""></a></td>
          </tr>
        </table>
      </div>
      <div class="icon-bar">
        <ul>
          <li><a href="#"><img src="appci/assets/images/icon_ill.png" alt=""></a></li>
        </ul>
      </div>
      <div class="section-text">
        <p>So that parents can report a child sick via the app, an e-mail address of the parents must be registered. In order to prevent abuse, they receive a confirmation after each sick report.</p>
      </div>
    </div>
  </section>
  <?php 
   $familyEmail = "";
      $motherEmail = "";
      $fatherEmail = "";
  if(!empty($student[0]['parents_email'])){
     
      if($student[0]['parents_email'][0]['family']){
        $familyEmail = $student[0]['parents_email'][0]['family'];
      }
      if($student[0]['parents_email'][0]['mother']){
        $motherEmail = $student[0]['parents_email'][0]['mother'];
      }
      if($student[0]['parents_email'][0]['father']){
        $fatherEmail = $student[0]['parents_email'][0]['father'];
      }
  } ?>
  <section class="input-section">
    <div class="container">
      <form action="<?php echo base_url('settings/Student/family_emails'); ?>" method = "POST">
        <table>
        <tr>
          <td><input class="in" type="email" name="family" placeholder="Family email address" value="<?=$familyEmail?>"><i class="fas fa-gender"></i></td>
        </tr>
        <tr>
          <td><input class="in" type="email" name="mother" placeholder="Mother's email address" value="<?=$motherEmail?>"><i class="fas fa-venus"></i></td>
        </tr>
        <tr>
          <td><input class="in" type="email" name="father" placeholder="Father's email address" value="<?=$fatherEmail?>"><i class="fas fa-mars"></i></td>
        </tr>
        <input type="hidden" name="student_id" value="<?php echo $student[0]['_id']; ?>">
      </table>
      <div class="section-text">
        <p><b>Attention:</b> After every change here an automatic e-mail will be sent to the parents. They will be informed that this address has been added to the child‘s account. Email preview</p>
      </div>
      <input type="submit" value="Send">
      </form>
      

    </div>
  </section>
    <section class="connection-section">
    <div class="container">
      <div class="heading-bar">
        <table>
          <tr>
            <td>
              <h3>Change Student Password</h3>
            </td>
            <td><a class="ques-mark" href="#"><img src="appci/assets/images/question.png" alt=""></a></td>
          </tr>
        </table>
      </div>
      <div class="icon-bar">
        <ul>
          <li><a href="#"><img src="appci/assets/images/icon_settings.png" alt=""></a></li>
        </ul>
      </div>
      <div class="section-text">
        <p>Here you can generate a new password for a student. It is not possible to return to the old password.</p>
      </div>
    </div>
  </section>
  <section class="input-section">
    <div class="container">
      <h3>Current password: <span><?php echo $student[0]['code']; ?></span></h3>
      <table>
        <tr>
          <td><input type="submit" class="change-code" data-id="<?php echo $student[0]['_id']; ?>" data-student = "<?php echo $student[0]['student_name']; ?>" value="New"></td>
        </tr>
      </table>
    </div>
  </section>
    
    
     <section class="connection-section">
    <div class="container">
      <div class="heading-bar">
        <table>
          <tr>
            <td>
              <h3>Change the parent code</h3>
            </td>
            <td><a class="ques-mark" href="#"><img src="appci/assets/images/question.png" alt=""></a></td>
          </tr>
        </table>
      </div>
      <div class="icon-bar">
        <ul>
          <li><a href="#"><img src="appci/assets/images/icon_settings.png" alt=""></a></li>
        </ul>
      </div>
      <div class="section-text">
        <p>Here you can generate a new parent code for security reasons. The parents will receive an email with the new code. It is not possible to return to the old password. Email preview</p>
      </div>
    </div>
  </section>
  <section class="input-section">
    <div class="container">
      <h3>Current parent code: <span id="view_parent_code">******</span></h3>
      <table>
        <tr>
          <td><input type="submit" class="change-parent-code" data-id="<?php echo $student[0]['_id']; ?>" data-student = "<?php echo $student[0]['student_name']; ?>" value="New"></td>
        </tr>
      </table>
    </div>
  </section>


  <section class="input-section"  style="margin-top: 70px;">
    <div class="container close-btn-div">
       <div class="button">
                <a href="<?php echo base_url('settings/Student/'); ?>" type="button" class="close-btn">Close</a>
              </div>
    </div>
  </section>

<script type="text/javascript">
  $(document).ready(function() {
    $("#view_parent_code").on("click",function() {
      var secret = "******";
      var parent_code = "<?php echo $student[0]['parents-code'] ?>";
      $(this).text($(this).text() == secret? parent_code : secret);
    })
  })
</script>