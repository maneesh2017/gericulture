<!--<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.barrating.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/edit.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.colorbox-min.js"></script>-->
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<!--<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery-1.3.1.min.js"></script>-->
<script>
$(function () {	
google.setOnLoadCallback(function()
{
	// Safely inject CSS3 and give the search results a shadow
	var cssObj = { 'box-shadow' : '#888 5px 10px 10px', // Added when CSS3 is standard
		'-webkit-box-shadow' : '#888 5px 10px 10px', // Safari
		'-moz-box-shadow' : '#888 5px 10px 10px'}; // Firefox 3.5+
	$("#suggestions").css(cssObj);
	
	// Fade out the suggestions box when not active
	 $("input").blur(function(){
	 	$('#suggestions').fadeOut();
	 });
});          

var afgdata_search;

$('#inputString').keyup(function(){
	$('#searchRegSuggestBox').hide();
	
	if(afgdata_search && afgdata_search.readystate != 4)
			  afgdata_search.abort();
	
	var inputString = $('#inputString').val();
	if(inputString.length == 0) {
		$('#suggestions').fadeOut(); // Hide the suggestions box
	} else {
		afgdata_search=$.post("afgdata", {queryString: ""+inputString+"",code: "name"}, function(data) { // Do an AJAX call
				  
				   if(data=='LO')
					  window.parent.location=site_url;	  
				  else if(data!='')
				  {
					  $('#suggestions').fadeIn(); // Show the suggestions box
					  $('#suggestions').html(data); // Fill the suggestions box
				  }
				  else
				  {
				  	  $('#suggestions').hide();
				  }
		});
	}
});	 




var afgdata_search_reg;

$('#searchRegInputField').keyup(function(){
	$('#suggestions').hide();
	
	if(afgdata_search_reg && afgdata_search_reg.readystate != 4)
			  afgdata_search_reg.abort();
	
	var inputString = $('#searchRegInputField').val();
	if(inputString.length == 0) {
		$('#searchRegSuggestBox').fadeOut(); // Hide the suggestions box
	} else {
		afgdata_search_reg=$.post("afgdata", {queryString: ""+inputString+"",code: "uname"}, function(data) { // Do an AJAX call
				  if(data=='LO')
					  window.parent.location=site_url;	  
				  else  if(data!='')
				  {
					  $('#searchRegSuggestBox').fadeIn(); // Show the suggestions box
					  $('#searchRegSuggestBox').html(data); // Fill the suggestions box
				  }
				  else
				  {
				  	  $('#searchRegSuggestBox').hide();
				  }
		});
	}
});	 
	 
	  
	  
});	
</script>
<!----------start-popup  add frd in geri circle-------------->
<div id="addFrdGeriCirclePopUp" class="popup_content" style="display:block"  >    
   <span class="button b-close"><span>X</span></span>
       <header>
         <hgroup><h1>Add friend to Geri Circle</h1></hgroup>
         <p>(you can add only those people that are already in your friend list)</p>
       </header>
       <section id="addFrdToCircleForm">
          <ul>
            <li>
              <div class="seachFrdForm">
             <p class="marginBttm16">Search friend</p>
            <form class="floatLeft">
              <!--<input type="search" class="input widthInput_273 marginRight10" id="searchInputField" placeholder="Search by name..." />-->
              <input type="search" class="input widthInput_273 marginRight10" id="inputString" placeholder="Search by name..." name="searchname"  />  
                <div class="searchSuggestBox" style="display:none;" id="suggestions"  >
                      <!--<ul class="subMenuMain3 positionAbs" style="left:63px;">
                        <li>
                         <a href="about-me-others.html">
                          <img class="floatLeft" alt="user" src="<?php echo $this->config->item('system_path');?>img/rider-user-pic.jpg">
                           <div class="floatLeft">
                              <h1 class="marginTop3 colorRed">Aman Mander</h1>
                              <p class="marginTop2 color666">PB27C0093 - Volkswagen Polo</p>
                           </div>
                           <img class="floatRight" alt="car" src="<?php echo $this->config->item('system_path');?>img/pic10.jpg">
                         </a>
                        </li>                       
                      </ul>-->
                    </div>
             </form>
             <form class="floatLeft">
              <input type="search" class="input widthInput_273" id="searchRegInputField" placeholder="Search by registration number..." />
              <div class="searchRegSuggestBox" style="display:none;background-position:232px 0;" id="searchRegSuggestBox">
                    </div>
            </form>
          </div>
            </li>
          </ul>
          <ul class="listAddFrd">
		  <?php  if(!empty($friendlist)){ foreach($friendlist as $fl){ ?>
           <li> 
             <a href="<?php echo base_url();?>user/aboutOthers/<?php echo $fl['usersid'] ?>">
             <img src="<?php echo base_url();?>uploads/gallery/verysmall/<?php echo $fl['profile_pic'] ?>" class="floatLeft marginRyt1" alt="rider">
             </a>
             <a href="<?php echo base_url();?>user/aboutRidesother/<?php echo $fl['usersid'] ?>">
             <img src="<?php echo base_url();?>uploads/gallery/verysmall/<?php echo $fl['image'] ?>" class="floatLeft" alt="rider">
             </a>
             <div class="floatLeft marginLft15">
               <h1><a href="<?php echo base_url();?>user/aboutOthers/<?php echo $fl['usersid'] ?>"><?php echo $fl['first_name'].'&nbsp;'.$fl['last_name'];  ?></a></h1>
               <p><a href="<?php echo base_url();?>user/aboutRidesother/<?php echo $fl['usersid'] ?>" class="marginTop4"><?php echo $fl['username'];?></a></p>
               <span><a href="<?php echo base_url();?>user/aboutRidesother/<?php echo $fl['usersid'] ?>" class="marginTop4"><?php echo $fl['model'];?></a></span>
             </div>
             <a href="javascript: void(0);" class="addFrdGeriCircle1 marginTop15 floatRight" onclick="return add_frd(<?php echo $fl['usersid']; ?>);"  style="position:inherit;">Add to geri circle</a>
           </li>
           <?php }} ?>
          </ul>
       </section>
 </div>  
       <!---------end-popup add frd in geri circle-------------> 
	   
