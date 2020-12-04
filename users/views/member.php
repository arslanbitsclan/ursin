<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="modal-title" id="myModalLabel">
                        <span class="edit-title"><?php echo _l('New Person'); ?></span>
                        </h4>



                        </h4>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                      
 
                        <div id="person_modu2le">
                        <?php
                        if(isset($data))
                        echo form_open_multipart('users/Users/Persons/'.$data->id,array('id'=>'person_module','class'=>'dropzone dropzone-manual'));
                        else 
                        echo form_open_multipart('users/Users/Persons',array('id'=>'person_module','class'=>'dropzone dropzone-manual')); ?>


                            <div class="row">
                            <div class="col-md-12">
                               <?php
                                $value = '';
                                if(isset($data)){
                                    $value = $data->location;
                                }
                                ?>
                                <?php echo render_input('location','Location',$value); ?>
                            </div>
                        </div>
                          <div class="row">
                                <div class="col-md-12">
                                    <?php echo render_input('latitude','',"",'hidden'); ?>
                                    <?php echo render_input('longitude','',"",'hidden'); ?>

                                </div>
                            </div>

                        <div class="row">
                            <div class="col-md-12">

                                <?php
                                $value = '';
                                if(isset($data)){
                                    $value = $data->id;
                                }
                                ?>

                                <?php echo form_hidden('id',$value); ?>
                                 <?php
                                $value = '';
                                if(isset($data)){
                                    $value = $data->email;
                                }

                                ?>
                                <?php echo render_input('email','Email',$value); ?>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                               <?php
                                $value = '';
                                if(isset($data)){
                                    $value = $data->firstname;
                                }
                                ?>
                                <?php echo render_input('firstname','First Name',$value); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                               <?php
                                $value = '';
                                if(isset($data)){
                                    $value = $data->lastname;
                                }
                                ?>
                                <?php echo render_input('lastname','Last Name',$value); ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                               <?php
                                $value = '';
                                if(isset($data)){
                                    $value = $data->facebook;
                                }
                                ?>
                                <?php echo render_input('facebook','Face book',$value); ?>
                            </div>
                         </div>
                            <div class="row">
                            <div class="col-md-12">
                               <?php
                                $value = '';
                                if(isset($data)){
                                    $value = $data->phonenumber;
                                }
                                ?>
                                <?php echo render_input('phonenumber','Phone Number',$value); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <?php
                                $value = '';
                                if(isset($data)){
                                    $value = $data->password;
                                }
                                ?>
                                <?php echo render_input('password','Password',$value); ?>
                            </div>
                        </div>
                            <?php if(isset($data) && $data->attachment !== ''){ ?>
                                <div class="row">
                                    <div class="col-md-10">
                                        <i class="<?php echo get_mime_class($data->filetype); ?>"></i> <a href="<?php echo site_url('download/file/expense/'.$data->id); ?>"><?php echo $data->attachment; ?></a>
                                    </div>
                                    <?php if($data->attachment_added_from == get_staff_user_id() || is_admin()){ ?>
                                        <div class="col-md-2 text-right">
                                            <a href="<?php echo admin_url('Users/delete_person_attachment/'.$data->id); ?>" class="text-danger _delete"><i class="fa fa fa-times"></i></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if(!isset($data) || (isset($data) && $data->attachment == '')){ ?>
                            <div id="dropzoneDragArea" class="dz-default dz-message">
                                <span><?php echo _l('Upload Files'); ?></span>
                            </div>
                            <div class="dropzone-previews"></div>
                            <?php } ?>
                            <hr class="hr-panel-heading" />



                        <?php if(isset($data)){?>
                            <div class="">
                                <button type="submit" class="btn btn-info pull-right"><?php echo _l('Update'); ?></button>
                            </div>

                            <?php }else{?>

                            <div class="">
                                <button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
                            </div>
                            <?php }?>
                               <?php echo form_close(); ?>
                         </div>
                      





                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    window.addEventListener('load',function(){
        appValidateForm($('#person_module'), {
            email: 'required',
            firstname: 'required',
            lastname: 'required',
            facebook: 'required',
            phonenumber: 'required',
            //password: 'required',
            password: {
               required : true, 
               min:6
            }
         }, imageuploader);
         });

    function manage_person(form) {
        
        var data = $(form).serialize();
        var url = form.action;
        $.post(url, data).done(function(response) {
            response = JSON.parse(response);
            if (response.success == true) {
                if($.fn.DataTable.isDataTable('.table-persons')){
                    $('.table-persons').DataTable().ajax.reload();
                }

                alert_float('success', response.message);
                }

        });
        return false;
 }


  Dropzone.autoDiscover = false;
  if($('#dropzoneDragArea').length > 0){
    Dropzone.options.expenseForm = false;
        var expenseDropzone;
        expenseDropzone = new Dropzone("#person_module", appCreateDropzoneOptions({
          autoProcessQueue: false,
          clickable: '#dropzoneDragArea',
          previewsContainer: '.dropzone-previews',
          addRemoveLinks: true,
          maxFiles: 10,
          success:function(file,response){
          if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            console.log(response);
            
             window.location.assign( admin_url +'users/Users/index');
             
           }
           window.location.assign( admin_url +'users/Users/index');
         },
       }));
     }

     function imageuploader(form) {
        
        $.post(form.action, $(form).serialize()).done(function (response) {
            response=JSON.parse(response);
            console.log(response.id);
            if (response.id) {
            if (expenseDropzone.getQueuedFiles().length > 0) {
    
                expenseDropzone.options.url = admin_url + 'Users/add_person_attachment/'+ response.id ;
                expenseDropzone.processQueue();
            }
            }else{
                window.location.assign(response.url);
            }

            

        });
    }



      $(function(){

        var input = document.getElementById('location');
        var autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(autocomplete, 'place_changed',
            function() {
                var place = autocomplete.getPlace();
                var lat = place.geometry.location.lat();
                var lng = place.geometry.location.lng();
                $("#latitude").val(lat);
                $("#longitude").val(lng);

            }
        );
    })
</script>
</body>
</html>







