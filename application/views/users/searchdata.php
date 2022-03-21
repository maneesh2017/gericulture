			 <ul class="subMenuMain3 positionAbs" style="left:63px;">	
			 <?php if(!empty($gerifriendlist)) { foreach($gerifriendlist as $gfl){ ?>
					<li>
						<a href="<?php echo base_url() ?>user/aboutOthers/<?php echo $gfl['usersid'] ?>">
                          <img class="floatLeft" alt="user" src="<?php echo base_url();?>uploads/gallery/verysmall/<?php echo $gfl['profile_pic'] ?>" height="38" width="38" >
                           <div class="floatLeft">
                              <h1 class="marginTop3 colorRed"><?php echo $gfl['first_name'].'&nbsp;'.$gfl['last_name'];  ?></h1>
                              <p class="marginTop2 color666"><?php echo $gfl['username']?> - <?php echo $gfl['make']?></p>
                           </div>
                           <img class="floatRight" alt="car" src="<?php echo base_url();?>uploads/gallery/verysmall/<?php echo $gfl['image'] ?>" height="38" width="86"  >
                         </a>
                     </li>   		
             <?php  }}  ?>
			 </ul>
