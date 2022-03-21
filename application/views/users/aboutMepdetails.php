<?php
$getStateList=getStateList();
$getDobYearList=getDobYearList();
$getMonthList=getMonthList();
$getOccupationList=getOccupationList();
?>
 <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700' rel='stylesheet' />
<link href="<?php echo $this->config->item('system_path');?>css/setup.css" rel="stylesheet" />
 <!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>--> 
 <script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/edit.js"></script>
 <!--<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.colorbox-min.js"></script>-->
 
 <script type="text/javascript">
$(document).ready(function(){	
		$('.input').keypress(function (e) {
		  if (e.which == 13) {
		   return UpdatePersonalDetails();
		  }
		});
	
	  $('#cityS').keyup(function(){
		  	$('#city').val('');
			citySuggestions();
		  });
		  
		  $('.b-close').click(function(){
			   window.parent.$('.b-modal').bPopup().close();  
			   window.parent.$('#popup2').bPopup().close();
			  });
});
</script>

  <!----------edit PERSONAL section-popup-------------->  
<!--<div id="personalEditPopUp" class="popup_content">--><!----------edit PERSONAL section-popup-------------->
     <div id="personalEditPopUp" class="popup_content" style="display:block; position:relative;"  >
       <!--<span class="button b-close"><span>X</span></span>-->
       <header>
         <hgroup><h1>Edit personal details</h1></hgroup>
         <p class="b-close"><img src="<?php echo $this->config->item('system_path');?>img/close-icon-pop.png"></p>
       </header>
       <section id="editPersonalForm">
       <!--  html addtion - 21 nov 2014  -->
       <!--  html edit form structure - 19 dec 2014  --> 
          <form id="EditPersonalForm" method="post" name="EditPersonalForm" >          
        <div class="floatLeft peronalDetails1">		 
           <div class="floatLeft widthInput_345" id="personal_popup">
             <p>
             <label>Firstname</label>
             <input type="text" class="input widthInput_158 borderCCC floatLeft" value="<?php  echo $Userdata[0]['first_name']; ?>" id="firstname" name="firstname" placeholder="Firstname" />
             </p>
             <p>
             <label>Surname</label>
             <input type="text" class="input widthInput_158 borderCCC floatRight" id="surname" name="surname" value="<?php  echo $Userdata[0]['last_name']; ?>" placeholder="Surname" />
             </p>
             <p class="clear-ear">
              <!--  html edit - 05 dec 2014  --> 
              <label>Birthday</label>
              <select style=" width: 85px; margin-right:5px; clear:both;" name="day" id="day" class="borderCCC choice1 floatLeft">
               	<option value="">Day</option>
                <?php for($i=1;$i<=31;$i++){?>
              	<option value="<?=$i?>" <?php if($Userdata[0]['DOB'] !='0000-00-00' && date('d',strtotime($Userdata[0]['DOB'] ))==$i){echo 'selected="selected"';}?>><?=$i?></option>
              <?php } ?>
              </select>
              
              
              <!--  html edit - 05 dec 2014  --> 
             <select style="width: 100px; margin-right: 5px; " name="month" id="month" class="borderCCC choice1 floatLeft">
                  <option value="">Month</option>
                   <?php foreach($getMonthList as $monthK=>$monthV){?>
                  <option value="<?=$monthK?>" <?php if($Userdata[0]['DOB']!='0000-00-00' && date('m',strtotime($Userdata[0]['DOB']))==$monthK){echo 'selected="selected"';}?>><?=$monthV?></option>
                  <?php } ?>
              </select>
              </p>
			  <p>
             <label></label>
             <input type="text" class="input borderCCC floatLeft personal-year-input"  id="year" name="year" placeholder="Year" value="<?php $yearOld=$Userdata[0]['DOB'];
			 $yr=explode('-',$yearOld);
			 $years=$yr[0];
			 echo $years; ?>" />
             </p>
             <p>
             <label>Gender</label>
             </p>
             <p class="clear radioBtnBg">
               <input type="radio" value="male" <?php if ($Userdata[0]['gendor']=='male') echo 'checked="checked"'; ?> id="g-male" class="input marginRight10" name="gender"><label for="g-male"><span style="margin-top:-5px;"></span>Male</label>
               <input type="radio" style="margin-left:20px;" class="input marginRight10" value="female" <?php if ($Userdata[0]['gendor']=='female') echo 'checked="checked"'; ?> id="g-female" name="gender"><label for="g-female"><span style="margin-left:20px; margin-top:-5px;"></span>Female</label>
             </p>
             
             
             <p class="clear-state">
             <label>Current state</label>
               <select class="choice borderCCC floatLeft" style="width: 287px;" id="state" name="state" onchange="clearCityVal();"  >
     			 <option value="0">Select State</option>	  
      				<?php foreach($getStateList as $stateK=>$stateV){?>
                          <!--<option value="<?=$stateK?>"  <?php if($stateK==$Userdata[0]['state']){echo 'selected="selected"';}?> <?php if($stateK=='union_territories'){echo ' style="font-size:16px !important; padding:10px 0 5px; font-weight:bold" disabled';}?>><?=$stateV?></option>-->
                          <option value="<?=$stateK?>"  <?php if($stateK==$Userdata[0]['state']){echo 'selected="selected"';}?> ><?=$stateV?></option>
                     <?php } ?>
                </select>
                </p>
		
          <p class=" clear-country">
             <label>Current city/locality</label>
	  		 <input type="text" class="input floatRight widthInput_158 borderCCC" value="<?=cityNameFromId($Userdata[0]['city']) ?>" id="cityS"  placeholder="" style="width: 287px;"  autocomplete="OFF"/>
      		  <input type="hidden"  value="<?php echo $Userdata[0]['city']; ?>" id="city" name="city">
      		 <span class="citySuggestionsSearching" style="display:none;"><img src="<?php echo $this->config->item('system_path');?>img/circle-load.gif"></span>
          </p>
            <div id="citySuggestionsPDetailPage" class="citySuggestionsWrapper positionAbs" style="display:none;width: 288px; overflow-y: auto; overflow-x: hidden; height:250px; font-size: 10px; z-index: 9; top: 480px; left: 20px;"></div>
             
             <p class="clear">
             <input type="hidden" name="ocp" id="ocp" style="width: 170px; float: none; margin-top: 20px;" class="choice floatLeft widthInput_158 borderCCC">
             </p>
             
              <!--  html addition - 05 dec 2014  --> 
             <p class="clear"><input type="hidden" class="input floatLeft widthInput_158 borderCCC" value="<?php echo $Userdata[0]['college']; ?>" id="college" name="college" placeholder="College" style="width: 170px; margin-top: 20px; margin-right: 5px; margin-bottom: 18px;" />
             <input type="hidden" class="input floatLeft widthInput_158 borderCCC" value="<?php echo $Userdata[0]['course']; ?>" id="course" name="course" placeholder="Course" style="width: 170px; margin-top:20px;" />
             </p>
           </div> 
           </div> 
           
           <div class="buttonUpdatePerDetails">
           <input type="submit" id="editRiderUpdate" class="marginTop20" value="Update" onclick="return UpdatePersonalDetails();" />
           <span style="display: none;" id="watchmeter" class="perDetailsMeter"><img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif"></span>
         </div>
           
           <div class="floatRight peronalDetails2">
              <!--  html edit - 08 dec 2014  -->
           <textarea  class="borderCCC input"  name="bio" id="bio" placeholder="Little bit about you"><?php echo $Userdata[0]['bio'];  ?></textarea>
          </div>
          
          </form>
          
       </section>
      </div> 
      

  <!--</div>-->
<!----------end-PERSONAL section-popup-------------->  
