<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ride extends CI_Controller { 


	/**
	 * Index Page for this controller.
	 *	
	 */
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('main_model');
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
	 
/////////////////////////////////////////////////////////////////	
	public function about()	{  
	   $this->ensureUser();
	   $arData =   array();  
	   	  
	   $LoggedInUser= array();
       $LoggedInUser = userSession();    	    
  	   $arData['LoggedInUser'] = $LoggedInUser; 
	   $this->load->model('User_model');
	   $this->load->model('main_model');	
	   
	   $arData['Userdata'] = $this->main_model->user_detail($LoggedInUser['id']);
     //  $arData['countfriends'] = count(friendList($LoggedInUser['id']));
       
       $arData['RideInfo'] = $this->User_model->ride_info($LoggedInUser['id']);
	   $arData['pr'] = $this->main_model->popularide();		
  	   $arContent['content'] = $this->load->view('rides/about.php',$arData,true);		
	   $this->load->view('layouts/default-user.php',$arContent);  
  }
////////////////////////////////////////////////////////////	
public function coverpicride()	{ 
		
	$this->ensureUser();	
	$arData =   array(); 
	$arData['Userdetail'] =userSession();	 	
	$userid = $arData['Userdetail']['username'];		
	$arData['Userdata'] = $this->main_model->user_detail($userid);			
	$arContent['content'] = $this->load->view('rides/coverpicride.php',$arData,true);	
	$this->load->view('layouts/empty.php',$arContent);  
	
  } 
////////////////////////////////////////////////////////////	
public function addnewdetails()	{ 		
		
		 if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
		else
			{
				$this->ensureUser();
				$arData =   array(); 
				$arData['Userdetail'] =userSession();	 	
				$userid = $arData['Userdetail']['username'];	
				$arData['Userdata'] = $this->main_model->user_detail($userid);			
				$arContent['content'] = $this->load->view('rides/addnewdetails.php',$arData,true);	
				$this->load->view('layouts/empty.php',$arContent);  
			}
	} 
////////////////////////////////////////////////////////////	
public function addfeature()	{ 		
		
	  if(!ensureUser_popup())
		echo "LO";
	else
		{
			//$this->ensureUser();
				 $arData =   array();
				 $arData['Userdetail'] =userSession();	 	
				 $userid = $arData['Userdetail']['username'];
				 $user_id = $arData['Userdetail']['id'];
				 $rideid = $this->main_model->get_ride_id($user_id);
				 $ride_id=$rideid[0]['id'];	    	
				 $accessory = $this->input->post('accessory');		
				 $phone = $this->input->post('phone');		
				 $brand = $this->input->post('brand');
				 $sname = $this->input->post('sname');
				 $saddress = $this->input->post('saddress');
				 $feature = $this->input->post('feature');
				 $rating = $this->input->post('rating');
				 $price = $this->input->post('price');
				 $review = $this->input->post('review');		 
				if($_FILES['picture']['name'] != ""){
				$path="./uploads/gallery"; 
				$t1=time();
				$imagename=$t1.$_FILES['picture']['name'];		
				$tmpname = $_FILES['picture']['tmp_name'];
				@move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
				//$this->smart_resize_image($path.'/temp/'.$imagename,154,'154',true,$path.'/large/'.$imagename,false,false );		
				$this->smart_resize_image($path.'/temp/'.$imagename,154,'154',true,$path.'/thumb/'.$imagename,true,false );	
				if(is_readable($path."/thumb/".$imagename)) {
				@chmod($path."/thumb/".$imagename,0777);
				}
				//if(is_readable($path."/large/".$imagename)) {
				//@chmod($path."/large/".$imagename,0777);
				//}		
				
				}else{
				$imagename='';		
				}
				$data = array('name' => $accessory,'seller_phn' => $phone,'brand' => $brand,'seller_name' => $sname,'seller_address' => $saddress,'feature_type' => $feature,'price'=>$price,'review'=>$review,'image'=>$imagename,'user_id'=>$userid,'ride_id'=>$ride_id);
				$this->main_model->insertfeature($data);
				$this->db->trans_complete();
				$rideall = $this->main_model->ride_info_feature($userid);
				echo '<li><a href="#"><img src="'.base_url().'uploads/gallery/thumb/'.$imagename.'" alt="rider" /></a></li>';
				die;
		}
	
  }  
 
////////////////////////////////////////////////////////////	
public function addfrdtocircle()	{ 		
	
	$this->ensureUser();
	$arData =   array(); 
	$arData['Userdetail'] =userSession();	 	
	$userid = $arData['Userdetail']['username'];
	$arData['gerifriendlist'] = $this->main_model->ride_geri_frd_list($userid);	
	$arData['Userdata'] = $this->main_model->user_detail($userid);			
	$arContent['content'] = $this->load->view('rides/addfrdtocircle.php',$arData,true);	
	$this->load->view('layouts/empty.php',$arContent);  
	
  }   
  
////////////////////////////////////////////////////////////	
public function ridefrdcircle()	{ 		
	
	$this->ensureUser();
	$arData =   array(); 
	$arData['Userdetail'] =userSession();	 	
	$userid = $arData['Userdetail']['username'];
	$arData['gerifriendlist'] = $this->main_model->geri_frd_list($userid);
	$arData['friendcount'] = $this->main_model->geri_frd_list_count($userid);
	$arData['Userdata'] = $this->main_model->user_detail($userid);			
	$arContent['content'] = $this->load->view('rides/ridefrdcircle.php',$arData,true);	
	$this->load->view('layouts/empty.php',$arContent);  
	
  }   
    
////////////////////////////////////////////////////////////	
public function info()	{		
	
	$this->ensureUser();
	$arData =   array();
	$arData['Userdetail'] =userSession();	 	
	$userid = $arData['Userdetail']['username'];
	$arData['gerifriendlist'] = $this->main_model->geri_frd_list($userid);	
	$arContent['content'] = $this->load->view('rides/info.php',$arData,true);	
	$this->load->view('layouts/default.php',$arContent);  
	
  }   
 ////////////////////////////////////////////////////////////	
public function search()	{		
	
	
	$arData =   array();
	$arData['Userdetail'] =userSession();	 	
	$userid = $arData['Userdetail']['username'];
    $sdata = $_POST['searchname'];
	$search_friends = $this->main_model->search_frd_list($sdata,$userid);	
	echo '<li><a href="'.base_url().'user/aboutOthers/'.$search_friends[0]['usersid'].'"><img class="floatLeft" width="75" height="75" alt="car" src="'.base_url().'uploads/gallery/small/'.$search_friends[0]['profile_pic'].' ">
    </a><a href="'.base_url().'user/aboutRidesother/'.$search_friends[0]['usersid'].'"><img class="floatLeft" width="167" height="75" alt="user" src="'.base_url().'uploads/gallery/thumb/'.$search_friends[0]['image'].'">
	<div class="floatLeft marginLft15"><h1><a href="'.base_url().'user/aboutOthers/'.$search_friends[0]['usersid'].'">'.$search_friends[0]['first_name'].$search_friends[0]['last_name'].'</a></h1>
    </a><p><a  href="'.base_url().'user/aboutRidesother/'.$search_friends[0]['usersid'].'"class="marginTop4">'.$search_friends[0]['username'].'</a></p>
	<span><a class="marginTop4" href="'.base_url().'user/aboutRidesother/'.$search_friends[0]['usersid'].'">'.$search_friends[0]['model'].'</a></span></div>
	<a style="position:inherit;" class="addFrdGeriCircle1 marginTop15 floatRight" href="#">Add friend / ride</a>
	</li>';
	die;
	
	
  } 
////////////////////////////////////////////////////////////	
public function regsearch()	{		
	
	
	$arData =   array();
	$arData['Userdetail'] =userSession();	 	
	$userid = $arData['Userdetail']['username'];
    $regtags = $_POST['regtags'];
	$search_friends = $this->main_model->search_frd_list_reg($regtags,$userid);
	// foreach($search_friends as $search_friends){	
	// echo '<li><a href="'.base_url().'user/aboutOthers/'.$search_friends['usersid'].'"><img class="floatLeft" width="75" height="75" alt="car" src="'.base_url().'uploads/gallery/small/'.$search_friends['profile_pic'].' ">
    // </a><a href="'.base_url().'user/aboutRidesother/'.$search_friends['usersid'].'"><img class="floatLeft" width="167" height="75" alt="user" src="'.base_url().'uploads/gallery/thumb/'.$search_friends['image'].'">
	// <div class="floatLeft marginLft15"><h1><a href="'.base_url().'user/aboutOthers/'.$search_friends['usersid'].'">'.$search_friends['first_name'].$search_friends['last_name'].'</a></h1>
    // </a><p><a  href="'.base_url().'user/aboutRidesother/'.$search_friends['usersid'].'"class="marginTop4">'.$search_friends['username'].'</a></p>
	// <span><a class="marginTop4" href="'.base_url().'user/aboutRidesother/'.$search_friends['usersid'].'">'.$search_friends['model'].'</a></span></div>
	// <a style="position:inherit;" class="addFrdGeriCircle1 marginTop15 floatRight" href="#">Add friend / ride</a>
	// </li>';
	// }
	echo '<li><a href="'.base_url().'user/aboutOthers/'.$search_friends[0]['usersid'].'"><img class="floatLeft" width="75" height="75" alt="car" src="'.base_url().'uploads/gallery/small/'.$search_friends[0]['profile_pic'].' ">
    </a><a href="'.base_url().'user/aboutRidesother/'.$search_friends[0]['usersid'].'"><img class="floatLeft" width="167" height="75" alt="user" src="'.base_url().'uploads/gallery/thumb/'.$search_friends[0]['image'].'">
	<div class="floatLeft marginLft15"><h1><a href="'.base_url().'user/aboutOthers/'.$search_friends[0]['usersid'].'">'.$search_friends[0]['first_name'].$search_friends[0]['last_name'].'</a></h1>
    </a><p><a  href="'.base_url().'user/aboutRidesother/'.$search_friends[0]['usersid'].'"class="marginTop4">'.$search_friends[0]['username'].'</a></p>
	<span><a class="marginTop4" href="'.base_url().'user/aboutRidesother/'.$search_friends[0]['usersid'].'">'.$search_friends[0]['model'].'</a></span></div>
	<a style="position:inherit;" class="addFrdGeriCircle1 marginTop15 floatRight" href="#">Add friend / ride</a>
	</li>';
	die;	
  }    
       	
////////////////////////////////////////////////////////////	
public function profilepicride()	{ 		
	
	$this->ensureUser();
	$arData =   array(); 
	$arData['Userdetail'] =userSession();	 	
	$userid = $arData['Userdetail']['username'];		
	$arData['Userdata'] = $this->main_model->user_detail($userid);
	$arContent['content'] = $this->load->view('rides/profilepicride.php',$arData,true);	
	$this->load->view('layouts/empty.php',$arContent);  
	
  }   
    
/////////////////////////////////////////////////////////////////	
public function aboutride()	{  	    
	   
	   if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
		else
			{
				 $this->ensureUser();
				 $arData =   array();  	  
				 $LoggedInUser= array();
				 $LoggedInUser = userSession();	 		    
				 $arData['LoggedInUser'] = $LoggedInUser; 
				 $this->load->model('User_model');
				 $this->load->model('main_model');
				 $arData['countphotos'] = $this->main_model->count_photos($LoggedInUser['id']);
				
				 $arData['RideInfo'] = $this->User_model->ride_info($LoggedInUser['id']);  	   
				 $arContent['content'] = $this->load->view('rides/aboutride.php',$arData,true); 
				 $this->load->view('layouts/empty.php',$arContent);  
			}
  }  
/////////////////////////////////////////////////////////////////	
public function aboutspecifications()	{  	    
	   
	    if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
		else
			{
				 $this->ensureUser();
				 $arData =   array();  	  
				 $LoggedInUser= array();
				 $LoggedInUser = userSession();	 		    
				 $arData['LoggedInUser'] = $LoggedInUser; 
				 $this->load->model('User_model');
				 $this->load->model('main_model');
				 $arData['countphotos'] = $this->main_model->count_photos($LoggedInUser['id']);
				
				 $arData['RideInfo'] = $this->User_model->ride_info($LoggedInUser['id']);  	   
				 $arContent['content'] = $this->load->view('rides/aboutspecifications.php',$arData,true); 
				 $this->load->view('layouts/empty.php',$arContent);  
			}
  }  
////////////////////////////////////////////////////////////////////// 
  public function UpdatePersonalForm()
  {
   
   if(!ensureUser_popup())
		echo "LO";
	else
		{	
   				if($_POST){
					
					//$arData['Data'] = $_POST; 
					$arData=array();
					$this->load->model('User_model');
					//$LoggedInUser = $this->session->userdata('User');
					$userdata = userSession();	 	
					$userid =$userdata['id'];		 
					$description = $this->input->post('description');
					$exterior_color = $this->input->post('exterior_color');
					$year_model = $this->input->post('year_model');
					$type = $this->input->post('type');
					$brand = $this->input->post('brand');
					$model = $this->input->post('model');
					//see($_POST);
					$data = array('description ' => $description,'year_model' => $year_model,'exterior_color'=>$exterior_color,'type'=>$type,'make'=>$brand,'model'=>$model);
					
					$this->main_model->addNewVehicleDelete();//delete earlier added make/model that are still un-reviewed
					
					$brandArray=explode('-',$_POST['brand']);
					$modelArray=explode('-',$_POST['model']);
					
					$brandModel='';
					if($brandArray[0]=='suggestion')
						$brandModel='brand';
					else if($modelArray[0]=='suggestion')				
						$brandModel='model';
					if($brandModel!='')
					{

						$res=$this->main_model->addNewVehicle($_POST,$brandModel);
						if($brandModel=='brand')
							$data['make']=$res;
						$data['model']=$res;
					}
					
					
					$this->User_model->edit_my_ride($data,$userid);
					$this->db->trans_complete();
					//$arData['UserUpdateData'] =   $this->User_model->edit_my_ride($data,$userid);
					//print_r($_POST);  die;
			   
			   }
		}
  }
  
  public function processupload(){
  
      $this->load->library('file_upload');
  
      $thumb_square_size 		= 200; //Thumbnails will be cropped to 200x200 pixels
      $max_image_size 		= 500; //Maximum image size (height and width)
      $thumb_prefix			= "thumb_"; //Normal thumb Prefix
      $destination_folder		= $this->config->item('system_path').'uploads/'; //upload directory ends with / (slash)
      $jpeg_quality 			= 90; //jpeg quality
      ##########################################
      
      //continue only if $_POST is set and it is a Ajax request
      if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
      
      	// check $_FILES['ImageFile'] not empty
      	if(!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])){
      			die('Image file is Missing!'); // output error when above checks fail.
      	}
      	
      	//uploaded file info we need to proceed
      	$image_name = $_FILES['image_file']['name']; //file name
      	$image_size = $_FILES['image_file']['size']; //file size
      	$image_temp = $_FILES['image_file']['tmp_name']; //file temp
      
      	$image_size_info 	= getimagesize($image_temp); //get image size
      	
      	if($image_size_info){
      		$image_width 		= $image_size_info[0]; //image width
      		$image_height 		= $image_size_info[1]; //image height
      		$image_type 		= $image_size_info['mime']; //image type
      	}else{
      		die("Make sure image file is valid!");
      	}
      
      	//switch statement below checks allowed image type 
      	//as well as creates new image from given file 
      	switch($image_type){
      		case 'image/png':
      			$image_res =  imagecreatefrompng($image_temp); break;
      		case 'image/gif':
      			$image_res =  imagecreatefromgif($image_temp); break;			
      		case 'image/jpeg': case 'image/pjpeg':
      			$image_res = imagecreatefromjpeg($image_temp); break;
      		default:
      			$image_res = false;
      	}       
      
      	if($image_res){
      		//Get file extension and name to construct new file name 
      		$image_info = pathinfo($image_name);
      		$image_extension = strtolower($image_info["extension"]); //image extension
      		$image_name_only = strtolower($image_info["filename"]);//file name only, no extension
      		
      		//create a random name for new image (Eg: fileName_293749.jpg) ;
      		$new_file_name = $image_name_only. '_' .  rand(0, 9999999999) . '.' . $image_extension;
      		
      		//folder path to save resized images and thumbnails
      		$thumb_save_folder 	= $destination_folder . $thumb_prefix . $new_file_name; 
      		$image_save_folder 	= $destination_folder . $new_file_name;
      		
      		//call normal_resize_image() function to proportionally resize image
      		if($this->file_upload->normal_resize_image($image_res, $destination_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality))
      		{
      			//call crop_image_square() function to create square thumbnails
      			if(!$this->file_upload->crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
      			{
      				die('Error Creating thumbnail');
      			}
      			
      			/* We have succesfully resized and created thumbnail image
      			We can now output image to user's browser or store information in the database*/
      			echo '<img src="uploads/'.$thumb_prefix . $new_file_name.'" alt="Thumbnail">';
      			echo '<br />';
      			echo '<img src="uploads/'. $new_file_name.'" alt="Resized Image">';
      		}
      		
      		imagedestroy($image_res); //freeup memory
      	}
      }
  
  
     die('here');
  
  }
	
	
	
}

/* End of file Ride.php */
/* Location: ./application/controllers/Ride.php */
