<script type="text/javascript">
 $(document).ready(function (e) {
	$("#sendcomplform").on('submit',(function(e) {
		
		e.preventDefault();
		var complt = $('#complt').val();	
		var friend_id = $('#friend_id').val();    
		var photo_id = $('#photo_id').val();					 
		$.ajax({
        	url: site_url+'watchfriends/postcomplnt',
			type: "POST",
			data:'complt='+ complt +'&friend_id='+ friend_id +'&photo_id='+ photo_id,
			success: function(data)
		    {
			 alert("Comment added sucessfully");
			 
		    },
		  	error: function() 
	    	{
	    	} 	        
	   });
	}));
	
	
$("#statusomplt").on('submit',(function(e) {
		
		e.preventDefault(); 
		var compltStatus = $('#compltStatus').val();	
		var sfriend_id = $('#sfriend_id').val();
		var sphoto_id = $('#sphoto_id').val();					 
		$.ajax({
        	url: site_url+'watchfriends/spostcomplnt',
			type: "POST",
			data:'compltStatus='+ compltStatus +'&sfriend_id='+ sfriend_id +'&sphoto_id='+ sphoto_id,
			success: function(data)
		    { 
			// alert("Comment added sucessfully");
			 $('#c_cmp').html(data);		
		    },
		  	error: function()  
	    	{
	    	} 	        
	   });
	}));	
	
 $("#cpopup").click(function() {	
 $('#popup2').removeClass("wspeakerpopup");
 $('#popup2').removeClass("wchangeurstatus");        	 	 
 $('#popup2').addClass('wcomplimntpopup');
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},2000); 
 
});
 

 $("#spopup").click(function() {	
 $('#popup2').removeClass("wcomplimntpopup"); 
 $('#popup2').removeClass("wchangeurstatus");       	 	 
 $('#popup2').addClass('wspeakerpopup');
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},2000); 
});


$("#custatus").click(function() {	
 $('#popup2').removeClass("wcomplimntpopup");
 $('#popup2').removeClass('wspeakerpopup');      	 	 
 $('#popup2').addClass('wchangeurstatus');
 setTimeout(function(){
	$('#popup2> .content').prepend('<span class="button b-close"><span>X</span></span>');	

	},3000); 
});






	
});		
function blowhorn(bid){	 
		
		var bid = bid;	
		$.ajax({		
		url:site_url+'watchfriends/blowhorn',		
		type:'POST',			
		data:'bid='+ bid,
		success:function(data)
			{		  			  
			  $('#wbhorn').html(data);
			}
		});	 
	return false;
}
/*
function ublowhorn(bid){	 
		
		var bid = bid;	
		$.ajax({		
		url:site_url+'watchfriends/ublowhorn',		
		type:'POST',			
		data:'bid='+ bid,
		success:function(data)
			{		  			  
			  $('#wbhorn').html(data);
			}
		});	 
	return false;
}  */
	
</script>
<div id="popup2">
<div class="content"></div>
</div>
	
 <section id="contetDivWrap" class="overFlowInherit paddngBttm100"><!---------start section----------->
     
       <hgroup id="pageHeadng1">
                  <!--  html edit - 19 dec 2014  --> 
         <h1>Watch your friends<!--<span class="iconSmallIcon"></span>--></h1>
       </hgroup>
      
      <article id="leftSideBar1" class="floatLeft">
        
        <section>
	<?php  
		if(!empty($allfdetail)){ foreach($allfdetail as $afd){ 
		$query = $this->db->query("Select *  from  photos where user_id ='". $afd['username']."' && status=1 && pic_type=3  order by id Desc Limit 1"); 
		$res = $query->result_array();
		if(!empty($res)){
		$compl = $this->db->query("Select count(*) as c_com from  compliements where friend_id ='". $afd['usersid']."' && photo_id='".$res[0]['id']."' "); 
		$complomint = $compl->result_array();
	    }	
		
	?>
	       <article id="watchFrdDetail_1"><!------article1------------->
            <div>
               <figure class="floatLeft"><img src="<?php echo base_url(); ?>uploads/gallery/thumb/<?php echo $afd['profile_pic']; ?>" alt="user" width="154" height="154" /></figure>
              <div class="positionRel">
		      <hgroup><h3 class="paddingTop10 paddingBottom3"><a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $afd['usersid'] ?>"><?php echo $afd['first_name'].'&nbsp'.$afd['last_name'];?></a></h3>
                 <span class="positionAbs">
				<?php if(!empty($res[0]['created'])){
			$fnowdate = date('Y-m-d H:i:s');
            $ftdifference = $res[0]['created'];              
			$fdate1 = date_create($fnowdate);    
			$fdate2 = date_create($ftdifference);
			$fdiff12 = date_diff($fdate2, $fdate1);
			$fhours = $fdiff12->h;
		    $fmint = $fdiff12->i;
			$fdays = $fdiff12->d;
			$fmonths = $fdiff12->m;   
			$fyears = $fdiff12->y;
			if($fyears == '0' && $fmonths=='0' && $fdays < '7'){
			if($fhours<'1' && $fdays<'1'){
			echo "Just now";
			} 
			elseif($fhours=='1' && $fdays<'1'){ 
			echo "an hour ago";
			} 
			elseif($fhours > '2' && $fdays<'1'){
			echo $fhours."&nbsp;hours ago";
			}
			elseif($fdays =='1'){
			echo "a day ago";
			}
			elseif($fdays >'1' && $fdays< '7'){
			echo $fdays."&nbsp;days ago";
			}
				}else{
				echo date("d M,Y", strtotime($res[0]['created'])); 
				 
				}		
		}		
				?></span></hgroup> 
                 <hgroup><h2 class="paddingBottom8"><a href="<?php echo base_url(); ?>user/aboutRidesother/<?php echo $afd['usersid']; ?>"><?php echo $afd['username'].'&nbsp'.$afd['model'];?> </a></h2></hgroup>
                  <div class="watchCotentDet_"> 
                       <p><?php if(!empty($res[0]['pic_desc'])){ echo substr($res[0]['pic_desc'],0,300); ?></br><?php $limit=300;if(strlen($res[0]['pic_desc']) > $limit) { ?> <a href="<?php echo base_url(); ?>user/aboutOthers/<?php echo $afd['usersid'] ?>" class="marginTopMinus10 readMoreLink">Read More</a><?php } }?></p>
                    <?php if(!empty($res[0]['pic_name'])){ ?>
                    <figure>
					<img src="<?php echo base_url(); ?>uploads/gallery/large/<?php echo $res[0]['pic_name']; ?>" alt="upload" width="478" height="300"  />
					</figure>
					<?php } ?>     
                  
                  </div>
               </div>
            </div>
            <div></div>
           <?php  if(!empty($res)){ ?>
            <div class="inputImgUserEnter">
			<form method="post" id="sendcomplform-<?php echo $afd['id']; ?>" >
            <input type="text" class="input floatLeft" placeholder="Write a compliment..." value="" id="complt" name="complt" />
			<input type="hidden" value="<?php echo $res[0]['id']; ?>" id="photo_id" name="photo_id" />
			<h1>just checking view</h1>
			<input type="hidden"  value="<?php echo $afd['usersid']; ?>" id="friend_id" name="friend_id" />
            <input type="submit" class="floatLeft enter-btn" name="submit" />
            </form>
             <figure class="floatRight"><img src="<?php echo base_url(); ?>uploads/gallery/verysmall/<?php echo $Userdetail['profile_pic']; ?>" alt="user-pic" /></figure> 
            </div>
<!--  html edit - 1 dec 2014  --> 
            <div style="clear:both;">
             <p class="floatLeft blowHornCom"><a class="floatLeft" href="#">Blow Horn</a>
             <span id="cpopup" class="floatRight button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>watchfriends/complimntpopup/<?php echo $res[0]['id']; ?>"}'>Compliments (<?php echo $complomint[0]['c_com'];?>)</span>
             </p>
             <p class="floatRight hornStyle"> 
			<span id="spopup" class="no-underline-effect button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>watchfriends/speakerpopup/<?php echo $res[0]['id']; ?>"}'><span class="speakerIconWhite"></span><?php if(!empty($res[0]['horn'])){ echo $res[0]['horn'];} ?></span>
           </p> 
            </div>
            <?php } ?>
          </article>
		<?php }}else{ ?>  
           
           <article id="watchFrdDetail_1" class="watchFrdNotYetFrd"><!------article1------------->
			<div>               
			 <p>Current status of all of your friends will be shown in this area
But you do not have any friends yet.</p>
             <h6>Here is what you can do next</h6>
             <div>
                <span></span>
                <a href="<?php echo base_url(); ?>user/aboutMe">Complete your profile</a>
             </div>
             <div>
                <span></span>
                <a href="<?php echo base_url(); ?>findfriends">Find your friends</a>
             </div>
             <div>
                <span></span>
                <a href="<?php echo base_url(); ?>user/browsepeople">Browse people</a>
             </div>
             <div>
                <span></span>
                <a href="<?php echo base_url(); ?>user/browserides">Browse rides</a>
             </div>
			</div>
            
          </article>
          <?php } ?>
        </section>
      </article>
    <div class="floatRight marginBttm100">
      <article id="rightSideBar2">
        <header>
<!--  html edit - 1 dec 2014  -->
		<?php if(!empty($statusimage)){ ?>
        <span id="custatus" class="floatLeft btnBgStyle statusChangeBtn1 button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>watchfriends/changeurstatus"}'>Change status</span>
		<?php }else{ ?>
	<span id="custatus" class="btnBgStyle statusChangeBtn1 button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>watchfriends/changeurstatus"}'>Update status</span>
	<?php } ?>
<!--  html addition - 1 dec 2014  -->
		 <?php if(!empty($statusimage)){ ?>
         <a class="floatRight btnBgStyle statusChangeBtn1"  href="javascript: void(0)">Past statuses</a>
         <?php } ?> 
        </header>
        <?php if(!empty($statusimage)){ ?>    
        <section id="status_compliment_box">
           <hgroup><h5 class="floatLeft">Your Current Status</h5> 
           <span class="floatRight"><?php if(!empty($statusimage[0]['created'])){ 
            $nowdate = date('Y-m-d H:i:s');
            $tdifference = $statusimage[0]['created'];              
			$date1 = date_create($nowdate);    
			$date2 = date_create($tdifference);
			$diff12 = date_diff($date2, $date1);
			$hours = $diff12->h;
		    $mint = $diff12->i;
			$days = $diff12->d;
			$months = $diff12->m;   
			$years = $diff12->y;
			if($years == '0' && $months=='0' && $days < '7'){
			if($hours<'1' && $days<'1'){ 
			echo "Just now";
			} 
			elseif($hours=='1' && $days<'1'){
			echo "an hour ago";
			} 
			elseif($hours > '2' && $days<'1'){
			echo $hours."&nbsp;hours ago";
			}
			elseif($days =='1'){
			echo "a day ago";
			}
			elseif($days >'1' && $days< '7'){
			echo $days."&nbsp;days ago";
			}
		}else{ 
			echo date("d M,Y", strtotime($statusimage[0]['created']));
		}
	}					 			
          
            ?></span></hgroup>
           <p class="clear" id="picdesc"><?php if(!empty($statusimage)){ echo substr($statusimage[0]['pic_desc'],0,300);} ?>
           </p>
	<?php if(!empty($statusimage[0]['pic_name'])){ ?>
            <figure><img src="<?php echo base_url();?>uploads/gallery/large/<?php echo $statusimage[0]['pic_name'] ?>" id="status_new_pic" alt="upload" height="317" width="478" /></figure>
	<?php } ?> 
   
<!--  html edit - 1 dec 2014  -->  
            <div style="clear:both;" class="inputImgUserEnter"> 
			 <form method="post" id="statusomplt" name="statusomplt" >	
             <input type="text" placeholder="Reply to a compliment..." value="" id="compltStatus" name="compltStatus" class="input floatLeft">
             <input type="hidden" value="<?php echo $statusimage[0]['id']; ?>" id="sphoto_id" name="sphoto_id" />
             <input type="hidden"  value="<?php echo $Userdetail['id']; ?>" id="sfriend_id" name="sfriend_id" />			
             <input type="submit" class="floatLeft enter-btn">
             </form>
             <figure class="floatRight">
			<img src="<?php echo base_url(); ?>uploads/gallery/verysmall/<?php echo $Userdetail['profile_pic']; ?>" alt="user-pic" />	 
			
           </div>         
           <?php 				
				$cquery = $this->db->query("select count(*) as compcount from compliements where user_id ='".$Userdetail ['username']."' && photo_id ='".$statusimage[0]['id']."' "); 
				$ccomp = $cquery->result_array(); 
		   ?> 
            <div id="speakerid">
            <!--  html edit - 1 dec 2014  --> 
             <p class="floatLeft blowHornCom"><a class="floatLeft"  href="" onclick="return blowhorn(<?php echo $statusimage[0]['id']; ?>);">Blow Horn</a>
             <span class="floatRight button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url();?>watchfriends/cstatuspopup/<?php echo $statusimage[0]['id']; ?>"}'>
             Compliments (<!--<span id= "c_cmp" >--><?php echo $ccomp[0]['compcount']; ?>
             <!--</span>-->) 
             </span>
             </p>
             <!--  html edit - 1 dec 2014  --> 
             <p class="floatRight hornStyle">		
		<span id="spopup" class="no-underline-effect button small" data-bpopup='{"content":"iframe","contentContainer":".content","loadUrl":"<?php echo base_url(); ?>watchfriends/speakerspopup/<?php echo $statusimage[0]['id']; ?>"}'>  	
			<span class="speakerIconWhite"></span><!--<div id="wbhorn" >--><?php echo $statusimage[0]['horn']; ?><!--</div>-->
			</span>
			</p>
            </div>           
        </section>
        <?php }else{ ?>
        <section id="status_compliment_box">
             <!--  html edit - 19 jan 2015  -->
        <hgroup><h5 class="floatLeft">You have not updated your status yet.</h5> 
        <span class="floatRight">     
        </span></hgroup>
        <p class="clear" id="picdesc">
        </p>
        <figure><img src="" id="status_new_pic" alt="upload" height="317" width="478" ></figure>
	    </section>        
        <?php } ?>
      </article>
      
      
      
    </div>
       
       
    </section><!---------close section----------->
