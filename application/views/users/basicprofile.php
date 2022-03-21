<?php
$thumbSizes=thumbSizes('ride');

//output image
$rImageW=$thumbSizes['large']['width'];
$rImageH=$thumbSizes['large']['height'];

$aspectRatio=$rImageW.':'.$rImageH;

//Image element
$eImageW=880;
$eImageH=400;

$eImageW=978;
$eImageH=445;

/*$getListVehicleBrand=getListVehicleBrand($search_query['type']);
*/$getListVehicleType=getListVehicleType();
?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700' rel='stylesheet' />
<link href="<?php echo $this->config->item('system_path');?>css/style.css" rel="stylesheet" />
<link href="<?php echo $this->config->item('system_path');?>css/setup.css" rel="stylesheet" />
<!--<link rel="stylesheet" media="screen and (max-width: 1010px)" href="<?php echo $this->config->item('system_path');?>css/mobile-styles.css" />-->
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/mobilestyles.js"></script>

<script src="<?php echo $this->config->item('system_path');?>js/functions.js" type="application/javascript"></script>
<script src="<?php echo $this->config->item('system_path');?>js/jquery.form.min.js" type="application/javascript"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>js/crp/crp.css" />
<script type="text/javascript" src="<?=system_path()?>js/crp/jquery.imgareaselect.min.js"></script>

<script type="text/javascript">
if (window.history && window.history.pushState) {

   window.history.pushState('basicprofile', null, './basicprofile');

    $(window).on('popstate', function() 
	{	
		
     // alert('Back button was pressed.');
      window.location = site_url+"user/logout";
	 

     });
 }
/*if (window.history && window.history.pushState) {

    window.history.pushState('logout', null, './#logout');

    $(window).on('popstate', function() 
	{	
		
     // alert('Back button was pressed.');
      window.location = site_url+"/user/logout";
	 

     });
 }
 */
//output image
var rImageW=<?=$rImageW?>;
var rImageH=<?=$rImageH?>;

//Image element
var eImageW=<?=$eImageW?>;
var eImageH=<?=$eImageH?>;

if($(window).width()<1011 && $(window).width()>810)//1010 to 811
	eImageW=798;
else if($(window).width()<811)//<=810
	eImageW=698;
	
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
	  $('#cpiframe').click(function(){
		  $('#picture').trigger('click');
		  });
	  
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
				
			$('#vehicleForm').submit(function() { 
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
				window.location=site_url+'user/personaldetails';
		  }
		  
		  
		  //function to check file size before uploading.
		function beforeSubmit(){
				
				if(validateVehicleForm()==0)
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
				  
				  
		$("#picture").change(function() {
				  
				  $('.errorMsg').hide();
				  
				  if (this.files && this.files[0]) 
				  {
						  if(!checkFileExt($(this).val()))
							{
								 /*$('.errorMsg').html("Invalid File");
								 $('.errorMsg').show();*/
								 errorBar('Only .jpg, .jpeg or .png files are allowed');
								 $('#picture').val("");
							}
							else if(!checkFileSize($(this)[0].files[0].size))
							{
								 /*$('.errorMsg').html("Please select file less than 5MB");
								 $('.errorMsg').show();*/
								 errorBar('Please select file less than 5MB')
								 $('#picture').val("");
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
									/*$('.errorMsg').html("Please upload minimum 980px width image");
									$('.errorMsg').show();*/
									errorBar('Upload image that is minimum 980px wide');
									$('#picture').val("");
							}
					  };
					  img.src = _URL.createObjectURL(file);
				  }
				  
			  }
		  
				  
		  function imageIsLoaded(e) {        
				
			   $('#preview').css("display", "block");
			   $(".sec1").addClass("imageadd");
			   $('.sec1 .imageadd').css("display", "none");
			   $('#previewimg').attr({src:e.target.result,width:eImageW});
			  
			  var h=eval(eImageW*(imageH/imageW));
			 /* if(h>eImageH)
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
					  $('#contentWrap article section.sec1 div').css('padding-top',0);
					  ////new thing added
					  $('#preview').css({'padding':0,'height':h});
					  $('#contentWrap article section.sec1 div, #editCoverPicForm section.sec1 div').css('margin',0);
				 /* }*/
				  
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
				  $('#previewimg').imgAreaSelect({ aspectRatio:'<?=$aspectRatio?>', onSelectChange: preview ,x1: 0, y1: 0, x2: w1, y2: h1,persistent:true ,parent: '#layout1' });  			
				  
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
			   $('.errorMsg').css("display", "none");
			   $(".sec1").removeClass("imageadd");
			   $('#picture').val("");
			   $('#contentWrap article section.sec1 div').css('padding-top','50px');
		  }); 
		  
		  $( "#vmodel" ).keyup(function() {
			   var vmodel = $( "#vmodel" ).val();
			   var defaulVal = document.getElementById("vmodel").defaultValue;
				if (vmodel == defaulVal)
			   $("#vmodel").addClass("borderErr");
			   else
			   $("#vmodel").removeClass("borderErr");
		  });
		  
		  $( "#vbrand" ).change(function() {
			   var vbrand = $( "#vbrand" ).val();
				if (vbrand == 0)
			   $("#vbrand").addClass("borderErr");
				else
			   $("#vbrand").removeClass("borderErr");
		  });
		  
		  $( "#vtype" ).change(function() {
			   var vtype = $( "#vtype" ).val();
				if (vtype == 0)
			   $("#vtype").addClass("borderErr");
				else
			   $("#vtype").removeClass("borderErr");
		  });  
		
		
	$('.newMake').click(function(){
			if($('#vtype').val()=='0')
			{
				$('#vtype').addClass('borderErr');
				errorBar('Select your vehicle type first');
			}
			else
			{
				$('#newMakePop').bPopup();
				$('#vtype').removeClass('borderErr');
			}
		});
		
	$('.newModel').click(function(){
			  if($('#vtype').val()=='0' && $('#vbrand').val()=='0')
			  {
			 		$('#vtype').addClass('borderErr');
					errorBar('Select your vehicle type first');
			  }
			  else if
			  ($('#vtype').val()!='0' && $('#vbrand').val()=='0')
			  {
			 		$('#vtype').addClass('borderErr');
					errorBar('Select your vehicle make first');
			  }
			  else
			  {
				  $('#newModelPop').bPopup();
				  $('#vtype').removeClass('borderErr');
			  }
		});	
		
		
		$('#newMakeSubmit').click(function(){
				var brandId=$('#newMakeMake');
				var brand=brandId.val().trim();
				
				var modelId=$('#newMakeModel');
				var model=modelId.val().trim();
				
				var vtypeId=$('#vtype');
				var vtype=vtypeId.val().trim();
				
				if(brand=='' || model=='' || vtype=='')
				{
						if(brand=='')
							brandId.addClass('borderErr');
						else	
							brandId.removeClass('borderErr');
					
						if(model=='')
							modelId.addClass('borderErr');
						else	
							modelId.removeClass('borderErr');						
				}
				else
				{
					
					if($('#vbrand option[value="suggestion-'+brand+'"]').length==0)
						$('#vbrand').append('<option value="suggestion-'+brand+'" selected="selected">'+brand+'</option>');
					if($('#vmodel option[value="suggestion-'+model+'"]').length==0)	
						$('#vmodel').html('<option value="suggestion-'+model+'" selected="selected">'+model+'</option>');
						
					$('.b-close').trigger('click');								
					brandId.val('');
					modelId.val('');
					
					/*	
					$('.b-close').trigger('click');
					$.ajax({
							url:site_url+'user/addNewVehicleBrand/',
							type:'POST',
							data:{brand:brand,model:model,vtype:vtype},
							success:function(data)
										  {
											  if(data=='LO')
											  		window.location=site_url;
											 else
											 {
													$('#vbrand').append('<option value="suggestion-'+data+'" selected="selected">'+brand+'</option>');
													$('#vmodel').append('<option value="suggestion-'+data+'" selected="selected">'+model+'</option>');
													
													brandId.val('');
													modelId.val('');
													
											}
										  }
						});
				*/}
			});
			
			
			$('#newModelSubmit').click(function(){
				var brandId=$('#vbrand');
				var brand=brandId.val().trim();
				
				var modelId=$('#newModelModel');
				var model=modelId.val().trim();
				
				var vtypeId=$('#vtype');
				var vtype=vtypeId.val().trim();
				
				if(brand=='' || model=='' || vtype=='')
				{
						if(brand=='')
							brandId.addClass('borderErr');
						else	
							brandId.removeClass('borderErr');
					
						if(model=='')
							modelId.addClass('borderErr');
						else	
							modelId.removeClass('borderErr');						
				}
				else
				{
					if($('#vmodel option[value="suggestion-'+model+'"]').length==0)	
						$('#vmodel').append('<option value="suggestion-'+model+'" selected="selected">'+model+'</option>');
						
					$('.b-close').trigger('click');								
					modelId.val('');
					
					/*	
					$('.b-close').trigger('click');
					$.ajax({
							url:site_url+'user/addNewVehicleModel/',
							type:'POST',
							data:{brand:brand,model:model,vtype:vtype},
							success:function(data)
										  {
											  if(data=='LO')
											  		window.location=site_url;
											 else
											 {
													$('#vmodel').append('<option value="suggestion-'+data+'" selected="selected">'+model+'</option>');
													modelId.val('');
											}
										  }
						});
				*/}
			});

						
	});

	function validateVehicleForm()
	{
	   var vmodel = $("#vmodel").val();
	   var vbrand = document.forms["vehicleForm"]["brand"].value;
	   var vtype = document.forms["vehicleForm"]["type"].value;
	   //var defaulVal = document.getElementById("vmodel").defaultValue;
	  
	   
		if (vmodel == 0 || vbrand == 0 || vtype == 0)
		{
			// $("#nextPage").prev('p').text('All fields are required.').fadeIn().delay(3000).fadeOut();
			 errorBar('Fields marked with red are required');
			  if (vmodel == 0)
			 $("#vmodel").addClass("borderErr");
			 else
			 $("#vmodel").removeClass("borderErr");
			  if (vbrand == 0)
			 $("#vbrand").addClass("borderErr");
			  else
			 $("#vbrand").removeClass("borderErr");
			  if (vtype == 0)
			 $("#vtype").addClass("borderErr");
			  else
			 $("#vtype").removeClass("borderErr");
			//return false;
			return 0;
		}
		else
		{
	
			 $("#vmodel").removeClass("borderErr");
			 $("#vbrand").removeClass("borderErr");
			 $("#vtype").removeClass("borderErr");
			 //$('#vehicleForm').submit();
			 return 1;
			 
		}
		
	}
	
	function getBrandList()
		{
			$('.vehiclemakeloader').show();
			var d=$("#vtype").val();
			 $.ajax({ 
 					url:site_url+'setting/getCarBikeBrands/'+d,
 					success:function(data)
					 { 
					 	$('.vehiclemakeloader').hide();
						data='<option value="0">Vehicle Make</option>'+data;
						 $('#vbrand').html(data);
						 getModelList();
					 }
			 }); 
		}
		 
		 
		  function getModelList()
		{
			$('.vehiclemodelloader').show();
			var d=$("#vbrand").val();
			var t=$("#vtype").val();
			 $.ajax({ 
 					url:site_url+'setting/getCarBikeModels/'+d+'/'+t,
 					success:function(data)
					 { 
					 	$('.vehiclemodelloader').hide();
						data='<option value="0">Vehicle Model</option>'+data;
						 $('#vmodel').html(data);
					 }
			 }); 
			
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
       <li><a class="activePage1" href="#">1</a></li>
       <li><a class="activeNone page2" href="#">2</a></li>
       <li><a class="activeNone page3" href="#">3</a></li>
     </ul>
  </section>
  
  <section id="contentWrap" class="boxShadow"><!--------start content wrapper--------->  
    <form  name="vehicleForm" id="vehicleForm" method="post" action="<?php  echo base_url();?>user/addcoverpicbasic"  enctype="multipart/form-data" >
   <article id="layout1" class="layout1layout1">
      <header>
        <nav class="floatLeft">
          <ul>
            <li class="activeLi"><a href="<?php echo base_url(); ?>user/basicprofile">VEHICLE DETAILS</a></li>
            <li><span><img src="<?php echo $this->config->item('system_path');?>img/rightside-arrow.png" alt="arrow" /></span></li>
            <li>PERSONAL DETAILS</li>
            <li><span><img src="<?php echo $this->config->item('system_path');?>img/rightside-arrow.png" alt="arrow" /></span></li>
            <li>ENJOY GERI</li>
          </ul>
        </nav>
        <p class="floatRight basic-vehicle-number"><?php if(!empty($Userdata['username'])){echo strtoupper( $Userdata['username']);}?></p>
      </header>
	 
      <section class="sec1 basicsec" >
	   <div id="preview"  style="display: none;">
       <div id="preview_hack"  style=" background: #e5bebf none repeat scroll 0 0;height: 250px;position: absolute;width: 978px;"></div>
       <img id="previewimg" src="" />	  
	   <a href="javascript:void(0);" id="deleteimg" >Upload different photo</a> 
	  </div>  
	  
	  <!--<div class="upload-pic" style="position:relative;">
       <div>
	   
        <p>Upload your vehicle's photo that will be used as your profile's banner</p>
        <span>Image should be at least 980px wide</span><br/>
       </div>
	    
       <section class="uploadPhotoBtn">
		
          <label for="picture" class="fileBtn">Upload banner</label>
          <input type="file" id="picture" name="picture"  >
		
        
        </section>
        
        <p class="floatLeft errorMsg basicprofile-error" style="">All fields are required.</p> 
        
		</div>-->
        <input type="file" id="picture" name="picture"   style="display:none;">
        <div class="not-bnner-pic basic-setup-banneruploaded" id="basic-setup-banneruploaded">
         <h1>USE AN ATTRACTIVE PIC OF YOUR RIDE<br /> FOR THE BANNER</h1>
         <span>Few tips for banner pics:</span>
         <p>Make sure image is at least 980px wide</p>
          <p>Use your own vehicle's pic only</p>
          <p>Always click in landscape mode</p>
          <p>Keep your vehicle's headlights or day lamps on</p>
          
		  <a id="cpiframe" class="small about-text-upload-banner"  >Upload banner</a>
         </div>
        
		
          <span id="filename"></span>
      </section>
      <section class="sec2">
		
         <div class="Vehicle-first">  
          <select name="type" class="choice1" id="vtype" onchange="getBrandList()">
           	  <option value="0">Vehicle type</option>
              <?php foreach($getListVehicleType as $vTypeK=>$vTypeV){?>
              <option value="<?=$vTypeK?>"   ><?=$vTypeV?></option>
			  <?php }?>
          </select>
          </div>
          
        <div class="Vehicle-Make-second">  
      <select id="vbrand" class="choice1" name="brand" onchange="getModelList()">
            <option value="0">Vehicle Make</option>
         </select>
         <p class="newMake"><a href="javascript:void(0);">Vehicle Make not in the list?</a></p>
         <span class="vehiclemakeloader" style="display:none;"><img src="<?php echo $this->config->item('system_path');?>img/circle-load-grey-back.gif"></span>
         </div>
         
         <div class="Vehicle-Model-third"> 
		 <select id="vmodel" class="choice1" name="model">
            <option value="0">Vehicle Model</option>
         </select>
         <p class="newModel"><a href="javascript:void(0);">Vehicle Model not in the list?</a></p>
         <span class="vehiclemodelloader" style="display:none;"><img src="<?php echo $this->config->item('system_path');?>img/circle-load-grey-back.gif"></span>
         </div>


          <div id="progressbox" style="display:none;float: right;"><div id="progressbar"></div><div id="statustxt">0%</div></div>
          
      
      </section> 
	    
      <footer>
        
        <!--<input type="button"  id="nextPage" value="Next" onClick="validateVehicleForm();" />-->
        <input type="submit"  id="nextPage" value="Next"/>
      </footer>
	  
    </article>
    
     			<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />
                <input type="hidden" name="w_ori" value="" id="w_ori" />
				<input type="hidden" name="h_ori" value="" id="h_ori" />
                
	 </form>
  </section><!---------close content wrapper--------->
 <div id="clear"></div> 

 </div><!--------close main wrapper--------->
 

 <script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/retina.js"></script>
 <script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>
 
 <div id="newMakePop" class="newVehiclePop" style="display:none;">
 <p class="b-close"><img src="<?php echo $this->config->item('system_path');?>img/close-icon-pop.png" /></p>
 
 <div>
          <label for="newMakeMake">Enter your Vehicle Make</label><br />
          <input type="text" name="newMakeMake"  id="newMakeMake"/>
</div>
<div>         
          <label for="newMakeModel">Enter your Vehicle Model</label><br />
          <input type="text" name="newMakeModel" id="newMakeModel" />
</div>   

<p style="color: hsl(0, 0%, 40%);    font-size: 14px;    margin-top: 10px;    text-align: center; font-weight:300;">The Vehicle information entered above will be reviewed by our team.</p>

          <input type="button" value="Submit" id="newMakeSubmit" />
 </div>
 
  <div id="newModelPop" class="newVehiclePop" style="display:none;">
   <p class="b-close"><img src="<?php echo $this->config->item('system_path');?>img/close-icon-pop.png" /></p>

 <div>
          <label for="newModelModel">Enter your Vehicle Model</label><br />
          <input type="text" name="newModelModel" id="newModelModel" />
 </div>  
 
<p style="color: hsl(0, 0%, 40%);    font-size: 14px;    margin-top: 10px;    text-align: center; font-weight:300;">The Vehicle model entered above will be reviewed by our team.</p>
       
          <input type="button" value="Submit" id="newModelSubmit" />
  
 </div>