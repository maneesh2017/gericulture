<?php
if($about_me['id']==$userdata[0]['id'])
	header('location:'.site_url().'ride/about');

//$friendshipStatus=friendshipStatus($about_me['id'],$userdata[0]['id']);	

$getStateList=getStateList();
$getListVehicleBrand=getListVehicleBrand();

$getCover=getCover($userdata[0]['id'],'large');
$getProfilePic=getProfilePic($userdata[0]['id'],'thumb');
?>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/functions.js"></script>
 <script type="text/javascript">
  $(function () {
	 
	$("#oif").click(function() {	   	
		$('#oefeature').css("display", "none");			
		$('#outh').css("display", "none");
		$('#oifeature').css("display", "block");		
		$('#oif').addClass('activeSourceLi');
		$("#oef").removeClass('activeSourceLi');
		$("#outhood").removeClass('activeSourceLi'); 	    
		});	
			
		$("#oef").click(function() {	   	  
		$('#oifeature').css("display", "none");			
		$('#outh').css("display", "none");
		$('#oefeature').css("display", "block");		
		$('#oef').addClass('activeSourceLi');
		$("#outhood").removeClass('activeSourceLi'); 
		$("#oif").removeClass('activeSourceLi'); 	   
		});	
			
		$("#outhood").click(function() {	   	
		$('#oefeature').css("display", "none");			
		$('#oifeature').css("display", "none");
		$('#outh').css("display", "block");		
		$('#outhood').addClass('activeSourceLi');
		$("#oef").removeClass('activeSourceLi'); 
		$("#oif").removeClass('activeSourceLi');  	   
		}); 
		
	 });	
 </script>	

<!----------start-popup-------------->
   <!--<div id="rideFrdCirclePopUp" class="popup_content">
       <span class="button b-close"><span>X</span></span>
       <header>
         <hgroup><h1>3 Rides in Geri Circle</h1></hgroup>
         <p>(Aman can be seen on geri in these rides and is allowed to ride/drive them)</p>
		<!--<a href="#" class="addFrdGeriCircle">Add ride to Geri Circle</a>-->
       <!--</header>
       <section id="formTable1">
          <ul>
            <li>
              <figure class="floatLeft">
                <a href="about-the-rides-other.html"><img src="<?php echo $this->config->item('system_path');?>img/pic7.jpg" alt="pic" class="floatLeft marginRyt1" /></a><a href="about-me-others.html"><img src="<?php echo $this->config->item('system_path');?>img/pic6.jpg" alt="pic" class="floatLeft" /></a>
              </figure>
              <section class="floatLeft">
                <hgroup><h3 class="marginTopMinus5"><a href="about-the-rides-other.html">BMW 328</a> <span>owned by</span>  <a href="about-me-others.html">Robin Ahuja</a></h3></hgroup>
                <p>Male 26 from Mohali, Punjab</p>
                <span>1000 flashes | 5 custom accessories</span>
              </section>
              <a class="crossFrdBtn1 floatRight" href="#">delete</a>
            </li>
          </ul>
       </section>
  </div>-->
<!----------end-popup-------------->                
  <div class="positionRel" style="width:980px; display:block; margin:0 auto;">  
  
  <!-----ssend message hidden------------------>
<div class="sendMsgPopBox" style="display:none;">
            <ul class="subMenuMain2">
              <li>
			 <?php $uid = $this->uri->segment(3);?>
               <div>
			   <form method="post" id="sendmsg">
			     <input type="hidden" value="<?php echo $uid ?>" name="uid" />
                 <!--  html edit - 15 dec 2014  --> 
                 <textarea class="sendMessageIextarea input" name="msg" id="message" placeholder="Write a message to <?php echo ucwords($userdata[0]['first_name']).' ('.$userdata[0]['username'].')';?>..."></textarea>
                 <input type="submit" value="Send message" id="sendMsgPopBtn" onclick="return sendmsg();">
			   </form> 
               </div>
               
              </li>     
            </ul>
</div>
<form method="post" id="blockform">
<div class="reportBlockBox" style="display:none;" id="blockuserprofile">
	
            <ul class="subMenuMain2">
              <li>
			  
               <div class="marginBttm10">
			   <input type="hidden" value="<?php echo $uid ?>" name="usrid" />
                 <input type="checkbox"  id="report" class="floatLeft" value="report" name="report">
                 <p class="floatLeft">
                 <label for="report"><span></span>Report abuse</label>
                 <!--  html edit - 15 dec 2014  -->
                 <input type="text" class="input"  name="abuse" id="reasonAbuse" value="" placeholder="Please provide a reason of abuse" />
                 </p>
               </div>
               
               <div>
                 <input type="checkbox"  id="block" value="1" name="block">
                 <p class="floatLeft">
                 <label for="block"><span></span>Block this profile</label>
                 <span>
                    (By blocking this profile, this person will not be able to send you any 
                    messages in future and will not be able to post any compliments or 
                    blow horn on your status messages)
                 </span>
                 </p>
                 <input type="submit" value="Send" id="reportBlockBtn" onclick="return blockprofile();">
               </div>
               
              </li>     
            </ul>
		
</div>
  </form>         
     <section id="contetDivWrap" class="overFlowInherit paddngBttm100">
	 <!---------start section----------->     
       <hgroup id="pageHeadng1"> 
         <h2><?php echo $userdata[0]['username'];?></h2>
       </hgroup> 
                         <div class="clear"></div>
    <article id="coverPicwithDetails" class="overFlowHide marginBttm30">
			<figure>
				<img src="<?=$getCover?>" alt="cover pic" width="980" height="435"/>
			</figure> 
          <!--  html edir - 28 nov 2014  -->
         <figure class="positionAbs" id="openUserProfile"><span></span></figure>
         <div id="fullDetailsSideBar">
            <section id="otherUserProfileDetail">
              <!--  html edir - 28 nov 2014  -->
              <figure class="positionAbs"><span id="profileCloseArrow"></span></figure>
              <figure>
			  	<img src="<?=$getProfilePic?>"  id="passportPhoto" alt="user" height="200" width="200" />
			  </figure>
             <div class="detailsUser1">
               <div class="floatRight">
                <hgroup><h2><?php echo ucwords($userdata[0]['first_name']).'&nbsp&nbsp'.ucwords($userdata[0]['last_name']);?></h2></hgroup>
                <p><?php echo ucwords($userdata[0]['gendor']);if(!empty($userdata[0]['DOB'])) { echo '&nbsp;&nbsp;'.age_from_dob($userdata[0]['DOB']);}?>&nbsp;&nbsp;<?php if($userdata[0]['city'] ||  $userdata[0]['state'] ){ echo "From &nbsp;&nbsp;"; } if(!empty($userdata[0]['state'])){ echo ucwords($userdata[0]['city']).',<br/>'.ucwords($userdata[0]['state']);}else{ echo ucwords($userdata[0]['city']); } ?></p>
               </div> 
             </div>
             <div class="detailsUser2">
              <div class="floatRight">
               <hgroup><h2><?php  if(!empty($ridedata[0]['make'])){ echo $getListVehicleBrand[$ridedata[0]['make']];}  ?>  <?php if(!empty($ridedata[0]['model'])){echo ucwords($ridedata[0]['model']);}?></h2></hgroup>
               <p><?php if(!empty($ridedata[0]['flashes'])){ echo $ridedata[0]['flashes']; }else{ echo "0"; } ?>  flashes</p>
               <p><?php echo  $caccessories[0]['countacces']; ?>  accessories</p>
              </div>   
             </div>
           </section>
            <section id="otherUserBlockReport">
              <a href="javascript: void(0)" id="sendMsgPopupBox" class="floatLeft">Send Message</a>
              <a href="javascript: void(0)" id="reportPopupBox" class="floatRight">Report/Block</a>
            </section>
         </div>
		 <?php $ruser = $this->uri->segment(3); ?>
         <article id="menuTabsProfile1">
           <nav class="floatLeft">
             <ul style="text-transform:uppercase;">
             
             <li class="aboutActiveLi">
			 <a href="<?php echo base_url();?>user/aboutRidesother/<?php echo $ruser; ?>">	 
				<span class="<?=getRideIconClass($ridedata[0]['type'])?>"></span>
					ABOUT <?=hisHer($userdata[0]['gendor'])?> RIDE
				
				</a></li>
              <li><a href="<?php echo base_url();?>user/aboutOthers/<?php echo $ruser; ?>">
				  <span class="aboutUser<?=ucfirst(himHer($userdata[0]['gendor']))?>"></span>ABOUT <?=himHer($userdata[0]['gendor'])?></a>
			  </li>              
             </ul>
           </nav>
             <!--  html addition - 29 nov 2014  -->           
		   <nav class="floatRight">
             <ul>
              <li style="margin-right:1px;"><a href="<?php echo base_url(); ?>photo/photothers/<?php echo $ruser;?>">Photos<br/><?=getImageCount($userdata[0]['id'])?></a></li>
              <li><a href="<?php  echo base_url();?>user/allfriends/<?php echo $ruser;?>">Friends<br/><?=$countfriends?></a></li>
             </ul>
           </nav>
		   
		   <nav id="btnAllFrdFlashReq">
             <ul> 
             
			  <li class="marginRyt5" id="flesh">                 
			 <?php
             		if(flashedByMe($about_me['id'],$ruser))
					{?>
						<a href="javascript: void(0);" class="btnBgStyle riderFlashLyt btnEqualAll" onclick="return removeflash_lights(<?php echo $ruser; ?>);" ><p><span class="flashLightsBtn"></span><span>Remove Flash</span></p></a>
					<?php }
					else
					{?>
						<a  href="javascript: void(0);" class="btnBgStyle riderFlashLyt btnEqualAll" onclick="return flash_lights(<?php echo $ruser; ?>,1);" ><p><span class="flashLightsBtn"></span><span>Flash Lights</span></p></a> 
					<?php }
			?>
              </li>   
                    
              <li id="frndrqstid">
			   <?php
                             if($friendshipStatus==1)
                             {?>
                                      <a onclick="return remove_friend(<?php echo $ruser; ?>);" href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll"><p><span class="addFrdPlusIcon"></span><span>Unfriend</span></p></a>
                              <?php }
                             elseif($friendshipStatus==2)
                             {?>
                                      <a onclick="return cancel_request(<?php echo $ruser; ?>);" href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll"><p><span class="addFrdPlusIcon"></span><span>Cancel Request</span></p></a>
                             <?php } 
                             elseif($friendshipStatus==3)
                             {?>
                                      <a onclick="return cancel_request(<?php echo $ruser; ?>);" href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll"><p><span class="addFrdPlusIcon"></span><span>Reject Request</span></p></a>
                             <?php }
                             elseif($friendshipStatus==4)
                             {?>
                                       <a onclick="return friend_request(<?php echo $ruser; ?>,1);" href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll"><p><span class="addFrdPlusIcon"></span><span>Add Friend</span></p></a>
                             <?php }?>
			  </li>
             </ul>
           </nav>
         </article> 
        
       </article>
       <article id="allDetailsBox1" class="marginBttm100">
         <div class="floatLeft">
           <section id="riderDetails">
             <article>
               <header>
                 <hgroup class="floatLeft"><h2>Details of the ride</h2></hgroup>
               </header>
               <section>
               <!--  html addition - 28 nov 2014  -->
                   <table cellpadding="0" cellspacing="0">
                     <tbody>
                      <tr>
                        <td><span>Make:</span> <?php if(!empty($ridedata[0]['make'])){echo $getListVehicleBrand[$ridedata[0]['make']];}?></td> 
                        <td><span>Model:</span> <?php if(!empty($ridedata[0]['model'])){echo $ridedata[0]['model'];}?></td>
                      </tr>
                      <tr>
                        <td><span>Registration number:</span> <?php echo $userdata[0]['username'];?></td>
                        <td><span>Year model:</span> <?php if(!empty($ridedata[0]['year_model'])){echo $ridedata[0]['year_model'];}?></td>
                      </tr>
                      <tr>
                        <td><span>Location: </span><?php if(!empty($ridedata[0]['ride_location'])){echo $ridedata[0]['ride_location'];}?><?php if($ridedata[0]['ride_location']!='' && $ridedata[0]['state']!=''){?>, <?php } ?> <span class="bold state"> <?php if($ridedata[0]['state']!=''){ echo $getStateList[$ridedata[0]['state']]; }  ?> </span></td>
                        <td><span>Type:</span> <?php if(!empty($ridedata[0]['type'])){echo $ridedata[0]['type'];}?> </td>
                      </tr>
                      <tr>
                        <td><span>Color (Interior):</span> <?php if(!empty($ridedata[0]['interior_color'])){echo $ridedata[0]['interior_color'];}?></td>
                        <td><span>Color (Exterior):</span> <?php if(!empty($ridedata[0]['exterior_color'])){echo $ridedata[0]['exterior_color'];}?></td>
                      </tr>
                    </tbody>
                 </table>
               </section>
               <footer>
                 <hgroup><h2>What <?php if(!empty($userdata[0]['first_name'])){echo ucwords($userdata[0]['first_name']);}?> feels about his ride</h2></hgroup>
                 <p><?php if(!empty($ridedata[0]['description'])){ echo $ridedata[0]['description']; } ?>
                    
                 </p>
               </footer>
             </article>
           </section>
           
          <section id="ridesGeriCircle2">
             <article>
               <header>
                 <hgroup class="floatLeft"><h2>Non-standard accessories / modifications</h2></hgroup>
               </header>
               <nav>
                <ul>
                 <li><a href="javascript:void(0);" id="oef" class="activeSourceLi">External features</a></li>
                 <li><a href="javascript:void(0);" id="oif" >Internal features</a></li>              
                 <li><a href="javascript:void(0);"  id="outhood" >Under the hood</a></li>
                </ul>
               </nav>
               <section class="borderNone">
                 <ul>
				 <?php if(!empty($Ride_Info)){foreach($Ride_Info as $ri){  if($ri['feature_type'] == 'external feature'){ ?>
                   
                  <li id="oefeature" >
                    <a href="#">
                      <img src="<?php echo base_url();?>uploads/gallery/thumb/<?php echo $ri['image']?>" alt="rider" />
                   </a>
                  </li>
                  
                  <?php }else if($ri['feature_type'] == 'internal feature' ){ ?>
                  <li id="oifeature" style="display:none">
                    <a href="#">
                      <img src="<?php echo base_url();?>uploads/gallery/thumb/<?php echo $ri['image']?>" alt="rider" />
                   </a>
                  </li>
                  
                  <?php }else {  ?>
                  <li id="outh" style="display:none" >
                    <a href="#">
                      <img src="<?php echo base_url();?>uploads/gallery/thumb/<?php echo $ri['image']?>" alt="rider" />
                   </a>
                  </li>       
                  
				  <?php } }} ?>             
                                  
                 </ul>
               </section>
             </article>
           </section>
           
          
           
          <section id="standSpecification">
            <article>
               <header>
                 <hgroup class="floatLeft"><h2>Standard specifications</h2></hgroup>
               </header>
               <section>
               <!--  html addition - 28 nov 2014  -->
                   <table cellpadding="0" cellspacing="0">
				 <tbody>
                      <tr> 
                        <td><span>Engine (cc):</span> <?php if(!empty($RideInfo['engine'])) { echo $RideInfo['engine'];} ?></td>
                        <td><span>Bhp:</span> <?php if(!empty($RideInfo['bhp'])) { echo $RideInfo['bhp']; } ?></td>
                      </tr>
                      <tr>
                        <td><span>Body style:</span> <?php if(!empty($RideInfo['body_style'])) { echo $RideInfo['body_style']; } ?></td>
                        <td><span>Drive type:</span> <?php if(!empty($RideInfo['drive_type'])) { echo $RideInfo['drive_type']; } ?></td>
                      </tr>
                      <tr>
                        <td><span>Transmission:</span > <?php if(!empty($RideInfo['transmission'])) { echo $RideInfo['transmission']; } ?></td> 
                        <td><span>Fuel:</span> <?php if(!empty($RideInfo['bhp'])) { echo $RideInfo['fuel']; } ?></td>
                      </tr>
                      <tr>
                        <td><span>Mileage:</span> <?php if(!empty($RideInfo['mileage'])) { echo $RideInfo['mileage']; } ?></td>
                        <td><span></span></td>
                      </tr>
                    </tbody>
				  </table>	
               </section>
             </article>
           </section>
           
         </div>
         <aside class="marginBttm100 floatRight">
             <div class="whiteBg heightTotal500 blankDiv"></div>
        </aside>
     </article>
      
      
    
       
       
    </section><!---------close section----------->
    </div>
<script type="text/javascript">
// checkbox
$('#reasonAbuse').hide();
$('.reportBlockBox > .subMenuMain2 > li > div > input#report[type="checkbox"] + p label span').click('on', function(){
      if ( $('.reportBlockBox > .subMenuMain2 > li > div > input#report[type="checkbox"]').is(':checked') ) {
         $('#reasonAbuse').slideUp();
     } else {
         $('#reasonAbuse').slideDown();
     }
 });
</script>




    


