<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Photo extends CI_Controller {


	
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('photo_model');		
    }
	
/////////////////////////////////////////////////////////////////////////////////
function ensureUser()
 // get admin_id check whether its equal to administrator, if equal stay otherwise logout
     {
		return ensureUser();
	}
//////////////////////////////////////////////////////////////////////////
function smart_resize_image($file,
                              $width              = 0, 
                              $height             = 0, 
                              $proportional       = false, 
                              $output             = 'file', 
                              $delete_original    = true, 
                              $use_linux_commands = false ) {
      
    if ( $height <= 0 && $width <= 0 ) return false;

    # Setting defaults and meta
    $info                         = getimagesize($file);
    $image                        = '';
    $final_width                  = 0;
    $final_height                 = 0;
    list($width_old, $height_old) = $info;

    # Calculating proportionality
    if ($proportional) {
      if      ($width  == 0)  $factor = $height/$height_old;
      elseif  ($height == 0)  $factor = $width/$width_old;
      else                    $factor = min( $width / $width_old, $height / $height_old );

      $final_width  = round( $width_old * $factor );
      $final_height = round( $height_old * $factor );
    }
    else {
      $final_width = ( $width <= 0 ) ? $width_old : $width;
      $final_height = ( $height <= 0 ) ? $height_old : $height;
    }

    # Loading image to memory according to type
    switch ( $info[2] ) {
      case IMAGETYPE_GIF:   $image = imagecreatefromgif($file);   break;
      case IMAGETYPE_JPEG:  $image = imagecreatefromjpeg($file);  break;
      case IMAGETYPE_PNG:   $image = imagecreatefrompng($file);   break;
      default: return false;
    }
    
    
    # This is the resizing/resampling/transparency-preserving magic
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $transparency = imagecolortransparent($image);

      if ($transparency >= 0) {
        $transparent_color  = imagecolorsforindex($image, $trnprt_indx);
        $transparency       = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
        imagefill($image_resized, 0, 0, $transparency);
        imagecolortransparent($image_resized, $transparency);
      }
      elseif ($info[2] == IMAGETYPE_PNG) {
        imagealphablending($image_resized, false);
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
        imagefill($image_resized, 0, 0, $color);
        imagesavealpha($image_resized, true);
      }
    }
    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
    
    # Taking care of original, if needed
    if ( $delete_original ) {
      if ( $use_linux_commands ) exec('rm '.$file);
      //else @unlink($file);
    }

    # Preparing a method of providing result
    switch ( strtolower($output) ) {
      case 'browser':
        $mime = image_type_to_mime_type($info[2]);
        header("Content-type: $mime");
        $output = NULL;
      break;
      case 'file':
        $output = $file;
      break;
      case 'return':
        return $image_resized;
      break;
      default:
      break;
    }
    
    # Writing image according to type to the output destination
    switch ( $info[2] ) {
      case IMAGETYPE_GIF:   imagegif($image_resized, $output);    break;
      case IMAGETYPE_JPEG:  imagejpeg($image_resized, $output);   break;
      case IMAGETYPE_PNG:   imagepng($image_resized, $output);    break;
      default: return false;
    }

    return true;
  }

//////////////////////////////////////////////	
public function index()	{

		$this->ensureUser();
		$arData =   array();
		$arData['page_title']="My photos";  
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['countphotos'] = $this->photo_model->count_photos($user_id);
		$arData['cridephotos'] = $this->photo_model->cride_photos($user_id);
		$arData['cstatusphotos'] = $this->photo_model->cstatus_photos($user_id);	
		$arData['myphotos'] = $this->photo_model->my_photos($user_id);	
		$arContent['content'] = $this->load->view('photos/index.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 


}

//////////////////////////////////////////////	
public function photothers()	{

		$this->ensureUser();
		$arData =  array();
		$arData['page_title']="Photos";  
	    $arData['Userdetail'] =userSession();
		$userid = $this->uri->segment(3);
		$username = $this->photo_model->getusername($userid);
		$user_id = $username[0]['username'];
		
		$get_block_status=get_block_status($userid);
		if(!empty($get_block_status))
			redirect(site_url().'user/aboutOthers/'.$userid);
		
		
		
		$arData['countphotos'] = $this->photo_model->count_photos($userid);
		$arData['cridephotos'] = $this->photo_model->cride_photos($userid);
		$arData['cstatusphotos'] = $this->photo_model->cstatus_photos($user_id);	
		$arData['othersphotos'] = $this->photo_model->my_photos($userid); 
		
		
	
		$arContent['content'] = $this->load->view('photos/photothers.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 
		


}


//////////////////////////////////////////////	
public function other_photothers()	{

		$this->ensureUser();
		$arData =  array();
		$arData['page_title']="Photos"; 
	    $arData['Userdetail'] =userSession();
		$userid = $this->uri->segment(3);
		$username = $this->photo_model->getusername($userid);
		$user_id = $username[0]['username'];
		
		$get_block_status=get_block_status($userid);
		if(!empty($get_block_status))
			redirect(site_url().'user/aboutOthers/'.$userid);
			
		$arData['countphotos'] = $this->photo_model->count_photos($userid);
		$arData['cridephotos'] = $this->photo_model->cride_photos($userid);
		$arData['cstatusphotos'] = $this->photo_model->cstatus_photos($user_id);	
		$arData['othersphotos'] = $this->photo_model->my_photos($userid);	
		$arContent['content'] = $this->load->view('photos/other_photothers.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 


}

//////////////////////////////////////////////	
public function myride()	{

		$this->ensureUser();
		$arData =   array();
		$arData['page_title']="My photos"; 
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['countphotos'] = $this->photo_model->count_photos($user_id);
		$arData['cridephotos'] = $this->photo_model->cride_photos($user_id);
		$arData['cstatusphotos'] = $this->photo_model->cstatus_photos($user_id);	
		$arData['myridephotos'] = $this->photo_model->myridephotos($user_id);	
		//see($arData['myridephotos']);
		$arContent['content'] = $this->load->view('photos/myride.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 

}


//////////////////////////////////////////////	
public function othersride()	{

		$this->ensureUser();
		$arData =   array();
		$arData['page_title']="Photos"; 
	    $arData['Userdetail'] =userSession();
		$userid = $this->uri->segment(3);
		$username = $this->photo_model->getusername($userid);
		$user_id = $username[0]['username'];
		$get_block_status=get_block_status($userid);
		if(!empty($get_block_status))
			redirect(site_url().'user/aboutOthers/'.$userid);
			
		$arData['countphotos'] = $this->photo_model->count_photos($userid);
		$arData['cridephotos'] = $this->photo_model->cride_photos($userid);
		$arData['cstatusphotos'] = $this->photo_model->cstatus_photos($user_id);	
		$arData['othersridephotos'] = $this->photo_model->myridephotos($userid);
		
		$arContent['content'] = $this->load->view('photos/othersride.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 
		

}

//////////////////////////////////////////////	
public function statuspic()	{

		$this->ensureUser();
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['countphotos'] = $this->photo_model->count_photos($user_id);
		$arData['cridephotos'] = $this->photo_model->cride_photos($user_id);
		$arData['cstatusphotos'] = $this->photo_model->cstatus_photos($user_id);	
		$arData['mystatusphotos'] = $this->photo_model->mystatusphotos($user_id);	
		$arContent['content'] = $this->load->view('photos/statuspic.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 

}


//////////////////////////////////////////////	
public function otherstatuspic()	{

		$this->ensureUser();
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $this->uri->segment(3);
		$username = $this->photo_model->getusername($userid);
		$user_id = $username[0]['username'];
		$arData['countphotos'] = $this->photo_model->count_photos($userid);
		$arData['cridephotos'] = $this->photo_model->cride_photos($userid);
		$arData['cstatusphotos'] = $this->photo_model->cstatus_photos($userid);	
		$arData['otherstatusphotos'] = $this->photo_model->mystatusphotos($userid);	
		$arContent['content'] = $this->load->view('photos/otherstatuspic.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 

}

//////////////////////////////////////////////	
public function uploadphotos()	{

		if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{
		  $arData =   array();
		  $arData['Userdetail'] =userSession();
		  $userid = $arData['Userdetail']['username'];
		  $user_id = $arData['Userdetail']['id'];			
		  $arContent['content'] = $this->load->view('photos/uploadphotos.php',$arData,true);	
		  $this->load->view('layouts/empty.php',$arContent); 
		}

}
//////////////////////////////////////////////	
public function uploadridephotos()	{
	
		if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{
			$arData =   array();
			$arData['Userdetail'] =userSession();
			$userid = $arData['Userdetail']['username'];
			$user_id = $arData['Userdetail']['id'];			
			$arContent['content'] = $this->load->view('photos/uploadridephotos.php',$arData,true);	
			$this->load->view('layouts/empty.php',$arContent); 
		}

}

//////////////////////////////////////////////	
public function uploadstatusPhtos()	{

	if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{
		  $arData =   array();
		  $arData['Userdetail'] =userSession();
		  $userid = $arData['Userdetail']['username'];
		  $user_id = $arData['Userdetail']['id'];			
		  $arContent['content'] = $this->load->view('photos/uploadstatusphotos.php',$arData,true);	
		  $this->load->view('layouts/empty.php',$arContent); 
		}

}


/////////////////////////////////////////////////////////
public function photoform() {        
        
		if(!ensureUser_popup())
			echo "LO";
		else
		{	
			$userdata = userSession();
			$userid =$userdata['username'];
			$user_id =$userdata['id'];
			$description = $_POST['photo'];
			if($_FILES['picture']['name'] != ""){
			$path="./uploads/gallery"; 
			$t1=time();
			$imagename=$t1.$_FILES['picture']['name'];		
			$tmpname = $_FILES['picture']['tmp_name'];
			
			$uploadedfile = $_FILES['picture']['tmp_name'];
			list($width,$height)=getimagesize($uploadedfile);
			if($width>$height)
				{
					$y1=0;
					$x1=($width-$height)/2;
					$w=$h=$height;
				}
			elseif($height>$width)	
				{
					$x1=0;
					$y1=($height-$width)/2;
					$w=$h=$width;
				}
			elseif($height==$width)	
				{
					$x1=$y1=0;
					$w=$h=$width;
				}	
			
			
			
			@move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
							
							$this->smart_resize_image($path.'/temp/'.$imagename,800,'700',true,$path.'/large/'.$imagename,false,false ); 
									if(is_readable($path."/large/".$imagename)) {
									@chmod($path."/large/".$imagename,0777);
								}
							
								
						$thumbSizes=thumbSizes('user');
							 resizeThumbnailImage($path.'/thumb/'.$imagename, $path.'/temp/'.$imagename,$w,$h,$x1,$y1,array('width'=>$thumbSizes['thumb']['width'],'height'=>$thumbSizes['thumb']['height']));	  
	
			
			
			}else{
			$imagename='';		
			}   
			$data=array('pic_name'=>$imagename,'pic_type'=>'1','status'=>'1','user_id'=>$user_id,'pic_desc'=>$description,'created'=>date('Y-m-d H:i:s'));
			$this->photo_model->insertdata($data);
			$last_id = $this->db->insert_id();	
			$this->db->trans_complete();
			$cphotos = $this->photo_model->count_photos($userid);	
			$mp = $this->photo_model->lastrowdata($last_id);
			die;  
		}
  } 
/////////////////////////////////////////////////////////
public function rideform() {        
        
		if(!ensureUser_popup())
			echo "LO";
		else
		{	
			$userdata = userSession();	
			$userid =$userdata['username'];
			$user_id =$userdata['id'];
			$description = $_POST['ridephto'];
			if($_FILES['picture']['name'] != ""){
			$path="./uploads/gallery"; 
			$t1=time();
			$imagename=$t1.$_FILES['picture']['name'];		
			$tmpname = $_FILES['picture']['tmp_name'];
			
			$thumbSizes=thumbSizes('ride');
			$uploadedfile = $_FILES['picture']['tmp_name'];
			list($width,$height)=getimagesize($uploadedfile);
			
			
			
			$w=$width;
			$h=$width*($thumbSizes['thumb']['height']/$thumbSizes['thumb']['width']);
			$x1=0;
			$y1=($height-$h)/2;
			
			if($h>$height)
			{
				$h=$height;	
				$w=$height*($thumbSizes['thumb']['width']/$thumbSizes['thumb']['height']);
				
				$y1=0;
				$x1=($width-$w)/2;
			}
			
			
			
			@move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
			$this->smart_resize_image($path.'/temp/'.$imagename,800,'700',true,$path.'/large/'.$imagename,false,false ); 
			
									if(is_readable($path."/large/".$imagename)) {
									@chmod($path."/large/".$imagename,0777);
								}
								
							
							resizeThumbnailImage($path.'/thumb/'.$imagename, $path.'/temp/'.$imagename,$w,$h,$x1,$y1,array('width'=>$thumbSizes['thumb']['width'],'height'=>$thumbSizes['thumb']['height']));	  
	
	
			
			
			}else{
			$imagename='';		
			}   
			$data=array('pic_name'=>$imagename,'pic_type'=>'2','status'=>'1','user_id'=>$user_id,'pic_desc'=>$description,'created'=>date('Y-m-d H:i:s'));
			$this->photo_model->insertdata($data);
			$last_id = $this->db->insert_id();	
			$this->db->trans_complete();
			$mrp = $this->photo_model->lastriderowdata($last_id);
			
			die;  
		}
  } 
/////////////////////////////////////////////////////////
public function statusform() {        
        
		if(!ensureUser_popup())
			echo "LO";
		else
		{	
			$userdata = userSession();		
			$userid =$userdata['username'];
			$user_id =$userdata['id'];
			$description = $_POST['status'];
			$status_type = $this->input->post('status_type');
			if($_FILES['picture']['name'] != ""){
			$path="./uploads/gallery"; 
			$t1=time();
			$imagename=$t1.$_FILES['picture']['name'];		
			$tmpname = $_FILES['picture']['tmp_name'];
			@move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
			$this->smart_resize_image($path.'/temp/'.$imagename,500,'400',true,$path.'/large/'.$imagename,false,false ); 
			$this->smart_resize_image($path.'/temp/'.$imagename,307,'',true,$path.'/thumb/'.$imagename,true,false ); 
							
									if(is_readable($path."/thumb/".$imagename)) {
									@chmod($path."/thumb/".$imagename,0777);
								}
									if(is_readable($path."/large/".$imagename)) {
									@chmod($path."/large/".$imagename,0777);
								}		
			
			}else{
			$imagename='';		
			}   
			$data=array('pic_name'=>$imagename,'pic_type'=>'3','status'=>'1','user_id'=>$user_id,'pic_desc'=>$description, 'created'=>date('Y-m-d H:i:s'),'status_type'=>$status_type);
			$this->photo_model->insertdata($data);
			$last_id = $this->db->insert_id();	
			$this->db->trans_complete();			
			$mrp = $this->photo_model->lastriderowdata($last_id);
			echo '';
			
			
			die;  
		}
  } 


public function my_others_photos()	{

		$this->ensureUser();
		$arData =   array();
		$arData['page_title']="My photos"; 
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['countphotos'] = $this->photo_model->count_photos($user_id);
		$arData['cridephotos'] = $this->photo_model->cride_photos($user_id);
		$arData['cstatusphotos'] = $this->photo_model->cstatus_photos($user_id);	
		$arData['myphotos'] = $this->photo_model->my_photos($user_id);	
		$arContent['content'] = $this->load->view('photos/my_others_photos.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 


}

function delete($id)
{
	if(!ensureUser_popup())
			echo "LO";
		else
		{
			$this->load->model('photo_model');
			$this->photo_model->deletePhoto($id);
		}
}


function chooseFromPhotoList($type)
{
		if(!ensureUser_popup())
			echo "LO";
		else
		{
			$this->load->model('photo_model');
			$arData['Userdetail'] =userSession();
			$user_id = $arData['Userdetail']['id'];
			if($type==1)
			{
				$arData['photos'] = $this->photo_model->myridephotos($user_id);	
				$this->load->view('photos/chooseCover',$arData);
			}
			else	
			{
				$arData['photos'] = $this->photo_model->my_photos($user_id);	
				$this->load->view('photos/chooseProfilePic',$arData);
			}
}
}


function chooseFromPhotoListSubmit($type)
{
		if(!ensureUser_popup())
			echo "LO";
		else
		{
			if(isset($_POST['id']) && $_POST['id']!=0)
			{
				$this->load->model('photo_model');
				$arData['Userdetail'] =userSession();
				$user_id = $arData['Userdetail']['id'];

				$photo = $this->photo_model->chooseFromPhotoListSubmit($user_id,$type);
				if(!empty($photo))
				{
					$size='large';
					if($type==2)
						$size='thumb';
					
					echo site_url()."uploads/gallery/".$size."/".$photo['pic_name'];
				}
				else
					echo 0;	
			}
			else
				echo 0;
}
}
///////////////////////////////////////////////
}
