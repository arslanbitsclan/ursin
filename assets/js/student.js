// Transfer Student

$("#transfer-student").on('submit',function(e){
  e.preventDefault();
  $.ajax({
    method:'post',
    url:base_url+'settings/Student/transfer',
    data:new FormData(this),
    dataType:'json',
    contentType: false,       // The content type used when sending data to the server.
    cache: false,             // To unable request pages to be cached
    processData:false,
    success:function(res){
      if(res.status){
        $("#success-msg").html(res.msg);
        $("#success-msg").slideDown();
        window.setTimeout(function(){window.location.reload()}, 3000);
      }else{
        $("#error-msg").html(res.msg);
        $("#error-msg").slideDown();
      }
      $('#transfer-student').trigger("reset");
    }
  });
});



$(document).on('click', '.info', function(e){
  var title = $(this).attr('data-title');
  $.alert({
    title: 'Student Info',
    content: title,
    animation: 'scale',
    closeAnimation: 'scale',
    buttons: {
      okay: {
        text: 'Okay',
        btnClass: 'btn-blue'
      }
    }
  });
});
// Delete Student

$(document).on('click', '.delete-student', function(e){
  var id = $(this).attr('data-id');
  var classid = $(this).attr('data-classid');
  $.confirm({
    title: 'Delete Student',
    content: 'Do you really want to delete this student and all his data?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'settings/Student/delete',
          data:{id:id,classid:classid},
          dataType:'json',
          success: function(res){
            if(res.status){
              location.reload();
            }
          }
        });
      },
      Cancel: function () {}
    }
  });
});

// Generate Code Of Student

$(document).on('click', '.change-code', function(e){
  var id = $(this).attr('data-id');
  var student = $(this).attr('data-student');
  $.confirm({
    title: 'Create New Code',
    content: 'Do you really want to delete the current student code and generate a new one?',
    icon: 'fa fa-cog',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Ok: function () {
        $.ajax({
          type: "POST",
          url: base_url+'settings/Student/Change_code',
          data:{id:id,student:student},
          dataType:'json',
          success: function(data){
            if(data.status){
              location.reload();
            }
          }
        });
      },
      Cancel: function () {}
    }
  });
});

//Change Code Of Parent

$(document).on('click', '.change-parent-code', function(e){
  var id = $(this).attr('data-id');
  var student = $(this).attr('data-student');
  $.confirm({
    title: 'Create New Code',
    content: 'Do you really want to delete the current parent code and generate a new one?',
    icon: 'fa fa-cog',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Ok: function () {
        $.ajax({
          type: "POST",
          url: base_url+'settings/Student/Change_parent_code',
          data:{id:id,student:student},
          dataType:'json',
          success: function(data){
            if(data.status){
              location.reload();
            }
          }
        });
      },
      Cancel: function () {}
    }
  });
});

//Homework Second Bar Controll

$(document).on('click', '#homework', function(e){
  if($(this).prop("checked") == true){
    $(".dash-second").slideUp();
  } else if ($(this).prop("checked") == false){
    $(".dash-second").slideDown();
  }
});

// Option Change Student Setting

$(document).on('click', "input[name='option']", function(e){
  var class_id = $("[name='standart_class']").val();
  var index = $(this).attr('data-index');
  var value;
  if($(this).prop("checked") == true){
    value = 1;
  } else if ($(this).prop("checked") == false){
    value = 0;
  }
  
  $.ajax({
    type: "POST",
    url: base_url+'settings/Student/options',
    data:{class_id:class_id,index:index,value:value},
    dataType:'json',
    success: function(data){}
  });
});

// Second Homework option student setting

$(document).on('click', "#homework-second", function(e){
  var class_id = $("[name='standart_class']").val();
  var index = $(this).attr('data-index');
  var value;
  if($(this).prop("checked") == true){
    value = 2;
  }else if ($(this).prop("checked") == false){
    value = 0;
  }

  $.ajax({
    type: "POST",
    url: base_url+'settings/Student/options',
    data:{class_id:class_id,index:index,value:value},
    dataType:'json',
    success: function(data){}
  });
});

//Show Classes Options 
$(document).on('change', "[name='standart_class']", function(e){
  var class_id = $("[name='standart_class']").val();
  $.ajax({
    type: "POST",
    url: base_url+'settings/Classes/options',
    data:{class_id:class_id},
    success: function(res){
      $("#option-panel").html(res);
    }
  });
});




