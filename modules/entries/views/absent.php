<body>
  <header class="header-area">
    <div class="container">
      <div class="logo-area">
        <a href="https://edtools.io/apps/"><img src="<?php echo base_url() ?>appci/assets/entries/images/logo.png" alt="Logo"></a>
      </div>
      <div class="class-select-area">
        <div class="custom-select">
          <select name="class_name" id="class_id_absent">
            <option value="">Select Class</option>
            <?php foreach ($classes as $key => $class) { ?>
              <option value="<?=$class['_id']?>"<?php if($class['standard'] == 1){ echo 'selected';}else{ 
                          if($key == 0){ echo 'selected'; } 
                        } ?> ><?=$class['class_name']?></option>
            <?php } ?>
          </select>
        </div>
      </div>
      <script type="text/javascript">callabsnet_stuendts();</script>
      <div class="icon-set">
        <nav>
          <ul>
            <li>
              <div class="tooltip">
                <a class="ques-mark" href="javascript:void(0)" onclick="all_present_mark()"><i class="fas fa-check"></i></a>
                <span class="tooltiptext">Mark all as present</span>
              </div>
            </li>
            <li>
              <div class="tooltip">
                <a class="ques-mark" href="https://www.edtools.io/settings/Student"><i class="fas fa-cog"></i></a>
                <span class="tooltiptext">Set whether absent students can see home-work</span>
              </div>
            </li>
            <li>
              <div class="tooltip">
                <a class="ques-mark" href="#"><i class="fas fa-question"></i></a>
                <span class="tooltiptext">Help</span>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </header>
  <section class="attnd-table-section" id='show_students'>
    
  </section>
  <footer class="footer-area">
    <div class="container">
      <div class="footer-info">
        <h3>Info</h3>
        <span>Some apps take into account whether a student present or absent. Here you can set this for all students on a daily basis.</span>
      </div>
      <div class="info-checkq">
        <table>
          <tr>
            <td>
              <span class="circle"></span>
              <span class="label">present</span>
            </td>
            <td>
              <span class="circle"></span>
              <span class="label">absent</span>
            </td>
            <td>
              <span class="circle"></span>
              <span class="label">absent, can see homework</span>
            </td>
          </tr>
        </table>
      </div>

    </div>
  </footer>


</body>