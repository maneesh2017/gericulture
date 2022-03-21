<?php  //see($ridedata);
if($about_me['id']==$userdata[0]['id'])
header('location:'.site_url().'my-profile');
$uid = $this->uri->segment(2);

	
$getStateList=getStateList();
$getListVehicleType=getListVehicleType();
$getOccupationList=getOccupationList();
$getListVehicleBrand=getListVehicleBrand($ridedata[0]['type'],1);

$getCover=getCover($userdata[0]['id'],'large');
$getProfilePic=getProfilePic($userdata[0]['id'],'large');
$getProfilePicLarge=getProfilePic($userdata[0]['id'],'large');
$flashes=getFlashes($userdata[0]['id']);
$get_block_status=get_block_status($userdata[0]['id']);
$blockedByMe=blockedByMe($user_id,$userdata[0]['id']); 

?>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/functions.js"></script>

<link href="<?php echo $this->config->item('system_path');?>js/user_image_slider/photoswipe.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/user_image_slider/klass.min.js"></script>

<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/user_image_slider/code.photoswipe.jquery-3.0.4.min.js"></script>
<script type="text/javascript"> 
	 
$(document).ready(function(){

 $("#gfcpopup").click(function() {	
 //$('#popup2').removeClass("uaboutMeprofilepic"); 
 $('#popup2').removeClass("cocomplimntpopup");
 $('#popup2').addClass('cgfcpopup');
	setTimeout(function(){ 
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},2000);
 
});


$("#ocomplimntpopup, #hornpopup").click(function() {	
//$('#popup2').removeClass("uaboutMecoverpic");
$('#popup2').removeClass("cgfcpopup");       	 	 
$('#popup2').addClass('cocomplimntpopup'); 
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},2000);

});
});	

function blowhorn(bid){	 
		
		 $('.aboutOtherBlowComp a').addClass('horn-blowed');
  		 $('.aboutOtherBlowComp a').removeAttr('onclick');
  
		var bid = bid;	
		$.ajax({		
		url:site_url+'watchfriends/blowhorn',		
		type:'POST',			
		data:'bid='+ bid,
		success:function(data)
			{	
				if(data=='LO')
					window.location=site_url;	  
				else
					$('#hornStyle').html(data);
			}
		});	 
	return false;
}


<?php if(!empty($rideimage)&& empty($get_block_status )){ ?>
(function(window, $, PhotoSwipe)
		{
			$(document).ready(function()
			{
				$("#coverPicwithDetails a.coverProfilePicA").photoSwipe(
				{
					enableMouseWheel: false,
					enableKeyboard: false
				});
			});
		}(window, window.jQuery, window.Code.PhotoSwipe));
<?php } ?>

<?php if(!empty($userImage)&& empty($get_block_status )){ ?>
(function(window, $, PhotoSwipe)
		{
			$(document).ready(function()
			{
				$("#coverPicwithDetails a.coverProfilePicB").photoSwipe(
				{
					enableMouseWheel: false,
					enableKeyboard: false
				});
			});
		}(window, window.jQuery, window.Code.PhotoSwipe));
<?php } ?>
</script>
<div id="popup2">  
<div class="content"></div>
</div>


  <div class="clear"></div>
  <div class="positionRel about-others-fuul-position" style="width:980px; display:block; margin:0 auto;">  
  
  <!-----ssend message hidden------------------>
<div class="sendMsgPopBox" style="display:none;">
            <ul class="subMenuMain2" style="height:196px;">
              <li>
			
               <div>
			   <form method="post" id="sendmsg">
			     <input type="hidden" value="<?php echo $uid ?>" name="uid" />
                 <!--  html edit - 15 dec 2014  --> 
                 <textarea class="sendMessageIextarea input" name="msg" id="message" placeholder="Write a message to <?php echo ucwords($userdata[0]['first_name']).' ('.$userdata[0]['username'].')';?>..."></textarea>
                 <input type="button" value="Send message" id="sendMsgPopBtn" onclick="return sendmsg();">
                  <span style="display: none;" class="mobile-watch" id="watch-msg"><img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif" alt="waiting-watch" width="32" height="32"></span>
			   </form> 
               </div>
               
              </li>     
            </ul>
</div>

<form method="post" id="blockform">
<div class="reportBlockBox" style="display:none;" id="blockuserprofile">
	
            <ul class="subMenuMain2">
              <li>		
               
               
               
               <div class="marginBttm10" id="profile-other-blockDiv" <?php if($blockedByMe){echo 'style="display:none;"';}?>>
                       <input type="checkbox"  id="block" value="1" name="block" <?php if($blockedByMe){?>disabled="disabled"<?php } ?>>
                       <p class="floatLeft">
                       <label for="block"><span></span>Block this vehicle</label>
                       <span>
                          After blocking, this person will not be able to access your profile. Your profile will be completely hidden and inaccessible.
                       </span>
                       </p>
                       </div>
                 
                 <div class="marginBttm10" id="profile-other-unblockDiv"  <?php if(!$blockedByMe){echo 'style="display:none;"';}?>>
                       <input type="checkbox"  id="unblock" value="1" name="unblock" <?php if(!$blockedByMe){?>disabled="disabled"<?php } ?>>
                       <p class="floatLeft">
                       <label for="unblock"><span></span>Un-Block this vehicle</label>
                       <span>
                          After unblocking, this person will be able to access your profile. Your profile will be completely accessible.
                       </span>
                       </p>
                       </div>
                 
               <div>
			   <input type="hidden" value="<?php echo $uid ?>" name="usrid" />
                 <input type="checkbox"  id="report" class="floatLeft" value="report" name="report">
                 <p class="floatLeft">
                 <label for="report"><span></span>Report abuse</label>
                 <!--  html edit - 15 dec 2014  --> 
                 <input type="text" class="input"  name="abuse" id="reasonAbuse" value="" placeholder="Please provide a reason of abuse" />
                 </p>
               </div>
               
               <div>
               <input type="button"  value="Send" id="reportBlockBtn" onclick="return blockprofile();">
               <span style="display: none;" class="" id="reportBlockBtnProcess"><img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif" alt="waiting-watch" width="32" height="32"></span>
               </div>
               
              </li>     
            </ul>
		
</div>
  </form>         
     <section id="contetDivWrap" class="overFlowInherit paddngBttm100"><!---------start section----------->
       
       <hgroup id="pageHeadng1">
         <h2><?php echo  strtoupper($userdata[0]['username']); ?></h2>    
       </hgroup>
                         <div class="clear"></div>
    <article id="coverPicwithDetails" class="overFlowHide marginBttm30">
         <figure>
	<?php if(!empty($rideimage)&& empty($get_block_status )){ ?>	 <a href="<?php echo $getCover;?>" class="coverProfilePicA"><?php } ?>
				 <img src="<?=$getCover?>" alt="cover pic" width="978" height="433"  /><?php if(!empty($rideimage)&& empty($get_block_status )){ ?> </a><?php } ?>
		 </figure>

			<?php foreach($othersridephotos as $oRPK=>$oRPV) {if($oRPV['default']=='1'){continue;}?>
	            <a href="<?php echo base_url();?>uploads/gallery/large/<?=$oRPV['pic_name']?>" class="coverProfilePicA"  style="display:none"></a>
            <?php } ?>
			
         
           <!--  html edir - 29 nov 2014  -->
         <figure class="positionAbs" id="openUserProfile"><span></span></figure>
         <div id="fullDetailsSideBar">
            <section id="otherUserProfileDetail">
           <!--  html edir - 29 nov 2014  -->
            <figure class="positionAbs"><span id="profileCloseArrow"></span></figure>
              <figure> 
			 <?php if(!empty($userImage)&& empty($get_block_status )){ ?>	 <a href="<?php echo $getProfilePicLarge;?>" class="coverProfilePicB"><?php } ?> 
			  	<img src="<?=$getProfilePic?>"  id="passportPhoto" alt="user" height="200" width="200" /> <?php if(!empty($userImage)&& empty($get_block_status )){ ?></a><?php } ?> 
			  </figure>
              
              <?php foreach($othersphotos as $oPK=>$oPV) {if($oPV['default']=='1'){continue;}?>
	            <a href="<?php echo base_url();?>uploads/gallery/large/<?=$oPV['pic_name']?>" class="coverProfilePicB"  style="display:none"></a>
            <?php } ?>
              
	         <div class="detailsUser1"> 
               <div class="floatRight">
                <hgroup><h2><?php echo ucwords($userdata[0]['first_name']).'&nbsp&nbsp'.ucwords($userdata[0]['last_name']);?></h2></hgroup> 
                <p><?php if(!empty($userdata[0]['gendor'])){ echo ucwords($userdata[0]['gendor']);} if(!empty($userdata[0]['DOB'])){echo '&nbsp;'.age_from_dob($userdata[0]['DOB']); }?><br />
				<?php 
			  if(!empty($userdata[0]['city'])){ 
			  	echo ucwords(cityNameFromId($userdata[0]['city'])).', ';
			  }
			  if(!empty($userdata[0]['state'])){ 
			  	echo ucwords($getStateList[$userdata[0]['state']]);
			  }
              ?> </p>
                
               </div>    
             </div>
             <div class="detailsUser2">
              <div class="floatRight">
               <hgroup><h2><?php  if(!empty($ridedata[0]['make'])){ echo $getListVehicleBrand[$ridedata[0]['make']];}  ?> <? $model=getModelText($ridedata[0]['model'],$ridedata[0]['type']);echo ucwords($model) ?> </h2></hgroup>
               <p><?=$flashes?> flash<?php if($flashes!=1){echo 'es';}?></p>
               <!--<p><?php if(!empty($caccessories[0]['countacces'])){ echo  $caccessories[0]['countacces'];} ?> accessories</p>-->
              </div>
             </div>
           </section>
           
         </div>
		 <?php $ruser = $this->uri->segment(2); ?>
          <article id="menuTabsProfile1">	    
          <?
          if(empty($get_block_status))
          {
          ?>
          <nav class="about-others-photos">
               <ul>
                <li><a class="otheractionbtn" href="<?php echo base_url(); ?>photo/othersride/<?php echo $ruser;?>">
                <span class="camLightsBtn"></span>
                <span>Photos</span>
                </a></li>
                
               </ul>
             </nav>
          <nav class="about-others-message">
          <ul>
          <li><a class="otheractionbtn" href="javascript: void(0)" id="sendMsgPopupBox">
          <span class="msgLightsBtn"></span>
          <span>Message</span>
          </a></li>              
          </ul>
          </nav> 
          <nav id="btnAllFrdFlashReq">
               <ul> 
                <li id="flesh">                 
               <?php
                     
               if(flashedByMe($about_me['id'],$ruser))
              {
                      $days= flashedTime($about_me['id'],$ruser);
                      if( $days>=7)
                      {
                      ?>
                          <a href="javascript: void(0);" class="activerflash otheractionbtn" onclick="return rflash_lights(<?php echo $ruser; ?>,1);" ><span class="flashLightsBtn"></span><span>Re-Flash</span></a>
                      <?php }
                      else
                      {?>
                          <a  href="javascript: void(0);" class="otheractionbtn blur" id="popupNotification" ><span class="flashLightsBtn"></span><span>Re-Flash</span></a>
                      <?php }
                }
                else
                {
                ?>
                <a  href="javascript: void(0);" class="activeflash otheractionbtn"  onclick="return flash_lights(<?php echo $ruser; ?>,1);" ><span class="flashLightsBtn"></span><span>Flash Lights</span></a> 
                
                <?
                }
                ?>
                </li> 
               </ul>
             </nav>
          
          <? 
          } 
          else
          { 
          ?>
          <h2 class="blocked-by">Your vehicle has been blocked by <?php echo ucwords($userdata[0]['first_name']).'&nbsp'.ucwords($userdata[0]['last_name']);?>
          </h2>
          <? } ?>  
          <section id="otherUserBlockReport" class="other-block-sider">
          <a class="otheractionbtn" href="javascript: void(0)" id="reportPopupBox">
          <span class="repblicon"></span>
          <span><? if($blockedByMe){ ?>UnBlock/Report<? } else { ?>  Block/Report <? } ?></span>
          </a>
          </section>   
          <div class="clearBoth"></div>  
          </article>
          
       </article>
        <article id="allDetailsBox1" class="marginBttm100">
         <div class="floatLeft">
		 
		   <section id="personalDetails">
             <article>
               <header>
                 <hgroup class="floatLeft"><h2 style="color:hsl(360, 79%, 58%); margin-top:16px; margin-bottom:16px;">Personal details</h2></hgroup>
               </header>
               <section>
               <!--  html addition - 29 nov 2014  -->
               
               <!--  html edit - 16 dec 2014  -->
                   <table cellpadding="0" cellspacing="0">
                     <tbody>
                      <tr>
                        <td><span>Name:</span> 
						<?php echo ucwords($userdata[0]['first_name']).'&nbsp&nbsp'.ucwords($userdata[0]['last_name']);?>
						</td> 
                        <td><span>Gender:</span> <?php if(!empty($userdata[0]['gendor'])){ echo $userdata[0]['gendor']; } else echo 'not specified'?>  </td>
                      </tr>
                      <tr>
                        <td><span>Birthday:</span> <?php if(!empty($userdata[0]['DOB'])){ echo  date('d M Y',strtotime($userdata[0]['DOB']));} else echo 'not specified'?>  </td>
                        <td><span>Lives in:</span> <?php  if($userdata[0]['city']=='' && $userdata[0]['state']==''){echo 'not specified';}
						else {?>
						<span id="c_city"><?php if($userdata[0]['city']!=''){echo cityNameFromId($userdata[0]['city']).', '; } ?></span><span id="c_state"><?php  if($userdata[0]['state']!=''){echo $getStateList [$userdata[0]['state']]; } ?></span>
						<?php }?>
                        </td>
                      </tr> 
                      
                      
                    </tbody>
                 </table>
               </section> 
               <footer>
                 <hgroup><h2>Little bit about  <?php echo ucwords($userdata[0]['first_name']);?></h2></hgroup>
                 <p>
				 <?php if(!empty($userdata[0]['bio'])){ echo $userdata[0]['bio']; } else echo 'Not specified';?>
                    
                 </p>
               </footer>  
             </article>
           </section>
           
           <section id="riderDetails">
             <article>
               <header>
                 <hgroup class="floatLeft"><h2 style="color:hsl(360, 79%, 58%); margin-top:16px; margin-bottom:16px;">Ride details</h2></hgroup>
               </header>
               <section>
               <!--  html addition - 28 nov 2014  -->
                   <table cellpadding="0" cellspacing="0">
                     <tbody>
                      <tr>
                        <td><span>Make:</span> <?php if(!empty($ridedata[0]['make'])){echo $getListVehicleBrand[$ridedata[0]['make']];} else echo 'not specified'?></td> 
                        <td><span>Model:</span><? $model=getModelText($ridedata[0]['model'],$ridedata[0]['type']); ?> <?php if(!empty($model)){echo ucwords($model);} else echo 'not specified'?></td>
                      </tr>
                      <tr>
                        <td><span>Registration number:</span> <?php  if(!empty( $userdata[0]['username'])){ echo $userdata[0]['username'];}else echo 'not specified ';?></td>
                        <td><span>Year model:</span> <?php if(!empty($ridedata[0]['year_model'])){echo $ridedata[0]['year_model'];} else echo 'not specified'?></td>
                      </tr>
                      <tr>
                        
                        <td><span>Type:</span> <?php if(!empty($ridedata[0]['type'])){echo $ridedata[0]['type'];} else echo 'not specified'?> </td>
						<td><span>Color:</span> <?php if(!empty($ridedata[0]['exterior_color'])){echo $ridedata[0]['exterior_color'];} else echo 'not specified'?></td>
                      </tr>
                      
                    </tbody>
                 </table>
               </section>
               <footer>
                 <hgroup><h2>What <?php if(!empty($userdata[0]['first_name'])){echo ucwords($userdata[0]['first_name']);}?> feels about his ride</h2></hgroup>
                 <p><?php if(!empty($ridedata[0]['description'])){ echo $ridedata[0]['description']; } else echo 'Not specified';?>
                    
                 </p>
               </footer>
             </article>
           </section>
           
         </div>
         
         <div class="aside-about aside-profile">
         <?php if($userdata[0]['fb_url']) { ?>
         <div class="about-facebook-connect">
		 <?php $getGender=himHer($userdata[0]['gendor']); ?>
         <p>Visit <?php echo $userdata[0]['first_name'];?>'s facebook profile to know<br />more about <?php echo $getGender; ?></p>
         <span><a href="<?php echo $userdata[0]['fb_url']; ?>" target="_blank"><img src="<?php echo $this->config->item('system_path');?>img/fb-profile.png" alt="facebook-profile"  /></a></span>
         </div>
		 <?php }else
			 { 
				/*Famous Rides*/
				$this->load->view('users/famous_rides');
			 }
		?>         
        
       </div>
         
     </article>
      
       
    </section><!---------close section----------->
    </div>
    
    <div class="popupNotification reflash-popupNotification" style="display:none;">
           
			  <img src="<?php echo $this->config->item('system_path');?>img/alert-icon.png" alt="alert" />
			   
                <p> <!--  html edit - 15 dec 2014  --> 
                    <b style="font-weight:normal; font-size:20px; ">You've already flashed lights to this vehicle.<? //php echo ucwords($userdata[0]['first_name']).'('.$userdata[0]['username'].')';?></b><br /><br />
              <span style="color:#666;">You will only be able to Re-flash after one week, starting from the time when you flashed lights last time.</span>
         </p>        
			    
              
</div>
    
<script type="text/javascript">
// checkbox
$('#reasonAbuse').hide();
$('.reportBlockBox > .subMenuMain2 > li > div > input#report[type="checkbox"], p.floatLeft label span').click('on', function(){
      if ( $('.reportBlockBox > .subMenuMain2 > li > div > input#report[type="checkbox"]').is(':checked') ) {
         $('#reasonAbuse').slideDown();
     } else {
         $('#reasonAbuse').slideUp();
		 $('#reasonAbuse').removeClass('formFieldError');
		 $('#reasonAbuse').val('');
     }
 });

</script>

