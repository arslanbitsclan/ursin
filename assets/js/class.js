

$("#class-shortcut").on('submit',function(e){
  e.preventDefault();
  $.ajax({
    method:'post',
    url:base_url+'settings/Classes/shortcut',
    data:new FormData(this),
    dataType:'json',
    contentType: false,       // The content type used when sending data to the server.
    cache: false,             // To unable request pages to be cached
    processData:false,
    success:function(res){
      if(res.status){
        toastr.success(res.msg);
        window.setTimeout(function(){window.location.reload()}, 3000);
      }else{
        if(res.limit == 5){
          pop_up_message(res.msg,res.url);
        }else{
          pop_up_message2(res.msg);
        }
        
      }
      $('#class-shortcut').trigger("reset");
    }
  });
});


$(document).on('click', '.delete-class', function(e){
  var id = $(this).attr('data-id');
  $.confirm({
    title: 'Delete Class',
    content: 'Do you really want to delete this class permanently and remove all students in it?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'settings/Classes/delete',
          data:{id:id},
          dataType:'json',
          success: function(data)
          {
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



function pop_up_message(msg,redirect_url) {
  $.confirm({
    title: "Alert",
    content: msg,
    animation: 'scale',
    closeAnimation: 'scale',
    opacity: 0.5,
    buttons: {
      'confirm': {
        text: 'Upgrade',
        btnClass: 'btn-blue',
        action: function(){
          window.location = redirect_url;
        }
      },
      Ok: function(){},

    }
  });
}


function pop_up_message2(msg) {
  $.confirm({
    title: "Alert",
    content: msg,
    animation: 'scale',
    closeAnimation: 'scale',
    opacity: 0.5,
    buttons: {
      Ok: function(){},

    }
  });
}


      



function update(id) {
	var name = $("#class_name"+id).val();
	$.ajax({
		type: "POST",
		url: base_url+'settings/Classes/update',
		data:{id:id,name:name},
		dataType:'json',
		success: function(res)
		{
			if(res.status){
				location.reload();
			}
		}
	});
}


$(document).on('click', '.delete-connected-class', function(e){
  var id = $(this).attr('data-id');
  var index = $(this).attr('data-index');
  $.confirm({
    title: 'Delete Connected Class',
    content: 'Do you really want to remove the partner class?',
    icon: 'fa fa-trash',
    theme: 'supervan',
    closeIcon: true,
    animation: 'scale',
    type: 'orange',
    buttons: {
      Delete: function () {
        $.ajax({
          type: "POST",
          url: base_url+'settings/Classes/delete_connected_class',
          data:{id:id,index:index},
          dataType:'json',
          success: function(data)
          {
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


function delete_shortcut(id,shortcut,index) {

  $.ajax({
    type: "POST",
    url: base_url+'settings/Classes/delete_shortcuts',
    data:{id:id,shortcut:shortcut,index:index},
    dataType:'json',
    success: function(data)
    {
      if(data.status){
        location.reload();
      }
    }
  });
}