<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resolveconflict extends CI_Controller {


	
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('resloveconflict_model');
	
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
	
//////////Login function statrt here//////////////
public function index() {  
 
	    $arData =   array();
		$arData['userdata'] = userSession();
		
		$arContent['content'] = $this->load->view('resloveconflict/index.php',$arData,true);	 
		if(!ensureUser_popup())
			$this->load->view('layouts/default.php',$arContent);    
		else	
			$this->load->view('layouts/default-user.php',$arContent);    
		
  }   
///////////////////////////////////////////////////////////////////  
 public function submit()
 {
	   if(isset($_POST["Vehicle_no"]))
	   {
			   $data=$_POST;
				$this->resloveconflict_model->resolve_conflict_submit($data);
				// redirect(site_url().'resloveconflict');
			// header('location:'.site_url().'resloveconflict');
			echo "done";
        }
 }
 public function submitted()
 {
   
 
	    $arData =   array();
		$arContent['content'] = $this->load->view('resloveconflict/submitted',$arData,true);	 
		$this->load->view('layouts/default.php',$arContent);    

 }
 
public function vdetail() {  
 
	    $arData =   array(); 
	    if($_POST){										
		$newodata=array('user_id'=>$_POST['rno'],'make'=>$_POST['brand'],'model'=>$_POST['model'],'type'=>$_POST['type'],'username'=>$_POST['username']);
		$this->resloveconflict_model->inserconflict($newodata);
		echo "cadded"; 
		die;
		}	    
		$arContent['content'] = $this->load->view('resloveconflict/vdetail.php',$arData,true);	 
		$this->load->view('layouts/empty.php',$arContent);    
		
  } 
////////////////////////////////////////////////////////////////////////////////
public function vimage() {    
 
	    $arData =   array();	    
		
		$arData['Userdetail']=userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];			
		$arContent['content'] = $this->load->view('resloveconflict/vimage.php',$arData,true);	 
		$this->load->view('layouts/empty.php',$arContent);    
		
  }  
/////////////////////////////////////////////////////////////////////
public function vimageadd() {    
  
		$arData =   array();	    

		$arData['Userdetail']=userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id']; 
  	if($_FILES['picture']['name'] != ""){
				$path="./uploads/gallery"; 
				$t1=time();
				$imagename=$t1.$_FILES['picture']['name'];		
				$tmpname = $_FILES['picture']['tmp_name'];
				@move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
				$this->smart_resize_image($path.'/temp/'.$imagename,500,'400',true,$path.'/large/'.$imagename,false,false ); 
				$this->smart_resize_image($path.'/temp/'.$imagename,200,'239',true,$path.'/thumb/'.$imagename,true,false );
				$this->smart_resize_image($path.'/temp/'.$imagename,206,'93',true,$path.'/small/'.$imagename,true,false );
				$this->smart_resize_image($path.'/temp/'.$imagename,86,'38',true,$path.'/verysmall/'.$imagename,true,true ); 

				if(is_readable($path."/thumb/".$imagename)) {
				@chmod($path."/thumb/".$imagename,0777); 
				}
				if(is_readable($path."/large/".$imagename)) {
				@chmod($path."/large/".$imagename,0777);   
				}	
 
				if(is_readable($path."/verysmall/".$imagename)) {
				@chmod($path."/verysmall/".$imagename,0777);
				}
				if(is_readable($path."/small/".$imagename)) {
				@chmod($path."/small/".$imagename,0777);
				}	
		
		}else{
		$imagename='';
	    }	
		$newodata=array('image'=>$imagename);
		$this->resloveconflict_model->updateconflict($userid,$newodata);
		echo "imageadded"; 
		die;
		 
	}	
	
/////////////////////////////////////////////////////////////////////
public function vrdocument() {    
  
		$arData =   array();	    

		$arData['Userdetail']=userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id']; 
  	if($_FILES['picture']['name'] != ""){
				$path="./uploads/gallery/document"; 
				$t1=time();
				$imagename=$t1.$_FILES['picture']['name'];		
				$tmpname = $_FILES['picture']['tmp_name'];
				@move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/'.$imagename);					
		
		}else{
		$imagename='';
	    }	
		$newodata=array('document'=>$imagename);
		$this->resloveconflict_model->updateconflict($userid,$newodata);
		echo "document"; 
		die;
		 
	}		
 ////////////////////////////////////////////////////////////////////////////////
public function vregistration() {  
 
	    $arData =   array();

		$arData['Userdetail']=userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];		
		$arContent['content'] = $this->load->view('resloveconflict/vregistration.php',$arData,true);	 
		$this->load->view('layouts/empty.php',$arContent);    
		
  }  
/////////////////////////////////////////////////////////	
	
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
                                                         
