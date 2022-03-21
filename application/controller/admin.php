<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class admin extends CI_Controller {
	/**
	 * Index Page for this controller.	 
	 */
///////////////////////////////////////////////////////////////////
 function __construct() 
  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('admin_model');
		$this->load->model('main_model');
		$this->load->model('forgotpwd_model');
		$this->load->library('email'); 
		
		
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
//////////index function statrt here//////////////   
public function index()	{ 		
		
		 if($this->session->userdata('admin')){
				redirect(site_url().'admin/home','refresh');
	    }else{
		$adminData =   array();
		$adminData['page_title']="Login";  		
		$adminContent['content'] = $this->load->view('admin/login.php',$adminData,true);	
		$this->load->view('layouts/admindefaultlogin.php',$adminContent); 
	  }
	}     


 
//////////Login function statrt here//////////////
public function login()	{ 		
		
		$data = array();
		$adminData['page_title']="Login"; 
	    $usrname = strtoupper($_POST['username']);		
		$password = $_POST['pwd'];	  	
		$query = $this->admin_model->userlogin($usrname,$password);		
		if($query->num_rows > 0 ) {
				 
			    $adminData = $query->row_array();
				$this->session->set_userdata('uname',$adminData['first_name']);
				$this->session->set_userdata('admin',$adminData['role']);
				$this->session->set_userdata('surname',$adminData['last_name']);
				$this->session->set_userdata('user_id',$adminData['username']);
				$this->session->set_userdata('loginuserid',$adminData['id']);
				$this->session->set_userdata('User',$adminData);
				echo "success";				
				die;	
		}else{     
			    echo "fail";
				die;	
			 } 
	}     

////////////////////////////////////////////////////////////////////////////////////
	function logout(){
				
				$this->session->sess_destroy();				
				redirect(site_url().'admin','refresh');	
           }	
/////////////////////////////////////////////////////////////////////////////////
function ensureadminuser()         
 
     {
			if($this->session->userdata('admin') == '')
			{
				redirect(site_url().'admin','refresh');
				return false;				
			}
			  elseif($this->session->userdata('admin') != 1)
			{
				return true;
	   }
     }
//////////////////////////////////////////////////////////////////////////
public function forgotpassword()	{ 		
		
		//$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Reset Password";  		
		$adminContent['content'] = $this->load->view('admin/forgotpassword.php',$adminData,true);	
		$this->load->view('layouts/admindefaultlogin.php',$adminContent); 
	}    
//////////home function statrt here//////////////////////////////////////
public function home()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Home"; 
		$adminData['alluserdata'] = $this->admin_model->alluserdetail();		
		$adminContent['content'] = $this->load->view('admin/home.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	} 
/////////////////////////////////////////////////////////////////////////////////////////
public function photo()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Photo"; 
		$adminData['tabon']="photos";
		$adminData['allphotodata'] = $this->admin_model->allphotodetail();		
		$adminContent['content'] = $this->load->view('admin/photo.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	} 
	
public function photosReviewed()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Photo"; 
		$adminData['tabon']="photos-reviewed";
		$adminData['allphotodata'] = $this->admin_model->allphotodetailReviewed();		
		$adminContent['content'] = $this->load->view('admin/photo.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	} 	
	
/////////////////////////////////////////////////////////////////////////////////////////
public function order()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Order"; 
		$adminData['allorderdata'] = $this->admin_model->allorderdetail();		
		$adminContent['content'] = $this->load->view('admin/order.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	}
/////////////////////////////////////////////////////////////////////////////////////////
public function rconflict()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Conflict"; 
		$adminData['allrcdata'] = $this->admin_model->allrcdetail();		
		$adminContent['content'] = $this->load->view('admin/rconflict.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	}	
/////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////
public function contact()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="contact"; 
		$adminData['allcontactdata'] = $this->admin_model->allcontactdetail();		
		$adminContent['content'] = $this->load->view('admin/contact.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	}	
/////////////////////////////////////////////////////////////////////////////////////////
public function blockedlist()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Reported Profiles List"; 
		$adminData['allbplist'] = $this->admin_model->allbplist();		
		$adminContent['content'] = $this->load->view('admin/blockedplist.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	}	
/////////////////////////////////////////////////////////////////////////////////////////
public function pages()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Pages"; 
		$adminData['allpagesdata'] = $this->admin_model->allpagesdetail();		
		$adminContent['content'] = $this->load->view('admin/pages.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	}

/////////////////////////////////////////////////////////////////////////////////////////
public function htmlbox()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="HTML Box"; 
		$adminData['allhtmlboxdata'] = $this->admin_model->allhtmlboxdetail();		
		$adminContent['content'] = $this->load->view('admin/htmlbox.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	}	 		    
//////////////////////////////////////////////////////////////////////////////////////////
public function view()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="View"; 
	    $userid = $this->uri->segment(3);	
		$adminData['userdata'] = $this->admin_model->userdata($userid);		
		$adminContent['content'] = $this->load->view('admin/view.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}  
	
//////////////////////////////////////////////////////////////////////////////////////////
public function viewblist()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="View Blocked List"; 
	    $userid = $this->uri->segment(3);	
		$adminData['userdata'] = $this->admin_model->userdata($userid);		
		$adminContent['content'] = $this->load->view('admin/viewblist.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}	
	
//////////////////////////////////////////////////////////////////////////////////////////
public function viewpage()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="View Page"; 
	    $userid = $this->uri->segment(3);	
		$adminData['pagedata'] = $this->admin_model->pagedata($userid);		
		$adminContent['content'] = $this->load->view('admin/viewpage.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}	

//////////////////////////////////////////////////////////////////////////////////////////
public function viewhtmlbox()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="View Html Box"; 
	    $userid = $this->uri->segment(3);	
		$adminData['htmlboxdata'] = $this->admin_model->htmlboxdata($userid);		
		$adminContent['content'] = $this->load->view('admin/viewhtmlbox.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}	
//////////////////////////////////////////////////////////////////////////////////////////
public function viewphoto()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="View Photo"; 
	    $photoid = $this->uri->segment(3);	
		$adminData['photodata'] = $this->admin_model->photodata($photoid);				
		$adminContent['content'] = $this->load->view('admin/viewphoto.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}
//////////////////////////////////////////////////////////////////////////////////////////
public function vieworder()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="View order"; 
	    $photoid = $this->uri->segment(3);	
		$adminData['orderdata'] = $this->admin_model->orderdata($photoid);				
		$adminContent['content'] = $this->load->view('admin/vieworder.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}

//////////////////////////////////////////////////////////////////////////////////////////
public function viewrconflict()	{ 	 	
		
		$this->ensureadminuser(); 		  
		$adminData =   array();
		$adminData['page_title']="View conflict"; 
	    $photoid = $this->uri->segment(3);	
		$adminData['rconflict'] = $this->admin_model->rconflictdata($photoid);				
		$adminContent['content'] = $this->load->view('admin/viewrconflict.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}	
//////////////////////////////////////////////////////////////////////////////////////////
public function viewcontact()	{ 	 	
		
		$this->ensureadminuser(); 		  
		$adminData =   array();
		$adminData['page_title']="View contact"; 
	    $userid = $this->uri->segment(3);	
		$adminData['contact'] = $this->admin_model->contactdata($userid);				
		$adminContent['content'] = $this->load->view('admin/viewcontact.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}	
//////////////////////////////////////////////////////////////////////////////////////////
public function addorder()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="Add Order"; 
		if($_POST){
						$data = $_POST;
						$data['fname'] = ucwords($_POST['fname']);
						$data['sname'] = ucwords($_POST['sname']);					
						$data['street'] = ucwords($_POST['street']);  	  	
						$data['city'] = ucwords($_POST['city']);
						$data['landmark'] = ucwords($_POST['landmark']);
						$newodata=array('fname'=>$data['fname'],'lname'=>$data['sname'],'street'=>$_POST['street'],'phoneno'=>$_POST['phone'],'city'=>$data['city'],'state'=>$data['state'],'landmark'=>$data['landmark']);
						$this->admin_model->inserorder($newodata);
						echo "user_added";
						die;
		}					
		$adminContent['content'] = $this->load->view('admin/addorder.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}			 

//////////////////////////////////////////////////////////////////////////////////////////
public function addpage()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="Add Page"; 
		if($_POST){
						$data = $_POST; 
						 $data['pname'] = ucwords($_POST['pname']);
						 $data['description'] = ucwords($_POST['description']);						
						$newodata=array('name'=>$data['pname'],'description'=>$data['description'],'status'=>'0');
						$this->admin_model->insertpage($newodata);
						//echo "page_added";
						//return $page;
						//die;
						redirect(site_url().'admin/pages','refresh');
						die;
		}					
		$adminContent['content'] = $this->load->view('admin/addpage.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}			 


//////////////////////////////////////////////////////////////////////////////////////////
public function addhtmlbox()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="Add HTML Box";
		 
		if($_POST){
						
						
						$comma_separated = implode(",", $_POST['showplist']);
						$data = $_POST; 
						$data['htmlboxname'] = ucwords($_POST['htmlboxname']);
						$data['description'] = ucwords($_POST['description']);						
						$newodata=array('htmlboxname'=>$data['htmlboxname'],'description'=>$data['description'],'status'=>'0','pagelist'=>$comma_separated);
						$this->admin_model->inserthtmlbox($newodata);
						//echo "html_added";  
						//die;
						redirect(site_url().'admin/htmlbox','refresh');
		}
		$adminData['pagelist']= $this->admin_model->allpagelist();					
		$adminContent['content'] = $this->load->view('admin/addhtmlbox.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}	
	
//////////////////////////////////////////////////////////////////////////////////////////
public function adduser()	{ 		
		
		$this->ensureadminuser();		  
		$adminData =   array();
		$adminData['page_title']="Add User";
		if($_POST){
						$data = $_POST;
						$data['fname'] = ucwords($_POST['firstname']);
						$data['sname'] = ucwords($_POST['lastname']);  
						$checkduplicaterc=$this->admin_model->checkduplicaterc($data);
						$checkduplicateemail=$this->admin_model->checkduplicateemail($data);
						if($checkduplicaterc=='yes' && $checkduplicateemail=='yes'){
							echo "duplicatercemail";die;
						}elseif($checkduplicaterc=='yes' && $checkduplicateemail=='no')	{
							echo "duplicaterc";die;
						}elseif($checkduplicaterc=='no' && $checkduplicateemail=='yes')	{
							echo "duplicateemail";die;
						}else
						{
							  $activation_code=$this->admin_model->adduser($data);
							  $linkdata = array();
									  $linkdata['email'] = $data['email'];		
									  $linkdata['activation_code'] = $activation_code;
									  $activation_link = $this->config->item('base_url')."user/activate/" . urlencode(base64_encode(json_encode($linkdata)));	
                    
                   //echo $activation_link; die;	
									
								$this->load->library('email');           
								$config['mailtype'] = 'html';
								$this->email->initialize($config);
								$this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name'));
								//$this->email->from('Geri Culture');
								$this->email->to($data['email']);
								$this->email->subject('Activate your account');
								$this->email->message('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body style="background-color:#f5f3f0;">
<table bgcolor="#f5f3f0" cellpadding="0" cellspacing="0" align="center" width="100%" style=" padding:50px 0;" >
<tr>
<td>

<table  cellpadding="o" cellspacing="0" align="center" width="70%">

<tr align="center" height="100px" valign="bottom">
<td>
<a href="'.$this->config->item('base_url').'"><img width="147" height="56" src="'.site_url().'static/img/geri-email-logo.png"></a>
</td>
</tr>

<tr style="height:100px" align="center">
    <td style="font-size:25px; font-family:Verdana, Geneva, sans-serif;">
    Hi '.$data['firstname']. ' ' .$data['lastname'].'
</td>
</tr>

<tr align="center">
 <td valign="bottom">
    <table width="65%" border="0" cellspacing="0" cellpadding="0" style="background:white; border:1px solid #dddddd;" align="center">
     <tr align="center">
      <td valign="bottom" style=" font-family:Verdana, Geneva, sans-serif; font-size:14px; padding:35px 15px; color:#666666;">
      Activate your account on Geri Culture by confirming your email. 
      </td>
     </tr>
     <tr align="center" bgcolor="#ededed">
      <td style="padding:15px; border-top:1px solid #dddddd;">
       <a style="text-decoration:none;" href="#"><table width="200" border="1" cellspacing="12" cellpadding="0" style="width:150.0pt;background:#d43638;border:solid #910101 1.0pt">
       <tr align="center">
        <td style="border:none;padding:0in 0in 0in 0in">
        <span style="color:white;text-decoration:none; font-family:Verdana, Geneva, sans-serif; font-size:20px;">
	<a href="'.$activation_link.'" style="color:white;text-decoration:none;">Confirm email</a></span>
        </td>
       </tr>
      </table>
	  </a>
      </td>
     </tr>
    </table>
 </td>
</tr>
   
   
<tr align="center">
    <td style="font-family:Verdana, Geneva, sans-serif; font-size:25px; padding:30px 0 50px 0; color:#666666;">Have fun!</td>
</tr> 


<tr>
<td>
<table align="center" width="65%" border="0" cellspacing="0" cellpadding="0">
<tr align="center">
<td style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#999999; line-height:15px;">This email was sent to '.$data['email'].'</td>
</tr> 

<tr align="center">
<td style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#999999; line-height:15px;">©2017 Geri Culture | All Rights Reserved</td>
</tr>

<tr align="center">
<td style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#999999; line-height:15px;"><a style="color:#999999;" href="https://www.google.com/url?q=http://email.pinterest.com/mpss/c/nQA/2dUJAA/VpCjkMqNTISsdcb5LV9PHQ/h19/33lpGjfYrO3Hjsigk-2FI1FAawG1VHdOsWC0vuZmX1aQgxFA3BQ1xseVJgrOrIEdla">privacy Policy</a> | <a style="color:#999999;" href="https://www.google.com/url?q=http://email.pinterest.com/mpss/c/nQA/2dUJAA/VpCjkMqNTISsdcb5LV9PHQ/h19/33lpGjfYrO3Hjsigk-2FI1FAawG1VHdOsWC0vuZmX1aQgxFA3BQ1xseVJgrOrIEdla">Terms and Conditions</a></td>
</tr>
</table>
</td>
</tr>
</table>

</td>
</tr>
</table>
</body>
</html>');

								$this->email->send();
							//Email to user Ends
							
							//Email to Admin
								$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
								$this->email->to($this->config->item('admin_email_address'));
								$this->email->subject('New user registration - Chandigarh Geri');
								$this->email->message('<p>New user registered.</p><p>'.$data['firstname'].', '.$data['email'].'</p>');

								$this->email->send();
								//Email to Admin Ends							
								echo "user_added";
								die();

							
						}
		}					
		$adminContent['content'] = $this->load->view('admin/adduser.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	} 	
///////////////////////////////////////////////////////////////////////////////////////
function edituser(){
  
                $this->ensureadminuser();
                $adminData =   array();
		        $adminData['page_title']="Edit"; 			
				$id=$this->uri->segment(3);								
				$adminData['userdata'] = $this->admin_model->edituser($id);						
				$adminContent['content'] = $this->load->view('admin/edituser.php',$adminData,true);	
				$this->load->view('layouts/admindefault.php',$adminContent);              
             }	
             
///////////////////////////////////////////////////////////////////////////////////////
function editphoto(){
  
                $this->ensureadminuser();
                $adminData =   array();
		        $adminData['page_title']="Edit Photo"; 			
				$id=$this->uri->segment(3);								
				$adminData['photodata'] = $this->admin_model->editphoto($id);						
				$adminContent['content'] = $this->load->view('admin/editphoto.php',$adminData,true);	
				$this->load->view('layouts/admindefault.php',$adminContent);              
             }	

///////////////////////////////////////////////////////////////////////////////////////
function editpage(){
  
                $this->ensureadminuser();
                $adminData =   array();
		        $adminData['page_title']="Edit Page"; 			
				$id=$this->uri->segment(3);								
				$adminData['pagedata'] = $this->admin_model->editpage($id);						
				$adminContent['content'] = $this->load->view('admin/editpage.php',$adminData,true);	
				$this->load->view('layouts/admindefault.php',$adminContent);              
             }	
             
 ///////////////////////////////////////////////////////////////////////////////////////
function edithtmlbox(){
  
                $this->ensureadminuser();
                $adminData =   array();
		        $adminData['page_title']="Edit Html Box"; 			
				$id=$this->uri->segment(3);								
				$adminData['htmlboxdata'] = $this->admin_model->edithtmlbox($id);						
				$adminContent['content'] = $this->load->view('admin/edithtmlbox.php',$adminData,true);	
				$this->load->view('layouts/admindefault.php',$adminContent);              
             }            
 ///////////////////////////////////////////////////////////////////////////////////////
function editorder(){
  
                $this->ensureadminuser();
                $adminData =   array();
		        $adminData['page_title']="Edit Photo"; 			
				$id=$this->uri->segment(3);								
				$adminData['orderdata'] = $this->admin_model->editorder($id);						
				$adminContent['content'] = $this->load->view('admin/editorder.php',$adminData,true);	
				$this->load->view('layouts/admindefault.php',$adminContent);              
             }	
  ///////////////////////////////////////////////////////////////////////////////////////
function editrconflict(){      
  
                $this->ensureadminuser();   
                $adminData =   array();
		        $adminData['page_title']="Edit conflict"; 			
				$id=$this->uri->segment(3);	   							
				$adminData['rconflict'] = $this->admin_model->editrconflict($id);						
				$adminContent['content'] = $this->load->view('admin/editrconflict.php',$adminData,true);	
				$this->load->view('layouts/admindefault.php',$adminContent);              
             }	                      
 /////////////////////////////////////////////////////////////////////////////////////////
 public function fpassword()	{ 
		
	
	$arData =   array();	
	if($_POST){    
	$useremail = $_POST['email'];	
	$query = $this->forgotpwd_model->emailadmindetail($useremail);	
	if($query->num_rows > 0 ) {	   
	    
		$userdetails = $query->row_array();
		$userfname = $userdetails['first_name'];
		$userlname = $userdetails['last_name'];    
	    $activation_code=date('Y-m-d' );
		$linkdata = array();   
		$linkdata['email'] = $useremail;	   	
		$linkdata['activation_code'] = $activation_code;
		$activation_link = $this->config->item('base_url')."admin/changepwd/" . urlencode(base64_encode(json_encode($linkdata)));	
		$this->load->library('email');
		$config['mailtype'] = 'html';  
		$this->email->initialize($config);
		$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));		
		//$this->email->from($from,$this->config->item('email_from_name'));  
		$this->email->to($useremail);           
		$this->email->subject('Reset password');     
		$this->email->message('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body style="background-color:#f5f3f0;">
<table bgcolor="#f5f3f0" cellpadding="o" cellspacing="0" align="center" width="100%" style=" padding:50px 0;">
<tr>
<td>

<table cellpadding="o" cellspacing="0" align="center" width="70%" style="margin:0 auto;">

<tr align="center" height="100px" valign="bottom">
<td>
<a href="'.$this->config->item('base_url').'"><img width="147" height="56" src="'.site_url().'"static/img/geri-email-logo.png"></a>
</td>
</tr>

<tr align="center">
    <td style="font-size: 25px; font-family: Verdana,Geneva,sans-serif; display: block; margin-top:20px; height:70px;">
    Hi '.$userfname.' '.$userlname.'  
</td>
</tr>

<tr align="center">
 <td valign="bottom">
    <table width="65%" border="0" cellspacing="0" cellpadding="0" style="background:white; border:1px solid #dddddd;" align="center">
     <tr align="center">
      <td valign="bottom" style=" font-family:Verdana, Geneva, sans-serif; font-size:14px; padding:35px 15px; color:#666666; ">
      Ready to choose your password?  
      </td>
     </tr>
     <tr align="center" bgcolor="#ededed">
      <td style="padding:15px; border-top:1px solid #dddddd;">
       <a style="text-decoration:none;" href="#">
	   <table width="200" border="1" cellspacing="12" cellpadding="0" style="width:150.0pt;background:#d43638;border:solid #910101 1.0pt">
       <tr align="center">
        <td style="border:none;padding:0in 0in 0in 0in">
        <span style="font-family:Verdana, Geneva, sans-serif; font-size:20px;"><a href="'.$activation_link.'" style="color:white;text-decoration:none; ">Reset password</a></span>
        </td>
       </tr>
      </table>
	  </a>
      </td>
     </tr>
    </table>
 </td>
</tr>
   
   
<tr align="center">
<td style="padding-top:20px;">
    <table width="65%" border="0" cellspacing="0" cellpadding="0" style="background:white; border:1px solid #dddddd;" align="center">
    <tr align="center">
    <td style="font-family: Verdana,Geneva,sans-serif; font-size: 16px; padding: 40px; color: rgb(102, 102, 102); line-height: 24px;">You have 24 hours to change your password. After that, you will have to ask for a new email.</td>
    </tr>
    </table>
</td>
</tr> 


<tr>
<td style="padding:50px 0 0 0;">
<table align="center" width="65%" border="0" cellspacing="0" cellpadding="0" >
<tr align="center">
<td style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#999999; line-height:15px;">This email was sent to <a style="color:#999999;" href="mailto:'.$useremail.'">'.$useremail.'</a></td>
</tr> 

<tr align="center">
<td style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#999999; line-height:15px;">©2017 Geri Culture | All Rights Reserved</td>
</tr>

<tr align="center">
<td style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#999999; line-height:15px;"><a style="color:#999999;" href="https://www.google.com/url?q=http://email.pinterest.com/mpss/c/nQA/2dUJAA/VpCjkMqNTISsdcb5LV9PHQ/h19/33lpGjfYrO3Hjsigk-2FI1FAawG1VHdOsWC0vuZmX1aQgxFA3BQ1xseVJgrOrIEdla">Terms and Conditions</a></td>
</tr>
</table>
</td>
</tr>
</table>

</td>
</tr>
</table>
</body>
</html>');
		$this->email->send();		
		$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
		$this->email->to($this->config->item('admin_email_address'));
		$this->email->subject('Change Admin Password - Chandigarh Geri');
		$this->email->message('<p>Password change.</p><p>User, '.$useremail.'</p>');
		$this->email->send();		   
		echo "success";
		die;
		}else{
	          
				echo "error";
				die;
	         }
	} 
	//$arContent['content'] = $this->load->view('admin/forgotpassword.php',$arData,true);	
	//$this->load->view('layouts/default.php',$arContent);  
	
  }
////////////////////////////////////////////////////////////////////////
public function changepwd($encodeeddata=null)	{ 
		
	
	$arData =   array();	
	$arData['page_title']="Change Password";  
	$useremail = json_decode(base64_decode(urldecode($encodeeddata)));
	if(is_object($useremail))
	$user_email = (array) $useremail;
	if(	is_array($user_email) 	&& !empty($user_email['email']) && !empty($user_email['activation_code'])	)
	{											
							  
	}              
	
	$arData['user_email_id']=$user_email['email'];
	$arContent['content'] = $this->load->view('admin/changepwd.php',$arData,true);	
	$this->load->view('layouts/admindefaultlogin.php',$arContent);

}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
public function activate()	{ 		

$arData =   array(); 
if($_POST){
		
	  	$newpass = $_POST['password'];
		$cpass = $_POST['cpassword'];
	    $useremail = $_POST['emailid'];
		$this->load->library('form_validation');
		if($newpass=='' && $cpass=='' && $useremail==''){}
		else{
		$this->form_validation->set_rules('password', 'password', 'trim|required|matches[cpassword]');
		$this->form_validation->set_rules('cpassword', 'Password confirmation', 'trim|required|matches[password]');
		}
		if ($this->form_validation->run() == FALSE)
		{
			echo "error";
			die;
		}
		
		$newpass=MD5($newpass);
		$data = array('password' => $newpass);
		$this->db->trans_start();
		$this->forgotpwd_model->updatepassword($useremail,$data);
		$this->db->trans_complete(); 
		echo "success";
		die;		
		
	}
	//$arContent['content'] = $this->load->view('forgotpassword/thankyou',$arData,true);	
	//$this->load->view('layouts/defaultbasic.php',$arContent);
	
}	 
             
//////////////////////////////////////////////////////////////////////////////////////////            
  function editnewuser(){
  
                $this->ensureadminuser();   
                $data=array();
				$data['fname'] = ucwords($_POST['firstname']);
				$data['sname'] = ucwords($_POST['lastname']);
				$data['city'] = ucwords($_POST['city']);
				$data['state'] = ucwords($_POST['state']);
				$data['college'] = ucwords($_POST['college']);
				$data['course'] = ucwords($_POST['course']);
				$newdata=array('first_name'=>$data['fname'],'last_name'=>$data['sname'],'email_id'=>$_POST['email'],
				'city'=>$data['city'],'state'=>$data['state'],'college'=>$data['college'],'course'=>$data['course'],'occupation'=>$_POST['occupation']);
				$this->admin_model->updateuser($_POST['userid'],$newdata);
				echo "success";
               	die;					
				             
             }	           
//////////////////////////////////////////////////////////////////////////////////////////            
  function editneworder(){
  
                $this->ensureadminuser();   
                $data=array();
				$data['fname'] = ucwords($_POST['fname']);
				$data['sname'] = ucwords($_POST['fname']);
				$data['city'] = ucwords($_POST['city']);
				$data['state'] = ucwords($_POST['state']);
				$data['landmark'] = ucwords($_POST['landmark']);  
				$newodata=array('fname'=>$data['fname'],'lname'=>$data['sname'],'street'=>$_POST['street'],'status'=>$_POST['status'],'phoneno'=>$_POST['phone'],'city'=>$data['city'],'state'=>$data['state'],'landmark'=>$data['landmark']);
				$this->admin_model->updateorder($_POST['userid'],$newodata);
				echo "success";
               	die;					
				             
             }	
             
 //////////////////////////////////////////////////////////////////////////////////////////            
  function editnewconflict(){
  
                $this->ensureadminuser();   
                $data=array();				
			 
				$newodata=array('user_id'=>$_POST['rno'],'make'=>$_POST['make'],'status'=>$_POST['status'],'model'=>$_POST['model'],'type'=>$_POST['type']);
				$this->admin_model->updateconflict($_POST['userid'],$newodata);
				echo "success";
               	die;					
				             
             }	            
  //////////////////////////////////////////////////////////////////////////////////////////            
  function editnewpage(){
  
                $this->ensureadminuser();   
                $data=array();
				$data['pname'] = ucwords($_POST['pname']);
				$data['description'] = ucwords($_POST['description']);			
				$newodata=array('name'=>$data['pname'],'description'=>$data['description'],'status'=>$_POST['status']);
				$this->admin_model->updatepage($_POST['userid'],$newodata);
				//echo "success";
               	//die;	
               	redirect(site_url().'admin/pages','refresh');
               	die;				
				             
             }	 
                                  
function editnewhtmlbox(){
  
                $this->ensureadminuser();   
                $data=array();
				$data['htmlboxname'] = ucwords($_POST['htmlboxname']);				
				$data['description'] = ucwords($_POST['description']);			
				$newodata=array('htmlboxname'=>$data['htmlboxname'],'description'=>$data['description'],'status'=>$_POST['status']);
				$this->admin_model->updatehtmlbox($_POST['userid'],$newodata);
				echo "success";
               	die;	
               	redirect(site_url().'admin/htmlbox','refresh');				
				             
             }	
//////////////////////////////////////////////////////////////////////////////////////////            
  function editnewphoto(){
  
                $this->ensureadminuser();   
                $data=array();
				$data['user_id'] = ucwords($_POST['user_id']);				
				$data['pic_type'] = ucwords($_POST['pic_type']);
				$data['pic_desc'] = ucwords($_POST['pic_desc']);
				$data['status'] = ucwords($_POST['status']);
				$data['horn'] = ucwords($_POST['horn']);				
				if($_FILES['pic_name']['name'] != ""){
				$path="./uploads/gallery"; 
				$t1=time();
				$imagename=$t1.$_FILES['pic_name']['name'];		
				$tmpname = $_FILES['pic_name']['tmp_name'];
				@move_uploaded_file($_FILES['pic_name']['tmp_name'],$path.'/temp/'.$imagename);
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
				
				$newdata=array('user_id'=>$data['user_id'],'pic_type'=>$data['pic_type'],'pic_desc'=>$_POST['pic_desc'],'status'=>$data['status'],'horn'=>$data['horn'],'pic_name'=>$imagename);
				$this->admin_model->updatephoto($_POST['photoid'],$newdata);
				echo "success";  
               	die;					
				             
             }	           

///////////////////////////////////////////////////////////////////////////////////////
function delete()  {  
   
    $this->ensureadminuser();	
	$id= $this->uri->segment(3);		
	$this->admin_model->delete($id);	
	$this->db->trans_complete();
     redirect(site_url().'admin/home','refresh');
  }	
////////////////////////////////////////////////////////////////////////////
function deleteorder()  {  
   
    $this->ensureadminuser();	
	$id= $this->uri->segment(3);		
	$this->admin_model->deleteorder($id);	
	$this->db->trans_complete();	
     redirect(site_url().'admin/order','refresh'); 
  }	
  ////////////////////////////////////////////////////////////////////////////
function deletepage()  {  
   
    $this->ensureadminuser();	
	$id= $this->uri->segment(3);		
	$this->admin_model->deletepage($id);	
	$this->db->trans_complete();	
     redirect(site_url().'admin/pages','refresh'); 
  }	
///////////////////////////////////////////////////////////////////////////////////////
function deletephoto()  {  
  
    $this->ensureadminuser();	
	$id= $this->uri->segment(3);		
	$this->admin_model->deletephoto($id);	
	$this->db->trans_complete();	
     redirect(site_url().'admin/photo','refresh');    
  }	
/////////////////////////////////////////////////////////////////////////////////////
function deleterconflict()  {  
  
    $this->ensureadminuser();	
	$id= $this->uri->segment(3);		
	$this->admin_model->deleteconflict($id);	
	$this->db->trans_complete();	
     redirect(site_url().'admin/rconflict','refresh');
  }
///////////////////////////////////////////////////////////////////////////////////////
function deletecontact()  {  
  
    $this->ensureadminuser();	
	$id= $this->uri->segment(3);		
	$this->admin_model->deletecontact($id);	
	$this->db->trans_complete();	
     redirect(site_url().'admin/contact','refresh');
  }
///////////////////////////////////////////////////////////////////////////////////////


function deletehtmlbox()  {  
  
    $this->ensureadminuser();	
	$id= $this->uri->segment(3);		
	$this->admin_model->deletehtmlbox($id);	
	$this->db->trans_complete();	
     redirect(site_url().'admin/htmlbox','refresh');
  }	  

    function photosAction()
	{
		$data=$_POST;
		//see($data);
		if(!empty($data['imageSelected']))
		{	
			if($data['action']=='review')
				$this->admin_model->reviewImages($data);
			elseif($data['action']=='delete')
				$this->admin_model->deleteImages($data);	
		}
		 redirect(site_url().'admin/photo');
	}
    
    
/////////////////////////////////////////////////////////	

/////////////////////////////////////////////////////////////////////////////////////////
public function newVehicles()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="New Vehicles"; 
		$adminData['allrcdata'] = $this->admin_model->newVehicles();		
		$adminContent['content'] = $this->load->view('admin/newVehicles.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	}	
	
function updateNewVehicle($id)
{
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="New Vehicles"; 
		$adminData['result'] = $this->admin_model->newVehicle($id);		
		
		//see($adminData);
		if(!empty($adminData['result']))
			$this->load->view('admin/newVehicleUpdate',$adminData); 
}	

function updateNewVehicleSubmit()
{
		$this->ensureadminuser(); 
		$data=$_POST;
		if(!empty($data))
			$this->admin_model->updateNewVehicleSubmit($data);		
}
	
	
function reviewNewVehicle($id)
{
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="New Vehicles"; 
		$adminData['result'] = $this->admin_model->newVehicle($id);		
		
		//see($adminData);
		if(!empty($adminData['result']))
			$this->load->view('admin/newVehicleReview',$adminData); 
}	


function reviewNewVehicleSubmit()
{
	$this->ensureadminuser(); 
		$data=$_POST;
		if(!empty($data))
			$this->admin_model->reviewNewVehicleSubmit($data);		
}

public function vehicles()	{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Vehicles"; 
		$adminData['tabon']="photos";
		$adminData['allrcdata'] = $this->admin_model->newVehicles();		
		$adminContent['content'] = $this->load->view('admin/vehicles.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
	}
	
	
public function vehiclesBikes()	
{ 		
		
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['tabon']="photos-reviewed";
		$adminData['page_title']="VehiclesBikes"; 
		$adminData['allrcdata'] = $this->admin_model->newVehicles();		
		$adminContent['content'] = $this->load->view('admin/vehiclesbikes.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 
}


public function getCarModels($d,$t)
      {
					$this->load->model('setting_model');
					$res=$this->setting_model->getCarBikeModels($d,$t);
			//see($res);
		        foreach($res as $k=>$v)
			      {
                      echo '<tr><td class=model >'.$v['model'].'</td>
				      <td class="td-actions"> 
                      <a href="'.site_url().'admin/updateCarModel/'.$v['id'].'/'.$d.'" class="table_icons edit_icon editVehicle " title="Edit car model"  ></a>  
                      <a id="delete" href="'.site_url().'admin/deleteCarModel/'.$v['id'].'/'.$d.'" class="table_icons delete_icon editVehicle" title="Delete car model" onClick="" ></a>
					  </td> 
				      </tr>'; 
				
                  }
			          echo '	<tr>
			          <td>
		              <a href="'.site_url().'admin/addNewCarModel/'.$res[0]['brand_id'].'/'.$d.'" class="table_icons edit_icon editVehicle " title="Add new model"  >
                      <input type="button" name="brand" id="brand" value="Add new model" /></a>
					 </td>
					 </tr>';
          }
	  
	  
	  
function addNewCarModel($id,$d)
   {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Add new car";
		$adminData['id']=$id; 
		$adminData['brand']=$d; 
		
		
		//see($adminData);
		
		$this->load->view('admin/addNewCarModel',$adminData); 
    }
	
function addNewCarBrand()
   {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Add new car brand";
	 
		//see($adminData);
		
		$this->load->view('admin/addNewCarBrand',$adminData); 
    }		
	  
function updateCarModel($id,$d)
  {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="New Vehicles"; 
		$adminData['result'] = $this->admin_model->newCar($id);	
		$adminData['brand']=$d;	

		//see($adminData);
		if(!empty($adminData['result']))
		$this->load->view('admin/newVehicleCar',$adminData); 
   }
   
function updateCarMake($id)
  {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="New Vehicles"; 
		$adminData['result'] = $this->admin_model->CarMakeDetails($id);	
			

		//see($adminData);
		if(!empty($adminData['result']))
		$this->load->view('admin/newVehicleCarMake',$adminData); 
   }
   
function updateBikeMake($id)
  {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="New Vehicles"; 
		$adminData['result'] = $this->admin_model->bikeMakeDetails($id);	
			

		//see($adminData);
		if(!empty($adminData['result']))
		$this->load->view('admin/newVehicleBikeMake',$adminData); 
   }
   
   
   
function deleteCarMake($id)
  {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="delete Vehicles"; 
		$adminData['result'] = $this->admin_model->CarMakeDetails($id);	
			

		//see($adminData);
		if(!empty($adminData['result']))
		$this->load->view('admin/deleteVehicleCarMake',$adminData); 
   }
   
   
function deleteBikeMake($id)
  {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="delete Vehicles"; 
		$adminData['result'] = $this->admin_model->bikeMakeDetails($id);	
			

		//see($adminData);
		if(!empty($adminData['result']))
		$this->load->view('admin/deleteVehicleBikeMake',$adminData); 
   }	     
   
   
   	   
function deleteCarModel($id,$d)
  {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="delete Vehicles"; 
		$adminData['result'] = $this->admin_model->newCar($id);	
		$adminData['brand']=$d;	

		//see($adminData);
		if(!empty($adminData['result']))
		$this->load->view('admin/deleteVehicleCar',$adminData); 
   }	   
   
   
   
   
   	
	  
public function getBikeModels($d,$t)
      {
					$this->load->model('setting_model');
					$res=$this->setting_model->getCarBikeModels($d,$t);
			
		   foreach($res as $k=>$v)
			   {
                     echo '<tr><td class=model >'.$v['model'].'</td>
				     <td class="td-actions">      
					
                     <a href="'.site_url().'admin/updateBikeModel/'.$v['id'].'/'.$d.'" class="table_icons edit_icon editVehicle " title="Edit Bike Model"  ></a>  
                     <a id="delete" href="'.site_url().'admin/deleteBikeModel/'.$v['id'].'/'.$d.'" class="table_icons delete_icon editVehicle" title="Delete bike model" onClick="" ></a>
					 </td> 
					
				    </tr>'; 
				
                }
		            echo '	<tr>
			        <td>
		            <a href="'.site_url().'admin/addNewBikeModel/'.$res[0]['brand_id'].'/'.$d.'" class="table_icons edit_icon editVehicle " title="Add new model"  >
                    <input type="button" name="brand" id="brand" value="Add new model" /></a>
					</td>
					</tr>';
          } 
	  
	  
	  
function addNewBikeModel($id,$d)
   {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Add new bike"; 
		$adminData['id']=$id; 
		$adminData['brand']=$d; 
				
		
		//see($adminData);
		
		$this->load->view('admin/addNewBikeModel',$adminData); 
   }	
   
function addNewBikeBrand()
   {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="Add new bike brand";
	 
		//see($adminData);
		
		$this->load->view('admin/addNewBikeBrand',$adminData); 
    }		   
   
    
	  
function updateBikeModel($id,$d)
  { 
		   $this->ensureadminuser();   
		   $adminData =   array();
		   $adminData['page_title']="New Vehicles"; 
		   $adminData['result'] = $this->admin_model->newBike($id);
		   $adminData['brand']=$d;			
		
		//see($adminData);
		    if(!empty($adminData['result']))
			$this->load->view('admin/newVehicleBike',$adminData); 
   }
   
   function deleteBikeModel($id,$d)
  {
		$this->ensureadminuser();   
		$adminData =   array();
		$adminData['page_title']="delete Vehicles"; 
		$adminData['result'] = $this->admin_model->newBike($id);	
		$adminData['brand']=$d;	

		//see($adminData);
		if(!empty($adminData['result']))
		$this->load->view('admin/deleteVehicleBike',$adminData); 
   }	   
   
   	  
	
function addNewCarModelSubmit()
	       {
				 $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->addNewCarModel($data);	
		   }
		   
function addNewCarBrandSubmit()
	       {
				 $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->addNewCarBrand($data);	
		   }
		   
		   
function addNewBikeBrandSubmit()
	       {
				 $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->addNewBikeBrand($data);	
		   }
	  
	  
function addNewBikeModelSubmit()
	     {
				 $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->addNewBikeModel($data);	
		  }  
	  
function editCarModel()
         {
		 
		         $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->editCarModel($data);	
		 
		 }
function editCarMake()
         {
		 
		         $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->editCarMake($data);	
		 
		 }
		 
		 
function editBikeMake()
         {
		 
		         $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->editBikeMake($data);	
		 
		 }		 
		 
		 
function deleteCarMakeSubmit()
         {
		 
		         $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->deleteCarMakeSubmit($data);	
		 
		 }
		  
function deleteBikeMakeSubmit()
         {
		 
		         $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->deleteBikeMakeSubmit($data);	
		 
		 } 	 
		 
function editBikeModel()
         {
		 
		         $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->editBikeModel($data);	
		 
		 }	  	  
function deleteCarModelSubmit()
         {
		         $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->deleteCarModelSubmit($data);	
		 
		 }
		 
		 	
function deleteBikeModelSubmit()
         {
		         $this->ensureadminuser(); 
				 $data=$_POST;
				 if(!empty($data))
				 $this->admin_model->deleteBikeModelSubmit($data);	
		 
		 }	 
		 
function send_mail() 
         {
			 		 		 
		 $config['mailtype'] = 'html';
		 $this->email->initialize($config);		  	 
		 $this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name')); 
		  
         $userid=$_POST['hdd_user'];		 		
		 $datavalue=$this->main_model->getemailbyid($userid);
		 $email=$datavalue[0]['email_id'];
         $this->email->to($email);
  
         $sub = $_POST['Subject'];
		 $msg = $_POST['Message'];
		  
         $this->email->subject($sub);          
		 
		 $data['first_name']=$datavalue[0]['first_name'];
		 $data['last_name']=$datavalue[0]['last_name'];
		 $data['emid']=$datavalue[0]['email_id'];
		 $data['msg']=$msg;   
		 
         //Send mail 
		 $sendmailtemplate=$this->load->view('admin/sendEmail.php',$data,TRUE);
		 $this->email->message($sendmailtemplate);
		 $this->email->send(); 
		 echo "done";
		 die();        
        
      } 
	  	 
	function stickers($status='')
	{
		if($status=='')
			$status=0;
		$this->ensureadminuser();
		$adminData =   array();
		$adminData['page_title']="Stickers"; 
		$adminData['tabon']="waiting";
		if($status==1)
			$adminData['tabon']="shipped";
		$adminData['sticker_orders'] = $this->admin_model->sticker_orders($status);		
		$adminContent['content'] = $this->load->view('admin/sticker/sticker_orders.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent); 		
	}		  		   

	function stickerShippedPop($id)
	{
			$this->ensureadminuser();   
			$adminData =   array();
			$adminData['page_title']="Move to shipped stickers"; 
			$adminData['id']=$id; 
			$this->load->view('admin/sticker/stickerShippedPop',$adminData); 
	}
	
	function stickerShippedPopSubmit($id='')
	{
		if($id!='')
			$adminData['sticker_orders'] = $this->admin_model->stickerShippedPopSubmit($id);		
		header('location:'.site_url().'admin/stickers');
	}
	  
}