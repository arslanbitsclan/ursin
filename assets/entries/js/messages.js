

$(document).on('click', '.delete-message', function(e){
  var id = $(this).attr('data-id');
  var key = $(this).attr('data-key');
  var check = $(this).attr('data-check');
  $.confirm({
    title: 'Delete Message',
    content: 'Do you really want to delete this message permanently?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'entries/Messages/delete',
          data:{id:id,key:key,check:check},
          dataType:'json',
          success: function(res)
          {   toastr.success("Successfully Deleted");  
              $('#messagebox').html(res.data);     
          }
        });
      },
      Cancel: function () {}
    }
  });
});


$(document).on('click', '.delete-exam', function(e){
  var id = $(this).attr('data-id');
  var key = $(this).attr('data-key');
  var check = $(this).attr('data-check');
  $.confirm({
    title: 'Delete Exam',
    content: 'Do you want to delete this exam definitely?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'entries/Exams/delete',
          data:{id:id,key:key,check:check},
          dataType:'json',
          success: function(res)
          {
            $('#exambox').html(res.data);
          }
        });
      },
      Cancel: function () {}
    }
  });
});


$(document).on('click', '.delete-calendar', function(e){
  var id = $(this).attr('data-id');
  var key = $(this).attr('data-key');
   var check = $(this).attr('data-check');
  $.confirm({
    title: 'Delete Calendar',
    content: 'Do you want to delete this event definitely?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'entries/Calendar/delete',
          data:{id:id,key:key,check:check},
          dataType:'json',
          success: function(res)
          {
             $('#calendarbox').html(res.data);
          }
        });
      },
      Cancel: function () {}
    }
  });
});

$(document).on('click', '.delete-homework', function(e){
  var id = $(this).attr('data-id');
  var key = $(this).attr('data-key');
   var check = $(this).attr('data-check');
  $.confirm({
    title: 'Delete Homework',
    content: 'Do you want to delete this homework definitely?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'entries/Homework/delete',
          data:{id:id,key:key,check:check},
          dataType:'json',
          success: function(res)
          {
            $('#homeworkbox').html(res.data);
          }
        });
      },
      Cancel: function () {}
    }
  });
});


$(document).on('click', '.delete-links', function(e){

  var id = $(this).attr('data-id');
  var key = $(this).attr('data-key');
  var check = $(this).attr('data-check');
  $.confirm({
    title: 'Delete Links',
    content: 'Do you want to delete this weblink definitely?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'entries/Link/delete',
          data:{id:id,key:key,check:check},
          dataType:'json',
          success: function(res)
          {
            $('#linkbox').html(res.data);
          }
        });
      },
      Cancel: function () {}
    }
  });
});

function load_alldata_teacher(value){
                  
      if($("#checkboxconnectcls").prop("checked")  == true){
             var clsid = value;
                   $.ajax({
                    method:'post',
                    url: base_url+'entries/Messages/get_all_teacher_data',
                    data:{class_id:clsid},
                    dataType:'json',
                    success:function(res){
                      if(res.status){
                        
                        $('#messagebox').html(res.data);
                      }else{
                         
                      }
                     
                    }
            });
        }
        else if($("#checkboxconnectcls").prop("checked") == false){
          var clsid = value;
                   $.ajax({
                    method:'post',
                    url: base_url+'entries/Messages/get_messages_data',
                    data:{class_id:clsid},
                    dataType:'json',
                    success:function(res){
                      if(res.status){
                        
                        $('#messagebox').html(res.data);
                      }else{
                         
                      }
                     
                    }
            });
        }
}


function load_alldata_exams(value){
  if($("#examncheckbox_teachers").prop("checked")  == true){
       var clsid = value;
       $.ajax({
        method:'post',
        url: base_url+'entries/Exams/get_all_exams_data',
        data:{class_id:clsid},
        dataType:'json',
        success:function(res){
          if(res.status){
            $('#exambox').html(res.data);
          }else{
             
          }
         
        }
      });
  }else if($("#examncheckbox_teachers").prop("checked")  == false){
       var clsid = value;
       $.ajax({
        method:'post',
        url: base_url+'entries/Exams/get_exams_data',
        data:{class_id:clsid},
        dataType:'json',
        success:function(res){
          if(res.status){
            $('#exambox').html(res.data);
          }else{
             
          }
         
        }
      });
  }

}


function load_alldata_calendar(value){
if($("#calendarcheckbox_teacher").prop("checked")  == true){
       var clsid = value;
       $.ajax({
        method:'post',
        url: base_url+'entries/Calendar/get_all_calendar_data',
        data:{class_id:clsid},
        dataType:'json',
        success:function(res){
          if(res.status){
            
            $('#calendarbox').html(res.data);
          }else{
             
          }
         
        }
      });
  }else if($("#calendarcheckbox_teacher").prop("checked")  == false){
      var clsid = value;
       $.ajax({
        method:'post',
        url: base_url+'entries/Calendar/get_calendar_data',
        data:{class_id:clsid},
        dataType:'json',
        success:function(res){
          if(res.status){
            
            $('#calendarbox').html(res.data);
          }else{
             
          }
         
        }
      });
  }

}

function load_alldata_homework(value){
  if($("#homeworkcheckbox_teacher").prop("checked")  == true){
       var clsid = value;
       $.ajax({
        method:'post',
        url: base_url+'entries/Homework/get_all_homework_data',
        data:{class_id:clsid},
        dataType:'json',
        success:function(res){
          if(res.status){
            
            $('#homeworkbox').html(res.data);
          }else{
             
          }
         
        }
      });
  }else if($("#homeworkcheckbox_teacher").prop("checked")  == false){
      var clsid = value;
       $.ajax({
        method:'post',
        url: base_url+'entries/Homework/get_homework_data',
        data:{class_id:clsid},
        dataType:'json',
        success:function(res){
          if(res.status){
            
            $('#homeworkbox').html(res.data);
          }else{
             
          }
         
        }
      });
  }

}


function load_homework_data(){
       var clsid = document.getElementById("class_id_showhw").value;
       var filterval = $('input[name="filterdaterange"]:checked').val();

     if(!$( "#btn_change_color" ).hasClass( "colorgrn" )){
       $.ajax({
        method:'post',
        url: base_url+'entries/Showhomework/show_homework_data',
        data:{class_id:clsid,filterval:filterval},
        dataType:'json',
        success:function(res){
          if(res.status){
            var newUrl = base_url+"entries/Homework?classid="+clsid;
            $("#enterhomework"). attr("href", newUrl);
            $('#show_homeworkbox').html(res.data);
          }else{
             
          }
         
        }
      });
      }else{
        load_connected_teacher();
      }
}

function load_connected_teacher(){
       var clsid = document.getElementById("class_id_showhw").value;
       var filterval = $('input[name="filterdaterange"]:checked').val();
     
       if(!$( "#btn_change_color" ).hasClass( "colorgrn" )){
              $('#btn_change_color').addClass("colorgrn");
               $('#btn_change_color').removeClass("colorwhite");
              $('#iconid').css("color", "white");
               $.ajax({
                method:'post',
                url: base_url+'entries/Showhomework/get_all_homework_data',
                data:{class_id:clsid,filterval:filterval},
                dataType:'json',
                success:function(res){
                  if(res.status){
                    $('#show_homeworkbox').html(res.data);
                    $('#texttooltip').html('Hide');
                  }
                 
                }
              });
         }else{
          $('#btn_change_color').addClass("colorwhite");
          $('#btn_change_color').removeClass("colorgrn");
          $('#iconid').css("color", "green");
          $('#texttooltip').html('Show');
          load_homework_data();
         }

}

function load_alldata_links(value){

  if($("#linkcheckbox_teacher").prop("checked")  == true){
       var clsid = value;
       $.ajax({
        method:'post',
        url: base_url+'entries/Link/get_all_link_data',
        data:{class_id:clsid},
        dataType:'json',
        success:function(res){
          if(res.status){
            
            $('#linkbox').html(res.data);
          }else{
             
          }
         
        }
      });
  }else if($("#linkcheckbox_teacher").prop("checked")  == false){
          var clsid = value;
             $.ajax({
              method:'post',
              url: base_url+'entries/Link/get_link_data',
              data:{class_id:clsid},
              dataType:'json',
              success:function(res){
                if(res.status){
                  
                  $('#linkbox').html(res.data);
                }else{
                   
                }
               
              }
          });
  }

}




function checkvalidation_exam(){
  var clsid = document.getElementById("class_id_exm").value;
  if(clsid == ""){
    toastr.error("Please select a class");
    return false;  
  }
  
}

function checkvalidation_message(){
  var clsid = document.getElementById("clasid").value;
  if(clsid == ""){
    toastr.error("Please select a class");
    return false;  
  }
  
}

function checkvalidation_calendar(){
  var clsid = document.getElementById("class_id_calendar").value;
  if(clsid == ""){
    toastr.error("Please select a class");
    return false;  
  }
  
}

function checkvalidation_homework(){
  var clsid = document.getElementById("clasid_homework").value;
  if(clsid == ""){
    toastr.error("Please select a class");
    return false;  
  }
  
}

function checkvalidation_links(){
  var clsid = document.getElementById("clasid_link").value;
  var urlid = document.getElementById("urlid").value;

  if(clsid == ""){
    toastr.error("Please select a class");
    return false;  
  }

   var url = urlid.substring(0, 3);
   if(url == 'www'){
    return true;
   }

   if (!urlid.match(/^https?:/)) {
    toastr.error("Please start URLs with https://, http:// or www.");
    return false;  
   }


  
}

function changecolor(colorcode){
  $('#colorset').val(colorcode);

  $('#setboxcolor').css('background',colorcode);
  
}



// function showmailcheckbox(value){
//   alert(value);
//   if(value == 2){
//     $("#idofmailcheckbox").slideDown();
//   }else{
//     $("#idofmailcheckbox").slideUp();
//   }

// }

function showmailcheckbox(thisvalue){
       if($(thisvalue).prop("checked")  == true){
            $("#idofmailcheckbox").slideDown();
        }
        else if($(thisvalue).prop("checked") == false){
            $("#idofmailcheckbox").slideUp();
        }

}

function show_otherchekbox(thisvalue){
    if($(thisvalue).prop("checked")  == true){
            $("#idofmailcheckbox").slideDown();
        }
        else if($(thisvalue).prop("checked") == false){
            $("#idofmailcheckbox").slideUp();
        }

}

/////////////////////////////  Absent //////////////////////
  
  function callabsnet_stuendts(){
       var clsid = document.getElementById("class_id_absent").value;
       
         $.ajax({
          method:'post',
          url: base_url+'entries/Absent/show_students',
          data:{class_id:clsid},
          dataType:'json',
          success:function(res){
            if(res.status){
              
              $('#show_students').html(res.data);
            }else{
               
            }
           
          }
        });
        
  }

  function abset_mark(student_id, flag,indexofabsent){

        $.ajax({
          method:'post',
          url: base_url+'entries/Absent/mark_absent',
          data:{student_id:student_id,flag:flag,indexofabsent:indexofabsent},
          dataType:'json',
          success:function(res){
            if(res.status){
              
             toastr.success("Successfully updated");  
            }else{
               
            }
           
          }
        });
  }



  function all_present_mark(student_id){
        var clsid = document.getElementById("class_id_absent").value;
        if(clsid != ''){
          $.ajax({
            method:'post',
            url: base_url+'entries/Absent/get_all_student_present',
            data:{class_id:clsid},
            dataType:'json',
            success:function(res){
              if(res.status){
                
                $('#show_students').html(res.data);
              }else{
                 
              }
             
            }
          });
        }else{
           toastr.error("Please select a class");
        }
  }





///////////