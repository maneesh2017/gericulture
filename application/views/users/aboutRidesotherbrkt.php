<!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>-->
 <script>
  $(function () {
	 
	$("#oif").click(function() {	   	
		$('#oefeature').css("display", "none");			
		$('#outh').css("display", "none");
		$('#oifeature').css("display", "block");		
		$('#oif').addClass('activeSourceLi');
		$("#oef").removeClass('activeSourceLi');
		$("#outh").removeClass('activeSourceLi'); 	   
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
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/edit.js"></script>
<!----------start-popup-------------->
   <div id="rideFrdCirclePopUp" class="popup_content">
       <span class="button b-close"><span>X</span></span>
       <header>
         <hgroup><h1>3 Rides in Geri Circle</h1></hgroup>
         <p>(Aman can be seen on geri in these rides and is allowed to ride/drive them)</p>
		<!--<a href="#" class="addFrdGeriCircle">Add ride to Geri Circle</a>-->
       </header>
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
  </div>
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
                 <textarea class="sendMessageIextarea input" name="msg" id="message" >Write a message to <?php echo ucwords($userdata[0]['first_name']).' ('.$userdata[0]['username'].')';?>...</textarea>
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
                 <input type="text" class="input"  name="abuse" id="reasonAbuse" value="Please provide a reason of abuse" />
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
         <figure><img src="<?php echo base_url(); ?>uploads/gallery/large/<?php echo $rideimage[0]['image'] ?>" alt="cover pic" width="980" height="435"/></figure>
          <!--  html edir - 28 nov 2014  -->
         <figure class="positionAbs" id="openUserProfile"><span></span></figure>
         <div id="fullDetailsSideBar">
            <section id="otherUserProfileDetail">
              <!--  html edir - 28 nov 2014  -->
              <figure class="positionAbs"><span id="profileCloseArrow"></span></figure>
              <figure>
			   <?php if(!empty($userdata[0]['profile_pic'])){ ?>
			  <img src="<?php echo base_url(); ?>uploads/gallery/thumb/<?php echo $userdata[0]['profile_pic'] ?>"  id="passportPhoto" alt="user" height="200" width="200" />
			  <?php }else{ ?>
			  <img src="<?php echo $this->config->item('system_path'); ?>img/demo-pic.png" id="passportPhoto" alt="user" />
			   <?php } ?>
			  </figure>
             <div class="detailsUser1">
               <div class="floatRight">
                <hgroup><h2><?php echo '['.ucwords($userdata[0]['first_name']).']&nbsp&nbsp['.ucwords($userdata[0]['last_name']).']';?></h2></hgroup>
                <p><?php echo '['.$userdata[0]['gendor'].']'; $nowdate = date('Y'); $year = explode("-",$userdata[0]['DOB']);$age =$nowdate-$year[2]; echo '&nbsp;&nbsp;['.$age.']';?><br/>from <?php echo '['.$userdata[0]['city'].'],&nbsp['.$userdata[0]['state'].']';?></p>
               </div> 
             </div>
             <div class="detailsUser2">
              <div class="floatRight">
               <hgroup><h2><?php  if(!empty($ridedata[0]['make'])){ echo $ridedata[0]['make'];}  ?> &nbsp;<?php if(!empty($ridedata[0]['model'])){echo $ridedata[0]['model'];}?></h2></hgroup>
               <p><?php if(!empty($ridedata[0]['flashes'])){ echo '['.$ridedata[0]['flashes'].']'; }else{ echo "[0]"; } ?>  flashes</p>
               <p><?php echo  '['.$caccessories[0]['countacces'].']'; ?>  accessories</p>
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
             <ul>
             <!--  html addition - 28 nov 2014  -->
              <li class="aboutActiveLi">
			 <span class="rideUser"></span> <?php echo anchor("user/aboutRidesother/".$ruser,'ABOUT THE RIDE' ); ?>
			  </li>
             <!--  html addition - 28 nov 2014  -->
             <?php if($userdata[0]['gendor']=='male'){ ?>
              <li><span class="aboutUser"></span><?php echo anchor("user/aboutOthers/".$ruser,'ABOUT HIM' ); ?></li>
              <?php }else{ ?>
               <li><span class="aboutUser"></span><?php echo anchor("user/aboutOthers/".$ruser,'ABOUT HER' ); ?> </li>
               <?php } ?>
             </ul>
           </nav>
             <!--  html addition - 29 nov 2014  -->
           <nav class="floatLeft1" id="btnAllFrdFlashReq">
             <ul> 
			  
              <li class="marginRyt5"><a href="javascript: void(0);" class="btnBgStyle riderFlashLyt btnEqualAll" onclick="return flash_lights(<?php echo $ruser; ?>);" ><p><span class="flashLightsBtn"></span><span>Flash Lights</span></p></a></li>
			  <?php if(empty($frdststatus[0]['status'])){ ?>
              <li><a href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll" onclick="return friend_request(<?php echo $ruser; ?>);" ><p><span class="addFrdPlusIcon"></span><span>Add Friend</span></p></a></li>
			  <?php }else if($frdststatus[0]['status'] == 2){ ?>
			  <li><a href="javascript: void(0);" class="btnBgStyle addRiderFrd reqFrdSentBtn btnEqualAll" onclick="return friend_request(<?php echo $ruser; ?>);" ><p><span class="reqFrdPlusIcon"></span><span>Friend Request sent</span></p></a></li>
			  <?php }else{ ?>
			  <li><a href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll" onclick="return friend_request(<?php echo $ruser; ?>);" ><p><span class="frdPlusIcon"></span><span>Friend</span></p></a></li>
			  <?php } ?>
             </ul>
           </nav>           
		   <nav class="floatRight">
             <ul>
              <li style="margin-right:1px;"><a href="<?php echo base_url(); ?>photo/photothers/<?php echo $ruser;?>">Photos<br/><?php  if(!empty($countphotos)){echo $countphotos[0]['cphotos'];} ?></a></li>
              <li><a href="<?php  echo base_url();?>user/allfriends/<?php echo $ruser;?>">Friends<br/><?php if(!empty($countfriends))echo $countfriends[0]['cfriends']; ?></a></li>
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
                        <td><span>Make:</span> <?php if(!empty($ridedata[0]['make'])){echo $ridedata[0]['make'];}?></td> 
                        <td><span>Model:</span> <?php if(!empty($ridedata[0]['model'])){echo $ridedata[0]['model'];}?></td>
                      </tr>
                      <tr>
                        <td><span>Registration number:</span> <?php echo $userdata[0]['username'];?></td>
                        <td><span>Year model:</span> <?php if(!empty($ridedata[0]['year_model'])){echo $ridedata[0]['year_model'];}?></td>
                      </tr>
                      <tr>
                        <td><span>Location: </span><?php //if(!empty($ridedata[0][''])){echo $ridedata[0][''];}?> Mohali, Punjab</td>
                        <td><span>Type:</span> <?php if(!empty($ridedata[0]['type'])){echo $ridedata[0]['type'];}?> Car</td>
                      </tr>
                      <tr>
                        <td><span>Color (Exterior):</span> <?php if(!empty($ridedata[0]['color'])){echo $ridedata[0]['color'];}?></td>
                        <td><span>Color (Exterior):</span> <?php if(!empty($ridedata[0]['color'])){echo $ridedata[0]['color'];}?></td>
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
           
           <!--<section id="ridesGeriCircle">
             <article>
               <header>
                 <hgroup class="floatLeft"><h2 class="rideGeriCircle_h2">Rides in Geri Circle</h2></hgroup>
                 <a href="javascript: void(0)" onclick ="$('#rideFrdCirclePopUp').bPopup()" class="floatRight viewAllLinkBtn">View All</a>
                 <div class="clear"></div>
                 <p>(Add those friend's rides in which you can be seen on geri and you are allowed to ride/drive them)</p>
               </header>
               <section>
                 <ul>
                  <li id="hoverImgEffect">
                    <a href="#">
                      <img src="<?php echo $this->config->item('system_path'); ?>img/rider1.jpg" alt="rider" />
                   </a>
                   <div id="detailRiderInvisible">
               <!--  html addition - 28 nov 2014  -->
                   <!--<table cellpadding="0" cellspacing="0">
                        <thead>
                          <tr><th>BMW 328</th></tr>
                        </thead>
                        <tbody>
                          <tr><td>100 Lights flashed</td></tr>
                          <tr><td>4000 Km journey</td></tr>
                          <tr><td>Robin Goyal, male 28</td></tr>
                         </tbody>
                      </table>
                   </div> 
                  </li>
                  <li id="hoverImgEffect">
                    <a href="#">
                      <img src="<?php echo $this->config->item('system_path'); ?>img/rider1.jpg" alt="rider" />
                   </a>
                   <div id="detailRiderInvisible">
               <!--  html addition - 28 nov 2014  -->
                   <!--<table cellpadding="0" cellspacing="0">
                        <thead>
                          <tr><th>BMW 328</th></tr>
                        </thead>
                        <tbody>
                          <tr><td>100 Lights flashed</td></tr>
                          <tr><td>4000 Km journey</td></tr>
                          <tr><td>Robin Goyal, male 28</td></tr>
                         </tbody>
                      </table>
                   </div> 
                  </li>
                  <li id="hoverImgEffect">
                    <a href="#">
                      <img src="<?php echo $this->config->item('system_path'); ?>img/rider1.jpg" alt="rider" />
                   </a>
                   <div id="detailRiderInvisible">
               <!--  html addition - 28 nov 2014  -->
                   <!--<table cellpadding="0" cellspacing="0">
                        <thead>
                          <tr><th>BMW 328</th></tr>
                        </thead>
                        <tbody>
                          <tr><td>100 Lights flashed</td></tr>
                          <tr><td>4000 Km journey</td></tr>
                          <tr><td>Robin Goyal, male 28</td></tr>
                         </tbody>
                      </table>
                   </div> 
                  </li>
                 </ul>
               </section>
             </article>
           </section>-->
           
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
                        <td><span>Engine (cc):</span> <?php echo $RideInfo['engine'];?></td>
                        <td><span>Bhp:</span> <?php echo $RideInfo['bhp'];?></td>
                      </tr>
                      <tr>
                        <td><span>Body style:</span> <?php echo $RideInfo['body_style'];?></td>
                        <td><span>Drive type:</span> <?php echo $RideInfo['drive_type'];?></td>
                      </tr>
                      <tr>
                        <td><span>Transmission:</span > <?php echo $RideInfo['transmission'];?></td> 
                        <td><span>Fuel:</span> <?php echo $RideInfo['fuel'];?></td>
                      </tr>
                      <tr>
                        <td><span>Mileage:</span> <?php echo $RideInfo['mileage'];?></td>
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




    


