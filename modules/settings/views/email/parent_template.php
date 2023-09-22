<!DOCTYPE html>
<html>
<head>
</head>
<body>
Dear Parents
<br>
<br>
The teacher has assigned a new parent email address to the account of your child <?php echo $student[0]['student_name']; ?>.
<br>
<br>
Now the following email addresses are registered.
<br>
<?php 
 $familyEmail = "";
      $motherEmail = "";
      $fatherEmail = "";
      if(!empty($student[0]['parents_email'])){
      	foreach ($student[0]['parents_email'] as $key => $email) {

      		if($student[0]['parents_email'][0]['family']){
      			$familyEmail = $student[0]['parents_email'][0]['family']."<br>";
      		}
      		if($student[0]['parents_email'][0]['mother']){
      			$motherEmail = $student[0]['parents_email'][0]['mother']."<br>";
      		}
      		if($student[0]['parents_email'][0]['father']){
      			$fatherEmail = $student[0]['parents_email'][0]['father']."<br>";
      		}

      		echo $familyEmail."".$motherEmail."".$fatherEmail."";
      	}
      }


 ?>
 
<br> 

<b>Parent code:</b> <?php echo $student[0]['parents-code']; ?>
<br>
<b>Parents area:</b> parents.edtools.io
<br>
<br>

With the email address and the secret parent code you can log in to the pa- rent area: parents.edtools.io
<br>
Here you will find important information about everyday school life and can initiate approved actions.
<br>
<br>

Keep the parent code secret. For security reasons, every activity from the parent area is confirmed by an e-mail to this address. Thank you for under- standing. If you do not want this, ask the teacher to remove this email. In this case, you will no longer have access to the parent area.
<br>
<br>

Further information can be found in the help area parents.edtools.info or from the teacher.
<br>
<br>

EdTools makes everyday school life easier for teachers, students and parents and brings them closer together.
<br>
<br>

Many greetings
<br>
Your EdTools.io Team
<br>
</body>
</html>
