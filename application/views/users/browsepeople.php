<?php
$getStateList=getStateList();
$getOccupationList=getOccupationList();
?>
<!----------html edit - 06 jan 2015---------->
<section id="contetDivWrap" class="paddngBttm100"><!---------start section----------->
     
       <hgroup id="pageHeadng1">
         <h1>Browse</h1>
       </hgroup>
         
       <div class="clear"></div>
       
       <article id="rider-journey-people" class="overFlowInherit"><!---------start article rider-journey-people----------->
          <header>
            <nav>
              <ul>
                <li><a href="<?php echo base_url();?>user/browserides">Rides</a></li>
                <li class="activeUserLi"><a href="<?php echo base_url();?>user/browsepeople">People</a></li>
              </ul>
            </nav>
          </header>
          
          <article id="searchPeopleDetails"><!---------start articlesearchPeopleDetails--------->
            <aside>
              <hgroup><h6>Search People</h6></hgroup>
              <form>
                  <div class="floatLeft">
                      <p class="floatLeft">
              
                       <input type="text" name="fname" id="fname" class="input fontStyle16 inputStyle" value="<?=trim($search_query['fname'])?>" placeholder="Firstname" style="width:127px; float:none;">
              		  <input type="text" name="surname" id="surname" class="input fontStyle16 inputStyle" value="<?=trim($search_query['surname'])?>" placeholder="Surname" style="width:127px; float:none;">
                      </p>
                       <p class="floatLeft">
                       <select name="gender" id="gender" class="choice inputStyleSelect fontStyle16" style="width: 119px; float: none; height:53px; padding: 13px 10px;">
                        <option value="0">Gender</option>
                        <option value="male" >Male</option>
                        <option value="female"  <?php if($search_query['gender']=='female'){echo 'selected=""selected';}?>>Female</option>
                       </select>
                       <select name="occupation" id="occupation" class="choice inputStyleSelect fontStyle16" style="width: 160px; float: none; height:53px; padding: 13px 10px;">
                        <option value="0">Occupation</option>
                        <?php foreach($getOccupationList as $occuK=>$occuV) {?>
                        	<option value="<?=$occuK?>" <?php if($search_query['occupation']==$occuK){echo 'selected=""selected';}?>><?=$occuV?></option>
                        <?php } ?>
                        </select>
                      </p>
                      <select  name="state" id="state" class="fontStyle16 choice inputStyleSelect widthInput3" style="height:53px; padding: 13px 10px;">
                          <option value="0" style="font-size:16px !important; padding-bottom:5px;">State</option>
                          <?php foreach($getStateList as $stateK=>$stateV){?>
                          <option value="<?=$stateK?>"  <?php if($stateK==$search_query['state']){echo 'selected="selected"';}?> <?php if($stateK=='union_territories'){echo ' style="font-size:16px !important; padding:10px 0 5px; font-weight:bold" disabled';}?>><?=$stateV?></option>
                          <?php } ?>
                      </select>
               
                       <input type="text" name="city" id="city"  class="input fontStyle16 inputStyle widthInput1" value="<?=trim($search_query['city'])?>" placeholder="Current City/Town">
                       <input type="submit" value="Search People" class="marginTop10 btnBgStyle" />
                  </div>
              </form>
            </aside>
            <section> 
              <div><hgroup class="floatLeft"><h6><?=$bridecount?> result<?php if($bridecount!=1){echo 's';}?> found</h6></hgroup><!--<p class="floatRight">Sort List</p>--></div>
              <?php 
				if(!empty($bridepeople)){ foreach($bridepeople as $pr){ 
				$flashes=getFlashes($pr['id']); 	
				//$accessories=getAccessoryCount($pr['id']);
				$getCover=getCover($pr['id'],'verysmall');
				$getProfilePic=getProfilePic($pr['id'],'thumb');
				?>
			  <article>
                <figure><a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $pr['id']; ?>">
				<img 
                src="<?=$getProfilePic?>" alt="user" width="123" height="123" /></a></figure>
                 <section> 
                  <div>
                    <hgroup><h2><a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $pr['id']; ?>"><?php echo $pr['first_name'].'&nbsp'.$pr['last_name'];?></a></h2></hgroup>
                    <p><?php echo ucfirst($pr['gendor']).' '.age_from_dob($pr['DOB']).' from '.$pr['city'];  if($pr['city']!='' && $pr['state']!=''){echo ', ';}   if($pr['state']!=''){echo $getStateList[$pr['state']];} ?><br/><?php if($pr['occupation']!=''){echo $getOccupationList[$pr['occupation']];}?><?php if($pr['occupation']=='student'){echo ' at '.$pr['college'];} ?></p>
                    <hgroup><h3><a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $pr['id']; ?>"><?php echo $pr['username']; ?> - <?php echo $pr['model']; ?></a></h3></hgroup>
                  </div>
                  <figure class="flashImg1">
                    <figcaption style="margin-bottom:2px;"><?=$flashes?> flash<?php if($flashes!=1){echo 'es';}?></figcaption>
                    
                   <a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $pr['id']; ?>">
				   <img src="<?=$getCover?>" width="125" height="56" /></a>
                  </figure>
                </section>
              </article>
              
              <section>
					<?=$this->pagination->create_links();?>
			  </section>
              
              <?php }}?>
              
            </section>
          </article><!---------close articlesearchPeopleDetails--------->
          
       </article><!---------close article rider-journey-people----------->
       
    </section><!---------close section----------->

