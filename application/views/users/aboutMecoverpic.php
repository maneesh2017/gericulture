<?php
$thumbSizes=thumbSizes('ride');

//output image
$rImageW=$thumbSizes['large']['width'];
$rImageH=$thumbSizes['large']['height'];

$aspectRatio=$rImageW.':'.$rImageH;

//Image element
/*$eImageW=880;
$eImageH=400;*/

$eImageW=694;
$eImageH=400;
?>

<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>js/crp/crp.css" />
<script type="text/javascript" src="<?=system_path()?>js/crp/jquery.imgareaselect.min.js"></script>

    
<script type="text/javascript">
var page='<?=$page?>';
//output image
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

$(document).ready(function () { 

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
		
	$('#editCoverPicForm').submit(function() { 
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
		$('#covermeter').css("display", "none");
		if(page=='profile')
		{
			window.parent.$('article#coverPicwithDetails > div.positionRel').html(data);
			
			$('#coverPicHoverEffect, #changeCoverImg').mouseenter(function()
				{
					$('#changeCoverImg').show();
				});
		}
		else if(page=='photo')	
		{ window.parent.$('#searchPeopleDetails').removeClass('myPhotosEmpty'); 
		  window.parent.$('.showAfterUpload').show();
		  window.parent.$('.removeAfterImageUpload').hide();
		  window.parent.$('section#photoGalleryMe > ul').prepend(data);
		  window.parent.$("#photoGalleryMe a").photoSwipe(
				{
					enableMouseWheel: false,
					enableKeyboard: false
				});
		}
			
		  successBar('Banner changed successfully');
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
	  
			$('#covermeter').css("display", "block");
			$('#deleteimg').hide();
			
		  }
		  else
		  {
			  //Output error to older unsupported browsers that doesn't support HTML5 File API
			  alert("Please upgrade your browser, because your current browser lacks some new features we need!");
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
						  // $('.error-signin').html("Please select file less than 5MB");
						  // $('.error-signin').show();
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
							 // $('.error-signin').html("Please upload minimum 980px width image");
							 // $('.error-signin').show();
							  errorBar("Upload image that is minimum 980px wide");
							  
					  }
        		};
        		img.src = _URL.createObjectURL(file);
    		}
			
		}
	
			
	function imageIsLoaded(e) {        
          
		 $('#preview').css("display", "block");
         $('.sec3').css("display", "block");
		 $(".sec1").addClass("imageadd");
		 $('.sec1 imageadd').css("display", "none");
         //$('#previewimg').attr({src:e.target.result,width:980, height:435});
		 $('#previewimg').attr({src:e.target.result,width:eImageW});
		
		var h=eval(eImageW*(imageH/imageW));
		/*if(h>eImageH)
			{
				$('#previewimg').removeAttr('width');
				$('#previewimg').attr({height:eImageH});
				var w=eval((imageW/imageH)*eImageH);
				var h=eImageH;
			}
			else
			{*/
				var w=eImageW;
				$('#preview_hack').css({'height':h});
				$('#contentWrap article section.sec1 div, #editCoverPicForm section.sec1 div').css({'padding-top':0,'margin':0});

				////new thing added
				$('#preview').css({'padding':0,'height':h});
				
			/*}*/
			
			$('#h_ori').val(h);
			$('#w_ori').val(w);
			
			var height=eval(((w)*rImageH)/rImageW);
			var h1=height; 
			var w1=w;
			
			
			if(h1>h)
			{
				h1=h;
				w1=h*(rImageW/rImageH);
				
			}
		
		setTimeout(function(){
			$('#preview_hack').hide();
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
		 $('#preview_hack').show(); 	
		 $('#previewimg').removeAttr('height');
		 $('#previewimg').removeAttr('width');
		 $('#previewimg').removeAttr('src');
         $('#preview').css("display", "none");
         $('.error-signin').css("display", "none");
         $('.sec3').css("display", "none");
		 $(".sec1").removeClass("imageadd");
        $('#picture').val("");
		$('#contentWrap article section.sec1 div, #editCoverPicForm section.sec1 div').css({'padding-top':25,'margin':'0 auto'});
    }); 
	
	
	$('#choosePhotoCover').click(function(){
			 coverPicId=0;
			 $('#uploadPicHeading').hide();
			 $('#choosePicHeading').show();
			 
			  $('.sec3').css("display", "block");
			  $('#deleteimg, #coverPicUpdateMeter, #coverPicUpdateBtn').hide();
			  $('.coverPicUpdateMeterChoose').show();
			 
			   $(".sec1").addClass("imageadd");
			   $('.sec1 imageadd').css("display", "none");
			   
			   $.ajax({
				   url:'<?=site_url()?>photo/chooseFromPhotoList/1',
				   success:function(data)
						{
							if(data=='LO')
			     				  window.parent.location=site_url;	  
							else  
								$('#updateCoverPicForm').prepend(data);
								
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
			 
			 $('.sec1 imageadd').show()
			 $(".sec1").removeClass("imageadd");
			  $('.chooseCover').remove();
			});
		
		var coverPicId=0;
		$('#updateCoverPicForm').on('click','.chooseCover li',function(){
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
						url:'<?=site_url()?>photo/chooseFromPhotoListSubmit/1',
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
											window.parent.$('.not-bnner-pic').remove();
											window.parent.$('#coverPicHoverEffect').attr('src',data).parent('figure').show();
										}
										
										successBar('Banner changed successfully');
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

<!---------start-update cover pic popup-------------->
<div id="coverPicUpdate" class="popup_content" style="display:block">
         
       <header>
         <hgroup><h1 id="uploadPicHeading">Change ride's photo</h1> <h1 id="choosePicHeading" style="display:none;">Back</h1></hgroup>
         <p class="b-close"><img src="<?php echo $this->config->item('system_path');?>img/close-icon-pop.png"></p>
         <p class="error-signin" style="display: none;"></p>
       </header>     
       
       
       <section id="updateCoverPicForm">
	    <form method="post" id="editCoverPicForm" style="position:relative;" class="updateCoverPicForm-popupss" action="<?=site_url()?>user/editrideform/" enctype="multipart/form-data">
        <input type="hidden" name="page" value="<?=$page?>" />
        
          <section class="sec1">
		  <div id="preview"  style="display: none;"><div id="preview_hack"style=" background: #e5bebf none repeat scroll 0 0;height: 250px;position: absolute;width: 880px;"></div><img  id="previewimg" src="" class="imgareaselect-selection" />		  
		  </div>
		<!--<div class="upload-pic"> 
           <div> 
            <p>Upload your vehicle's photo that will be used as your profile's banner</p>
            <span>Image should be at least 980px wide</span><br>
           </div>
             <section class="uploadPhotoBtn">
               <label for="picture" class="fileBtn">Upload banner</label>
               <input type="file" id="picture" name="picture">
              </section>
			  </div> 
			<span id="filename"></span>-->
            <input type="file" id="picture" name="picture"   style="display:none;">
            <div id="basic-setup-banneruploaded" class="not-bnner-pic basic-setup-banneruploaded">
         <h1>USE AN ATTRACTIVE PIC OF YOUR RIDE<br> FOR THE BANNER</h1>
         <span>Few tips for banner pics:</span>
         <p>Make sure image is at least 980px wide</p>
          <p>Use your own vehicle's pic only</p>
          <p>Always click in landscape mode</p>
          <p>Keep your vehicle's headlights or day lamps on</p>
          
		  <a class="small about-text-upload-banner" id="cpiframe-Btn">Upload banner</a>
		  <?php $user=userSession();
			         $id=$user['id'];
			$noOfImages=getImageCount($id,2);
			if($noOfImages>0){
			     ?>
           <a class="about-text-choose-photo" id="choosePhotoCover">Choose from photos</a><?php } ?>
         </div>
          </section>
          
          
          
          <section class="sec3" style="display:none">
			
			<a href="#" id="deleteimg" class="uploadDiffText_1">Upload different photo</a> 
            
            <p class="coverPicUpdateMeter">
              <input type="submit" class="closePoP" id="coverPicUpdateBtn" value="Done">
              <span id="covermeter" style="display: none;"><img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif" style="margin:12px auto 0;"></span>
            </p>
            
             <p class="coverPicUpdateMeterChoose" style="display:none">
              <input type="button" class="closePoP" id="coverPicUpdateBtnChoose" value="Done">
            </p>
            
          </section>
          <div id="progressbox" style="display:none;"><div id="progressbar"></div><div id="statustxt">0%</div></div>
          
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

<!---------end update cover pic popup--------------> 	   
