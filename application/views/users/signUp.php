<script src="<?php echo $this->config->item('system_path');?>js/jquery.bpopup.min.js" type="application/javascript"></script>
<!--<script src="<?php echo $this->config->item('system_path');?>js/input.js"></script>-->
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/form_validation.js"></script> 
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/mobilestyles.js"></script>
<script type="text/javascript">
$(document).ready(function(){	
$('.input').keypress(function (e) {
  if (e.which == 13) {
   return onSubmitForm();
  }
});

});


</script>
 <div id="main_Wrapper" class="signupPage"> <!--------start main wrapper--------->
    <header>
     
    <figure id="figure-logo" class="logo-bg">
    <!--  html edit - 12 nov 2014  -->
      <a href="<?php echo base_url(); ?>"><img src="<?php echo $this->config->item('system_path');?>img/geri-logo.png" alt="logo" /></a>
    </figure>
 
    <article id="signUpPage">
      <hgroup>
       <h1>Sign up below</h1>
      </hgroup>
      <p>and experience the connectedness on the road</p>
    </article>  
  </header>
  
     <div class="mobile_header_1">
      <a href="<?php echo base_url(); ?>" id="small_gc_logo" class="floatLeft" rel="Geri Culture Logo"><img src="<?php echo $this->config->item('system_path');?>img/geri-culture-small-logo.png" alt="logo" data-at2x="<?php echo $this->config->item('system_path');?>img/geri-culture-small-logo@2x.png" /></a>
      <hgroup class="floatRight"><h1>Sign Up</h1></hgroup>
     </div>
  
   <section id="contentWrap1"><!--------start content wrapper--------->
    <div id="formSignUp">
      <section class="bgContentMobile">
           <!--  html all lable and input addition and edit classes - 03 dec 2014  -->
           <!--  html all input edit name - 04 dec 2014  -->
        <form name="signupForm" id="signup_form" method="post">
          <div class="floatLeft">
          <div id="first-name" class="floatLeft widthAutoOver">
          <!--  html edit - 20 nov 2014  -->       
             <input type="text" name="fname" id="signup-fname" class="input"  onkeyup="clearLabel(this);giveBorder('password',this.id);" onkeydown="clearLabel(this);giveBorder('password',this.id);" placeholder="Firstname" value="" style="width:114px; margin-right:5px;" />
           </div>
           <div id="sur-name" class="floatRight widthAutoOver">
           <!--  html edit - 20 nov 2014  -->
             <input type="text" name="sname" id="signup-sname" placeholder="Surname" class="input" onkeyup="clearLabel(this);giveBorder('password',this.id);" onkeydown="clearLabel(this);giveBorder('password',this.id);" value="" style="width:114px;" />
           </div>
           <div id="reg-num" class="widthAutoOver">
           <!--  html edit - 20 nov 2014  -->
             <input type="text" name="reg" id="signup-reg" placeholder="Vehicle number" class="input" onkeyup="clearLabel(this);giveBorder('password',this.id);" onkeydown="clearLabel(this);giveBorder('password',this.id);" value="" />
           </div>
            <img src="<?php echo $this->config->item('system_path');?>img/sky-blue-border.png" alt="border" />
            <p style="line-height:18px; font-size:13px;color:#333333; margin-top:5px;">Your profile is based on your vehicle, so a genuine registration number is required</p>
          </div>
          <div class="floatRight">
           <div id="email-id" class="widthAutoOver">
           <!--  html edit - 20 nov 2014  -->
            <input type="text" name="email" class="input" placeholder="Email Id" id="signup-email" value="" onkeyup="clearLabel(this);giveBorder('password',this.id);" onkeydown="clearLabel(this);giveBorder('password',this.id);" />
           </div>
           <div id="pwd" class="widthAutoOver">
           <!--  html edit - 20 nov 2014  -->
            <input type="password" class="input" placeholder="Password" id="signup-pwd" name="pwd" value="" onkeyup="clearLabel(this);giveBorder('password',this.id);" onkeydown="clearLabel(this);giveBorder('password',this.id);" />
           </div>
           <div id="cpwd" class="widthAutoOver">
            <!--  html edit - 20 nov 2014  -->
            <input type="password" class="input" name="cpwd" placeholder="Confirm password" id="signup-cpwd" value="" onkeyup="clearLabel(this);giveBorder('password',this.id);" onkeydown="clearLabel(this);giveBorder('password',this.id);" />
           </div>
          </div>
        </form>
      </section>
      <aside id="waiting">
      <input class="floatLeft" type="checkbox" id="agree" name="agree" value="agree" />
      <!--  html edit - 21 nov 2014  -->
      <!--  html edit - 25 nov 2014  -->
      <div class="floatLeft"><label for="agree"><span></span><p class="floatRight" style="width:219px;">I accept the <a target="_blank" href="<?=site_url()?>terms_of_use">Terms of use</a> and <a  target="_blank" href="<?=site_url()?>privacy">Privacy policy </a></label></p></div>
      <input type="submit" name="Signup" onclick="return onSubmitForm();" id="signupBtn" value="Sign up" />
		<span id="watch-login" class="signup-watch" style="display: none;">
		<img id="redWatch" src="<?php echo $this->config->item('system_path');?>img/speedometer.gif" alt="waiting-watch" width="32" height="32" />
		</span>
      <!--  html addition - 12 nov 2014  -->
      <p class="back-to"><a href="<?php echo base_url(); ?>">Already registered?</a></p>
      </aside>
      <br class="clear">
      <div id="notify-box"> 
        <p class="error"></p>
        <p class="errorall"></p>
        <p class="erroremail"></p>
        <p class="errorpwd"></p>
        <p class="success"></p> 
       <!--  html addition - 20 nov 2014  -->
        <p class="erroragree"></p>
        <p class="errorMsg3">You must agree to Terms & Conditions</p>
        <p id="vehicle_number_popup" style="display:none;">
        <img src="<?php echo $this->config->item('system_path');?>img/alert-icon.png" alt="alert" />
        This vehicle number is already used by someone. If you are the owner of this number, 
        <a href="<?=site_url()?>resolveconflict">click here</a> 
        to claim your ownership</p>
      </div>
    </div>  
  </section><!---------close content wrapper--------->
  

  

 </div><!--------close main wrapper--------->
          <!--  html edit - 05 dec 2014  -->
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/placeholder.js"></script>
 <script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/retina.js"></script>


