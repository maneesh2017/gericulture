<?php //see($Userdetail);
//$getListVehicleBrand=getListVehicleBrand();?>
				<ul class="subMenuMain1 positionAbs">
					 <?php if(!empty($friendlist)) { foreach($friendlist as $gfl){ 
					 
						 $profile_pic=getProfilePic($gfl['usersid'],'verysmall');
						 $ride_pic=getCover($gfl['usersid'],'verysmall');
						 
					$getListVehicleBrand=getListVehicleBrand($gfl['type'],1);
					$brand=$getListVehicleBrand[$gfl['make']];
					$model=getModelText($gfl['model'], $gfl['type']);
					?>	
                        <li class="search-dropdown"> 
                         <a href="<?php echo base_url() ?>profile/<?php echo $gfl['usersid'] ?>">                          
                           <img src="<?=$ride_pic?>" alt="car" class="floatLeft" />
                           <img src="<?=$profile_pic?>" alt="user" class="floatLeft marginRyt1" style="height:38px; margin-left:1px; margin-right:0;"/>
                           <div class="floatLeft">
                              <h1 class="marginTop2"><?php echo strtoupper( $gfl['username']); ?></h1>
                              <p><?php if($gfl['make']!=''){echo $brand.' '.$model;}?></p>
                           </div>
                         </a>
                        </li> 
                        <?php  }}else{  ?><li style="border-bottom: 1px solid hsl(0, 0%, 80%); font-size: 13px; padding: 10px 10px;">No result found</li><?php } ?>
                        <li class="justViewAll_1"><p><a href="<?php echo base_url(); ?>user/browserides?vehicle_number=<?=$queryString?>&vehiclenumber=3&age_range=0&state=<?=$Userdetail['state']?>&city=<?=$Userdetail['city']?>&first_name=&sur_name=&gender=0&email=&type=0&year_model=&brand=0&model=0&km=30&locationSearch=0&submit=Update">View All </a></p></li>
                      </ul>
  
