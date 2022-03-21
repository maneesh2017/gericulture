<?php
$thumbSizes=thumbSizes('user');

//output image
$rImageW=$thumbSizes['thumb']['width'];
$rImageH=$thumbSizes['thumb']['height'];

$aspectRatio=$rImageW.':'.$rImageH;

//Image element
/*$eImageW=200;
$eImageH=200;*/
$eImageW=552;
$eImageH=350;


 //see($Userdata);
$getMonthList=getMonthList();
?>
<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/edit.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!--<script type='text/javascript' src='http://code.jquery.com/jquery-1.6.3.js'></script>-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700' rel='stylesheet' />
<link href="<?php echo $this->config->item('system_path');?>css/style.css" rel="stylesheet" />
<link href="<?php echo $this->config->item('system_path');?>css/setup.css" rel="stylesheet" />
<!--<link rel="stylesheet" media="screen and (max-width: 1010px)" href="<?php echo $this->config->item('system_path');?>css/mobile-styles.css" />-->
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/mobilestyles.js"></script>


<script src="<?php echo $this->config->item('system_path');?>js/functions.js" type="application/javascript"></script>
<script src="<?php echo $this->config->item('system_path');?>js/jquery.form.min.js" type="application/javascript"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>js/crp/crp.css" />
<script type="text/javascript" src="<?=system_path()?>js/crp/jquery.imgareaselect.min.js"></script>

<script>
//output image
var rImageW=<?=$rImageW?>;
var rImageH=<?=$rImageH?>;

//Image element
var eImageW=<?=$eImageW?>;
var eImageH=<?=$eImageH?>;

//uploaded image
var imageW=0;
var imageH=0;
var demo_pic_src='<?php echo $this->config->item('system_path'); ?>img/demo-pic.png';

function preview(img, selection) { 
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
} 

$(document).ready(function (e) {
	
	$(window).keydown(function(event){
			if(event.keyCode == 13) {
			  event.preventDefault();
			  return false;
			}
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
		
		
		
		$('#personalDetailform').submit(function() { 
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
		     window.location=site_url+'user/enjoygeri';
	}
	
	//function to check file size before uploading.
	  function beforeSubmit(){
		  
		  if(validatePersonDetailForm()==0)
			return false;
			$('#nextPage').hide();
		  
		  //check whether browser fully supports all File API
		 if (window.File && window.FileReader && window.FileList && window.Blob)
		  {
	  
			  //Progress bar
			  progressbox.show(); //show progressbar
			  progressbar.width(completed); //initial value 0% of progressbar
			  statustxt.html(completed); //set status text
			  statustxt.css('color','#000'); //initial color of status text
	  
		 }
		  else
		  {
			  //Output error to older unsupported browsers that doesn't support HTML5 File API
			  alert("Please upgrade your browser, because your current browser lacks some new features we need!");
			  return false;
		  }
	  }
		
		
		$("#photo").change(function() {
			
			$('.errorMsg').hide();
			$('#previewimg').imgAreaSelect({ remove:true,hide:true }); 
			$('#previewimg').removeAttr('height');
			$('#previewimg').removeAttr('width');
			$('#previewimg').removeAttr('src');
			$('#previewimg').attr('src',demo_pic_src);
			
            if (this.files && this.files[0]) 
			{
					if(!checkFileExt($(this).val()))
					  {
						   /*$('.errorMsg').html("Invalid File");
						   $('.errorMsg').show();*/
						   errorBar("Only .jpg, .jpeg or .png files are allowed");
						   $('#photo').val("");
					  }
					  else if(!checkFileSize($(this)[0].files[0].size))
					  {
						   /*$('.errorMsg').html("Please select file less than 5MB");
						   $('.errorMsg').show();*/
						    errorBar("Please select file less than 5MB");
						   $('#photo').val("");
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
							  /*$('.errorMsg').html("Please upload minimum 200px width image");
							  $('.errorMsg').show();*/
							  errorBar("Upload image that is minimum 600px wide");
							  $('#photo').val("");
					  }
        		};
        		img.src = _URL.createObjectURL(file);
    		}
			
		}
	
	
	function imageIsLoaded(e) {        
          
		$('#previewimg').attr({src:e.target.result,width:eImageW}).show();
		$('#UploadPhotoSecProfile').css({'padding':0,'width':eImageW});
		$('#uploadPhotoSecInstruction').hide();
		$('#deleteimg').show();
		
		

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
		//alert(h1);
		setTimeout(function(){
			$('#previewimg').imgAreaSelect({ aspectRatio:'<?=$aspectRatio?>', onSelectChange: preview ,x1: 0, y1: 0, x2: w1, y2: h1,persistent:true,parent: '#layout1'  });  			
			
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
		 //$('#previewimg').attr('src',demo_pic_src);
		 $('.errorMsg').css("display", "none");
         $('#photo').val("");
		 
		 
		 ///
		$('#previewimg').hide();
		$('#UploadPhotoSecProfile').css({'padding':'40px 0 0 52px','width':500});
		$('#uploadPhotoSecInstruction').show();
		$('#deleteimg').hide();
		 ////
    }); 
		
		
		$( "#year" ).keyup(function() {
		 var year = $( "#year" ).val();
		  if (year.length!=4)
		 $("#year").addClass("borderErr");
		 else
		 $("#year").removeClass("borderErr");
	});
	
	$( "#year" ).change(function() {
		 var year = $( "#year" ).val();
		  if (year.length!=4)
		 $("#year").addClass("borderErr");
		 else
		 $("#year").removeClass("borderErr");
	});
	
	$( "#telphone" ).keyup(function() {
		 var telphone = $( "#telphone" ).val();
		  if (telphone == "")
		 $("#telphone").addClass("borderErr");
		 else
		 $("#telphone").removeClass("borderErr");
	});
	
	$( "#day" ).change(function() {
		 var day = $( "#day" ).val();
		  if (day == 0)
		 $("#day").addClass("borderErr");
		  else
		 $("#day").removeClass("borderErr");
	});
	
	$( "#month" ).change(function() {
		 var month = $( "#month" ).val();
		  if (month == 0)
		 $("#month").addClass("borderErr");
		  else
		 $("#month").removeClass("borderErr");
	});
		
		
	});

function validatePersonDetailForm()
{
   var gender = document.forms["personalDetail-form"]["gender"].value;  
   var day = document.forms["personalDetail-form"]["day"].value;
   var month = document.forms["personalDetail-form"]["month"].value;
   var year = document.forms["personalDetail-form"]["year"].value;
   var tel = document.forms["personalDetail-form"]["telphone"].value;   
   var defaulValYear = document.getElementById("year").defaultValue;
   var defaulValTel = document.getElementById("telphone").defaultValue;
   
   //alert(gender+' '+day+' '+month+' '+year+' '+tel);
   
    if (year.length!=4 || day == 0 || month == 0 || tel == ''  || isNaN(tel))
    {
		 //$("#nextPage").prev('p').text('All fields are required.').fadeIn().delay(3000).fadeOut();
		  errorBar('Fields marked with red are required');
		  if (year.length!=4)
		 $("#year").addClass("borderErr");
		 else
		 $("#year").removeClass("borderErr");
		 
		 if (day == 0)
		 $("#day").addClass("borderErr");
		  else
		 $("#day").removeClass("borderErr");
		 
		 if (month == 0)
		 $("#month").addClass("borderErr");
		  else
		 $("#month").removeClass("borderErr");
		 
		 if (tel.trim() =='')
		 $("#telphone").addClass("borderErr");
		 else
		 {
		 	$("#telphone").removeClass("borderErr");
			if (tel.trim()!='' && isNaN(tel))
		 		$("#telphone").val('').addClass("borderErr");
		 	else
		 		$("#telphone").removeClass("borderErr");
		 }
		 
		 return 0;
       // return false;
    }
	else
	{
		 $("#day").removeClass("borderErr");
		 $("#month").removeClass("borderErr")
		 $("#year").removeClass("borderErr")
		 $("#telphone").removeClass("borderErr")
		 
		 //$('#personalDetailform').submit();
		  return 1;
		
	}
	
}


function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>

<div id="main_Wrapper" class="profileBasicPage"> <!--------start main wrapper--------->
  <header>
    <figure id="figure-logo" class="figure-logo-resolve">
     
	  
	  <img src="<?php echo $this->config->item('system_path');?>img/geri-logo.png" alt="logo" />
    </figure>
    <article id="setUpProfile" class="setUpProfile-resolve">
      <hgroup>
       <h1>Set up your basic profile</h1>
      </hgroup>
    </article>
 </header>
 
  <div class="mobile_header_1">
      <a href="<?php echo base_url(); ?>" id="small_gc_logo" class="floatLeft" rel="Geri Culture Logo"><img src="<?php echo $this->config->item('system_path');?>img/geri-culture-small-logo.png" alt="logo" data-at2x="<?php echo $this->config->item('system_path');?>img/geri-culture-small-logo@2x.png" /></a>
      <hgroup class="floatRight"><h1>Set up your profile</h1></hgroup>
     </div>
     <section class="setup_profile_section">
     <ul>
       <li><a class="activeNone page1" href="#">1</a></li>
       <li><a class="activePage2" href="#">2</a></li>
       <li><a class="activeNone page3" href="#">3</a></li>
     </ul>
  </section>
  
  <section id="contentWrap" class="boxShadow"><!--------start content wrapper--------->  
    <article id="layout1" class="layout2layout2">
	<form name="personalDetail-form" id="personalDetailform" method="post" action="<?php echo base_url();?>user/addprofiledetails"  enctype="multipart/form-data">
      <header>
        <nav class="floatLeft">
          <ul>
            <li>VEHICLE DETAILS</li>
            <li><span><img src="<?php echo $this->config->item('system_path');?>img/rightside-arrow.png" alt="arrow" /></span></li>
            <li class="activeLi"><a href="<?php echo base_url(); ?>user/personaldetails">PERSONAL DETAILS</a></li>
            <li><span><img src="<?php echo $this->config->item('system_path');?>img/rightside-arrow.png" alt="arrow" /></span></li>
            <li>ENJOY GERI</li>
          </ul>
        </nav>
        <p class="floatRight basic-vehicle-number"><?php echo $Userdata['first_name'].'&nbsp'.$Userdata['last_name'];?></p>
      </header>
      <section class="secPhotoForm secPhotoForm2nd">	
      <div class="personaldetails-custom floatLeft">
        
        <div class="uploadPhotoSec floatLeft" id="UploadPhotoSecProfile">
          <figure>
            <img id="previewimg" src=""alt="user" style="display:none;" />
          	</figure>
            <!--<p>Upload your photo that will be used as profile photo</p>
            <span>Image should be at least 550px wide</span>-->
            <div id="uploadPhotoSecInstruction">
                <h1>UPLOAD YOUR IMAGE TO USE AS A PROFILE PIC</h1>
                <p>Make sure image is at least 600px wide</p>
          <!--  </div>
           <div>-->
            <label for="photo" class="fileBtn1 chnage1 about-text-upload-banner">Upload profile pic</label>
             <input type="file" id="photo" name="photo" >
            <span id="filename1"></span>
          </div>
        </div>
        <a href="javascript:void(0);" id="deleteimg" style="display:none;">Upload different photo</a>
     </div>   
        
        <div class="uploadFormSec floatRight">
         
             <p>
             <span>
               <input type="radio" value="male" checked="checked" id="g-male" class="marginRight10" name="gender"><label for="g-male"><span style="margin-top:-5px;"></span>Male</label>
               <input type="radio" style="margin-left:20px;" class="marginRight10" value="female" id="g-female" name="gender" ><label for="g-female"><span style="margin-left:20px; margin-top:-5px;"></span>Female</label>
               </span>
             </p> 
             <p>
              
              <label>Birthday</label><br/>
              
              <select class="choice1" id="day" name="day" style="width:85px; margin-top:10px; margin-right:5px;">
              <option value="0">Day</option>
              <?php for($i=1;$i<=31;$i++){?>
              	<option value="<?=$i?>" ><?=$i?></option>
              <?php } ?>
               </select>
             
             <select class="choice1" id="month" name="month" style="width:110px; margin-top:10px; margin-right:5px;">
                  <option value="0">Month</option>
                  <?php foreach($getMonthList as $monthK=>$monthV){?>
                  <option value="<?=$monthK?>" ><?=$monthV?></option>
                  <?php } ?>
              </select>
              <input type="text" id="year" name="year" maxlength="4" onkeypress="return isNumberKey(event)" placeholder="Year" class="input choice1" style="margin-top: 10px; width:85px; padding: 2px 8px 0px; height: 47px;" value=""/>
             </p>
             <p>
             <label>Phone number</label>
               <input type="text" id="telphone" name="telphone" class="input" value="" placeholder="Phone number" />
             </p>
             <p>Your phone number will not be displayed to public. 
             Its only required for verification purposes.</p>
          
          <div id="progressbox" style="display:none;float: right;"><div id="progressbar"></div><div id="statustxt">0%</div></div>
          
        </div>
		
      </section>
      <footer>
        <p class="floatLeft errorMsg" style="margin-left:39px; margin-top:16px;">All fields are required.</p>
        <!--<button onClick="return validatePersonDetailForm();" id="nextPage">Next</button>-->
		<!--<input type="button"  id="nextPage" value="Next"  onClick="return validatePersonDetailForm();"  />-->
        <input type="submit"  id="nextPage" value="Next"  />
      </footer>
      
		        <input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
                <input type="hidden" name="w_ori" value="" id="w_ori" />
				<input type="hidden" name="h_ori" value="" id="h_ori" />
      
	  </form>
    </article>
  </section><!---------close content wrapper--------->
  

  

 </div><!--------close main wrapper--------->
 

 <script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/retina.js"></script>