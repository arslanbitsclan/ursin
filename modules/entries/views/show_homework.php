
  <header class="header-area">
    <style type="text/css">
      .colorgrn{
        background-color: green;
      }
      .colorwhite{
        background-color: white;
      }
      .coloriconwhite{
        background-color: white;
      }
      .coloricongrn{
        background-color: white;
      }
    </style>
    <div class="container">
      <div class="logo-area">
        <a href="https://edtools.io/apps/"><img src="<?php echo base_url(); ?>appci/assets/entries/images/logo.png" alt="Logo"></a>
      </div>
      <div class="class-select-area">
        <div class="custom-select">
          <select name="class_id" id="class_id_showhw" >
            <option value="" selected="">Select Class</option>
            <?php foreach ($classes as $key => $class) { ?>
                    <option value="<?=$class['_id']?>" <?php if($class['standard'] == 1){ echo 'selected';}else{ 
                          if($key == 0){ echo 'selected'; } 
                        } ?> >
                    Homework <?=$class['class_name']?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      
      <script type="text/javascript">setTimeout(function(){load_homework_data(); }, 2000);</script>
      <div class="three-switch">
        <div class="switch-toggle switch-3 switch-candy">
          <input id="on" name="filterdaterange" onclick="load_homework_data()" type="radio" value="today" />
          <label for="on" onclick="">Today</label>
          <input id="na" name="filterdaterange" onclick="load_homework_data()" value="tomorrow" type="radio" />
          <label for="na" class="disabled" onclick="">Tomorrow</label>
          <input class="lst-cld" id="off" value="future" onclick="load_homework_data()" name="filterdaterange" type="radio" checked="checked" />
          <label class="lst-cld" for="off" onclick="">Future</label>
        </div>
      </div>
      <div class="icon-set">
        <nav>
          <ul>
            <li>
              <div class="tooltip">
                <a class="ques-mark" id="enterhomework" target="_blank" href="<?php echo base_url('entries/Homework/'); ?>"><i class="fas fa-plus"></i></a>
                <span class="tooltiptext">Enter homework</span>
              </div>
            </li>
            <li>
              <div class="tooltip">
                <a class="ques-mark" target="_blank" href="<?php echo base_url('entries/Absent'); ?>"><i class="fas fa-thermometer-three-quarters"></i></a>
                <span class="tooltiptext">Mark absent students</span>
              </div>
            </li>
            <li id="btn_change_color">
              <div class="tooltip">
                <a class="ques-mark" href="javascript:void(0)" onclick="load_connected_teacher()"><i id="iconid" class="fas fa-network-wired"></i></a>
                <span class="tooltiptext"><div style="display: inline;" id='texttooltip'>Show</div> homework of all teachers</span>
              </div>
            </li>
            <li>
              <div class="tooltip">
                <a class="ques-mark" href="<?php echo base_url('entries/Showhomework'); ?>"><i class="fas fa-undo-alt"></i></a>
                <span class="tooltiptext">Reload page</span>
              </div>
            </li>
            <li>
              <div class="tooltip">
                <a class="ques-mark" target="_blank" href="#"><i class="fas fa-question"></i></a>
                <span class="tooltiptext">How it works</span>
              </div>
            </li>
            <li>
              <div class="tooltip">
                <button class="ques-mark" style="background-color: transparent; border: none; color:#666; font-size: 20px;" href="#" onclick="document.documentElement.requestFullscreen();"><i class="fas fa-arrows-alt"></i></button>
                <span class="tooltiptext">Go fullscreen</span>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
  <section class="table-data" id="show_homeworkbox">
    
  </section>

