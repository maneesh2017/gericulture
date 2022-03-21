<!--------Pop UP start here--------->

<!--<link rel="stylesheet" media="screen and (max-width: 1010px)" href="<?php echo $this->config->item('system_path');?>css/mobile-styles.css" />-->
<script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/mobilestyles.js"></script>
  <!--  html edit - 19 dec 2014  -->

<div id="popup2">  
<div class="content">
<!--<span class="button b-close" style="display:none"><span>X</span></span>-->
</div>
</div>
 <!--------Pop UP end here---------> 
 
 <div id="main_Wrapper" class="profileBasicPage"> <!--------start main wrapper--------->
  <header>
     <figure id="figure-logo" class="figure-logo-resolve">
     
	  
	  <img src="<?php echo $this->config->item('system_path');?>img/geri-logo.png" alt="logo" />
    </figure>
    <article id="setUpProfile" class="setUpProfile-resolve">
      <hgroup>
       <h1>Choose what to do next</h1>
      </hgroup>
    </article>
 </header>
 
 
   <div class="mobile_header_1">
      <a href="<?php echo base_url(); ?>" id="small_gc_logo" class="floatLeft" rel="Geri Culture Logo"><img src="<?php echo $this->config->item('system_path');?>img/geri-culture-small-logo.png" alt="logo" data-at2x="<?php echo $this->config->item('system_path');?>img/geri-culture-small-logo@2x.png" /></a>
      <hgroup class="floatRight"><h1>Choose what to do next</h1></hgroup>
     </div>
     <section class="setup_profile_section">
     <ul>
       <li><a class="activeNone page1" href="#">1</a></li>
       <li><a class="activeNone page2" href="#">2</a></li>
       <li><a class="activePage3" href="#">3</a></li>
     </ul>
  </section>
 
  <section id="contentWrap" class="boxShadow"><!--------start content wrapper--------->  
    <article id="layout1">
      <header>
        <nav class="floatLeft">
          <ul>
            <li>VEHICLE DETAILS</li>
            <li><span><img src="<?php echo $this->config->item('system_path');?>img/rightside-arrow.png" alt="arrow" /></span></li>
            <li>PERSONAL DETAILS</li>
            <li><span><img src="<?php echo $this->config->item('system_path');?>img/rightside-arrow.png" alt="arrow" /></span></li>
            <li class="activeLi"><a href="<?php echo base_url(); ?>user/enjoygeri">ENJOY GERI</a></li>
          </ul>
        </nav>
      </header>
      <section id="freeSticker">
        <p>Your basic profile is ready. Below are couple of options to get you started for a Geri.</p>
      </section>
      <section id="sectionwithicon">       
        <a href="<?php echo base_url(); ?>my-profile">
        <figure class="img1">
         <img src="<?php echo $this->config->item('system_path');?>img/stars@2x.png" alt="star" />
         <figcaption>Complete your profile</figcaption>
        </figure></a>
        <a href="<?php echo base_url(); ?>findfriends">
        <figure class="img2">
         <img src="<?php echo $this->config->item('system_path');?>img/find-friend@2x.png" alt="find friends" />
         <figcaption>Find your friends</figcaption>
        </figure></a>
        <!--<a href="<?php //echo base_url(); ?>">-->
        <figure class="img3">
         <img src="<?php echo $this->config->item('system_path');?>img/car-geri@2x.png" alt="car" />
         <figcaption>The culture (coming soon)</figcaption>
        </figure><!--</a>-->   
      </section>
      
      <br class="clear" />
    </article>
  </section><!---------close content wrapper--------->

 <script type="text/javascript" src="<?php echo $this->config->item('system_path');?>js/retina.js"></script>