<!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.barrating.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/edit.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.colorbox-min.js"></script>-->
<!----------edit speaker popup--------------> 
<div id="speakerPopUp" class="popup_content" style="display:block" >  
  <!--<span class="button b-close"><span>X</span></span>-->
       <header>
         <hgroup><h1><?php if(!empty($blownhorns[0]['horn'])){echo $blownhorns[0]['horn'];} ?> horns blown</h1></hgroup>
         <a href="#" class="complimentBtnLink"><?php if(!empty($countcompliment[0]['compcount'])){echo $countcompliment[0]['compcount'];} ?> compliments</a>
       </header>
       <section id="editSpeakerForm"> 
          <ul>
		  
          <?php  
			    if(!empty($blowhorndata)){ foreach($blowhorndata as $cdata){ 
				$query = $this->db->query("Select * from users where id ='". $cdata['user_id']."' ");   
				$complres = $query->result_array();						
				$newquery = $this->db->query("SELECT ride_images.image,rides.make,rides.model FROM ride_images JOIN rides ON ride_images.ride_id = rides.id  WHERE ride_images.user_id ='".$complres[0]['username']."'");
	    		$imageres = $newquery->result_array(); 
			 ?> 
           <li>
            <a href="<?php echo base_url();?>aboutOthers/<?php echo $complres[0]['id']; ?>">
            <img src="<?php echo base_url();?>uploads/gallery/small/<?php echo $complres[0]['profile_pic']; ?>" alt="user" class="floatLeft marginRyt1" width="38" height="38" /></a>
            <a href="<?php echo base_url();?>aboutRidesother/<?php echo $complres[0]['id']; ?>">
            <img src="<?php echo base_url();?>uploads/gallery/small/<?php echo $imageres[0]['image']; ?>" alt="rider" class="floatLeft" width="86" height="38" /></a>
            <div class="floatLeft">
              <h1 class="marginTop3"><a href="<?php echo base_url();?>aboutOthers/<?php echo $complres[0]['id']; ?>"><?php echo $complres[0]['first_name'].'&nbsp'.$complres[0]['last_name'];?></a></h1>
              <p class="marginTop1"><a href="<?php echo base_url();?>aboutRidesother/<?php echo $complres[0]['id']; ?>"><?php echo $imageres[0]['make'];?> - <?php echo $imageres[0]['model']; ?></a></p>
            </div>
            <a href="#" class="addAsFlashBtn floatRight">f</a>
            <a href="#" class="addAsFrdBtn floatRight">+</a>
           </li>
            <? }} ?>
          </ul>
       </section>
    </div>   
<!---------end speaker-popup-------------->	   
