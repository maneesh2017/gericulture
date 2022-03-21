 <?php
 $getFamousFlashes=getFamousFlashes();
 ?>
         <div class="about-famous-rides">
            <header>
             <hgroup class=""><h2 style="">Famous rides</h2></hgroup>
            </header>
            

            <?php foreach( $getFamousFlashes as $k=>$v ){
			$getCover=getCover($v['friendid'],'thumb');
			$getProfilePic=getProfilePic($v['friendid'],'thumb'); 
			?>
            
            <div class="">
            <a href="<?php echo site_url()?>profile/<? echo $v['friendid']; ?>"><img src="<?php echo $getCover;?>"  width="308" /></a>
            
            <div class="trans-famous-about">
            <h2><a href="<?php echo site_url()?>profile/<? echo $v['friendid']; ?>"><?php if(!empty($v['make'])){$getListVehicleBrand=getListVehicleBrand($v['type'],1);
 				echo $getListVehicleBrand[$v['make']];}  ?> <? $model=getModelText($v['model'],$v['type']); echo ucwords($model); ?></a></h2>
            <p><?php echo $v['count']; ?> unique flashes</p>
            </div>
            
            <figure class="famousImg2">
                    <a href="<?php echo site_url()?>profile/<? echo $v['friendid']; ?>">
						<img width="68" height="68" src="<?php echo $getProfilePic;?> ">
                    </a>
                   </figure>
            </div>
			<?php }?>

			
			
            
         </div>