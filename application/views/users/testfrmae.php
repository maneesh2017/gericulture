<!---------start-update cover pic popup-------------->
<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>css/colorbox.css" />    
<link rel="stylesheet" href="<?php echo $this->config->item('system_path');?>css/setup.css" />   
	
<div id="coverPicUpdate" class="popup_content">
<span  class="button b-close" style="z-index:10; bottom:-6px; left:-6px;"><span>X</span></span>
       <header>
         <hgroup><h1>Change ride's photo</h1></hgroup>
       </header>
       <section id="updateCoverPicForm">
	    <form method="post" id="editCoverPicForm" enctype="multipart/form-data">
          <section class="sec1">
		  <div id="preview"  style="display: none;"><img id="previewimg" src="" />
		  <img id="deleteimg" src="<?php echo base_url(); ?>uploads/gallery/temp/delete.png" />
		  </div>
		<div class="upload-pic">    
           <div> 
            <p>Upload your vehicle's photo that will be used as your profile's cover photo</p>
            <span>Image should be at least 980px wide</span><br>
           </div>
             <section class="uploadPhotoBtn">
               <label for="picture" class="fileBtn">Upload photo</label>
               <input type="file" id="picture" name="picture">
              </section>
			  </div>
			  <br/>
           <span id="filename"></span>
          </section>
          <section class="sec3">
            <input type="submit" value="Done" id="coverPicUpdateBtn"  >
          </section>
		</form>
       </section>
       
 </div>
<!---------end update cover pic popup--------------> 	   

