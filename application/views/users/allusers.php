<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/functions.js"></script>
<script type="text/javascript">
function unfriend(userid){	 
				
		var userid = userid;	 	
		$.ajax({		
		url:site_url+'user/removefriend',		
		type:'POST',			
		data:'userid='+ userid,
		success:function(data)
			{				
			 alert('vvvvvvvvvv');
			 $('unfriend-'+userid).hide();			  
			}     
		});	 
	return false;
}
</script>
 <section id="contetDivWrap" class="overFlowInherit paddngBttm100">
 <!---------start section-----------> 
 
       <hgroup id="pageHeadng1">
         <h1>Friends</h1>
       </hgroup>
         
       <div class="clear"></div>
       
       <article id="rider-journey-people" class="overFlowInherit"><!---------start article rider-journey-people----------->
          <header>
            <nav>
              <ul>
                <li class="activeUserLi"><a href="<?php echo base_url(); ?>user/allfriends">All friends (<?php if(!empty($countfriends)){echo $countfriends[0]['cfriends'];} ?>)</a></li>
                <li><a href="<?php echo base_url(); ?>user/gerifriends">Geri Circle friends / rides (<?php if(!empty($countgfriends)){echo $countgfriends[0]['gedifrd'];} ?>)</a></li>
                <li><a href="<?php echo base_url(); ?>user/friendsoffriends">Friends of friends</a></li>
              </ul>
            </nav>
          </header>
          
          <article id="searchPeopleDetails"><!---------start articlesearchPeopleDetails--------->
            <section class="friendsPage">
              <div style="padding-left:10px;">
                <form class="floatLeft" method="post" action="<?php echo base_url();?>user/allfriends"  id="searchnamemodel" >
                  <input type="text" class="input inputStyle1" placeholder="Search by name..." name="flname" />
                  <input type="text" class="input inputStyle1" placeholder="Search by ride's model..." name="modelname" />
                  <input type="submit" class="btnBgStyle1 floatRight" style="margin-bottom:1px;" value="Find Friends" />
				 
                <!--<a href="find-friend.html" class="btnBgStyle1 floatRight" style="margin-bottom:1px;">Find Friends</a>-->
				</form>
				</div>
				<?php if(!empty($friendrequest)){foreach($friendrequest as $fr){ ?>
			<article id="frhide-<?php echo $fr['usersid']; ?>">
			<figure class="riderFig1">
			<a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $fr['usersid'] ?>" >	
			<img src="<?php echo base_url(); ?>uploads/gallery/small/<?php echo $fr['profile_pic']; ?>" alt="user" width="93" height="93" />
			</a>
			</figure>
			<figure class="riderFig2">
			<a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $fr['usersid'] ?>" >		
			<img src="<?php echo base_url(); ?>uploads/gallery/thumb/<?php echo $fr['image']; ?>" alt="user" width="208" height="93" />
			</a>
			</figure>
			<section class="secRider1">
			<?php
			$query = $this->db->query("Select count(*) as countacces from accessories  where user_id ='". $fr['username']."'"); 
			$res = $query->result_array();
			?>
			<div class="divRider">
			<hgroup>
			<h2 style="margin-top:0;"> 
			<a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $fr['usersid'] ?>" style="font-size:16px;" class="floatLeft allFrdA">
			<?php echo $fr['first_name'].'&nbsp'.$fr['last_name'];?>
			</a>
			<span style="color: rgb(102, 102, 102); float: left; display: block; padding-top: 4px; font-weight: 300; font-size: 12px; padding-right: 5px; padding-left: 4px;"> 
			owns
			</span>
			<a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $fr['usersid'] ?>" class="floatLeft allFrdA" style="font-size:16px;"> <?php echo $fr['make'].'&nbsp'.$fr['model'];?>
			</a>
			</h2>
			</hgroup>
			<p class="clear"><?php echo $fr['gendor'] ?> <?php if(!empty($fr['DOB'])) { $nowdate = date('Y'); $year = explode("-",$fr['DOB']);$age =$nowdate-$year[2]; echo $age; } ?> from <?php echo $fr['city'].'&nbsp'.$fr['state']; ?><br/><?php echo $fr['occupation'] ?> at <?php echo $fr['course'].'&nbsp'.$fr['college']; ?></p>
			<hgroup><h4> <?php echo $fr['flashes'];?> flashes | <?php echo $res[0]['countacces'];  ?> custom accessories</h4></hgroup>
			</div>
			</section>
			<div class="btn-box" style="position:relative" id="confirmrequest" >
			<a href="javascript:void(0);"onclick="return confirm_request(<?php echo $fr['usersid']; ?>);" id="a-<?php echo $fr['usersid']?>" >Confirm</a>
			<a href="javascript:void(0);" onclick="return delete_request(<?php echo $fr['usersid']; ?>);"  id="b-<?php echo $fr['usersid']?>" >Delete</a>
			</div> 
			</article> 
			<?php }} ?>
				
				
				
				
				
				
				
				<div id="hideaftresearch">
				<?php if(!empty($friendlist)){foreach($friendlist as $fs){ ?>
				<article id="unfriend-<?php echo $fs['usersid']; ?>">
                <figure class="riderFig1">
				<a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $fs['usersid'] ?>" >	
				<img src="<?php echo base_url(); ?>uploads/gallery/small/<?php echo $fs['profile_pic']; ?>" alt="user" width="93" height="93" />
				</a>
				</figure>
                <figure class="riderFig2">
				<a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $fs['usersid'] ?>" >		
				<img src="<?php echo base_url(); ?>uploads/gallery/thumb/<?php echo $fs['image']; ?>" alt="user" width="208" height="93" />
				</a>
				</figure>
                 <section class="secRider1">
				<?php
				$query = $this->db->query("Select count(*) as countacces from accessories  where user_id ='". $fs['username']."'"); 
				$res = $query->result_array();
				?>
				 
                  <div class="divRider">
                    <hgroup>
					<h2 style="margin-top:0;">
					<a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $fs['usersid'] ?>" style="font-size:16px;" class="floatLeft allFrdA">
					<?php echo $fs['first_name'].'&nbsp'.$fs['last_name'];?>
					</a>
					<span style="color: rgb(102, 102, 102); float: left; display: block; padding-top: 4px; font-weight: 300; font-size: 12px; padding-right: 5px; padding-left: 4px;"> 
					owns
					</span>
					<a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $fs['usersid'] ?>" class="floatLeft allFrdA" style="font-size:16px;"> <?php echo $fs['make'].'&nbsp'.$fs['model'];?>
					</a>
					</h2>
					</hgroup>
                    <p class="clear"><?php echo $fs['gendor'] ?> <?php if(!empty($fs['DOB'])) { $nowdate = date('Y'); $year = explode("-",$fs['DOB']);$age =$nowdate-$year[2]; echo $age; } ?> from <?php echo $fs['city'].'&nbsp'.$fs['state']; ?><br/><?php echo $fs['occupation'] ?> at <?php echo $fs['course'].'&nbsp'.$fs['college']; ?></p>
                    <hgroup><h4> <?php echo $fs['flashes'];?> flashes | <?php echo $res[0]['countacces'];  ?> custom accessories</h4></hgroup>
                  </div>
                </section>
                <div class="btn-box" style="position:relative">
                <!---------html edit - 17 edit 2014--------------->
                <a onclick="return unfriend(<?php echo $fs['usersid']; ?>);" href="javascript:void(0);" id="optionAddFrdFlashBtn-<?php echo $fs['usersid'] ?>" class="optionAddFrdFlashBtn friendsOptionBtn">Unfriend</a>
                </div>
              </article>
				<?php }} ?>
				</div>
				  
             </section>
          </article><!---------close articlesearchPeopleDetails--------->
          
       </article><!---------close article rider-journey-people----------->
       
    </section><!---------close section----------->


			
		
    


