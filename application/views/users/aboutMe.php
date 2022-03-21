<?php 
if($Userdata[0]['role']!='admin')
{
$getListVehicleType=getListVehicleType();
$getOccupationList=getOccupationList();
$getListVehicleBrand=getListVehicleBrand($RideInfo['type'],1);
$getStateList=getStateList();

$getCover=getCover($Userdetail['id'],'large');
$getProfilePic=getProfilePic($Userdetail['id'],'large');
$flashes=getFlashes($Userdetail['id']);
?>
<script type="text/javascript"> 
	 
$(document).ready(function(){
  
 $("#cpiframe").click(function() {	
 $('#popup2').removeClass("uaboutMeprofilepic"); 
 $('#popup2').removeClass("uaboutMepdetails");
 $('#popup2').removeClass("ugerifrd");
 $('#popup2').removeClass("uaddfrdgeri");
 $('#popup2').removeClass("uaboutMestatus"); 
 $('#popup2').removeClass("ucomplimnt");
 $('#popup2').removeClass("uspeaker");	 
 $('#popup2').addClass('uaboutMecoverpic');
	setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},3000);
 
});
                  
 $("#ppic").click(function() {	
 $('#popup2').removeClass("uaboutMecoverpic");
 $('#popup2').removeClass("uaboutMepdetails");
 $('#popup2').removeClass("ugerifrd");
 $('#popup2').removeClass("uaddfrdgeri");
 $('#popup2').removeClass("uaboutMestatus");
 $('#popup2').removeClass("ucomplimnt"); 
 $('#popup2').removeClass("uspeaker"); 	 	 	 
 $('#popup2').addClass('uaboutMeprofilepic');
	setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},2000); 
 
});

$("#ampdetails, .small").click(function() {
  var clickedId=$(this).attr('id');
  $('#popup2').removeClass("uaboutMecoverpic");
 $('#popup2').removeClass("uaboutMeprofilepic");
 $('#popup2').removeClass("ugerifrd"); 	
 $('#popup2').removeClass("uaddfrdgeri");
 $('#popup2').removeClass("uaboutMestatus");
 $('#popup2').removeClass("ucomplimnt");
 $('#popup2').removeClass("uspeaker");   	 
 $('#popup2').addClass('uaboutMepdetails');
 

 setTimeout(function(){
	
	 if(clickedId=='erdiframe')
	 	$('#popup2 iframe').css('min-height',700);
	else
	 	$('#popup2 iframe').css('min-height',1200);
		
		$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	
	},2000);

  

});

$("#gfid").click(function() {	
 $('#popup2').removeClass("uaboutMecoverpic");
 $('#popup2').removeClass("uaboutMeprofilepic");
 $('#popup2').removeClass("uaboutMepdetails");  
 $('#popup2').removeClass("uaddfrdgeri");
 $('#popup2').removeClass("uaboutMestatus");
 $('#popup2').removeClass("ucomplimnt"); 
 $('#popup2').removeClass("uspeaker");  	 	 
 $('#popup2').addClass('ugerifrd');
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},3000);

});

$("#aftg").click(function() {	
 $('#popup2').removeClass("uaboutMecoverpic");
 $('#popup2').removeClass("uaboutMeprofilepic");
 $('#popup2').removeClass("uaboutMepdetails");  
 $('#popup2').removeClass("ugerifrd");
 $('#popup2').removeClass("uaboutMestatus"); 
 $('#popup2').removeClass("ucomplimnt"); 
 $('#popup2').removeClass("uspeaker"); 	 	 
 $('#popup2').addClass('uaddfrdgeri');
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},3000);

});

$("#cus").click(function() {	
 $('#popup2').removeClass("uaboutMecoverpic");
 $('#popup2').removeClass("uaboutMeprofilepic");
 $('#popup2').removeClass("uaboutMepdetails");  
 $('#popup2').removeClass("ugerifrd");
 $('#popup2').removeClass("uaddfrdgeri");
 $('#popup2').removeClass("ucomplimnt"); 
 $('#popup2').removeClass("uspeaker");       	 	 
 $('#popup2').addClass('uaboutMestatus');
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},4000);

});


$("#cts").click(function() {	
 $('#popup2').removeClass("uaboutMecoverpic");
 $('#popup2').removeClass("uaboutMeprofilepic");
 $('#popup2').removeClass("uaboutMepdetails");  
 $('#popup2').removeClass("ugerifrd");
 $('#popup2').removeClass("uaddfrdgeri");
 $('#popup2').removeClass("uaboutMestatus"); 
 $('#popup2').removeClass("uspeaker");     	 	 
 $('#popup2').addClass('ucomplimnt');
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},3000);

});

$('#connectFacebook').click(function(){
	$('#success').hide();
	$('#facebook-profile').removeClass('formFieldError');
	$('#facebookPop').bPopup();
		});
		
			
		$('#connectFacebookBtn').click(function(){
		
		        $('#success').hide();
		       $('#facebook-profile').removeClass('formFieldError');
				var fburl=$('#facebook-profile').val();
				
				if(fburl=='' || !validFBurl(fburl))
				{
	                   $('#facebook-profile').addClass('formFieldError');
					   errorBar('Enter Facebook URL to submit',1);
			    }
			 else
		       {
		             $('#facebook-profile').removeClass('formFieldError');
					 $('#connectFacebookBtn').hide();
					  $('#redWatch').show();
					 
					   $.ajax({
							   url:'<?=site_url()?>setting/connectFacebook',
							   type:'POST',
							   data:{fburl:fburl},
							   success:function(data)
							   {
							        $('#redWatch').hide();
									$('#connectFacebookBtn').show();
									successBar('Your facebook profile/page has been linked to your profile successfully');
									$('.about-facebook-connect').remove();
									 setTimeout(function(){ $('#facebookPop').bPopup().close(); }, 1500);
							   }
					   });
		       }
				
		 
		 });
 
		
		
		
		
		
		

$("#spk").click(function() {	
 $('#popup2').removeClass("uaboutMecoverpic");
 $('#popup2').removeClass("uaboutMeprofilepic");
 $('#popup2').removeClass("uaboutMepdetails");  
 $('#popup2').removeClass("ugerifrd");
 $('#popup2').removeClass("uaddfrdgeri");
 $('#popup2').removeClass("uaboutMestatus");
 $('#popup2').removeClass("ucomplimnt");       	 	 
 $('#popup2').addClass('uspeaker');
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},3000);

});


  
});	


function validFBurl(enteredURL) {
  var FBurl = /^(http|https)\:\/\/www.facebook.com\/.*/i;
  if(!enteredURL.match(FBurl)) {
	      return false;
      }
  else {
          return true;
      }
  }



</script>
<div id="popup2">
  
   <div class="content"><span class="button b-close"><span>X</span></span></div>
</div>
          
    <section id="contetDivWrap" class="overFlowInherit paddngBttm100">
	 <!---------start section----------->
     
       <hgroup id="pageHeadng1">
         <h2><?php if(!empty($Userdata[0]['username'])){echo strtoupper($Userdata[0]['username']);}?> </h2>
       </hgroup> 
       
       <article id="coverPicwithDetails" class=" about-fuul-position overFlowHide marginBttm30">
          <div class="positionRel">
          
          <?php if($getCover==system_path().'img/default_images/default-cover-large.jpg'){?>
          
         <div class="not-bnner-pic">
         <h1>USE AN ATTRACTIVE PIC OF YOUR RIDE<br /> FOR THE BANNER</h1>
         <span>Few tips for banner pics:</span>
         <p>Make sure image is 980px wide</p>
          <p>Use your own vehicle's pic only</p>
          <p>Always click in landscape mode</p>
          <p>Keep your vehicle's headlights or day lamps on</p>
          
		  <a id="cpiframe" class="small about-text-upload-banner"  data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>user/aboutMecoverpic"}' data-bpopupNew='<?php echo base_url(); ?>user/aboutMecoverpic'>Upload banner</a>
         </div>
         		<figure style="display:none;">
                          <img src="" id="coverPicHoverEffect" alt="cover pic" height="433" width="978"/>
         		</figure>
                 <span id="cpiframe" class="positionAbs changeBtnPattern changeCoverImg button small" style="display:none;" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>user/aboutMecoverpic"}'  data-bpopupNew='<?php echo base_url(); ?>user/aboutMecoverpic'>Change banner</span>
         
          <?php } else {?>
                        <figure>
                          <img src="<?=$getCover?>" id="coverPicHoverEffect" alt="cover pic" height="433" width="978" />
                        </figure>
                       <!--  html edit - 20 nov 2014  -->  
                       <!--  html edit - 05 dec 2014  -->  
                        <span id="cpiframe" class="positionAbs changeBtnPattern changeCoverImg button small" style="display:none;" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>user/aboutMecoverpic"}'  data-bpopupNew='<?php echo base_url(); ?>user/aboutMecoverpic'>Change banner</span>
            <?php } ?>
		 </div>
           <!--  html edir - 29 nov 2014  -->
         <figure class="positionAbs" id="openUserProfile"><span></span></figure>
         
         <div id="fullDetailsSideBar">
         <section id="otherUserProfileDetail" style="">
           <!--  html edir - 29 nov 2014  -->
            <figure class="positionAbs"><span id="profileCloseArrow"></span></figure>
            <div class="positionRel">
              <figure>
			  <img src="<?=$getProfilePic?>" id="passportPhoto" alt="user" width="200" height="200" />   
			  </figure>
              <span  id="ppic" style="display:none;"  class="positionAbs changeBtnPattern1 changeCoverImg1 button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>user/aboutMeprofilepic"}' data-bpopupNew='<?php echo base_url(); ?>user/aboutMeprofilepic'>Change photo</span>
              
           </div>
           <div class="detailsUser1">
             <div class="floatRight">
              <hgroup><h2><?php echo ucwords($Userdata[0]['first_name']).'&nbsp;'.ucwords($Userdata[0]['last_name']);?></h2></hgroup>
              
              <p><?php echo ucwords($Userdata[0]['gendor']); 
			  if(!empty($Userdata[0]['DOB'])){
				  echo ' '.age_from_dob($Userdata[0]['DOB']);}?><br />
			  
			<?php 
			  if(!empty($Userdata[0]['city'])){ 
			  	echo ucwords(cityNameFromId($Userdata[0]['city'])).', ';
			  }
			  if(!empty($Userdata[0]['state'])){ 
			  	echo ucwords($getStateList[$Userdata[0]['state']]);
			  }
              ?> 
             </p> 
             
             </div>
           </div>
           <div class="detailsUser2">
            <div class="floatRight">      
             <hgroup><h2><?php  if(!empty($ridetabledata['make'])){ echo $getListVehicleBrand[$ridetabledata['make']];}  ?> <? $model=getModelText($ridetabledata['model'],$ridetabledata['type']);echo ucwords($model) ?>  </h2></hgroup>
             <p><?=$flashes?> flash<?php if($flashes!=1){echo 'es';}?></p>
            
            </div> 
			
           </div>
             
			 </section>
             
             <section id="otherUserBlockReport" class="side-photo-me profile-myphoto-btn">

<a href="<?php echo base_url(); ?>photo/myride">My Photos</a>
             
              
 </section>
</div>	

	<article id="menuTabsProfile1" class="menuTabsProfile1">	    
        
        <nav class="about-others-photos">
               <ul>
                <li><a class="otheractionbtn" href="<?php echo base_url(); ?>photo/myride">
                <span class="camLightsBtn"></span>
                <span>My Photos</span>
                </a></li>
                
               </ul>
             </nav>
          <div class="clearBoth"></div>  
     </article> 
     

</article>
       
       
                  <div class="clear"></div>
       <article id="allDetailsBox1" class="marginBttm100">
         <div class="floatLeft">
		 
		   <section id="personalDetails">
             <article id="updetail"> 
               <header>
                 <hgroup class="floatLeft"><h2 style="color:hsl(360, 79%, 58%); margin-top:16px;">Personal details</h2></hgroup>
            <span id="ampdetails" class="editSectionBtn floatRight button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>user/aboutMepdetails"}' data-bpopupNew='<?php echo base_url(); ?>user/aboutMepdetails'>Edit Section</span> 
              </header>
             <?php
             $edit_personal_details_link='{"content":"iframe","contentContainer":".content","loadUrl":"'.base_url().'user/aboutMepdetails"}';
			 $edit_personal_details_linkA="<span data-bpopup='".$edit_personal_details_link."' class='small'  data-bpopupNew='".base_url()."user/aboutMepdetails'>Edit</span>";
			 ?>
               <section>
               <!--  html addition - 29 nov 2014  -->
               
                   <table cellpadding="0" cellspacing="0" > 
                     <tbody>
                      <tr>
                        <td><span>Name:</span> <span id="first_name"><?php echo ucwords($Userdata[0]['first_name']);?></span>&nbsp; <span id="last_name"><?php echo ucwords($Userdata[0]['last_name']); ?></span> <?php if($Userdata[0]['first_name']=='' && $Userdata[0]['last_name']==''){echo $edit_personal_details_linkA;}?></td>
                        <td><span>Gender:</span> <span id="ugender"><?php echo ucwords($Userdata[0]['gendor']);  ?></span> <?php if($Userdata[0]['gendor']==''){echo $edit_personal_details_linkA;}?></td>
                      </tr>      
                      <tr>
                        <td><span>Birthday:</span> <?php if($Userdata[0]['DOB']!='0000-00-00'){  echo date("j M Y", strtotime($Userdata[0]['DOB']));}  if($Userdata[0]['DOB']==''){echo $edit_personal_details_linkA;}?> </td>
                        <td><span>Lives in:</span> <?php  if($Userdata[0]['city']=='' && $Userdata[0]['state']==''){echo '<span class="cursor">'.$edit_personal_details_linkA.'</span>';}
						else {?>
						<span id="c_city"><?php if($Userdata[0]['city']!=''){echo cityNameFromId($Userdata[0]['city']).', '; } ?></span><span id="c_state"><?php  if($Userdata[0]['state']!=''){echo $getStateList [$Userdata[0]['state']]; } ?></span>
						<?php }?>
						</td>
                      </tr>
                    </tbody>
                 </table>
              
               </section>
               <footer>
                 <hgroup><h2>Little bit about <?php echo ucwords($Userdata[0]['first_name']);?></h2></hgroup>
                 <p id="c_bio"><?php echo $Userdata[0]['bio'];?>
                 </p>
                 <?php  if($Userdata[0]['bio']==''){echo $edit_personal_details_linkA;}?>
               </footer>

             </article>
           </section>
           
           <section id="riderDetails">
             <article id="UserData"> 
               <header>
                 <hgroup class="floatLeft"><h2 style="color:hsl(360, 79%, 58%); margin-top:16px;">Ride details</h2></hgroup>
                 <!--<a href="javascript: void(0);" onclick ="return ridedetails();" class="editSectionBtn floatRight">Edit Section</a>-->  <!--  html edit - 11 dec 2014  -->
               <span id="erdiframe" class="editSectionBtn floatRight button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>ride/aboutride"}' data-bpopupNew='<?php echo base_url(); ?>ride/aboutride'>Edit Section</span>
               </header>
               <?php
             $edit_ride_details_link='{"content":"iframe","contentContainer":".content","loadUrl":"'.base_url().'ride/aboutride"}';
			 $edit_ride_details_linkA="<span data-bpopup='".$edit_ride_details_link."' class='small' data-bpopupNew='".base_url()."ride/aboutride' >Edit</span>";
			 ?>
               <section>
               <!--  html addition - 28 nov 2014  -->
                   <table cellpadding="0" cellspacing="0" id="datUser" >
                     <tbody> 
                      <tr>
                        <td><span>Make: </span><?php if(!empty($RideInfo['make'])){echo $getListVehicleBrand[$RideInfo['make']];} ?></td> 
                        <td><span>Model: </span><? $model=getModelText($ridetabledata['model'],$ridetabledata['type']); echo ucwords($model) ?></td>
                      </tr>
                      <tr>
                        <td><span>Registration number: </span><?php if(!empty($Userdata[0]['username'])){ echo  strtoupper ($Userdata[0]['username']);} ?></td>
                        <td><span>Year model: </span><?php if(!empty($RideInfo['year_model'])){echo $RideInfo['year_model']; } else {?> <span class="cursor"> <? echo $edit_ride_details_linkA; ?> </span><?php } ?></td>
                      </tr>
                      <tr>
                        
                        <td><span>Type: </span><?php if(!empty($RideInfo['type'])){ echo $getListVehicleType[$RideInfo['type']]; } ?></td>
						<td><span>Color: </span><?php if(!empty($RideInfo['exterior_color'])){echo $RideInfo['exterior_color'];}else{?> <span class="cursor"><? echo $edit_ride_details_linkA; ?></span><?php } ?></td>
                      </tr>
                      
                    </tbody>
                 </table>
               </section>
               <footer> 
                 <hgroup><h2>What <?php if(!empty($Userdata[0]['first_name'])){echo ucwords($Userdata[0]['first_name']);} ?> feels about his ride</h2></hgroup>
                 <p id="about_description">
                    <?php if(!empty($RideInfo['description'])){echo $RideInfo['description'];}?>
                 </p>
                 <?php if($RideInfo['description']==''){ echo $edit_ride_details_linkA;}?>
               </footer>
             </article>
           </section>
           
		   <?php /*?><section id="standSpecification">
            <article id="newid" > 
               <header> 
                 <hgroup class="floatLeft"><h2>Standard specifications</h2></hgroup>
                 <!--<a href="javascript: void(0)" onclick ="return specdetails();" class="editSectionBtn floatRight">Edit Section</a>-->
            <span id="ersdiframe" class="editSectionBtn floatRight button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>ride/aboutspecifications"}'>Edit Section</span>   
               </header>
                <?php
             $edit_specifications_link='{"content":"iframe","contentContainer":".content","loadUrl":"'.base_url().'ride/aboutspecifications"}';
			 $edit_specifications_linkA="<span data-bpopup='".$edit_specifications_link."' class='small'>Edit</span>";
			 ?>
               <section>
                   <table id="testid">  
                     <tbody>
                      <tr>
                        <td><span>Engine (cc):</span><span id="engineid" class="ride_box1_item"> <?php if(!empty($RideInfo['engine'])){echo $RideInfo['engine']; }?></span><?php  if(empty($RideInfo['engine'])){ echo $edit_specifications_linkA;}?></td>
                        <td><span>Bhp:</span><span id="bhpid" class="ride_box1_item"> <?php if(!empty($RideInfo['bhp'])){echo $RideInfo['bhp'];}?></span><?php  if(empty($RideInfo['bhp'])){ echo $edit_specifications_linkA;}?></td>
                      </tr>
                      <tr>
                        <td><span>Body style:</span><span id="bstyleid" class="ride_box1_item"> <?php if(!empty($RideInfo['body_style'])){echo $RideInfo['body_style'];}?></span><?php  if(empty($RideInfo['body_style'])){ echo $edit_specifications_linkA;}?></td>
                        <td><span>Drive type:</span><span id="typeid" class="ride_box1_item"> <?php if(!empty($RideInfo['drive_type'])){echo $RideInfo['drive_type']; }?></span><?php  if(empty($RideInfo['drive_type'])){ echo $edit_specifications_linkA;}?></td>
                      </tr>
                      <tr>
                        <td><span>Transmission:</span ><span id="transmissionid" class="ride_box1_item"> <?php if(!empty($RideInfo['transmission'])){echo $RideInfo['transmission']; }?></span><?php  if(empty($RideInfo['transmission'])){ echo $edit_specifications_linkA;}?></td> 
                        <td><span>Fuel:</span> <span id="fuelid" class="ride_box1_item"> <?php if(!empty($RideInfo['fuel'])){echo $RideInfo['fuel']; }?></span><?php  if(empty($RideInfo['fuel'])){ echo $edit_specifications_linkA;}?></td>
                      </tr>
                      <tr>
                        <td><span>Mileage:</span><span id="mileageid" class="ride_box1_item"> <?php if(!empty($RideInfo['mileage'])){echo $RideInfo['mileage'];}?></span><?php  if(empty($RideInfo['mileage'])){ echo $edit_specifications_linkA;}?></td>
                        <td><span></span></td>
                      </tr>
                    </tbody>
                 </table>
               </section>
             </article>
           </section><?php */?>
            
		        
           
           
           
         </div>
         
         <div class="aside-about aside-profile">
          <?php 
		  $ifStickerOrdered=ifStickerOrdered($Userdata[0]['id']);
		  if(empty($ifStickerOrdered)){?>
         <?php  $this->load->view('free_sticker/sidebar_link');?> 
         <?php } ?>
         
         <?php if(!$Userdata[0]['fb_url']){ ?>
         <div class="about-facebook-connect">
         <p>Link your facebook profile/page with<br />your Geri Culture profile</p>
         <span><a href="javascript:void(0);" id="connectFacebook"><img src="<?php echo $this->config->item('system_path');?>img/fb-connect.png" alt="facebook-connect"  /></a></span>
         </div>
		 <?php }?>
         
          
          		<!--Famous Rides-->
		<?php 
		 if(!empty($ifStickerOrdered) && $Userdata[0]['fb_url']!=''){
			$this->load->view('users/famous_rides');
		 }?>       
      </div>
		 
         
     </article>
	 <div id="facebookPop" class="ChangeVehiclePop" style="display:none;">
            <p class="b-close"><img src="<?php echo $this->config->item('system_path');?>img/close-icon-pop.png" /></p>
            <label for="address"> Enter the URL of your facebook profile / facebook page</label><br />
              <input type="text" name="facebook-profile" id="facebook-profile" /><br />
              <p style=" font-size:13px; padding:10px 0 0 0; color:hsl(0, 0%, 40%); font-weight:300;">This will show a Facebook link on your Geri Culture profile so that people<br />can know more about you.</p>
           <input type="button" id="connectFacebookBtn" value="Submit" name="submit" class="facebook-connect-btn" />
           <img id="redWatch" src="<?php echo $this->config->item('system_path');?>img/speedometer.gif" alt="waiting-watch" width="32" height="32" />
       
        <p class="success" id="success">Your facebook profile/page has been linked to your profile successfully.</p>
           
  </div>
       
    </section><!---------close section----------->
	
	
<?php } //if not admin
else
{?>
    <section class="overFlowInherit paddngBttm100" id="contetDivWrap">
         <hgroup style="text-align:center;" id="pageHeadng1">
             <h1 style="text-align:center; padding-top:125px; padding-bottom:20px;">You are admin, you don't have any about me page.</h1>
             </hgroup>
         <div class="clear"></div>
    </section>
<?php } ?>
