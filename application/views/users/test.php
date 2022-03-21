
        <!--<link rel="stylesheet" href="http://www.formmail-maker.com/var/demo/jquery-popup-form/colorbox.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://www.formmail-maker.com/var/demo/jquery-popup-form/jquery.colorbox-min.js"></script>-->
		<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>css/colorbox.css" />    
		<!--<link rel="stylesheet" href="<?php //echo $this->config->item('system_path');?>css/setup.css" />    
		<link rel="stylesheet" href="<?php //echo $this->config->item('system_path');?>css/style.css" />-->    
	      
		<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/jquery.colorbox-min.js"></script>
        <script>
            $(document).ready(function(){
		
              $(".iframe").colorbox({iframe:true, fastIframe:false, width:"980px", height:"569px", transition:"fade", scrolling   : false});
               
           
              
             });
				
        </script>
         
    
        <p><h3>Click here for the popup form demo : <a class='iframe' href="http://chd.rexwebsolution.com/user/testfrmae">Contact Us</a></h3></p>
