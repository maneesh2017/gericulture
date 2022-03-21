<?php
$statusTypeList=statusTypeList();

//Image element
$eImageW=335;
$eImageH=222;
?>

<script type="text/javascript">
//Image element
var eImageW=<?=$eImageW?>;
var eImageH=<?=$eImageH?>;

//uploaded image
var imageW=0;
var imageH=0;

$(document).ready(function (e) {
	
	if (window.File && window.FileReader && window.FileList && window.Blob)
		  {}
		  else
		  {
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
		
	$('#updateUrStatus').submit(function() { 
	
		$('.error-signin').html('').hide();
		var updatestatus = $('#updatestatus').val();
		 if (updatestatus == '') 
		 	{
            	//alert('Status cannot be empty.');
				$('#demo').show();
				return false;
        	}
		else
			{
				$(this).ajaxSubmit(options);  			
				return false; 
			}
		
		});	
		
	//when upload progresses	
	function OnProgress(event, position, total, percentComplete)
	{
		statustxt.html(percentComplete + '%'); //update status text
	}	
	
	//after succesful upload
	function afterSuccess(data)
	{				
					if(data=='LO')
					  window.parent.location=site_url;	  
					  else
					  {	  
							window.parent.$('#status_box').load(site_url+'user/aboutMe #status_box > *',function(){
							window.parent.$('.b-modal').bPopup().close();
							window.parent.$('#popup2').bPopup().close();
							window.parent.$('#popup2 > .content').html(' '); 
						 });
					  }
						  
	}
	
	
	//function to check file size before uploading.
	  function beforeSubmit(){
		 
			  //Progress bar
			  progressbox.show(); //show progressbar
			  progressbar.width(completed); //initial value 0% of progressbar
			  statustxt.html(completed); //set status text
			  statustxt.css('color','#000'); //initial color of status text
	  
			$('#statusmeter').css("display", "block");
			$('#deleteimg').hide();
		}	
		  
		  
		  
		  $("#picture").change(function() {
			
			$('.error-signin').hide();
			
            if (this.files && this.files[0]) 
			{
					if(!checkFileExt($(this).val()))
					  {
						   $('.error-signin').html("Invalid File");
						   $('.error-signin').show();
						   $('#picture').val("");
					  }
					  else if(!checkFileSize($(this)[0].files[0].size))
					  {
						   $('.error-signin').html("Please select file less than 5MB");
						   $('.error-signin').show();
						   $('#picture').val("");
					  }
					  else
						   imageSize(this.files[0]);
			}
        });
	
	
	function imageSize(image)
		{ 
		   $('#editOtherUpdate').hide();
		   $('#preview').css("display", "block"); 
		   $('#deleteimg').css("display", "block");
		   $(".marginTop2").addClass("imageadd");
		   $('.imageadd').css("display", "none");	
		 
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
					
						   var reader = new FileReader();
				  			reader.onload = imageIsLoaded;			      
                  			reader.readAsDataURL(image);
					
        		};
        		img.src = _URL.createObjectURL(file);
    		}
			
		}
		
		function imageIsLoaded(e) {     
		
		 $('#previewimg').attr({src:e.target.result,width:eImageW});
		
		var h=eval(eImageW*(imageH/imageW));
		if(h>eImageH)
			{
				$('#previewimg').removeAttr('width');
				$('#previewimg').attr({height:eImageH});
			}
			
			
			setTimeout(function(){
			$('#preview_hack').hide();
			$('#editOtherUpdate').show();
			},500);
		};
		
		
		 $("#deleteimg").click(function() {
			 
			$('#preview').css("display", "none");
			$('#deleteimg').css("display", "none");
    	    $(".marginTop2").removeClass("imageadd");
	        $('.marginTop2').css("display", "block");
			
			$('#preview_hack').show(); 	
		 	$('#previewimg').removeAttr('height');
		 	$('#previewimg').removeAttr('width');
		 	$('#previewimg').removeAttr('src');
			$('.error-signin').css("display", "none");
         	$('#picture').val("");
    }); 
		  
	
});	
</script>	
<!----------edit status popup-------------->
<div id="changeUrStatus" class="popup_content" style="display:block"  >
<!--<span class="button b-close"><span>X</span></span>--> 
       <header>
         <hgroup><h1>Change your status</h1>
         <p style="display: none;" class="error-signin"></p>
         </hgroup>
         <!--  html edit - 21 nov 2014  -->
         <a href="#" class="pastStatusLnk editSectionBtn">Past statuses</a>
       </header>
       <section id="editUrStatus">
       <!--  html addtion - 21 nov 2014  -->
        <div class="floatLeft statusBox1">
          <form method="post" id="updateUrStatus" action="<?=site_url()?>user/editstatusform" enctype="multipart/form-data" >
              <!--  html edit - 15 dec 2014  -->
            <select class="choice" name="status_type">
              <option value="0">Choose a category for your status</option>
               <?php 
			  foreach($statusTypeList as $statusK=>$statusV)
			  {
			?>
						<option value="<?=$statusK?>"><?=$statusV?></option>  
				<?php
				 } ?>
            </select>  
            <!--  html edit - 15 dec 2014  -->     
            <textarea class="input floatLeft borderCCC" id="updatestatus" name="status" placeholder="What do you want to say today?"></textarea>
			<p id="demo" style="display:none;color: #E94142;font-size: 20px; font-weight: 300;" >Status can not be empty</p>
            <!--  html edit - 15 jan 2015  --> 
            <p class="clear updateStatusMeter">
               <input type="submit" value="Update status" class="floatLeft" id="editOtherUpdate"  />
              <span style="display: none;" id="statusmeter">
                <img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif"></span>
            </p>
            <div id="progressbox" style="display:none;float: right;"><div id="progressbar"></div><div id="statustxt">0%</div></div>
     </div>
       <!--  html addtion - 21 nov 2014  -->
         <div class="floatRight statusBox2">
             <h1>Upload a photo to go with your status</h1>
             <div id="preview"  style="display: none;">
             
             <div id="preview_hack"style=" background: #cccccc none repeat scroll 0 0;height: 430px;position: absolute;width:335px; z-index:1;"><img src="<?=system_path()?>img/speedometer.gif" style="background: black none repeat scroll 0% 0%; margin: 20% 0px 0px 46%;"></div>
             	<img id="previewimg" src="" />		  
             </div>
       <!--  html edit - 15 jan 2015  -->
			 <a href="#" id="deleteimg" style="display:none" class="uploadStatusPic">Upload different photo</a>
              <section class="uploadPhotoBtn marginTop2">
                <label for="picture" class="fileBtn_chngeStatus"><span class="icon-camera"></span><span class="text-camera">Browse photos</span></label>
                <input type="file" id="picture" name="picture">
              </section>
              <span id="filename" class="filePath"></span>    

            </div>  
           </form>    
       </section>
    </div>  
<!---------end status-popup-------------->
