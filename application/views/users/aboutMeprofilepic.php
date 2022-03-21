<?php
$thumbSizes=thumbSizes('user');

//output image
/*$rImageW=$thumbSizes['thumb']['width'];
$rImageH=$thumbSizes['thumb']['height'];*/

$rImageW=600;
$rImageH=600;

$aspectRatio=$rImageW.':'.$rImageH;

//Image element
/*$eImageW=200;
$eImageH=200;*/
$eImageW=552;
$eImageH=350;
?>


<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>js/crp/crp.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="<?=system_path()?>js/crp/jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="<?=system_path()?>js/jquery.form.min.js"></script>

<script type="text/javascript">
var page='<?=$page?>';
//output image
//var rImageW=<?=$rImageW?>;
var rImageW=<?=$rImageW?>;
var rImageH=<?=$rImageH?>;

//Image element
var eImageW=<?=$eImageW?>;
var eImageH=<?=$eImageH?>;

//uploaded image
var imageW=0;
var imageH=0;

function preview(img, selection) { 
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 


var demo_pic_src='<?php echo $this->config->item('system_path'); ?>img/demo-pic.png';
$(document).ready(function (e) {
	
	 //window.parent.$('#ppic').hide();
	
	$('#cpiframe-Btn').click(function(){
		  $('#picture').trigger('click');
		  });
	
	if (window.File && window.FileReader && window.FileList && window.Blob)
		  {}
		  else
		  {
			  $('.uploadPhotoBtn').hide();
			  alert("Please upgrade your browser, because your current browser lacks some new features we need!");
			  return false;
		  }
	
	
	var progressbox     = $('#progressbox');
	var progressbar     = $('#progressbar');
	var statustxt       = $('#statustxt');
	var completed       = '0%';
	
	
	var options = { 
			//target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			uploadProgress: OnProgress,
			success:       afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		};
		
		
	$('#editprofilePicForm').submit(function() { 
			$('.sec3').hide();
			$(this).ajaxSubmit(options);  			
			// return false to prevent standard browser submit and page navigation 
			return false; 
		});		
		
		//when upload progresses	
	function OnProgress(event, position, total, percentComplete)
	{
		statustxt.html(percentComplete + '%'); //update status text
	}	
	
	//after succesful upload
	function afterSuccess(data)
	{
		    $('#profilemeter').css("display", "none");	
			
			if(page=='profile')
				window.parent.$("#passportPhoto").attr('src',data);
			else if(page=='photo')	
				{
				  window.parent.$('#searchPeopleDetails').removeClass('myPhotosEmpty');
				  window.parent.$('.showAfterUpload').show();
		          window.parent.$('.removeAfterImageUpload').hide();
				  window.parent.$('section#photoGalleryMe > ul').prepend(data);
				  window.parent.$("#photoGalleryMe a").photoSwipe(
						{
							enableMouseWheel: false,
							enableKeyboard: false
						});
				}

			successBar('Profile image changed successfully');
			setTimeout ( function(){ 
			window.parent.$('.b-modal').bPopup().close();
			window.parent.$('#popup2').bPopup().close();
			window.parent.$('#popup2 > .content').html(' ');
			},4200);
	}
	
	//function to check file size before uploading.
	  function beforeSubmit(){
		  //check whether browser fully supports all File API
		 if (window.File && window.FileReader && window.FileList && window.Blob)
		  {
	  
			  //Progress bar
			  progressbox.show(); //show progressbar
			  progressbar.width(completed); //initial value 0% of progressbar
			  statustxt.html(completed); //set status text
			  statustxt.css('color','#000'); //initial color of status text
	  
			$('#profilemeter').css("display", "block");
			$('#deleteimg').hide();
			
		  }
		  else
		  {
			  //Output error to older unsupported browsers that doesn't support HTML5 File API
			  alert()("Please upgrade your browser, because your current browser lacks some new features we need!");
			  return false;
		  }
	  }
		
	
	$("#picture").change(function() {
			
			$('.error-signin').hide();
			
            if (this.files && this.files[0]) 
			{
					if(!checkFileExt($(this).val()))
					  {
						   //$('.error-signin').html("Invalid File");
						  // $('.error-signin').show();
						    errorBar("Only .jpg, .jpeg or .png files are allowed");
					  }
					  else if(!checkFileSize($(this)[0].files[0].size))
					  {
						   //$('.error-signin').html("Please select file less than 5MB");
						   //$('.error-signin').show();
						   errorBar("Please select file less than 5MB");
					  }
					  else
						   imageSize(this.files[0],rImageW);
			}
        });
	
	
	function imageSize(image,imgWidth)
		{
			var _URL = window.URL || window.webkitURL;
			var file, img;
		    if ((file = image)) 
			{
        		img = new Image();
        		img.onload = function () 
				{
    	        	//alert(this.width + " " + this.height);
					imageW=this.width ;
					imageH=this.height;
					
					  if(this.width>=imgWidth)
					  {
						   var reader = new FileReader();
				  			reader.onload = imageIsLoaded;			      
                  			reader.readAsDataURL(image);
					  }
					  else
					  {
							 // $('.error-signin').html("Please upload minimum 200px width image");
							  //$('.error-signin').show();
							  errorBar("Upload image that is minimum 600px wide");
					  }
        		};
        		img.src = _URL.createObjectURL(file);
    		}
			
		}
	
	
	function imageIsLoaded(e) {  
	
		 $('.uploadPhotoBtn').hide();
		 $('.sec3').css("display", "block");
		 $(".sec1").addClass("imageadd");
		 $('.sec1 imageadd').css("display", "none");
         //$('#previewimg').attr({src:e.target.result,width:980, height:435});
		 $('#previewimg').attr({src:e.target.result,width:eImageW}).show();
		 $('#uploadPhotoSecInstruction').hide();
		 $('#UploadPhotoSecProfile').css({'padding':0,'width':eImageW});
		
		if(imageW>imageH)
				var w=eImageW;
		else
				var w=eImageH;
		
		var h=eval(w*(imageH/imageW));
     	$('#previewimg').attr({width:w});
		
			$('#h_ori').val(h);
			$('#w_ori').val(w);
			
		if(h>w)
			h1=w1=w;
		else
			h1=w1=h;	
		
		setTimeout(function(){
			$('#previewimg').imgAreaSelect({ aspectRatio:'<?=$aspectRatio?>', onSelectChange: preview ,x1: 0, y1: 0, x2: w1, y2: h1,persistent:true });  			
			
			$('#x1').val(0);
			$('#y1').val(0);
			$('#x2').val(w1);
			$('#y2').val(h1);
			$('#w').val(w1);
			$('#h').val(h1);
			
			},500);
		
	    };
	
	 $("#deleteimg").click(function() {
		 $('#previewimg').imgAreaSelect({ remove:true,hide:true }); 
		 $('#previewimg').removeAttr('height');
		 $('#previewimg').removeAttr('width');
		 $('#previewimg').removeAttr('src');
		 $('.uploadPhotoBtn').show();
         $('.error-signin').css("display", "none");
         $('.sec3').css("display", "none");
		 $(".sec1").removeClass("imageadd");
         $('#picture').val("");
		 
		 $('#previewimg').hide();
		$('#UploadPhotoSecProfile').css({'padding':'40px 0 0 52px','width':500});
		$('#uploadPhotoSecInstruction').show();
	}); 
	
	
		$('#choosePhotoCover').click(function(){
			 
			 $('#uploadPicHeading').hide();
			 $('#choosePicHeading').show();
			 
			  $('.sec3').css("display", "block");
			  $('#deleteimg, #coverPicUpdateMeter,#coverPicUpdateBtn').hide();
			  $('.coverPicUpdateMeterChoose').show();
			  
			  $('#UploadPhotoSecProfile').hide();
			  $('.uploadPhotoSec').css('margin-top',0);
			 
			   $.ajax({
				   url:'<?=site_url()?>photo/chooseFromPhotoList/2',
				   success:function(data)
						{
							$('#updateProfilePicForm').prepend(data);
						}
				   });
		});
		
		$('#choosePicHeading').click(function(){
			 coverPicId=0;
			 $('#uploadPicHeading').show();
			 $('#choosePicHeading').hide();
			 
			 $('.sec3').hide();
			 $('#deleteimg, #coverPicUpdateMeter, #coverPicUpdateBtn').show();
			 $('.coverPicUpdateMeterChoose').hide();
			 
			 $('#UploadPhotoSecProfile').show();
			 $('.uploadPhotoSec').css('margin-top',50);
			 $('.chooseProfilePic').remove();
			});
			
		var coverPicId=0;
		$('#updateProfilePicForm').on('click','.chooseProfilePic li',function(){
				$('span.selectedPicFrame').hide();
				$(this).find('span.selectedPicFrame').show();
				coverPicId=$(this).attr('id').split('-')[1];
			});	
			
		$('#coverPicUpdateBtnChoose').click(function(){
			window.parent.$('#errorBar, #successBar').remove();
			
				if(coverPicId==0)
					errorBar('Please select an image');
				else
				{
					$('#covermeter').show();
					$('.sec3').hide();
					window.parent.$('#choosePicProgress').show();
					window.parent.$('#popup2').css('z-index',9997)
					
					$.ajax({
						url:'<?=site_url()?>photo/chooseFromPhotoListSubmit/2',
						data:{id:coverPicId},
						type:'POST',
						success:function(data)
							{
								if(data=='LO')
			     				  window.parent.location=site_url;	  
							else  
								{
									if(data!=0)
									{
										if(page=='profile')
										{
											window.parent.$('#passportPhoto').attr('src',data)
										}
										
										successBar('Profile image changed successfully');
										setTimeout ( function(){ 
									   window.parent.$('#choosePicProgress').hide();
									   window.parent.$('.b-modal').bPopup().close(); 
									   window.parent.$('#popup2').bPopup().close();			
									   window.parent.$('#popup2 > .content').html(' '); 
										 },4200);
									}
								}
							}
						});
				}	
					
			});			
	
});
</script>
 <!---------start-update Profile pic popup-------------->
 <div id="profilePicUpdate" class="popup_content" style="display:block; position:relative;">
   <!--<span class="button b-close"><span>X</span></span>-->
       <header>
         <hgroup><h1 id="uploadPicHeading">Change your profile pic</h1> <h1 id="choosePicHeading" style="display:none;">Back</h1></hgroup>
         <p class="b-close"><img src="<?php echo $this->config->item('system_path');?>img/close-icon-pop.png"></p>
         <p style="display: none;" class="error-signin"></p>
       </header>
	  
       <section id="updateProfilePicForm">
	   <form method="post" action="<?=site_url()?>user/editprofilepic" id="editprofilePicForm" class="updateProfilePicForm-popss" style="position:relative;" enctype="multipart/form-data">
	   <input type="hidden" name="page" value="<?=$page?>" />
       
            <div class="uploadPhotoSec">
              <!-- <figure>
               <?php if(!empty($Userdata[0]['profile_pic'])){ ?>
			   <img alt="user" src="<?php echo base_url(); ?>uploads/gallery/thumb/<?php echo $Userdata[0]['profile_pic'] ?>"  id="previewimg" >
			   <?php }else{ ?>
               
			   <img alt="user" src="<?php echo $this->config->item('system_path'); ?>img/demo-pic.png" id="previewimg"> 
			   <?php } ?>
              </figure>
               <p>Upload your photo that will be used as your profile photo</p>
               <span>Image should be at least 600px wide</span><br/>             
			 <div> 
               <section class="uploadPhotoBtn">
               <label for="picture" class="fileBtn3">Upload photo</label>
               <input type="file" id="picture" name="picture">
              </section><br/>
           <span id="filename"></span> 
            </div>-->
  
            
            
            <div id="UploadPhotoSecProfile" class="uploadPhotoSec floatLeft">
          <figure>
            <img style="display:none;" alt="user" src="" id="previewimg">
          	</figure>
            <div id="uploadPhotoSecInstruction">
                <h1>UPLOAD YOUR IMAGE TO USE AS A PROFILE PIC</h1>
                <p>Make sure image is at least 600px wide</p>
                <a class="small about-text-upload-banner" id="cpiframe-Btn">Upload profile pic</a>
            <!--<label class="fileBtn1 chnage1 about-text-upload-banner " for="photo">Upload profile pic</label>-->
			<?php $user=userSession();
			         $id=$user['id'];
			$noOfImages=getImageCount($id,1);
			if($noOfImages>0){
			     ?>
            <a class="about-text-choose-photo" id="choosePhotoCover">Choose from photos</a>
			<?} ?>
             <input type="file" name="picture" id="picture" style="display:none;">
            <span id="filename1"></span>
          </div>
        </div>
        
        			<section class="sec3 hideSec3" style="display:none">
             <a id="deleteimg" href="#">Upload different photo</a>
            <input type="submit" value="Done" id="coverPicUpdateBtn"  >
          <span style="display: none;" id="profilemeter"><img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif"></span>  
          
          <p class="coverPicUpdateMeterChoose" style="display:none">
              <input type="button" class="closePoP" id="coverPicUpdateBtnChoose" value="Done">
            </p>
            
         	</section>		    
            <div id="progressbox" style="display:none;"><div id="progressbar"></div><div id="statustxt">0%</div></div> 
            
        </div>
		
		        <input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
                <input type="hidden" name="w_ori" value="" id="w_ori" />
				<input type="hidden" name="h_ori" value="" id="h_ori" />
        </form>		  
       </section>
	 </div>
<!---------end update profile pic popup-------------->  

	   
