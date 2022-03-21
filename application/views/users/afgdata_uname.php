<?php if(!empty($friendlist)) {?>


                      
             <ul class="subMenuMain3 positionAbs" style="right:160px;">	
			 <?php  foreach($friendlist as $gfl){ 
			 
			 $pPicPath=getProfilePic($gfl['user_id'],'small');
			 $coverPic=getCover($gfl['user_id'],'small');
			
			 $getListVehicleBrand=getListVehicleBrand();
			?>
					<li>
						<a href="<?php echo base_url() ?>user/aboutOthers/<?php echo $gfl['user_id'] ?>">
                          <img class="floatLeft" alt="user" src="<?=$pPicPath?>" height="38" width="38" >
                           <div class="floatLeft">
                              <h1 class="marginTop3 colorRed"><?php echo $gfl['first_name'].'&nbsp;'.$gfl['last_name'];  ?></h1>
                              <p class="marginTop2 color666"><?php echo $gfl['username']?> - <?=$getListVehicleBrand[$gfl['make']]?></p>
                           </div>
                           <img class="floatRight" alt="car" src="<?=$coverPic?>" height="38">
                         </a>
                     </li>   		
             <?php  }  ?>
			 </ul>
<?php }  ?>