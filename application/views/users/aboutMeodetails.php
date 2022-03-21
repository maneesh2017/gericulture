<!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/edit.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.colorbox-min.js"></script>
<!----------edit OTHER section-popup-------------->
<div id="editOtherDetailsPopUp" class="popup_content" style="display:block" >
       <!--<span class="button b-close"><span>X</span></span>-->
       <header>
         <hgroup><h1>Edit other details</h1></hgroup>
       </header>
       <section id="editOtherForm">
          <form method="post" id="UpdateotherDetails">
            <div>
              <select name="ocp" id="ocp" style="width: 346px; margin-bottom:0; float: none; height:53px; padding:14px 12px 12px 0;" class="choice inputStyleSelect fontStyle16">
                        <option value="0">Occupation</option>
                        <option value="student">Student</option>
                        <option value="business">Business Owner</option>
                        <option value="employee">Employee</option>
                        <option value="college">College Passout</option>
                       </select>
            </div>
            <input type="text" class="input borderCCC widthInput_323 floatLeft" value="<?php echo $Userdata[0]['course']; ?>" id="course" name="course" placeholder="Course name" />
            <input type="text" class="input borderCCC widthInput_323 floatRight" value="<?php echo $Userdata[0]['college']; ?>" id="college" name="college" placeholder="College name" />
            <p class="clear"><center><input type="submit" value="Update" id="editOtherUpdate" onclick="return UpdateotherDetails();" /></center></p>
          </form>
       </section>
     </div>      
<!---------end OTHER section-popup-------------->
 

