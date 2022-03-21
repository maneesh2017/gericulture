<?php
$coverPic=getCover($Userdetail['id'],'small');
$profilePic=getProfilePic($Userdetail['id'],'small');

$getPicCompCount=getPicCompCount($pic_id);
$getPicHorns=getPicHorns($pic_id);
?>

<script src="<?php echo $this->config->item('system_path');?>js/edit.js"></script>
<script type="text/javascript">
 $(document).ready(function (e) {
	
	var defaultValue = $('#replycom').val();
	
		$('#complimntPopUp').on('submit','#replycomp',(function(e){
		e.preventDefault();
		var replycompl = $('#replycom').val();
		var photo_id = $('#photo_id').val();
		
			  if(replycompl.trim()!='' && replycompl.trim()!=defaultValue) 
			  {
				  $('#replycom').val(defaultValue);
					  $.ajax({
						  url: site_url+'watchfriends/postcomplnt',
						  type: "POST",
						  data:'complt='+ replycompl +'&photo_id='+ photo_id,
						  success: function(data)
						  {
							  if(data=='LO')
								window.parent.location=site_url;
								else
								{	
							  	 	$('#complimntPopUp').load(site_url+'user/otherscomplnt/'+photo_id+' #complimntPopUp > *');
							  		window.parent.$('#ocomplimntpopup').text('Compliments ('+data+')'); 
								}
						  },
						  error: function() 
						  {
						  } 	        
					 });
			  }
	}));
});	
</script>
<div id="complimntPopUp" class="popup_content" style="display:block" >
<!--<span class="button b-close"><span>X</span></span>-->   
       <header>
         <hgroup><h1><?=$getPicCompCount?> compliment<?=s($getPicCompCount)?></h1></hgroup>
         <a href="javascript:void(0);" class="speakerBtnLink"><span class="speakerIconWhite"></span><?=$getPicHorns?></a>
       </header>
       <section id="editComplimntForm">
		  <section class="enterComlimnt">
			  
            <ul>			
             <li>
               <a href="<?php echo base_url();?>user/aboutMe" target="_blank"><img src="<?=$profilePic?>" class="floatLeft marginRyt1" alt="user" height="38" /></a>
               <a href="<?php echo base_url();?>ride/about" target="_blank"><img src="<?=$coverPic?>" class="floatLeft marginRyt2" alt="rider" height="38" /></a>
                <form method="post" id="replycomp" name="replycomp" >
			 	<input type="hidden"  value="<?php echo $pic_id; ?>" name="photo_id" id="photo_id" />	
               <input type="text" class="inputSky floatLeft" value="Reply to a compliment..." name="replycom" id="replycom" />
               <input type="submit" class="floatLeft enter-btn1">
                </form >
             </li>
            </ul>
          </section>
          <section class="complimntDetails">
             <ul>
				<?php 
				if(!empty($complements)){
					foreach($complements as $comp){ 
						
						$pPicPath=getProfilePic($comp['user_id'],'small');
						$cPicPath=getCover($comp['user_id'],'small');
							
						$getHornsC=getHornsC($comp['id']);
						if($getHornsC==0)
							$getHornsC='';
	    			
			    ?> 
              <li>
                 <figure class="floatLeft">
                  <a href="<?php echo base_url();?>user/aboutOthers/<?=$comp['user_id']?>" target="_blank"><img src="<?=$pPicPath?>" class="floatLeft marginRyt1" alt="user" height="38" /></a>
                  <a href="<?php echo base_url();?>user/aboutRidesother/<?=$comp['user_id']?>" target="_blank"><img src="<?=$cPicPath?>" class="floatLeft marginRyt2" alt="user" height="38" /></a>
                 </figure>
                <article class="floatLeft">
                  <div class="floatLeft">
                    <p><strong><?php echo $comp['first_name'].'&nbsp'.$comp['last_name'];?>:</strong> <?=$comp['compliment']?></p>
                    <a href="javascript:void(0);" class="blowHornC <?php if(ifHornCBlowed($comp['id'],$Userdetail['id'])){echo 'blur';}?>" id="blowHornC-<?=$comp['id']?>">Blow Horn</a>
                  </div>
                  <p class="floatRight"><a href="javascript:void(0);" ><span class="speakerIconRed" <?php if($getHornsC==''){?>style="display:none;"<?php } ?>></span><span id="blowHorncNum-<?=$comp['id']?>"><?=$getHornsC?></span></a></p>
                </article>
              </li>
              <?php }} ?>
             
             </ul>
          </section>
       </section>
     </div>  
