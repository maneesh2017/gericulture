<!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.Jcrop.min.js" type="application/javascript"></script>-->
<!--<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>css/colorbox.css" />    
<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>css/setup.css" />-->
<!--<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.colorbox-min.js"></script>-->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.2/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript">
$(document).ready(function (e) {
	//$("#editCoverPicForm").on('submit',(function(e) {
		$("#coverPicUpdateBtn").click(function(e) {
		e.preventDefault();
		var formadata=$('#editCoverPicForm').serialize();
		var image = document.getElementById('previewimg');
		var width = image.naturalWidth;
		var height = image.naturalHeight;
 		if(width > 980){
		$('#covermeter').css("display", "block");
		$.ajax({  
        	url: site_url+'user/editrideform',
			type: "POST",
			data:  formadata,
			contentType: false,
    	    cache: false,
			processData:false,
			success: function(data)
		    {	
		  	   
			$('#covermeter').css("display", "none");
			$('#loadingimage').css("display", "none");
			window.parent.$('#coverPicHoverEffect').attr('src',data);
			window.parent.$('.b-modal').bPopup().close(); 
			window.parent.$('#popup2').bPopup().close();			
			window.parent.$('#popup2 > .content').html(' '); 	
		
			return true;		
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	   
	 } else{
			
			$('.error-signin').html("Please upload minimum 980pxwidth image");
			$('.error-signin').css("display", "block");
		 
		 }
	   
	});
	
	//Function for preview image.
    $(function() {
        $(":file").change(function() {
			$('.error-signin').hide();
			
            if (this.files && this.files[0]) {
			
			if(!checkFileExt($(this).val()))
			{
				 
				 $('.error-signin').html("Invalid File");
				 $('.error-signin').show();
			}
			else if(!checkFileSize($(this)[0].files[0].size))
			{
				 
				 $('.error-signin').html("Please select file less than 5MB");
				 $('.error-signin').show();
			}
			else
				 imageSize(this.files[0],980);
				
							/*var reader = new FileReader();
				  			reader.onload = imageIsLoaded;			      
                  			reader.readAsDataURL(this.files[0]);	 */
			}
        }); 
    });
    

function imageIsLoaded(e) {        
      
                 
         $('#preview').css("display", "block");
         $('.sec3').css("display", "block");
		 $(".sec1").addClass("imageadd");
		 $('.sec1 imageadd').css("display", "none");		 
         $('#previewimg').attr({src:e.target.result,width:980, height:435});
        		
		    
         
		};
		
		
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
					
					  if(this.width>=imgWidth)
					  {
						   var reader = new FileReader();
				  			reader.onload = imageIsLoaded;			      
                  			reader.readAsDataURL(image);
					  }
					  else
					  {
							  $('.error-signin').html("Please upload minimum 980px width image");
							  $('.error-signin').show();
					  }
        		};
        		img.src = _URL.createObjectURL(file);
    		}
			
		}
		
		

		

//Function for deleting preview image.
    $("#deleteimg").click(function() {
        $('#preview').css("display", "none");
        $('.error-signin').css("display", "none");
        $('.sec3').css("display", "none");
		 $(".sec1").removeClass("imageadd");
        $('#file').val("");
    });  
   

/*$('#previewimg').each(function() {
	$(this).attr('data-img-height', $(this).attr('height'));
	$(this).attr('data-img-width', $(this).attr('width'));
	$(this).removeAttr('height');
	$(this).removeAttr('width');

	$(this).wrap('<div style="height:'+$(this).attr("data-img-height")+'px;width:'+$(this).attr("data-img-width")+'px;overflow:hidden;position:relative;padding:0;margin:0;"></div>');
	$(this).parent().append('<div style="position:absolute;z-index:99999;"><input type="button" class="plus" value="+" style="position:absolute;height:32px;width:32px;left:0;" onclick="$(this).parent().siblings().first().css(\'width\', parseInt($(this).parent().siblings().first().width())*1.05+\'px\');$(this).parent().siblings().first().css(\'height\', parseInt($(this).parent().siblings().first().height())*1.05+\'px\');"> <input type="button" class="minus" value="-" style="position:absolute;height:32px;width:32px;left:32px;" onclick="$(this).parent().siblings().first().css(\'width\', parseInt($(this).parent().siblings().first().width())*0.95+\'px\');$(this).parent().siblings().first().css(\'height\', parseInt($(this).parent().siblings().first().height())*0.95+\'px\');"></div>');
	$(this).css("position", "absolute");
	$(this).css("padding", 0);
	$(this).css("margin", 0);
	$(this).css("top", -((parseInt($(this).css('height'))-parseInt($(this).attr("data-img-height")))/2)+"px");
	$(this).css("left", -((parseInt($(this).css('width'))-parseInt($(this).attr("data-img-width")))/2)+"px");
	console.log($(this).offset().top);
		$(this).draggable({
			revert: false,
			revertDuration: 100,
			drag: function(event, ui) {
				if (parseInt($(this).offset().top) > 0)
				{
					$(this).draggable("option", "revert", true);
				}
				else if (parseInt($(this).offset().left) > 0)
				{
					$(this).draggable("option", "revert", true);
				}
				else if (parseInt($(this).offset().left) < parseInt($(this).parent().css('width'))-parseInt($(this).css('width')))
				{
					$(this).draggable("option", "revert", true);
				}
				else if (parseInt($(this).offset().top) < parseInt($(this).parent().css('width'))-parseInt($(this).css('width')))
				{
					$(this).draggable("option", "revert", true);
				}
				else
				{
					$(this).draggable("option", "revert", false);
				}
			}
		});              
});*/
    
 	
});
</script>    

<!---------start-update cover pic popup-------------->
<div id="coverPicUpdate" class="popup_content" style="display:block">
           <!--  html edit - 10 dec 2014  --> 
 <!--<span class="button b-close" style="left: -2px; top:3px; z-index:1"><span>X</span></span>-->
<!--<span style="display:none;" id="loadingimage"><img src="<?php echo $this->config->item('system_path');?>img/loading.png"></span>-->
       <header>
         <hgroup><h1>Change ride's photo</h1></hgroup>
         <p class="error-signin" style="display: none;"></p>
       </header>
       <section id="updateCoverPicForm">
	    <form method="post" id="editCoverPicForm" enctype="multipart/form-data">
          <section class="sec1">
		  <div id="preview"  style="display: none;"><img height="435" width="980"id="previewimg" src="" class="imgareaselect-selection" />		  
		  </div>
		<div class="upload-pic"> 
           <div> 
            <p>Upload your vehicle's photo that will be used as your profile's cover photo</p>
            <span>Image should be at least 980px wide</span><br>
           </div>
             <section class="uploadPhotoBtn">
               <label for="picture" class="fileBtn">Upload photo</label>
               <input type="file" id="picture" name="picture">
              </section>
			  </div> 
			  <br/>
           <span id="filename"></span>
          </section>
          <section class="sec3" style="display:none">
			<!--<form  method="post" onsubmit="return checkCoords();">
            <input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />
            <input type="submit" value="Crop Image" />
        </form>-->
        <!------html edit - 16 jan 2015 -->
			<a href="#" id="deleteimg" class="uploadDiffText_1">Upload different photo</a> 
            <!--<button type="submit" class="closePoP" id="coverPicUpdateBtn">Done</button>-->
            <p class="coverPicUpdateMeter">
              <input type="submit" class="closePoP" id="coverPicUpdateBtn" value="Done">
              <span id="covermeter" style="display: none;"><img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif" style="margin:12px auto 0;"></span>
            </p>
            
          </section>
		</form>
		
       </section>
</div>
<!---------end update cover pic popup--------------> 	   
