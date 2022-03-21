<?php
//$getListVehicleBrand=getListVehicleBrand();?>
				
					 <?php if(!empty($cities)) { ?> 
					 <ul class="subMenuMain1 positionAbs" style="">
					 <?php foreach($cities as $gfl){ 
					 if(ucfirst( $gfl['r3'])!=ucfirst( $gfl['locality']))
					 	$district=', '.$gfl['r3'];
					else
					    $district	='';
					?>	
                    
                        <li class="citygest search-dropdown"> 
                         <a href="javascript:citySelected(<?=$gfl['id']?>,'<?=$gfl['locality']?>');">
                              <h1 class="marginTop2"><?=ucfirst($gfl['locality']).$district; ?></h1>
                         </a>
                        </li> 
                        
                        <?php  }?>
						</ul>
						<?php }else{  ?><p  class="noResultsCitySugg">No result Found</p><?php } ?>
                       
  
