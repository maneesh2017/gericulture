<?php
$getOccupationList=getOccupationList();
$getStateList=getStateList();
?>
<!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>-->
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
                <li><a href="<?php echo base_url(); ?>user/allfriends">All friends (<?=$countfriends?>)</a></li>
                <li><a href="<?php echo base_url(); ?>user/gerifriends">Geri Circle friends / rides (<?php if(!empty($countgfriends)){echo $countgfriends[0]['gedifrd'];} ?>)</a></li>
                <li class="activeUserLi"><a href="<?php echo base_url(); ?>user/friendsoffriends">Friends of friends</a></li>
              </ul>
			     
            </nav>
          </header>
          
          <article id="searchPeopleDetails">
		  <!---------start articlesearchPeopleDetails--------->
            <section class="friendsPage">
              <div>
			  <hgroup class="floatLeft"><h6 style="padding-top:13px;">Friends of your friends that you may know</h6></hgroup>
			  <a href="<?php echo base_url(); ?>findfriends" class="btnBgStyle1 floatRight">Find more Friends</a>			  
			  </div>
             
			  
			  <?php
						
				if(!empty($friendsoffriends)){foreach($friendsoffriends as $fs){
					
					$pPicPath=getProfilePic($fs['id'],'thumb');
					$cPicPath=getCover($fs['id'],'thumb');
				?>
			  <article> 
			  <?php
				//$query = $this->db->query("Select count(*) as countacces from accessories  where user_id ='". $fs['username']."'"); 
				//$res = $query->result_array();
				?>
                <figure class="riderFig1">
				<a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $fs['id'] ?>" >
				<img src="<?=$pPicPath?>" alt="user" height="93" />
				</a>
				</figure>
                <figure class="riderFig2">
				<a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $fs['id'] ?>" >	
				<img src="<?=$cPicPath?>" alt="user" height="93" />
				</a>
				</figure>
                 <section class="secRider1">
                  <div class="divRider">
                    <hgroup>
					<h2 style="margin-top:0;">
					<a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $fs['id'] ?>" style="font-size:16px;" class="floatLeft allFrdA">
					<?php echo $fs['first_name'].'&nbsp'.$fs['last_name'];?>
					</a>
					<span style="color: rgb(102, 102, 102); float: left; display: block; padding-top: 4px; font-weight: 300; font-size: 12px; padding-right: 5px; padding-left: 4px;">
					owns
					</span>
					<a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $fs['id'] ?>" class="floatLeft allFrdA" style="font-size:16px;">
					<?php echo $fs['make'].'&nbsp'.$fs['model']; ?> </a>
					</h2>
					</hgroup>
                    <p class="clear"><?php echo $fs['gendor']; ?> <?=age_from_dob($fs['DOB'])?> from <?php echo $fs['city']; ?>, <?=$getStateList[$fs['state']]; ?><br/><?=$getOccupationList[$fs['occupation']]?><?php if($fs['college']!='')echo ' at '.$fs['college'];?></p>
                    <hgroup><h4><?=getFlashes($fs['id'])?> flashes | <?php //echo $res[0]['countacces'];  ?> custom accessories</h4></hgroup>
                  </div>
                </section>
				<div id="frdreq<?php echo $fs['id']; ?>">
                <a href="javascript:void(0);" onclick="return frndrequest(<?php echo $fs['id']; ?>);" class="addFriendBtn">
				Add Friend
				</a>
				</div>
              </article>
              <?php }} ?>
             </section>
          </article><!---------close articlesearchPeopleDetails--------->
          
       </article><!---------close article rider-journey-people----------->
       
    </section><!---------close section----------->


    


