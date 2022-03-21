<?php  
$getListVehicleType=getListVehicleType();
if($search_query['type']!='0')
{
	$getListVehicleBrand=getListVehicleBrand($search_query['type']);
	
	if($search_query['brand']!='0')	
		$getListVehicleModel=getListVehicleModel($search_query['brand'],$search_query['type']);
}
	
$getStateList=getStateList();
//$getStateList2=getStateList2();
$ageRangeList=ageRangeList();
//see($search_query);
$current_state=$Userdetail['state'];
$cc=cityNameFromId($search_query['city']);
?>
<script>
$(document).ready(function()
{
	$('.jkl').val("<?php echo $cc; ?>");
	$(window).resize(checkSize);
	checkSize(); 
});

function checkSize()
{
	if ($("#searchPeopleDetails section article figure.riderFig").css("width") <= "238px" ){
		$("#searchPeopleDetails section article figure.riderFig a img").attr("width", "238").attr("height", "105");
	}else{
		$("#searchPeopleDetails section article figure.riderFig a img").attr("width", "258").attr("height", "114");
	}
}

function getBrandList()
{
	 $('.vehiclemakeloadrc').show();
	var d=$("#type").val();
			 $.ajax({ 
 					url:site_url+'setting/getCarBikeBrands/'+d,
 					success:function(data)
					 { 
					 $('.vehiclemakeloadrc').hide();
				data='<option value="0">Select</option>'+data;
				$('#brand').html(data);
				getModelList();
			 }
			 }); 
			
		 }
		 
		 function getModelList()
		{
			$('.vehiclemodelloadrc').show();
			var d=$("#brand").val();
			var t=$("#type").val();
			 $.ajax({ 
 					url:site_url+'setting/getCarBikeModels/'+d+'/'+t,
 					success:function(data)
					 { 
					 $('.vehiclemodelloadrc').hide();
						 data='<option value="0">Select</option>'+data;
						 $('#model').html(data);
					 }
			 }); 
			
		 }
		 
		 
function clearBrowseRidesForm(id)
{
	if(id=='browserides-vehicle_details')
	{
		$('#browserides-vehicle_details #type, #browserides-vehicle_details #brand, #browserides-vehicle_details #model').val(0);
		$('#browserides-vehicle_details input[name="year_model"').val('');
	}
	else if(id=='browserides-location')
	{
	$('#browserides-location #state').val(0);
		$('#browserides-location input[name="city"').val('');
	}
	
	else if(id=='browserides-people')
	{
	$('#browserides-people input[name="first_name"').val('');
	$('#browserides-people input[name="sur_name"').val('');
	$('#browserides-people #gender').val(0);
	$('#browserides-people #age_range').val(0);

	}
	else if (id='browserides-vehicle_number')
	{
	$("#vehicle-default").prop("checked", true);
	$("#vehicle-starting").prop("checked", false);
	$("#vehicle-ending").prop("checked", false);
	$('#browserides-vehicle_number input[name="vehicle_number"').val('');
	}
	
	$('#'+id+' .update-btn').trigger('click');
}


function turnOffLocation()
{
	$(".top-blu-aside").slideUp("slow");
	$("#filter_result_roll_top").addClass("filter_result_roll_top");
	$('.locationSearch').val(0);
	$('#vehicles_nearby').submit();
}

function turnOnLocation()
{
	$('.locationSearch').val(1);
	$('#vehicles_nearby').submit();
}
	

	
	$(function () {

        $("#range").ionRangeSlider({
            hide_min_max: true,
            keyboard: true,
            min: 5,
            max: 50,
            /*from: 20,*/
			 grid: true,
			 step: 5,
			 grid_snap: true,
			 onChange: function (data) {
					 $('#radiusValText').text(data.from+' Kms');
    			},
				onStart: function (data) {
        			 $('#radiusValText').text(data.from+' Kms');
   				 },
    });
	
	
		 
$('#vehicle_cityS,#browsePageMyLoc_cityS').keyup(function()
               {
					if($('#state').val()!='')
					{
						$('#vehicle_city').val('');
						$('#locationFormSubmitBtn').hide();				
						$('#browsePageMyLoc_city').val('');
						citySuggestions();
					}
					else
					{
						errorBar("Select state to enter city");
						$('#state').addClass('formFieldError');
					}
			  });
			  
			  $('#state').change(function(){
					  if($(this).val()!='')
					  	$('#state').removeClass('formFieldError');
				  });
			  
			
			  
			  
			 
			$('#browsePageMyLocBtn').click(function(){
				
					$('#browsePageMyLoc_cityS').removeClass('formFieldError');
					var city=$('#state').val();
					var cityS=$('#browsePageMyLoc_cityS').val();
					//alert(city);
					//alert(cityS);
					if(city=='' || cityS=='')
					{					
					     errorBar("City is required to browse rides & people");
						$('#browsePageMyLoc_cityS').addClass('formFieldError');
					}
					else
					{
						$('#browsePageMyPImg').show();
						//$('#browsePageMyLocBtn').hide();
						$.ajax({
							url:'<?=site_url()?>user/saveMyLoc',
							type:'POST',
							data:$('#browsePageMyLocForm').serialize(),
							success:function(data)
								{
									$('#browsePageMyPImg').hide();
						            //$('#browsePageMyLocBtn').show();
									if(data=='LO')
							  			window.parent.location='<?=site_url()?>';
									else
										window.location.reload();	
								}
							});
					}	
				});
	  
    });
	$('#vehicle_cityS').val('ww');
	
	
</script>





<section id="contetDivWrap" class="paddngBttm100"><!----------html edit - 06 jan 2015---------->
<!---------start section----------->
     
       <hgroup id="pageHeadng1">
         <h1>Browse Rides and People</h1>
       </hgroup>
         
       <div class="clear"></div>
       
       <article id="rider-journey-people" class="overFlowInherit"><!---------start article rider-journey-people----------->
         <!-- <header>
            <nav>
              <ul>
                <li class="activeUserLi"><a href="<?php echo base_url();?>user/browserides">Rides</a></li>
               
              </ul>
            </nav>
          </header>-->
          
          <article id="searchPeopleDetails" class="browserides"><!---------start articlesearchPeopleDetails--------->
            <?php if($Userdata[0]['city']==''){?>
                
                      <form id="browsePageMyLocForm" data-enhance="false">
                      <h6>Please enter your location to browse rides</h6>
                      <p class="clearBoth"></p>
                      <div class="browsePageMyLocholl">
                              <p>
                                      <label style="">State</label>
                                      <select id="state" name="state" style="float: none; padding:0px; vertical-align:top;" class="fontStyle16 choice inputStyleSelect" onchange="clearCityVal();">
                                       <option value="">Select state</option>
                                      <?php
									  foreach($getStateList as $sTypeK=>$sTypeV){					  
										  ?>
                                      <option value="<?=$sTypeK?>" <?php if($sTypeK==$current_state){echo 'selected="selected"';}?> ><?=$sTypeV?></option>
                                      
                                       <?php }?>
                                   </select>
                              </p>
                              
                              <p>
                              <label style="">City/Town</label>
           <input style="" type="text" id="browsePageMyLoc_cityS"  class="input fontStyle16 inputStyle" placeholder="" autocomplete="off">
                                
                                <span class="citySuggestionsSearching" style="display:none;"><img src="<?php echo $this->config->item('system_path');?>img/circle-load.gif"></span>
                                 </p>
            					  <input type="hidden" id="browsePageMyLoc_city" name="city" >                                  
                                  <div id="browsePageMyLoc_citySuggestionsBridePage" class="citySuggestionsWrapper positionAbs" style="display:none; width: 298px; overflow-y: auto; overflow-x: hidden; height: 250px; font-size: 10px; z-index: 9; top: 207px;"></div>
           						  <p id="browsePageMyPImgSpan">
                                  	<input type="button" value="Submit" id="browsePageMyLocBtn"/>
                                  <img width="32" height="32" alt="waiting-watch" src="<?=system_path()?>img/speedometer.gif" id="browsePageMyPImg" style="display:none;"> 
                                   </p> 
                                 
                                 <p class="clearBoth"></p>
                                 </div>
                      </form>
				<?php }else{?>
			
            <?php //if(isset($_POST['locationSaved'])){?>
            <section class="new">
              <div>
              		<hgroup class="floatLeft"><h6><?=$bridecount?> vehicle<?php if($bridecount!=1){echo 's';}?> found<?php if($search_query['locationSearch']==1){echo " in ".cityNameFromId($search_query['city']).', '.$getStateList[$search_query['state']];}?></h6></hgroup><!--<p class="floatRight">Sort List</p>-->
                    <?php if($search_query['locationSearch']==1){?>
	                    <a href="javascript:turnOffLocation();" class="turn-off">Turn Off location search</a>
                    <?php } else{ ?>
                        <a href="javascript:turnOnLocation();" class="turn-off turn-on">Turn On location search</a>
                    <?php } ?>                        
                </div>
               <?php  if(!empty($bride)) { ?>
			  <?php $this->load->view('users/browserides_results');?>
             <?php }
			 else{
			 ?>
             <div class="location-on-text">
                 <p>We cannot find any profiles within <?=$search_query['km']?> Kms of your location.</p>
                 <ol type="1">
                 <li>You can <b>Increase the Km radius</b> to cover more search area.</li>
                 <li>Or try to <b>Turn off location search</b> to see all the profiles irrespective of the area.</li>
                 </ol> 
             </div>
             <div class="location-on-img"><img src="<?=system_path()?>img/empty-gauge.png"></div>
             <?php } ?>
             
             
            </section>
            <?php //} else {echo "Loading";}?>
             
            <aside>
            
            <div id="filter_result_roll_top"><h1>Search by location</h1></div>
            
            <div class="top-blu-aside" <?php if($search_query['locationSearch']==0){echo 'style="display:none;"';}?>>
            <hgroup><h6>Location</h6></hgroup>
			<form id="vehicles_nearby" action="">           
            	
            	<p>
                  <label style="font-size:14px; color:#555555; font-weight:normal;">State</label><br />
                       <select id="state" name="state" style="float: none; width: 287px; padding:0px; vertical-align:top; margin-top: 5px;" class="fontStyle16 choice inputStyleSelect" onchange="clearCityVal();">
                        <?php foreach($getStateList as $sTypeK=>$sTypeV){?>
                        <option value="<?=$sTypeK?>" <?php if($sTypeK==$search_query['state']){echo 'selected="selected"';}?>><?=$sTypeV?></option>
						<?php }?>
                       </select>
                       </p>
            
            
            <p>
            <label style="font-size:14px; color:#555555; font-weight:normal;">City / Town </label><br />
             <input type="text" id="vehicle_cityS"  class="input fontStyle16 inputStyle jkl" placeholder="" style="float:none; width:275px; margin-top: 5px;" value="" autocomplete="off" > 
           <?php /* <input type="text" id="vehicle_cityS"  class="input fontStyle16 inputStyle" placeholder="" style=" float:none; width:275px; margin-top: 5px;" value="<?=cityNameFromId($search_query['city'])?>" autocomplete="off" >
		    */?>
            <span class="citySuggestionsSearching" style="display:none;"><img src="<?php echo $this->config->item('system_path');?>img/circle-load.gif"></span>
            </p>
            
            <input type="hidden" id="vehicle_city" name="city" value="<?=$search_query['city']?>">
            
            <div id="citySuggestionsBridePage" class="citySuggestionsWrapper positionAbs" style="display:none;width: 288px; overflow-y: auto; overflow-x: hidden; height:250px; font-size: 10px; z-index: 9; top: 144px;"></div>
            
            <p class="marginTop10">Search within the radius of <b id="radiusValText"><?=$search_query['km']?> Kms</b></p>

 
                <div style="padding-bottom: 25px; margin-top: -15px; position: relative;">
                    <div>
                        <input type="text" id="range" value="<?=$search_query['km']?>" name="km" />
                    </div>
                                    </div>

              <input type="hidden" name="first_name" value="<?=$search_query['first_name']?>"   />
              <input type="hidden" name="sur_name" value="<?=$search_query['sur_name']?>"   />
              <input type="hidden" name="gender" value="<?=$search_query['gender']?>"   />
              <input type="hidden" name="age_range" value="<?=$search_query['age_range']?>"   />
              
              <input type="hidden" name="type" value="<?=$search_query['type']?>"   />
              <input type="hidden" name="year_model" value="<?=$search_query['year_model']?>"   />
              <input type="hidden" name="brand" value="<?=$search_query['brand']?>"   />
              <input type="hidden" name="model" value="<?=$search_query['model']?>"   />
              
              <input type="hidden" name="vehiclenumber" value="<?=$search_query['vehiclenumber']?>"   />
              <input type="hidden" name="vehicle_number" value="<?=$search_query['vehicle_number']?>"   />
            
              <input type="hidden" name="locationSearch" class="locationSearch" value="<?=$search_query['locationSearch']?>"   />
              
             <?php if($search_query['locationSearch']==1){?>
			            <input type="button" class="marginTop10 update-btn" value="Update" id="locationFormSubmitBtn" onclick="$('#vehicles_nearby').submit();">
                        <a href="javascript:turnOffLocation();" class="turn-off">Turn off location</a>
            <?php } else{?>
			            <a href="javascript:turnOnLocation();" class="turn-off turn-on">Turn on location</a>
            <?php }?> 


			</form>            
           
            </div>

<div id="filter_result_roll"><h1>Filter your results</h1></div>

<div class="rolldown_details">

            <div>
              <hgroup><h6>Vehicle number</h6></hgroup>
     			<form id="browserides-vehicle_number">
                  	<div class="floatLeft">
    
                       <p>
              <input type="text" value="<?php if(isset($search_query['vehicle_number'])){echo trim($search_query['vehicle_number']);}?>" style=" float:none; width:275px; margin-bottom:15px;" placeholder="Enter vehicle number" class="input fontStyle16 inputStyle" name="vehicle_number" id="vehicle_number">
                   	   </p>
                  
                        <p id="browse_people" class="clear radioBtnBg">
                                <input type="radio" name="vehiclenumber" id="vehicle-default"  value="3"<?php if($search_query['vehiclenumber']==0 || $search_query['vehiclenumber']==3){echo 'checked="checked"';}?> class="input marginRight10" style=""><label for="vehicle-default"><span style=" margin-top:-5px;"></span>Default</label>
                                <input type="radio" name="vehiclenumber" id="vehicle-starting" value="1"<?php if($search_query['vehiclenumber']==1){echo 'checked="checked"';}?> class="input marginRight10" style=""><label for="vehicle-starting"><span style="margin-top:-5px;"></span>Numbers starting with</label>
                                <input type="radio" name="vehiclenumber" id="vehicle-ending"  value="2"<?php if($search_query['vehiclenumber']==2){echo 'checked="checked"';}?> class="input marginRight10" style=""><label for="vehicle-ending"><span style=" margin-top:-5px;"></span>Numbers ending with</label>	   
                        </p>
                   
                       <input type="hidden" name="first_name" value="<?=$search_query['first_name']?>"   />
                       <input type="hidden" name="sur_name" value="<?=$search_query['sur_name']?>"   />
                       <input type="hidden" name="gender" value="<?=$search_query['gender']?>"   />
                       <input type="hidden" name="age_range" value="<?=$search_query['age_range']?>"   />
                                                                
                      <input type="hidden" name="type" value="<?=$search_query['type']?>"   />
                      <input type="hidden" name="year_model" value="<?=$search_query['year_model']?>"   />
                      <input type="hidden" name="brand" value="<?=$search_query['brand']?>"   />
                      <input type="hidden" name="model" value="<?=$search_query['model']?>"   />
            
                      <input type="hidden" name="state" value="<?=$search_query['state']?>"   />
                       <input type="hidden" name="city" value="<?=$search_query['city']?>"   />
                       <input type="hidden" name="km" value="<?=$search_query['km']?>" />
                       <input type="hidden" name="locationSearch" class="locationSearch" value="<?=$search_query['locationSearch']?>"   />
            
                       <input type="submit" value="Update" name="submit" class="marginTop10 update-btn" />
                   
                      <a class="browse-clear" href="javascript:clearBrowseRidesForm('browserides-vehicle_number');">Clear</a>

                  </div>
              </form>
              
              </div>
              
              <div>
              <hgroup><h6>Vehicle details</h6></hgroup>
     				<form id="browserides-vehicle_details">
                  		<div class="floatLeft">
                 			 <p class="floatLeft">
                  				<span style="float:left; margin-right:5px;">
                 				 <label style="font-size:14px; color:#555555; font-weight:normal;">Type</label><br />
                       			 <select id="type" name="type" style="float: none; width: 140px; padding:0px; vertical-align:top; margin-top: 5px;" class="fontStyle16 choice inputStyleSelect" onchange="getBrandList()">
                        				<option value="0">Select</option>
                        				<?php foreach($getListVehicleType as $vTypeK=>$vTypeV){?>
					                        <option value="<?=$vTypeK?>" <?php if($vTypeK==$search_query['type']){echo 'selected="selected"';}?>><?=$vTypeV?></option>
										<?php }?>
                       			  </select>
                       			</span>
                       
                                 <span style="float:left;">
                                   <label style="font-size:14px; color:#555555; font-weight:normal;">Year model</label><br />
                                   <input type="text" name="year_model" class="input fontStyle16 inputStyle"  placeholder="" style="width:130px; float:none; margin-top: 5px; height:38px;"  value="<?php if(isset($search_query['year_model'])){echo trim($search_query['year_model']);}?>">
                                </span>
                      </p>
                      
                      <p class="floatLeft">
                      	<span style="float:left; margin-right:5px; position:relative;">
                  			<label style="font-size:14px; color:#555555; font-weight:normal;">Make</label><br />
                      			 <select style="float: none; width: 139px; padding: 0px; vertical-align:top;  margin-top: 5px;" class="fontStyle16 choice inputStyleSelect" name="brand" id="brand" onchange="getModelList()">
                       				 <option value="0">Select</option>
                         			 <?php if($search_query['type']!='0'){foreach($getListVehicleBrand as $brandK=>$brandV){?>
                          			<option value="<?=$brandK?>" <?php if($search_query['brand']==$brandK){echo 'selected="selected"';}?>><?=$brandV?></option>
                          			<?php }} ?>
                       			</select>
                         <span class="vehiclemakeloadrc" style="display:none;"><img src="<?php echo $this->config->item('system_path');?>img/circle-load.gif"></span>
                       </span>
                       <span style="float:left; position:relative;">
                       			<label style="font-size:14px; color:#555555; font-weight:normal;">Model</label><br />
					   				<select style="float: none; width: 140px; padding: 0px; vertical-align:top; margin-top: 5px;" class="fontStyle16 choice inputStyleSelect" name="model" id="model">
                        				<option value="0">Select</option>
                          				<?php if($search_query['type']!='0'){foreach($getListVehicleModel as $brandK=>$brandV){?>
                          				<option value="<?=$brandK?>" <?php if($search_query['model']==$brandK){echo 'selected="selected"';}?>><?=$brandV?></option>
                          				<?php }} ?>
                       				</select>
                        <span class="vehiclemodelloadrc" style="display:none;"><img src="<?php echo $this->config->item('system_path');?>img/circle-load.gif"></span>
                       </span>                       
                      </p>
			 
                    <input type="hidden" name="first_name" value="<?=$search_query['first_name']?>"   />
                    <input type="hidden" name="sur_name" value="<?=$search_query['sur_name']?>"   />
                    <input type="hidden" name="gender" value="<?=$search_query['gender']?>"   />
                    <input type="hidden" name="age_range" value="<?=$search_query['age_range']?>"   />
                    
                    <input type="hidden" name="vehiclenumber" value="<?=$search_query['vehiclenumber']?>"   />
                    <input type="hidden" name="vehicle_number" value="<?=$search_query['vehicle_number']?>"   />
                    
                    <input type="hidden" name="state" value="<?=$search_query['state']?>"   />
                    <input type="hidden" name="city" value="<?=$search_query['city']?>"   />
                    <input type="hidden" name="km" value="<?=$search_query['km']?>" />
                    <input type="hidden" name="locationSearch" class="locationSearch" value="<?=$search_query['locationSearch']?>"   />
                    
                    <input type="submit" value="Update" name="submit" class="marginTop10 update-btn" />
					   <a class="browse-clear" href="javascript:clearBrowseRidesForm('browserides-vehicle_details');">Clear</a>
                  </div>
				 
              </form>
              
              </div>
              
              
              <div style="margin-bottom: 1px;">
              <hgroup><h6 style="float:left; ">People</h6></hgroup>
              
                <form id="browserides-people">
                  <div class="floatLeft">
				  
				  <p class="floatLeft">
                  <span style="float:left; margin-right:5px;">
                  <label style="font-size:14px; color:#555555; font-weight:normal;">Firstname</label><br>
                       <input type="text" name="first_name" class="input fontStyle16 inputStyle"  placeholder="Firstname" style="width:129px; float:none;margin-top: 5px;"  value="<?php if(isset($search_query['first_name'])){echo trim($search_query['first_name']);}?>">
                       </span>
                       
                       <span style="float:left;">
                       <label style="font-size:14px; color:#555555; font-weight:normal;">Surname</label><br>  
                       <input type="text" name="sur_name" class="input fontStyle16 inputStyle"  placeholder="Surname" style="width:129px; float:none;margin-top: 5px;"  value="<?php if(isset($search_query['sur_name'])){echo trim($search_query['sur_name']);}?>">
                      </span>
                      </p>
                      
                      <p class="floatLeft">
                      <span style="float:left; margin-right:5px;">
                  <label style="font-size:14px; color:#555555; font-weight:normal;">Gender</label><br>
                      <select  id="gender" name="gender" class="fontStyle16 choice inputStyleSelect" style="float: none; width: 140px; margin-top: 5px;padding: 0px; vertical-align: top;  color: rgb(136, 136, 136);">
                        <option value="0">Select</option> 
                        <option value="male" <?php if($search_query['gender']=='male'){echo 'selected="selected"';}?>>Male</option> 
                        <option value="female" <?php if($search_query['gender']=='female'){echo 'selected="selected"';}?>>Female</option>                      
                       </select>
                       </span>
                       <span style="float:left;">
                  <label style="font-size:14px; color:#555555; font-weight:normal;">Age range</label><br>
					 <select  id="age_range" name="age_range" class="fontStyle16 choice inputStyleSelect" style="float: none; width: 139px;margin-top: 5px; padding: 0px; vertical-align: top;  color: rgb(136, 136, 136);">
                        <option value="0">Select</option> 
						<? foreach ($ageRangeList as $kno=>$yrange){ ?>
						<option value="<?=$kno?>" <?php if($kno==$search_query['age_range']){echo 'selected="selected"';}?>><?=$yrange?></option> 
						<? } ?>                     
                       </select>
                       </span>
                       </p>
                       
                      <input type="hidden" name="type" value="<?=$search_query['type']?>"   />
                      <input type="hidden" name="year_model" value="<?=$search_query['year_model']?>"   />
                      <input type="hidden" name="brand" value="<?=$search_query['brand']?>"   />
                      <input type="hidden" name="model" value="<?=$search_query['model']?>"   />
                      
                      <input type="hidden" name="vehiclenumber" value="<?=$search_query['vehiclenumber']?>"   />
                      <input type="hidden" name="vehicle_number" value="<?=$search_query['vehicle_number']?>"   />
                      
                      <input type="hidden" name="state" value="<?=$search_query['state']?>"   />
                      <input type="hidden" name="city" value="<?=$search_query['city']?>"   />
                      <input type="hidden" name="km" value="<?=$search_query['km']?>" />
                      <input type="hidden" name="locationSearch" class="locationSearch" value="<?=$search_query['locationSearch']?>"   />
 
					   <input type="submit" value="Update" name="submit" class="marginTop10 update-btn" />
                       
                       <a class="browse-clear" href="javascript:clearBrowseRidesForm('browserides-people');">Clear</a>
                  </div>
              </form>
              </div>
 
 </div>
              
            </aside>
          <?php } ?>  
          </article><!---------close articlesearchPeopleDetails--------->
       <div class="load-more-flash">
             <a href="javascript: void(0)" id="loadMoreFlashesProcess"><img src="<?=system_path()?>img/circle-load-32-blue.gif"></span></a> 
         </div>
       </article><!---------close article rider-journey-people----------->
       
    </section><!---------close section----------->

<script type="text/javascript">
  //if($('.browseRideSingle').length==totalFlashesOnMe)
			//$('#loadMoreFlashes').hide();
			
 $(document).ready(function(){
	 var flashPageNo=1;
 var totalFlashesOnMe=<?=$bridecount?>;
	 
	 	//$('#loadMoreFlashes').click(function(){
		//$('#container').on('click','#loadMoreFlashes',function(){
			$('#loadMoreFlashesProcess').hide();
			$(window).scroll(function()
			 {
				if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) 
				{
					
			//$('#loadMoreFlashes').text('Loading...');
					//$('#loadMoreFlashes').hide();
					 if($('.browseRideSingle').length<totalFlashesOnMe)
					{
					   if($('.browseRideSingle').length<totalFlashesOnMe)
					    {
						$('#loadMoreFlashesProcess').hide();
						}
						else
						{
						//alert($('.flashesByMeSingle').length+' '+totalFlashesByMe);			
							$('#loadMoreFlashesProcess').show();
						}			
				     $('#loadMoreFlashesProcess').show();
				flashPageNo++;
				
					$.ajax({
						url:'<?=site_url()?>user/loadMorerides/'+flashPageNo,
						type:'POST',
						data:$('#browserides-vehicle_number').serialize(),
						success:function(data)
								{
									$('#searchPeopleDetails section.new').append(data);
									//$('#loadMoreFlashes').text('Load more...');
									//$('#loadMoreFlashes').show();
									$('#loadMoreFlashesProcess').hide();
									
										//if($('.browseRideSingle').length==totalFlashesOnMe)
										//$('#loadMoreFlashes').hide();	
								}
							
				});
				}
							}
				
			});
			
			
	$("#filter_result_roll").click(function(){
        $(".rolldown_details").slideToggle("slow");
		$("#filter_result_roll").toggleClass("filter_result_roll");
    });
	
		$("#filter_result_roll_top").click(function(){
        $(".top-blu-aside").slideDown("slow");
		$("#filter_result_roll_top").removeClass("filter_result_roll_top");
    });
	
			/*$(".turn-off").click(function(){
        $(".top-blu-aside").slideUp("slow");
		$("#filter_result_roll_top").addClass("filter_result_roll_top");
    });*/
	 
	 });
 </script>


