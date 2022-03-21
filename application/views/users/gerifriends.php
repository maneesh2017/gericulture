<!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>-->
<!----------start-popup  add frd in geri circle-------------->
<script type="text/javascript">	 
$(document).ready(function(){  
 $("#addfrdrides").click(function() {	
	$('#popup2').addClass('addfrdsrides');
	setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},3000);
 
  }); 
  
$('a.crossFrdBtn').click(function() { 
$('#hidearticle-'+this.id).hide(); 
}); 
  
});	


	 





</script>

 <div id="popup2">  
   <div class="content"></div>
</div>
 <div class="loader"></div>
   	<div id="backgroundPopup"></div>
<!---------end-popup add frd in geri circle-------------> 
    <section id="contetDivWrap" class="overFlowInherit paddngBttm100"><!---------start section----------->
     
       <hgroup id="pageHeadng1">
         <h1>Friends</h1>
       </hgroup>
         
       <div class="clear"></div>
       
       <article id="rider-journey-people" class="overFlowInherit">
	   <!---------start article rider-journey-people----------->
          <header>
            <nav>
              <ul>
                <li><a href="<?php echo base_url(); ?>user/allfriends">All friends (<?php if(!empty($countfriends)){echo $countfriends[0]['cfriends'];} ?>)</a></li>
                <li class="activeUserLi"><a href="<?php echo base_url(); ?>user/gerifriends">Geri Circle friends / rides (<?php if(!empty($countgfriends)){echo $countgfriends[0]['gedifrd'];} ?>)</a></li>
                <li><a href="<?php echo base_url(); ?>user/friendsoffriends">Friends of friends</a></li>
              </ul>
            </nav>
          </header>
          
          <article id="searchPeopleDetails"><!---------start articlesearchPeopleDetails--------->
            <section class="friendsPage">
              <div>
			  <hgroup class="floatLeft"><h6 style="padding-top:13px;">Friends / rides in Geri Circle</h6></hgroup>
              <!--<a href="javascript: void(0);" onclick ="return addfrdtcbox();" class="btnBgStyle1 floatRight" style="margin-bottom:1px;">Add friends / rides</a>-->
              <span  id="addfrdrides" class="btnBgStyle1 floatRight button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>user/addfrdtcbox"}'>Add friends / rides</span>
              </div>
              <?php if(!empty($gerifriendlist)){ foreach($gerifriendlist as $gfl){ 
              $result = $this->db->query("Select count(*) as countacces from accessories  where user_id ='".$gfl['usersid']."'");
	          $cacessries = $result->result_array();
	          
	     ?>	
			  <article id="hidearticle-<?php echo $gfl['usersid']; ?>" >
                <figure class="riderFig1">
				<a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $gfl['usersid'] ?>" >	
				<img src="<?php echo base_url(); ?>uploads/gallery/small/<?php echo $gfl['profile_pic']; ?>" alt="user" width="93" height="93" />
				</a>	
				</figure>
                <figure class="riderFig2">
				<a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $gfl['usersid'] ?>" >
				<img src="<?php echo base_url(); ?>uploads/gallery/thumb/<?php echo $gfl['image']; ?>" alt="user" width="208" height="93" />
				</a>
				</figure>
                 <section class="secRider1">
                  <div class="divRider">
                    <hgroup>
					<h2 style="margin-top:0;">
					<a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $gfl['usersid'] ?>" style="font-size:16px;" class="floatLeft allFrdA">
					<?php echo $gfl['first_name'].'&nbsp'.$gfl['last_name'];?></a>
                    <span style="color: rgb(102, 102, 102); float: left; display: block; padding-top: 4px; font-weight: 300; font-size: 12px; padding-right: 5px; padding-left: 4px;">owns</span>
                    <a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $gfl['usersid'] ?>" class="floatLeft allFrdA" style="font-size:16px;">    
                    <?php echo $gfl['make'].'&nbsp'.$gfl['model'];?></a>
                    </h2>   
                    </hgroup>
                    <p class="clear"><?php if(!empty($gfl['gendor'])){ echo $gfl['gendor'];} ?>  <?php if(!empty($gfl['DOB'])){ $nowdate = date('Y'); $year = explode("-",$gfl['DOB']);$age =$nowdate-$year[2]; echo $age;}?> from <?php echo $gfl['city'].'&nbsp'.$gfl['state']; ?><br/><?php echo $gfl['occupation'] ?> at <?php echo $gfl['course'].'&nbsp'.$gfl['college']; ?></p>
                    <hgroup><h4> <?php echo $gfl['flashes'];?> flashes | <?php echo  $cacessries[0]['countacces']; ?> custom accessories</h4></hgroup>
                  </div>
                </section>
                <a href="javascript:void(0);" class="crossFrdBtn" id="<?php echo $gfl['usersid'] ?>" >delete</a>
              </article>
              <?php }} ?>
              
              
              
            </section>
          </article><!---------close articlesearchPeopleDetails--------->
          
       </article><!---------close article rider-journey-people----------->
       
    </section><!---------close section----------->
