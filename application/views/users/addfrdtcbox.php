<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>css/jquery-ui.css">
<script src="<?php echo $this->config->item('system_path');?>js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>css/stylenew.css">
<script type="text/javascript" src="http://www.google.com/jsapi"></script>   
<div id="addFrdToCircleBox" class="popup_content" style="display:block">
<!--<span class="button b-close"><span>X</span></span>-->
       <header>
         <hgroup><h1>Add friends/rides</h1></hgroup>
         <p>(you can add only those people that are already in your friend list)</p>
       </header>
       <section id="addFrdToCircleForm">
		<!--<div class="ui-widget"style="margin-top:100px">
		<form  id="searchForm" name="form" method="post">
		<input id="tags" name="search" type="text">
		</form>
		</div>-->
          <ul>
            <li>
              <div class="ui-widget" >
             <p class="marginBttm16">Search friends / rides</p>
            <form class="floatLeft" method="post" > 
              <!--<input type="search" class="input widthInput_273 marginRight10" id="tags" placeholder="Search by name..." name="searchname"  />-->
              <input type="search" class="input widthInput_273 marginRight10" id="inputString" placeholder="Search by name..." name="searchname"  />
              
                <!--<div id="suggestions"></div>-->
                <div class="searchSuggestBox" style="display:none;" id="suggestions" >
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
            <form class="floatLeft" method="post">
           <input type="search" class="input widthInput_273" id="regtags" placeholder="Search by registration number..." />
              <!--<input type="text" size="30" value="" id="inputString" onkeyup="lookup(this.value);" />-->
              <div id="suggestions"></div>
              <div class="searchRegSuggestBox" style="display:none;background-position:232px 0;" >
                      <ul class="subMenuMain3 positionAbs" style="right:160px;">
						  
						  
                        <li>
                         <a href="">
                           <img class="floatLeft" alt="car" src="<?php echo $this->config->item('system_path');?>img/pic10.jpg">
                           <div class="floatLeft">
                              <h1 class="marginTop3 colorRed">PB27C0093 - Volkswagen Polo</h1>
                              <p class="marginTop2 color666">Aman Mander</p>
                           </div>
                          <img class="floatRight" alt="user" src="<?php echo $this->config->item('system_path');?>img/rider-user-pic.jpg">
                         </a>
                        </li>                   
                       
                        
                      </ul>
                    </div>
            </form>
          </div>
            </li>
          </ul>
          <ul class="listAddFrd">
		 <?php if(!empty($gerifriendlist)) { foreach($gerifriendlist as $gfl){ ?>	  
           <li>
             <a href="<?php echo base_url() ?>user/aboutOthers/<?php echo $gfl['usersid'] ?>">
             <img src="<?php echo base_url(); ?>uploads/gallery/small/<?php echo $gfl['profile_pic'] ?>" class="floatLeft marginRyt1" alt="rider">
             </a>
             <a href="<?php echo base_url() ?>user/aboutRidesother/<?php echo $gfl['usersid'] ?>">
			 <img src="<?php echo base_url(); ?>uploads/gallery/small/<?php echo $gfl['image'] ?>" class="floatLeft" alt="rider">
			 </a>
             <div class="floatLeft marginLft15">
             <h1>
			 <a href="<?php echo base_url() ?>user/aboutOthers/<?php echo $gfl['usersid'] ?>"><?php echo $gfl['first_name'].'&nbsp;'.$gfl['last_name'];  ?> </a>
			 </h1>
               <p><a href="<?php echo base_url() ?>user/aboutRidesother/<?php echo $gfl['usersid'] ?>" class="marginTop4"><?php echo $gfl['username']; ?></a></p>
               <span><a href="<?php echo base_url() ?>user/aboutRidesother/<?php echo $gfl['usersid'] ?>" class="marginTop4"><?php echo $gfl['make']; ?></a></span>
             </div>
             <a href="#" class="addFrdGeriCircle1 marginTop15 floatRight" style="position:inherit;">Add friend / ride</a>
           </li>
           <?php }} ?>
          </ul>
		
       </section> 
     </div>  
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery-1.3.1.min.js"></script>
<script>
$(function () {
/*
var availableTags = [
<?php  foreach($gerifriendlist as $gfl){
	echo '"';
	echo "<img src='".base_url().'uploads/gallery/small/'.$gfl['profile_pic']."'>  ".$gfl['first_name'];
	echo '",';
 } ?>

];
var availableRegTags = [

<?php  foreach($gerifriendlist as $gfl){?>
"<?php echo $gfl['username'];?>",
<?php } ?>
"PHP",
"Scheme"
];
$( "#tags" ).autocomplete({
source: availableTags
});
$( "#regtags" ).autocomplete({
source: availableRegTags
});*/ 


	$("#inputString").keypress(function(event) {
	
        if (event.keyCode == 13) {	
		var searchname = $('#inputString').val();
		
	$.ajax({
            url: site_url+'ride/search',
			type: "POST",
			//data:  new FormData($('form')[0]),
			data:'searchname='+ searchname,			
			success: function(data)
		    {
			alert(data);
			$('.listAddFrd').html(data);
		    },				
		  	error: function() 
	    	{
			alert('soomething wronge');
			return false;
	    	} 
	   });
	   return false;
	  } 
	  });
	/* $("#regtags").keypress(function(event) {
	
        if (event.keyCode == 13) {	
		var regtags = $('#regtags').val();
		
	$.ajax({
            url: site_url+'ride/regsearch',
			type: "POST",
			//data:  new FormData($('form')[0]),
			data:'regtags='+ regtags,			
			success: function(data)
		    {
			alert(data);
			$('.listAddFrd').html(data);
		    },				
		  	error: function() 
	    	{
			alert('soomething wronge');
			return false;
	    	} 
	   });
	   return false;
	  } 
	  }); */    
	   
	  
	
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

$('#inputString').keyup(function(){
	if(inputString.length == 0) {
		$('#suggestions').fadeOut(); // Hide the suggestions box
	} else {
		$.post("searchdata", {queryString: ""+inputString+""}, function(data) { // Do an AJAX call
			$('#suggestions').fadeIn(); // Show the suggestions box
			$('#suggestions').html(data); // Fill the suggestions box
		});
	}
});	 
	 
	  
	  
});	
</script>
	   
