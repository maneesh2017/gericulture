<script src="<?php echo $this->config->item('system_path');?>js/input.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/form_validation.js"></script> 
<script type="text/javascript">
$(document).ready(function (e) {	
	$("#resentemail").on('submit',(function(e) {
		
		e.preventDefault();
		$('#watch-login').css("display", "block");
		$.ajax({
        	url: site_url+'user/resentemail', 
			type: "POST",
			data:  new FormData(this),
			contentType: false,
    	    cache: false, 
			processData:false, 
			success: function(data) 
		    {
			 if(data=='emailsent'){   
				 
				 $('#watch-login').css("display", "none");	
				 $('.success').slideDown(500); 	 
           <!--  html edit - 16 dec 2014  -->
				 $('.success').html("We have resent the activation email. Please check your email to activate your account.");				 
			 }
		    },
		  	error: function() 
	    	{
			 
	    	} 
			
	   });
	}));
	
	
	
	});	
</script>

 <div id="main_Wrapper"> <!--------start main wrapper--------->
   <header>
    <figure id="figure-logo" class="logo-bg">
    <!--  html edit - 12 nov 2014  -->
      <a href="<?php echo base_url(); ?>"><img src="<?php echo $this->config->item('system_path');?>img/geri-logo.png" alt="logo" /></a>
    </figure>
 
    <article id="signUpPage">
      <hgroup>
       <h1 style="padding-top:14px;">Account Activation</h1>
      </hgroup>
    </article>  
  </header>
  
   <section id="contentWrap1"><!--------start content wrapper--------->
   
   <?php 
   $message = $this->session->userdata('message');
   
   $email =  $this->session->userdata('email');
   $activation_code = $this->session->userdata('activation_code');
   if(!empty($message)){	if($message=='found')  {  
	   ?>
    <div id="formSignUp">		
      <section id="activeEmaillConfirm">  
         <h1>Your account is active now.</h1>
         <p>Now, you will be able to login using your vehicle registration 
          number and your chosen password.</p>
      </section>
      <aside id="continueToLogin">
      <!--  html addition - 12 nov 2014  -->
      <a href="<?php echo base_url(); ?>">Continue</a>
      </aside> 
    </div> 
		<?php   } elseif($message=='active') {  ?>
		
		 <div id="formSignUp">		
      <section id="activeEmaillConfirm">
         <h1>This activation link has expired.</h1>
         <p>It expired because your account is already active and you will be able to
     login using your vehicle number and password.</p>
      </section>
      <aside id="continueToLogin">
      <!--  html addition - 12 nov 2014  -->     
      <a href="<?php echo base_url(); ?>">Continue</a>
    
      </aside>
    </div> 
	<?php }elseif($message=='expired') {  ?> 
	
    <div id="formSignUp">	 	
      <section id="activeEmaillConfirm">
         <h1>This activation link has expired.</h1>
         <p>Activation link expires after 24 hours. To activate your account you have
     to resend the activation email.</p>
      </section>
      <aside id="continueToLogin">    
     
        <form  id="resentemail" name="resentemail" method="post">
		<input id="email" name="email" type="hidden" value="<?php echo $email; ?>" >
		<input id="activation_code" name="activation_code" type="hidden" value="<?php echo $activation_code; ?>"  >
      <!--  html edit - 13 dec 2014  -->
	    <input name="submit" type="submit" id="resndActivationEmailBtn" value="Resend activation email" >       
	    <span style="display: none;" id="watch-login"><img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif"></span>
         </form>
      </aside>   
    </div>
      <!--  html edit - 13 dec 2014  -->
        <p class="success" id="success"></p> 
    <?php }else{ $this->session->unset_userdata('message'); ?> 	
    <div id="formSignUp">		
      <section id="activeEmaillConfirm">
         <h1>This activation link has expired</h1>
         <p>Activation link expires after 24 hours. To activate your account you have
     to resend the activation email.</p>   
      </section>
      <aside id="continueToLogin">
	<?php   
       $email =  $this->session->userdata('email');
       $activation_code = $this->session->userdata('activation_code');     
     ?>
      <!--  html addition - 12 nov 2014  -->
		<form  id="resentemail" name="resentemail" method="post">
		<input id="email" name="email" type="hidden" value="<?php echo $email; ?>" >
		<input id="activation_code" name="activation_code" type="hidden" value="<?php echo $activation_code; ?>"  >
		<!--  html edit - 13 dec 2014  -->
		<input name="submit" type="submit" id="resndActivationEmailBtn" value="Resend activation email" >
		<span style="display: none;" id="watch-login"><img src="<?php echo $this->config->item('system_path');?>img/speedometer.gif"></span>
		</form>
      </aside>  
    </div>    
      <p class="success" id="success"></p>  
     
    <?php } } ?>
     
  </section><!---------close content wrapper--------->
  

  

 </div><!--------close main wrapper--------->
