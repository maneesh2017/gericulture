<?php 
			  if(!empty($bride)){ 
			  //see($bride);
			  foreach($bride as $pr){
				  $flashes=getFlashes($pr['user_id']); 	
				  $getCover=getCover($pr['user_id'],'thumb');
				  $getProfilePic=getProfilePic($pr['user_id'],'small');
				  $getListVehicleBrand=getListVehicleBrand($pr['type'],1);
				
			?>
			  <article class="browseRideSingle">
                <figure class="riderFig">
                   <a href="<?php echo base_url(); ?>profile/<?php echo $pr['user_id']; ?>">
                        <img src="<?=$getCover?>" alt="user" width="258" height="114" />
                    </a>                    
                </figure>
                
                 <section class="secRider">
                  <div class="divRider">
                    <hgroup><h2 class="pbCode"><a href="<?php echo base_url(); ?>profile/<?php echo $pr['user_id']; ?>" class="rideA">
			<?php echo $getListVehicleBrand[$pr['make']].' '; $model=getModelText($pr['model'],$pr['type']);echo ucwords($model) ?> - <?php echo strtoupper( $pr['username']);?></a></h2></hgroup>
                    <hgroup><h4><?=$flashes?> flash<?php if($flashes!=1){echo 'es';}?></h4>
                    	<? if ( ($pr['city' ] !='') ||  ($pr['state' ] !='')) {?><h3 class="browsectst"><? $getStateList=getStateList(); ?>
					<?  if ( ($pr['city' ] !=''))  
					echo cityNameFromId($pr['city']).', '; ?>
					<? echo $getStateList[$pr['state']];?> </h3><? }?>
					</hgroup>
                    <hgroup><h3 class="brnmgdag">
					<a href="<?php echo base_url(); ?>profile/<?php echo $pr['user_id']; ?>">					
					<?php echo ucwords($pr['first_name'].' '.$pr['last_name']);?></a>, 
					<span style=""><?=ucfirst($pr['gendor'])?>
					 <?php if($pr['DOB']!='0000-00-00'){ echo age_from_dob($pr['DOB']); }?></span></h3><?php //'<p style="font-size:10px;">'.getaddress($pr['lat'],$pr['lng']).'</p>';?></hgroup>
                  </div>
					<figure class="flashImg2">
                    <a href="<?php echo base_url(); ?>profile/<?php echo $pr['user_id']; ?>">
						<img src="<?=$getProfilePic?>" width="50" height="50" />
                    </a>
                   </figure>
                </section>
              </article>

              <?php }}?>
			  