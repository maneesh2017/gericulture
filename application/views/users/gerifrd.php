<!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.barrating.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/edit.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.colorbox-min.js"></script>-->
<script type="text/javascript"> 	 
$(document).ready(function(){
$('a.floatRight').click(function() { 
$('#hideli-'+this.id).hide(); 
});

});
</script>
<!----------start-view all in geri circle-------------->
 <div id="geriFrdCirclePopUp" class="popup_content" style="display:block" > 
 <!--<span class="button b-close"><span>X</span></span>-->
       <header>  
         <hgroup><h1><?php if(!empty($countgfnd[0]['Totalfrd'])){echo $countgfnd[0]['Totalfrd'];} ?> Friends in Geri Circle</h1></hgroup>
         <p>(people who can be seen on geri in this vehicle and are allowed to ride/drive it)</p>
<!--<a href="#" class="addFrdGeriCircle">Add friend to Geri Circle</a>-->
       </header>
       <section id="formTable1">
	   
          <ul>
		  <?php 
		   if(!empty($gerifriendlist)){ foreach($gerifriendlist as $gfl){
			$result = $this->db->query("Select count(*) as countacces from accessories  where user_id ='".$gfl['usersid']."'");
	        $cacessries = $result->result_array();  
			  
			  
		  ?>
            <li id="hideli-<?php echo $gfl['usersid']; ?>"> 
              <figure class="floatLeft">
                <a href="<?php echo base_url();?>user/aboutOthers/<?php echo $gfl['usersid'] ?>" rel="about-me">
                <img src="<?php echo base_url(); ?>uploads/gallery/small/<?php echo $gfl['profile_pic']; ?>" alt="pic" class="floatLeft marginRyt1" width="75" height="75" />
                </a>
                <a href="<?php echo base_url();?>user/aboutRidesother/<?php echo $gfl['usersid'] ?>" rel="rides">
                <img src="<?php echo base_url(); ?>uploads/gallery/thumb/<?php echo $gfl['image']; ?>" alt="pic" class="floatLeft" width="167" height="75" />
                </a>
              </figure>
              <section class="floatLeft">
                <hgroup>
				<h3 class="marginTopMinus5">
				<a href="<?php echo base_url();?>user/aboutOthers/<?php echo $gfl['usersid'] ?>"><?php echo $gfl['first_name'].'&nbsp;'.$gfl['last_name'];  ?>
				</a> 
				<span>owns</span>  
				<a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $gfl['usersid'] ?>"> <?php if(!empty($gfl['make'])){ echo $gfl['make'].'&nbsp'; } if(!empty($gfl['model'])){ echo $gfl['model'];} ?>
				</a> 
				</h3>
				</hgroup>
                <span class="paddingBottom3 marginTopMinus2">
				<?php if(!empty($gfl['gendor'])){ echo $gfl['gendor'];} ?> <?php if(!empty($gfl['DOB'])){ $nowdate = date('Y'); $year = explode("-",$gfl['DOB']);$age =$nowdate-$year[2]; echo $age;}?> from 
				<?php echo $gfl['city'];?>,<?php echo $gfl['state']; ?> </span>
                <p><?php echo $gfl['flashes'];?> flashes | <?php if(!empty($cacessries[0]['countacces'])) { echo  $cacessries[0]['countacces']; }else{echo "0";} ?> custom accessories</p>
              </section> 
              <a class="crossFrdBtn1 floatRight" href="javascript: void(0);" id="<?php echo $gfl['usersid'] ?>" >delete</a>
            </li>

			<?php }} ?>
            
          </ul>
       </section>
      </div>
<!---------end-popup frd in geri circle------------->  	   
