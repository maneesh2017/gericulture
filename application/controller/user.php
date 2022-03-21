<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class User extends CI_Controller {


	/**
	 * Index Page for this controller.	 
	 */
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('main_model');
		$this->load->model('User_model');
		$this->load->model('helper_model');
		
    }
	
//////////Login function statrt here//////////////
public function login()	{ 		
		$arData['msg'] =  array();
		$this->load->model('main_model');   
		$arContent['content'] = $this->load->view('pages/index.php',$arData,true);		
		$this->load->view('layouts/default.php',$arContent);
		$data = array();
	    $usrname = strtoupper(trim(str_replace(' ','',$_POST['username'])));		
		$password = $_POST['pwd'];		
		$query = $this->main_model->userlogin($usrname,$password);		
		if($query->num_rows > 0 ) {
				 
			    $UserData = $query->row_array();
				
				$UserDataSession['id']=$UserData['id'];
				$this->session->set_userdata('User',$UserDataSession);	
				
				
				//remember me starts
					if(isset($_POST['remember']))
					{
					$cookieemail=md5($UserData['email_id']);
					$cookieuserid=$UserData['id'];
				
					setcookie("email", $cookieemail,  time()+3600*24*7,"/");
					setcookie("userid", $cookieuserid,  time()+3600*24*7,"/");
					$this->main_model->delete_remember_cookie($cookieuserid);
					$this->main_model->remember_cookie($cookieemail,$cookieuserid);
					}
					//remember me ends
							
				
				/*
				$this->session->set_userdata('uname',$UserData['first_name']);
				$this->session->set_userdata('surname',$UserData['last_name']);
				$this->session->set_userdata('user_id',$UserData['username']);
				$this->session->set_userdata('loginuserid',$UserData['id']);
				$this->session->set_userdata('email',$UserData['email_id']);
				$this->session->set_userdata('User',$UserData);				
				*/
				
				if($UserData['first_login']== 0){
				echo "first_login";
				die;	
				
				 redirect(site_url().'user/basicprofile','refresh');	
				}
				echo "aboutme";     
				die;         
					         
		}else{     
			    echo "Vehicle registration number and Password do not match.";
				die;	
			 } 
	}     

////////////////////////////////////////////////////////////////////////////////////
	function logout(){ 
		
		//////////
		$session=$this->session->userdata("User");
		$user_id=$session['id'];
		//deleting the cookies
		$this->load->model("main_model");
		$this->main_model->delete_remember_cookie($user_id);
		
		setcookie("email", "", time()-3600,"/");
		setcookie("userid", "", time()-3600,"/");
		
				//unset all sessions
				$this->session->sess_destroy();				
				redirect(site_url(),'refresh');	
			}	
/////////////////////////////////////////////////////////////////////////////////
function ensureUser()
 // get admin_id check whether its equal to administrator, if equal stay otherwise logout
     {
				return  ensureUser();
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
    switch ( $info[2] ) 
	{
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
/////////////////////////////////////////////////////////////////////////////////	
	public function signUp()
	{    
	
		if(ensureUser_popup())
	   		redirect(site_url(),'refresh');
	   
	   
	if($_POST){   
	   $this->load->model('main_model'); 
	$this->load->helper('common_helper');
	 $data = $_POST; 
		 $data['fname'] = ucwords($_POST['fname']);
		 $data['sname'] = ucwords($_POST['sname']); 
		 $data['reg']=strtoupper (trim(str_replace(' ','',($data['reg']))));
		 /* to auto fill the state */
		 $vechile_number=substr($data['reg'], 0, 2);
		 $GetStateId=$this->main_model->getStateID($vechile_number);				 
		 $data['state']='';
		 if(!empty($GetStateId))
			 $data['state']=$GetStateId['id'];
		 //$from = 'Geri Culture';
   	    
		 
		
						$checkduplicaterc=$this->main_model->checkduplicaterc($data);
						//$checkduplicateemail=$this->main_model->checkduplicateemail($data);
						$checkduplicateemail='no';
						if($checkduplicaterc=='yes' && $checkduplicateemail=='yes'){
							echo "duplicatercemail";die;
						}elseif($checkduplicaterc=='yes' && $checkduplicateemail=='no')	{
							echo "duplicaterc";die;
						}elseif($checkduplicaterc=='no' && $checkduplicateemail=='yes')	{
							echo "duplicateemail";die;
						}else
						{
							$activation_code=$this->main_model->adduser($data);
							$uid=$this->main_model->selectUserId($data['reg']);
							
							//Email to user
							 
								  // activation link
									  $linkdata = array();
									  $emaildata = array();
									  $emaildata['emaildata'] =$data;
									  $linkdata['email'] = $data['email'];	
									   $linkdata['id'] = $uid;		
									  $linkdata['activation_code'] = $activation_code;
									  $linkdata['date'] = date('Y-m-d H:i:s');
									  $activation_link = $this->config->item('base_url')."user/activate/" . urlencode(base64_encode(json_encode($linkdata)));	
                    
								$this->load->library('email');             
								$config['mailtype'] = 'html';
								$this->email->initialize($config);
								$this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name'));
								$emaildata['reciever']=$data['email'];
								$emaildata['activation_link'] = $activation_link;																
								$confirmemailtemplate=$this->load->view('emails/signup.php',$emaildata,true);
								$this->email->to($data['email']);   
								$this->email->subject('Activate your account');
								$this->email->message($confirmemailtemplate);
								$this->email->send();    
							//Email to user Ends
							
							//Email to Admin
								$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
								$this->email->to($this->config->item('admin_email_address'));
								$this->email->subject('New user registration - Chandigarh Geri');
								$this->email->message('<p>New user registered.</p><p>'.$data['fname'].', '.$data['email'].'</p>');

								$this->email->send();
							//Email to Admin Ends
							
							echo "user_added";
							die();
						}	
	  }
	  $arData =  array(); 
		$arContent['content'] = $this->load->view('users/signUp.php',$arData,true);
		$this->load->view('layouts/default.php',$arContent);
	}
	 
	function activate($encodeeddata=null)
	{
		$data=array();
		$data['page_title']='Account Activation';		
		$decodeddata = '';
		$send_email=FALSE;		
			
		if(!empty($encodeeddata))
			  {
				  $decodeddata = json_decode(base64_decode(urldecode($encodeeddata)));
				 
				  if(is_object($decodeddata))
					  $decodeddata = (array) $decodeddata;
					  //see($decodeddata);
					  
					  if(
				is_array($decodeddata) 	&& !empty($decodeddata['email']) && !empty($decodeddata['activation_code'])&& !empty($decodeddata['date'])
				)
							  {	
							  	$UserDataSession['id']=$decodeddata['id'];
								$this->session->set_userdata('User',$UserDataSession);						
								$this->load->model('main_model');	
								$activateFlag = $this->main_model->activate($decodeddata);
									
								$decodeddata['email']=$decodeddata['email'];
								$decodeddata['activation_code']=$decodeddata['activation_code'];
									
										if($activateFlag=='found')
										{ 
											  $this->session->set_userdata('message','found');
											  $this->session->set_userdata('email',$decodeddata['email']);   
											  $this->session->set_userdata('activation_code',$decodeddata['activation_code']);
											  $send_email=TRUE;
											   redirect(site_url().'user/thankyou','refresh');	
										  }
										  elseif($activateFlag=='active') 
										  {
											   $this->session->set_userdata('message','active');
											   $this->session->set_userdata('email',$decodeddata['email']);   
											   $this->session->set_userdata('activation_code',$decodeddata['activation_code']);
											   redirect(site_url().'user/thankyou','refresh');
										  }	
										  elseif($activateFlag=='expired')
										  {
											   $this->session->set_userdata('message','expired');
											   $this->session->set_userdata('email',$decodeddata['email']);
											   $this->session->set_userdata('activation_code',$decodeddata['activation_code']);
											   redirect(site_url().'user/thankyou','refresh');
										  }
										  elseif($activateFlag=='not found') 
										  {
											   $this->session->set_userdata('message','notfound');
											   $this->session->set_userdata('email',$decodeddata['email']);   
											   $this->session->set_userdata('activation_code',$decodeddata['activation_code']);
											   redirect(site_url().'user/thankyou','refresh');
										  }
							  }
						  else
							  {
								 $decodeddata['message'] = "";	 
								 redirect(site_url().'my-profile','refresh');
								}
				 }
		else
			{
				redirect(site_url());
			}	
		
		if($send_email)
			{
				//Email to user
								$this->load->library('email');
								$config['mailtype'] = 'html';
								$this->email->initialize($config);
								$this->email->from(email_from_address(), email_from_name());
								$this->email->to($decodeddata['email']);
								$this->email->subject('Account activated - Chandigarh Geri');
								$this->email->message('<p>You have successfully activated your account!</p>');

								$this->email->send();
			//Email to user Ends
			}
				
			}
			
//////////////////////////////////////////////////////////////////////////////////////			
	function resentemail(){	
		
									  $newdata = $_POST;
									  $datavalue=$this->main_model->getdetailbyemail($newdata['email']); 
									 
							          $activation_code=$this->main_model->updatebyemail($newdata);				
									  $linkdata = array();
									  $emaildata= array();
									  $emaildata['emaildata']=$datavalue;
									  $linkdata['email'] = $datavalue[0]['email_id'];		
									  $linkdata['activation_code'] = $activation_code;
									  $activation_link = $this->config->item('base_url')."user/activate/" . urlencode(base64_encode(json_encode($linkdata)));	
                    
                  
									
								$this->load->library('email');           
								$config['mailtype'] = 'html';
								$this->email->initialize($config);
								$this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name'));
								$this->email->to($datavalue[0]['email_id']);
								$this->email->subject('Activate your account');
								$emaildata['activation_link'] = $activation_link;									
								$emaildata['datavalue']=$datavalue;
								//see($emaildata);
								$confirmemailtemplate=$this->load->view('users/resent_email.php',$emaildata,true);
								$this->email->message($confirmemailtemplate);

								$this->email->send(); 
							//Email to user Ends
							
							//Email to Admin
								$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
								$this->email->to($this->config->item('admin_email_address'));
								$this->email->subject('New user registration - Chandigarh Geri');
								$this->email->message('<p>New user registered.</p><p>'.$datavalue[0]['first_name'].', '.$datavalue[0]['email_id'].'</p>');

								$this->email->send();
							//Email to Admin Ends
							
							echo "emailsent";
							die();
								
		}
		
//////////////////////////////////////////////////////////////////////////////////////			
	function newresentemail(){	
		
									  $userid = $_POST['uid'];
									  $newdata = userSession();	
									  if (empty($newdata['id']))
									  {
										echo   $newdata['id']=$userid;
									  }
									
				$datavalue=$this->main_model->getemailbyid($newdata['id']);		
									 				 
							          $activation_code=$this->main_model->updatebyemailnew($newdata);				
									  $linkdata = array();
									  $linkdata['email'] = $datavalue[0]['email_id'];		
									  $linkdata['id'] = $userid;
									  $linkdata['activation_code'] = $activation_code;
									  $linkdata['date']=date('Y-m-d H:i:s');
									  $activation_link = $this->config->item('base_url')."user/activate/" . urlencode(base64_encode(json_encode($linkdata)));	
                    
                  
									
								$this->load->library('email');           
								$config['mailtype'] = 'html';
								$this->email->initialize($config);
								$this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name'));
								$this->email->to($datavalue[0]['email_id']);
								$this->email->subject('Activate your account');
								$data['activation_link'] =$emaildata['activation_link'] = $activation_link;				$data['emid']=$newdata['email_id'];					
								$data['emaildata']=$emaildata;
								$data['datavalue']=$datavalue;
								$confirmemailtemplate=$this->load->view('emails/resend_verification_email.php',$data,true);
								$this->email->message($confirmemailtemplate);
								$this->email->send();
							//Email to user Ends
							
							echo "emailsent";
							die();
								
		}		
		
			
////////////////////////////////////////////////////////////////////////////////////
function basicprofile(){
			$this->ensureUser();
			$arData =   array();
			$arData['page_title']="Basic Profile";  
			$Userdetail =userSession();
			$userid = $Userdetail['id'];
			$arData['Userdata'] = fRow($this->main_model->user_detail($userid));
			$getRideInfo=getRideInfo($Userdetail['id']);
			
			if($arData['Userdata']['first_login']==1)
				 redirect(site_url(),'refresh');
			
			if($getRideInfo['make']!='')
				redirect(site_url().'user/personaldetails','refresh');
			
			$arContent['content'] = $this->load->view('users/basicprofile.php',$arData,true);	
			$this->load->view('layouts/defaultbasic.php',$arContent); 
	}				
			
////////////////////////////////////////////////////////////	
public function aboutMe()	{
		redirect(site_url().'my-profile','refresh');	
		$this->ensureUser();
		$arData =   array();
		$LoggedInUser= array();
       $LoggedInUser = userSession();    	    
  	   $arData['LoggedInUser'] = $LoggedInUser;
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];          
		$arData['Userdata'] = $this->main_model->user_detail($user_id);
		$arData['ridetabledata'] = $this->main_model->ride_info($user_id);		
		$arData['RideInfo'] = $this->User_model->ride_info($LoggedInUser['id']);
		$arContent['content'] = $this->load->view('users/aboutMe.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent);    
  }
////////////////////////////////////////////////////////////	
public function aboutMepdetails()	{ 	

	if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{
			  $this->ensureUser();
			  $arData =   array();
			  $arData['Userdetail'] =userSession();
			  $userid = $arData['Userdetail']['username'];
			  $user_id = $arData['Userdetail']['id'];
			  $arData['Userdata'] = $this->main_model->user_detail($user_id);		
			  $arContent['content'] = $this->load->view('users/aboutMepdetails.php',$arData,true);	
			  $this->load->view('layouts/empty.php',$arContent);    
		}
  } 
////////////////////////////////////////////////////////////	
public function aboutMecoverpic($page='profile')	{ 	
		$this->ensureUser();
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['Userdata'] = $this->main_model->user_detail($userid);		
		$arData['page'] = $page;		
		$arContent['content'] = $this->load->view('users/aboutMecoverpic.php',$arData,true);	
		$this->load->view('layouts/empty.php',$arContent);
		
  }
////////////////////////////////////////////////////////////	
public function testfrmae()	{ 	
		$this->ensureUser();
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['Userdata'] = $this->main_model->user_detail($userid);		
		$arContent['content'] = $this->load->view('users/testfrmae.php',$arData,true);	
		$this->load->view('layouts/empty.php',$arContent);
		
  }   
  
 ////////////////////////////////////////////////////////////	
public function test()	{ 	
		$this->ensureUser();
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['Userdata'] = $this->main_model->user_detail($userid);		
		$arContent['content'] = $this->load->view('users/test.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent);
		
  }      
///////////////////////////////////////////////////////////	
public function aboutMeprofilepic($page='profile')	{ 
		$this->ensureUser();		
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['Userdata'] = $this->main_model->user_detail($userid);	
		$arData['page'] = $page;		
		$arContent['content'] = $this->load->view('users/aboutMeprofilepic.php',$arData,true);	
		$this->load->view('layouts/empty.php',$arContent);    
  }  
///////////////////////////////////////////////////////////	
public function addfrdgeri()	{ 	

	if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{
			$arData =   array();
			$arData['Userdetail'] =userSession();
			$userid = $arData['Userdetail']['username'];
			$user_id = $arData['Userdetail']['id'];
			$arData['friendlist'] = $this->main_model->frd_list_to_add($userid);
			$arContent['content'] = $this->load->view('users/addfrdgeri.php',$arData,true);	
			$this->load->view('layouts/empty.php',$arContent);    
		}
  } 
  
  ///////////////////////////////////////////////////////////	
public function afgdata()	{ 	
		
		if(!ensureUser_popup())
			echo "LO";
		else
		{	
				$arData =   array();
				$arData['Userdetail'] =userSession();
				$userid = $arData['Userdetail']['username'];
				$userid = $arData['Userdetail']['id'];
				if(isset($_POST['queryString'])) 
				{			
					$queryString = $_POST['queryString'];				
					$arData['code'] = $code=$_POST['code'];
					
					if(strlen($queryString) >0) 
						$arData['friendlist'] = $this->main_model->frd_list_to_add_new($userid,$queryString,$code);				
					
					$this->load->view('users/afgdata.php',$arData);	
		 		}
		}
	}
  
  ///////////////////////////////////////////////////////////	
public function headersdata()	{ 	
			
		if(!ensureUser_popup())
		echo "LO";
	else
		{	
			$arData =   array();
			$arData['Userdetail'] =userSession();
			$userid = $arData['Userdetail']['username'];
			$arData['queryString']='';
			if(isset($_POST['queryString'])) {			
				$queryString = $_POST['queryString'];	
				$arData['queryString'] =strtoupper (trim(str_replace(' ','',$queryString)));			
				if(strlen($queryString) >0) {
					$arData['friendlist'] = $this->main_model->frd_list_to_header($queryString);				
				 }
			 }
			//$arData['friendlist'] = $this->main_model->frd_list_to_add($userid);
			$arContent['content'] = $this->load->view('users/headersdata.php',$arData,true);
			
			$arContent['content_for'] = 'headersdata';	
			$this->load->view('layouts/empty.php',$arContent);    
		}
  } 
   

    
 ///////////////////////////////////////////////////////////	
public function gerifrd()	{  	

		$this->ensureUser();
		$arData =   array();
		$arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$arData['countgfnd'] = $this->main_model->geri_frd_count_list($userid);
		$arData['gerifriendlist'] = $this->main_model->geri_frd_list($userid);		
		$arContent['content'] = $this->load->view('users/gerifrd.php',$arData,true);	
		$this->load->view('layouts/empty.php',$arContent);    
  }  
  
////////////////////////////////////////////////////////////	
public function aboutMeodetails()	{ 	

		$this->ensureUser();
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['Userdata'] = $this->main_model->user_detail($userid);		
		$arContent['content'] = $this->load->view('users/aboutMeodetails.php',$arData,true);	
		$this->load->view('layouts/empty.php',$arContent);    
  }    
////////////////////////////////////////////////////////////	
public function aboutMestatus()	{ 	

		if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
		else
			{
				$arData =   array();
				$arData['Userdetail'] =userSession();
				$userid = $arData['Userdetail']['username'];
				$user_id = $arData['Userdetail']['id'];
				$arData['Userdata'] = $this->main_model->user_detail($userid);
				$arData['currentstatuspic'] = $this->main_model->statuspic($userid);		
				$arContent['content'] = $this->load->view('users/aboutMestatus.php',$arData,true);	
				//echo "<pre>";print_r($arData['Userdata'][0]['post_status']);die('naiiiii');
				 /* if(!empty($arData['Userdata'][0]['post_status'])){
				redirect('user/aboutMe');
				} */
				 
				$this->load->view('layouts/empty.php',$arContent);    
			}
  }  
///////////////////////////////////////////////////////////
public function aboutOthers()	{
		redirect(site_url().'my-profile','refresh');
		$this->ensureUser();
		$arData =   array();
		$luserdetail =userSession();
		$fid = $luserdetail['id'];
		$fusername = $luserdetail['username'];
		$userid = $this->uri->segment(3);
		$otherusername = $this->main_model->otheruser_detail($userid);
		
		
		if(($otherusername[0]['status']==0 || $otherusername[0]['first_login']==0) && $luserdetail['username']!='admin')
			redirect(site_url(),'refresh');
			
		$username = $otherusername[0]['username'];
		$arData['about_me'] = $luserdetail;		
		$arData['user_id']=$fid;
		
		
		
		$arData['userdata'] = $this->main_model->otheruser_detail($userid);		  
		$arData['rideimage'] = $this->main_model->ride_image_others($userid); 
		
		$arData['ridedata'] = $this->main_model->ride_detail($userid);
		$arData['currentstatuspic'] = latestStatus($userid);
		
		//see($arData['currentstatuspic']);
		$arContent['content'] = $this->load->view('users/aboutOthers.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent);  
  }
///////////////////////////////////////////////////////////
public function complimnt()	{  
		if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{	 
			$arData =   array();
			$userid = $this->uri->segment(3);
			$arData['Userdetail'] =userSession();
			$username = $arData['Userdetail']['username'];
			$arData['picid']=$this->watchfriends_model->photoimagefriendid($userid);	
			$arData['pic_id']=$userid;
			$arData['complements'] = getPicComp($userid);
			//see($arData);
			$arContent['content'] = $this->load->view('users/complimnt.php',$arData,true);
			$this->load->view('layouts/empty.php',$arContent);  
		}
  } 
 
///////////////////////////////////////////////////////////
public function speaker()	{  
		
		$arData =   array();
		$userid = $this->uri->segment(3);
		$arData['Userdetail'] =userSession();
		$loginuserid = $arData['Userdetail']['username'];		
		$arData['blownhorns'] = $this->watchfriends_model->watch_image($loginuserid);	
		$arData['countcompliment'] = $this->watchfriends_model->countcompliment($userid);		
		$arData['blowhorndata'] = $this->watchfriends_model->allblowhorn($userid);
		$arContent['content'] = $this->load->view('users/speaker.php',$arData,true);
		$this->load->view('layouts/empty.php',$arContent);  
  }
  
///////////////////////////////////////////////////////////
public function othergeriFrdCirclePopUp()	{  
		$arData =   array();
		$userid = $this->uri->segment(3);		
		$usersegdetail = $this->main_model->segmentdetail($userid);
		$username=$usersegdetail[0]['username'];
		$arData['countgfnd'] = $this->main_model->geri_frd_count_list($username);
		$arData['gerifriendlist'] = $this->main_model->geri_frd_list($username);		
		$arContent['content'] = $this->load->view('users/othergeriFrdCirclePopUp.php',$arData,true);
		$this->load->view('layouts/empty.php',$arContent);  
  } 
  
///////////////////////////////////////////////////////////
public function otherscomplnt()	{  
		
		if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{	 
			$arData =   array();
			$userid = $this->uri->segment(3);
			$arData['Userdetail'] =userSession();
			$username = $arData['Userdetail']['username'];
			$arData['picid']=$this->watchfriends_model->photoimagefriendid($userid);	
			$arData['pic_id']=$userid;
			$arData['complements'] = getPicComp($userid);
			//see($arData);
			$arContent['content'] = $this->load->view('users/otherscomplnt.php',$arData,true);
			$this->load->view('layouts/empty.php',$arContent);  
		}
  }   
  
  ///////////////////////////////////////////////////////////
public function otherspeakerpopup()	{  

			if(!ensureUser_popup())
					$this->load->view('layouts/if_logged_out.php');
				else
				{
					$arData =   array();
					$userid = $this->uri->segment(3);
					$arData['Userdetail'] =userSession();
					$loginuserid = $arData['Userdetail']['username'];		
					
					$arData['pic_id']=$userid;
					$arData['blowhorndata'] = $this->watchfriends_model->allblowhorn($userid);	
					$arContent['content'] = $this->load->view('users/otherspeakerpopup.php',$arData,true);
					$this->load->view('layouts/empty.php',$arContent);  
				}
}    
   
///////////////////////////////////////////////////////////////////////////////
public function aboutRidesother()	{
 
		$this->ensureUser();  
		$arData =   array();
		$luserdetail =userSession();
		$fid = $luserdetail['id'];
		$fusername = $luserdetail['username'];				
		$userid = $this->uri->segment(3);
		$loginuid = $luserdetail['username'];
		$otherusername = $this->main_model->otheruser_detail($userid);
		
		if($otherusername[0]['status']==0 || $otherusername[0]['first_login']==0)
			redirect(site_url(),'refresh');
			
		$username = $otherusername[0]['username'];
		
		$arData['about_me'] =$luserdetail;
		//$arData['countfriends'] = count(friendList($userid));
		$arData['userdata'] = $this->main_model->otheruser_detail($userid);
		$arData['RideInfo'] = $this->User_model->ride_info($userid);
		//$arData['frdststatus'] = $this->main_model->friendrequeststatus($userid,$loginuid);		
		$arData['fleshdetail'] = $this->main_model->fleshcheck($fid,$userid);
		//$arData['frndcheck'] = $this->main_model->frndcheck($fusername,$userid,$username,$fid);		
		//$arData['Ride_Info'] = $this->main_model->ride_info_feature_others($username);			
		//$arData['caccessories'] = $this->main_model->customaccessothers($username);
		$arData['rideimage'] = $this->main_model->ride_image_others($userid);
		$arData['ridedata'] = $this->main_model->ride_detail($userid);		
		$arContent['content'] = $this->load->view('users/aboutRidesother.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent);  
  }
  

//////////////////////////////////////////////////////////
public function browserides(){
		$this->ensureUser();
		
		$arData =   array();
		$arData['page_title']="Browse rides and people";  
		$arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];		
		$arData['Userdata'] = $this->main_model->user_detail($user_id);
		//see($arData['Userdata']);
		if($arData['Userdata'][0]['city']!='')
		{
				  if($_GET)
				  {
					   $data=$_GET;
					   if($data['locationSearch']==0)
					   {
						  $data['km']=30;
						  $data['state']=$arData['Userdata'][0]['state'];
						  $data['city']=$arData['Userdata'][0]['city'];
					   }
				  }
				  else
				  {
					  $data['type']=$data['age_range']=$data['brand']=$data['model']=$data['gender']='0';
					  $data['year_model']=$data['first_name']=$data['sur_name']=$data['vehicle_number']='';
					  $data['vehiclenumber']='0';
					  
					  $data['locationSearch']=1;
					  $data['km']=30;
					  $data['state']=$arData['Userdata'][0]['state'];
					  $data['city']=$arData['Userdata'][0]['city'];
				  } 
				  
				  $data['vehicle_number']=strtoupper (trim(str_replace(' ','',$data['vehicle_number'])));
				  $arData['search_query']=$data;
				  
				  $arData['browse_ride_radius']=$arData['browse_ride_radius'] = $this->main_model->browse_ride_radius($data);
				  $browse_ride_radius=array();
				  if(!empty($arData['browse_ride_radius']))
				  {
					  foreach($arData['browse_ride_radius'] as $usersIn)
						  $browse_ride_radius[]=$usersIn['id'];
				  }
				  $data['browse_ride_radius']=$browse_ride_radius;
				  //see($data['browse_ride_radius']);
				  $arData['bridecount'] = $this->main_model->browse_ride_count($data);
				  
				  $queryInput['limit']=20;
				  $queryInput['page']=0;
				  $arData['bride'] = $this->main_model->browse_ride($data,$queryInput);
				 // see($arData['bride']);
		}
		else
		{
					  $data['type']=$data['age_range']=$data['brand']=$data['model']=$data['gender']='0';
					  $data['year_model']=$data['first_name']=$data['sur_name']=$data['vehicle_number']='';
					  $data['vehiclenumber']='0';
					  
					  $data['locationSearch']=1;
					  $data['km']=30;
					  $data['state']=$arData['Userdata'][0]['state'];
					  $data['city']=$arData['Userdata'][0]['city'];
					  $arData['search_query']=$data;
					  
		}
	    $arContent['content'] = $this->load->view('users/browserides.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent);  
  }
  
  
  function loadMorerides($page)
  {
	  $this->ensureUser();
	  $arData =   array();
	  $arData['Userdetail'] =userSession();
	  $userid = $arData['Userdetail']['username'];
	  $user_id = $arData['Userdetail']['id'];		
	  $arData['user_id']=$arData['Userdetail']['id'];
	  
	  $data=$_POST; 
	  
		$arData['browse_ride_radius'] = $this->main_model->browse_ride_radius($data);
		$browse_ride_radius=array();
		if(!empty($arData['browse_ride_radius']))
		{
			foreach($arData['browse_ride_radius'] as $usersIn)
				$browse_ride_radius[]=$usersIn['id'];
		}
		$data['browse_ride_radius']=$browse_ride_radius;
		
	$queryInput['limit']=20;
	$queryInput['page']=($page-1)*$queryInput['limit'];
	$arData['bride'] = $this->main_model->browse_ride($data,$queryInput);
	$this->load->view('users/browserides_results.php',$arData);
  }
  
  
  
  public function flashes(){
		
		
		$this->ensureUser();
		$arData =   array();
		$arData['page_title']="Flashes";  
		$arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];		
		$arData['Userdata'] = $this->main_model->user_detail($userid);
		$this->main_model->makeSeen($user_id);
		
		$arData['user_id']=$arData['Userdetail']['id'];
		
		$arData['bridecount'] = $this->helper_model->flashesSeenUnseenCount($user_id);
		
		$queryInput['limit']=10;
		$queryInput['page']=0;
		$arData['bride'] = $this->helper_model->flashesSeenUnseenTop($user_id,$queryInput);
		
		$flashes=getFlashes($arData['Userdetail']['id']);
		$arData['flashes']=$flashes;
		
		//see($arData['bride']);
	    $arContent['content'] = $this->load->view('flash/flash.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent);  
  }
  
  
  public function flashesByMe()
  {
  $this->ensureUser();
		$arData =   array();
		$arData['page_title']="Flashes"; 
		$arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];		
		$arData['Userdata'] = $this->main_model->user_detail($userid);
		$this->main_model->makeSeen($user_id);
		
		$arData['user_id']=$arData['Userdetail']['id'];
		
		$arData['bridecount'] = $this->helper_model->flashesSeenUnseenCountByMe($user_id);
		
		$queryInput['limit']=10;
		$queryInput['page']=0;
		$arData['bride'] = $this->helper_model->flashesSeenUnseenTopByMe($user_id,$queryInput);
		
		$flashes=getFlashesByMe($arData['Userdetail']['id']);
		$arData['flashes']=$flashes;
		
		//see($arData['bride']);
	    $arContent['content'] = $this->load->view('flash/flashByMe.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent);
  
  }
 
  function loadMoreFlashes($page)
  {
	  $this->ensureUser();
	  $arData =   array();
	  $arData['Userdetail'] =userSession();
	  $userid = $arData['Userdetail']['username'];
	  $user_id = $arData['Userdetail']['id'];		
	  $arData['user_id']=$arData['Userdetail']['id'];
		 //$arData['bridecount'] = $this->helper_model->flashesSeenUnseenCount($user_id);
		//see($arData['bridecount']);
		
	$queryInput['limit']=10;
	$queryInput['page']=($page-1)*$queryInput['limit'];
	$arData['bride'] = $this->helper_model->flashesSeenUnseenTop($user_id,$queryInput);
	$this->load->view('flash/flashes.php',$arData);
  }
  
  function loadMoreFlashesByMe($page)
  {
	  $this->ensureUser();
	  $arData =   array();
	  $arData['Userdetail'] =userSession();
	  $userid = $arData['Userdetail']['username'];
	  $user_id = $arData['Userdetail']['id'];		
	  $arData['user_id']=$arData['Userdetail']['id'];
		
	$queryInput['limit']=10;
	$queryInput['page']=($page-1)*$queryInput['limit'];
	$arData['bride'] = $this->helper_model->flashesSeenUnseenTopByMe($user_id,$queryInput);
	$this->load->view('flash/flashesByMe.php',$arData);
  }
  
  
  
  
  
//////////////////////////////////////////////////////////
public function browsepeople($offset=0){
		if(!empty($_REQUEST['per_page'])){$offset=$_REQUEST['per_page'];}
		
		$this->ensureUser();
		$arData =   array();
		$arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];		
		$arData['Userdata'] = $this->main_model->user_detail($userid);
		
		if($_GET)
			 $data=$_GET;
		else
		{
			$data['gender']=$data['occupation']=$data['state']='0';
			$data['fname']=$data['surname']=$data['city']='';
		} 
		
		$arData['search_query']=$data;
		$arData['bridecount'] = $this->main_model->browse_people_count($data);
		
		$this->load->library('pagination');
		$result_per_page =25;
		
		$baseurl = site_url() . '/';
		$config['base_url'] = $baseurl.'user/browsepeople?fname='.$data['fname'].'&surname='.$data['surname'].'&gender='.$data['gender'].'&occupation='.$data['occupation'].'&state='.$data['state'].'&city='.$data['city'];
		$config['per_page'] = $result_per_page;
		$config['total_rows']=$arData['bridecount'];
				
		$this->pagination->initialize($config);
		
		
		$arData['bridepeople'] = $this->main_model->browse_people($data,$offset,$result_per_page);
		//see($arData['bridepeople']);
	    $arContent['content'] = $this->load->view('users/browsepeople.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent);  
	}  
	
	
	
	 
 
////////////////////////////////////////////////////////////	
public function friendsoffriends()	{		
		$this->ensureUser();
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		//$arData['foflist'] = $this->main_model->frd_of_frd_list($userid);
		//$arData['friendlist'] = $this->main_model->all_frd_list($userid);
		$arData['countfriends'] = count(friendList($user_id));
		$arData['countgfriends'] = $this->main_model->count_show_geri_frd_list($userid);
		$arData['friendsoffriends'] = $this->main_model->friendsoffriends($user_id);
		
		
		$arData['Userdata'] = $this->main_model->user_detail($userid);		
		$arContent['content'] = $this->load->view('users/friendsoffriends.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent);    
  }
////////////////////////////////////////////////////////////
public function gerifriends()	{	
	
		$this->ensureUser();
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['Userdata'] = $this->main_model->user_detail($userid);
		$arData['gerifriendlist'] = $this->main_model->show_geri_frd_list($userid);		
		$arData['countgfriends'] = $this->main_model->count_show_geri_frd_list($userid);
		$arData['countfriends'] = $this->main_model->count_friends($userid);
		$arContent['content'] = $this->load->view('users/gerifriends.php',$arData,true);	 
		$this->load->view('layouts/default-user.php',$arContent);    
  }
////////////////////////////////////////////////////////////
public function addfrdtcbox()	{	
	
		$this->ensureUser(); 
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['gerifriendlist'] = $this->main_model->frd_list_to_add($userid);
		$arData['Userdata'] = $this->main_model->user_detail($userid);		
		$arContent['content'] = $this->load->view('users/addfrdtcbox.php',$arData,true);	 
		$this->load->view('layouts/empty.php',$arContent);    
  }
  
////////////////////////////////////////////////////////////
public function searchdata()	{	
	
		$this->ensureUser(); 
		$arData =   array();
	    $arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];
		$user_id = $arData['Userdetail']['id'];
		$arData['gerifriendlist'] = $this->main_model->frd_list_to_add($userid);
		$arData['Userdata'] = $this->main_model->user_detail($userid);		
		$arContent['content'] = $this->load->view('users/searchdata.php',$arData,true);	 
		$this->load->view('layouts/empty.php',$arContent);    
  }  
///////////////////////////////////////////////////////////
public function sentmsgform()	{
	   if(!ensureUser_popup())
		echo "LO";
	else
		{	
	 		
		$arData =  array();
		$user=userSession();
		$sender_id = $user['id'];
		$userid = $msg = $this->input->post('uid');
		$msg = $this->input->post('msg');
		$data = array('message' =>$msg,'user_id'=>$sender_id,'friend_id'=>$userid,'created'=>date('Y-m-d H:i:s'));								
		$this->main_model->insert($data);
		$this->db->trans_complete();
		
		
		$dataEmailSetting=$this->main_model->getemailbyid($userid); 		 
		$msg=$dataEmailSetting[0]['email_on_message'];
		
		if($msg=='1')
		{
		/*email send*/
		 $this->load->library('email');		 
		 $config['mailtype'] = 'html';
		 $this->email->initialize($config);		  	 
		 $this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name'));
		 $friend_id = $this->input->post('uid');		 		
		 $datavalue=$this->main_model->getemailbyid($friend_id); 
		 $email=$datavalue[0]['email_id'];		 
		 $this->email->to($email);        
		 $this->email->subject('You have a new message.');
         $data['receiver']=$email; 
		 $data['first_name']=$datavalue[0]['first_name'];
		 $data['last_name']=$datavalue[0]['last_name'];
		 $data['emid']=$datavalue[0]['email_id'];
		 		 
		 $data['flasher_first_name']=$user['first_name'];
		 $data['flasher_last_name']=$user['last_name'];
		 /* get model name*/
		 $getRideInfo=getRideInfo($user['id']);		 
		 
		 $getListVehicleBrandRideInfo=getListVehicleBrand($getRideInfo['type'],1);
		 $brandRideInfo=$getListVehicleBrandRideInfo[$getRideInfo['make']];
		 
		 $data['make']=ucfirst($brandRideInfo);
		 $modelRideInfo=getModelText($getRideInfo['model'], $getRideInfo['type']);
		 $data['model']=ucfirst($modelRideInfo);
		   		       
		 $sendmailtemplate=$this->load->view('emails/sendEmailMsg.php',$data,TRUE);
		 $this->email->message($sendmailtemplate);
		 $this->email->send();
		 /*email send*/	
		}
		die();	
		}
  }  
///////////////////////////////////////////////////////////
public function blockprofileform()	{	
		if(ensureUser_popup())
			{
				$user=userSession();	
				$sender_id = $user['id'];
				$userid = $this->input->post('usrid');
				$abuse = $this->input->post('abuse');
				
				if(isset($_POST['block']) || isset($_POST['unblock']))
				$this->main_model->blockProfile($userid,$sender_id);
				
				if(isset($_POST['report']))
				$this->main_model->reportAbuse($userid,$sender_id,$abuse);
				
				$this->db->trans_complete();
				die();	  
			}
		else
				echo 'LO';
	}  
  
////////////////////////////////////////////////////////////////////
public function editpersonalform() {    		
	if(!ensureUser_popup())
		echo "LO";
	else
		{	
		$userdata = userSession();	
	    $userid =$userdata['username'];		 
	    $firstname = $this->input->post('firstname');
		$surname = $this->input->post('surname');
		$bio = $this->input->post('bio');
		$state = $this->input->post('state'); 
		$city = $this->input->post('city');
		$day = $this->input->post('day');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$dob = $year.'-'.$month.'-'.$day;  
		$gender = $this->input->post('gender');
		$ocp = $this->input->post('ocp');
		$course = $this->input->post('course');
		$college = $this->input->post('college');
		$data = array('first_name ' => $firstname,'last_name' => $surname,'bio' =>$bio,'state' => $state,'city' => $city,'gendor' => $gender,'DOB'=>$dob,'college'=>$college,'occupation'=>$ocp,'course'=>$course);
	    $this->main_model->update($userid,$data);
		$this->db->trans_complete();		
	    print_r($_POST); die;
		}
			
  }
///////////////////////////////////////////////////////
public function editstatusform() {	
		if(!ensureUser_popup())
			echo "LO";
		else
		{	 
				  $userdata = userSession();	
				  $userid =$userdata['id'];		 
				  $status = $this->input->post('status');
				  $status_type = $this->input->post('status_type');
				  //$picture = $this->input->post('picture');
				  if(isset($_FILES['picture']) && $_FILES['picture']['name'] != ""){
				  $path="./uploads/gallery"; 
				  $t1=time();
				  $imagename=$t1.$_FILES['picture']['name'];		
				  $tmpname = $_FILES['picture']['tmp_name'];
				  @move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
				  $this->smart_resize_image($path.'/temp/'.$imagename,500,'400',true,$path.'/large/'.$imagename,false,false ); 
				  $this->smart_resize_image($path.'/temp/'.$imagename,307,'',true,$path.'/thumb/'.$imagename,true,false );
				  /*$this->smart_resize_image($path.'/temp/'.$imagename,206,'93',true,$path.'/small/'.$imagename,true,false );
				  $this->smart_resize_image($path.'/temp/'.$imagename,86,'38',true,$path.'/verysmall/'.$imagename,true,true ); */
								  
										  if(is_readable($path."/thumb/".$imagename)) {
										  @chmod($path."/thumb/".$imagename,0777);
									  }
										  if(is_readable($path."/large/".$imagename)) {
										  @chmod($path."/large/".$imagename,0777);
									  }	
									  
										 /* if(is_readable($path."/verysmall/".$imagename)) {
										  @chmod($path."/verysmall/".$imagename,0777);
									  }
										  if(is_readable($path."/small/".$imagename)) {
										  @chmod($path."/small/".$imagename,0777);
									  }	*/
				  
				  }else{
				  $imagename='';		
				  }  
										  
				  $data=array('pic_name'=>$imagename,'pic_type'=>'3','status'=>'1','user_id'=>$userid,'pic_desc'=>$status, 'created'=>date('Y-m-d H:i:s'),'status_type'=>$status_type);
				  //echo "<pre>";print_r($data);die('status');
				  $status_id=$this->main_model->insertuserstatus($userid,$data);
				  $this->db->trans_complete();
				  if($imagename){
				  echo base_url()."uploads/gallery/large/".$imagename;
				  }else{ 
						  echo "onlydesc";
					   } 		 
				
				  $this->load->helper('notification');
				  addNotificationStatusUpdate($status_id);
				  die;	 
		}
  }
  
///////////////////////////////////////////////////////
public function addbasicprofile() {	 
		
	   $arData['page_title']="Basic Profile";  
		$userdata =userSession();	
	    $userid =$userdata['username'];
		$id =$userdata['id'];	
	    $type = $this->input->post('type');		
		$brand = $this->input->post('brand');
		$model = $this->input->post('model');		
		$data = array('model' => $model,'type' => $type,'make' => $brand);
		$this->main_model->updateride_std($id,$data);
		$this->db->trans_complete();
	    redirect(site_url().'user/personaldetails','refresh');
		die;	  
  }
  
 ///////////////////////////////////////////////////////
public function addcoverpicbasic() {	 
			   //see($_POST);
			  $userdata = userSession();	
			  $userid =$userdata['username'];		
			  $user_id =$userdata['id'];	
		  	
			  $type = $this->input->post('type');		
			  $brand = $this->input->post('brand');
			  $model = $this->input->post('model');
			 
			  $data = array('model' => $model,'type' => $type,'make' => $brand, 'modified'=>date('Y-m-d H:i:s'));
			  
			  //////add new vehicle
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
			  /////
			   
			  $this->main_model->updateride_std($user_id,$data);
		
				  if(isset($_FILES['picture']['name']) && $_FILES['picture']['name'] != "")
			  {
					$path="./uploads/gallery"; 
					$t1=time();
					$imagename=cleanString($t1.$_FILES['picture']['name']);		
					$tmpname = $_FILES['picture']['tmp_name'];
						
					//$thumb_image_location=$path.'/large/'.$imagename;
					$large_image_location=$path.'/temp/'.$imagename;
					
					$filename = $_FILES['picture']['tmp_name'];
					list($width, $height) = getimagesize($filename);
					 
					@move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
					
					
					//Get the new coordinates to crop the image.
					$x1 = $_POST["x1"];
					$y1 = $_POST["y1"];
					$x2 = $_POST["x2"];
					$y2 = $_POST["y2"];
					$w = $_POST["w"];
					$h = $_POST["h"];
					
					//new values according to the dimensions of the original image
					$x1=$x1*$width/$_POST['w_ori'];
					$w=$w*$width/$_POST['w_ori'];
					$h=$h*$height/$_POST['h_ori'];
					$y1=$y1*$height/$_POST['h_ori'];
					
					$thumbSizes=thumbSizes('ride');
					
					foreach($thumbSizes as $sizeK=>$sizeV)
					{
						  resizeThumbnailImage($path.'/'.$sizeK.'/'.$imagename, $large_image_location,$w,$h,$x1,$y1,array('width'=>$sizeV['width'],'height'=>$sizeV['height']));	  
					}
					
					//Reload the page again to view the thumbnail
					
					$datapic=array('pic_name'=>$imagename,'pic_type'=>'2','status'=>'1','user_id'=>$user_id,'created'=>date('Y-m-d H:i:s'),'default'=>'1');
					$this->load->model('photo_model');
					$this->photo_model->insertdata($datapic);
					
					echo base_url()."uploads/gallery/large/".$imagename;	
			  }
	  
	}
   
  
///////////////////////////////////////////////////////
public function addprofilepic() {	 
		
	   
		$userdata = userSession();	
	    $userid =$userdata['username'];
		$id =$userdata['id'];	
	    $userid =$userdata['username'];				
		if($_FILES['picture']['name'] != ""){
		$path="./uploads/gallery"; 
		$t1=time();
		$imagename=$t1.$_FILES['picture']['name'];		
		$tmpname = $_FILES['picture']['tmp_name'];		
		@move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
		$this->smart_resize_image($path.'/temp/'.$imagename,978,'435',true,$path.'/large/'.$imagename,false,false );		
		$this->smart_resize_image($path.'/temp/'.$imagename,357,'136',true,$path.'/thumb/'.$imagename,true,false );
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
		$data=array('image'=>$imagename);
		$this->main_model->updateride($userid,$data);
			
		$this->db->trans_complete();	
		
		addNotificationProfilePicUpdate();
		echo base_url()."uploads/gallery/thumb/".$imagename;	
		die;  	  
  }  

   
///////////////////////////////////////////////////////
public function editprofilepic() {	 
		
		
		if($_FILES['picture']['name'] != "")
	{
		  $userdata = userSession();	
		  $userid =$userdata['username'];		
		  $user_id =$userdata['id'];	
		  
		  $path="./uploads/gallery"; 
		  $t1=time();
		  $imagename=cleanString($t1.$_FILES['picture']['name']);		
		  $tmpname = $_FILES['picture']['tmp_name'];
			  
		  //$thumb_image_location=$path.'/large/'.$imagename;
		  $large_image_location=$path.'/temp/'.$imagename;
		  
		  $filename = $_FILES['picture']['tmp_name'];
		  list($width, $height) = getimagesize($filename);
		   
		  @move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
		  
		  
		  //Get the new coordinates to crop the image.
		  $x1 = $_POST["x1"];
		  $y1 = $_POST["y1"];
		  $x2 = $_POST["x2"];
		  $y2 = $_POST["y2"];
		  $w = $_POST["w"];
		  $h = $_POST["h"];
		  
		  //new values according to the dimensions of the original image
		  $x1=$x1*$width/$_POST['w_ori'];
		  $w=$w*$width/$_POST['w_ori'];
		  $h=$h*$height/$_POST['h_ori'];
		  $y1=$y1*$height/$_POST['h_ori'];
		  
		  $thumbSizes=thumbSizes('user');
		  
		  foreach($thumbSizes as $sizeK=>$sizeV)
		  {
				resizeThumbnailImage($path.'/'.$sizeK.'/'.$imagename, $large_image_location,$w,$h,$x1,$y1,array('width'=>$sizeV['width'],'height'=>$sizeV['height']));	  
		  }
		  
		  //Reload the page again to view the thumbnail
		  
		  $datapic=array('pic_name'=>$imagename,'pic_type'=>'1','status'=>'1','user_id'=>$user_id,'created'=>date('Y-m-d H:i:s'),'default'=>'1');
		  $this->load->model('photo_model');
		  $picId=$this->photo_model->insertdata_update($datapic);
		  //echo base_url()."uploads/gallery/large/".$imagename;
		  
		   $html='';
		  if($_POST['page']=='profile')
		  {
		  		$html .=site_url()."uploads/gallery/large/".$imagename;
		  }
		else if($_POST['page']=='photo')
		 {
			 $html .=' <li  id="userImage-'.$picId.'" class="hoverImgEffect" style="position:relative;">';
                   $html .='<a href="'.site_url().'uploads/gallery/large/'.$imagename.'" class="fancybox" >';
				   $html .='<img src="'.site_url().'uploads/gallery/thumb/'.$imagename.'" alt="photo" width="195" height="195" /></a>';
                   $html .='<div id="detailRiderInvisible4" class="detailRiderInvisible4"  style="display: none;">';
                  $html .='</div>';
                    $html .='<span class="photo-delete-icon"  style=""><img src="'.system_path().'img/photo-delete-icon.png" /></span>';
                 $html .='</li>';
		 }
		 echo $html;	
	}
}  
///////////////////////////////////////////////////////
public function addprofiledetails() {	 
		
		  $userdata = userSession();	
		  $userid =$userdata['username'];		
		  $user_id =$userdata['id'];	
		  	
		  $gender = $this->input->post('gender');		
		  $telphone = $this->input->post('telphone');
		  $day = $this->input->post('day');
		  $month = $this->input->post('month');
		  $year = $this->input->post('year');
		  $dob =$year.'-'.$month.'-'.$day;
		  $data = array('DOB' => $dob,'phone_number' => $telphone,'gendor' => $gender);
		  $this->main_model->update($userid,$data);
		
		  if(isset($_FILES['photo']['name']) && $_FILES['photo']['name'] != "")
		  {
			$path="./uploads/gallery"; 
			$t1=time();
			$imagename=cleanString($t1.$_FILES['photo']['name']);		
			$tmpname = $_FILES['photo']['tmp_name'];
				
			//$thumb_image_location=$path.'/large/'.$imagename;
			$large_image_location=$path.'/temp/'.$imagename;
			
			$filename = $_FILES['photo']['tmp_name'];
			list($width, $height) = getimagesize($filename);
			 
			@move_uploaded_file($_FILES['photo']['tmp_name'],$path.'/temp/'.$imagename);
			
			
			//Get the new coordinates to crop the image.
			$x1 = $_POST["x1"];
			$y1 = $_POST["y1"];
			$x2 = $_POST["x2"];
			$y2 = $_POST["y2"];
			$w = $_POST["w"];
			$h = $_POST["h"];
			
			//new values according to the dimensions of the original image
			$x1=$x1*$width/$_POST['w_ori'];
			$w=$w*$width/$_POST['w_ori'];
			$h=$h*$height/$_POST['h_ori'];
			$y1=$y1*$height/$_POST['h_ori'];
			
			$thumbSizes=thumbSizes('user');
			
			foreach($thumbSizes as $sizeK=>$sizeV)
			{
				  resizeThumbnailImage($path.'/'.$sizeK.'/'.$imagename, $large_image_location,$w,$h,$x1,$y1,array('width'=>$sizeV['width'],'height'=>$sizeV['height']));	  
			}
			
			//Reload the page again to view the thumbnail
			
			$datapic=array('pic_name'=>$imagename,'pic_type'=>'1','status'=>'1','user_id'=>$user_id,'created'=>date('Y-m-d H:i:s'),'default'=>'1');
			$this->load->model('photo_model');
			$this->photo_model->insertdata($datapic);
	  }
		
	} 
  
/////////////////////////////////////////////////////////
public function personaldetails() {	       
        
		$arData =array();
		$arData['page_title']="Personal Details";  
		$userdata = userSession();	
	    $userid =$userdata['id'];
		$arData['Userdata'] = fRow($this->main_model->user_detail($userid));
		$getRideInfo=getRideInfo($userid);
		
		if($arData['Userdata']['first_login']==1)
				 redirect(site_url(),'refresh');
				 
		if($getRideInfo['make']=='')
				redirect(site_url().'user/basicprofile','refresh');
		
		if($arData['Userdata']['DOB']!='0000-00-00')
				redirect(site_url().'user/enjoygeri','refresh');
		  
		$arContent['content'] = $this->load->view('users/personaldetails.php',$arData,true);	
		$this->load->view('layouts/defaultbasic.php',$arContent);
				
  }
  
/////////////////////////////////////////////////////////
public function enjoygeri() {	       
        $arData =array();
		$userdata = userSession();	
		$userid =$userdata['id'];
		$arData['Userdata'] = fRow($this->main_model->user_detail($userid));
		$getRideInfo=getRideInfo($userid);
		
		if($arData['Userdata']['first_login']==1)
				 redirect(site_url(),'refresh');
		
		if($getRideInfo['make']=='')
				redirect(site_url().'user/basicprofile','refresh');
		
		if($arData['Userdata']['DOB']=='0000-00-00')
				redirect(site_url().'user/personaldetails','refresh');
		  
	    $userid =$userdata['username'];
		$data=array('first_login'=>1);
		$query = $this->main_model->update($userdata['username'],$data);
		$arData['Userdata'] = $userdata;		
		$arContent['content'] = $this->load->view('users/enjoygeri.php',$arData,true);	
		$this->load->view('layouts/defaultenjoygeri.php',$arContent);		
  }
    
  
/////////////////////////////////////////////////////////
public function editotherDetails() {	       
        $userdata =userSession();	
	    $userid =$userdata['username'];		 
	    $course = $this->input->post('course');
		$college = $this->input->post('college');
		$ocp = $this->input->post('ocp');
		$data = array('course' => $course,'college' => $college,'occupation' => $ocp);
		$this->main_model->update($userid,$data);		
		$this->db->trans_complete();		
		die;		
  } 
/////////////////////////////////////////////////////////
public function editrideform() {    

	if($_FILES['picture']['name'] != "")
	{
		  $userdata = userSession();	
		  $userid =$userdata['username'];		
		  $user_id =$userdata['id'];	
		  
		  $path="./uploads/gallery"; 
		  $t1=time();
		  $imagename=cleanString($t1.$_FILES['picture']['name']);		
		  $tmpname = $_FILES['picture']['tmp_name'];
			  
		  //$thumb_image_location=$path.'/large/'.$imagename;
		  $large_image_location=$path.'/temp/'.$imagename;
		  
		  $filename = $_FILES['picture']['tmp_name'];
		  list($width, $height) = getimagesize($filename);
		   
		  @move_uploaded_file($_FILES['picture']['tmp_name'],$path.'/temp/'.$imagename);
		  
		  
		  //Get the new coordinates to crop the image.
		  $x1 = $_POST["x1"];
		  $y1 = $_POST["y1"];
		  $x2 = $_POST["x2"];
		  $y2 = $_POST["y2"];
		  $w = $_POST["w"];
		  $h = $_POST["h"];
		  
		  //new values according to the dimensions of the original image
		  $x1=$x1*$width/$_POST['w_ori'];
		  $w=$w*$width/$_POST['w_ori'];
		  $h=$h*$height/$_POST['h_ori'];
		  $y1=$y1*$height/$_POST['h_ori'];
		  
		  $thumbSizes=thumbSizes('ride');
		  
		  foreach($thumbSizes as $sizeK=>$sizeV)
		  {
				resizeThumbnailImage($path.'/'.$sizeK.'/'.$imagename, $large_image_location,$w,$h,$x1,$y1,array('width'=>$sizeV['width'],'height'=>$sizeV['height']));	  
		  }
		  
		  //Reload the page again to view the thumbnail
		  
		  $datapic=array('pic_name'=>$imagename,'pic_type'=>'2','status'=>'1','user_id'=>$user_id,'created'=>date('Y-m-d H:i:s'),'default'=>'1');
		  $this->load->model('photo_model');
		  $picId=$this->photo_model->insertdata_update($datapic);
		  //echo base_url()."uploads/gallery/large/".$imagename;
		  
		  $html='';
		  if($_POST['page']=='profile')
		  {
		  		$html .='<figure>';
                $html .='<img src="'.site_url().'uploads/gallery/large/'.$imagename.'" id="coverPicHoverEffect" alt="cover pic" height="435" width="978" />'; 
                $html .='</figure>';
                $html .='<span id="cpiframe" class="positionAbs changeBtnPattern changeCoverImg button small" style="display:none;" data-bpopup=\'{"content":"iframe","contentContainer":".content","loadUrl":"'.base_url().'user/aboutMecoverpic"}\' data-bpopupNew="'.base_url().'user/aboutMecoverpic">Change banner</span>';
		  }
		else if($_POST['page']=='photo')
		 {
			 $html .='<li style="position:relative;" class="hoverImgEffect" id="userImage-'.$picId.'">';
			 $html .='<a href="'.site_url().'uploads/gallery/large/'.$imagename.'">';
			 $html .='<img width="355" height="144" alt="photo" src="'.site_url().'uploads/gallery/thumb/'.$imagename.'"></a>';
			 $html .='<div class="detailRiderInvisible5" id="detailRiderInvisible5" style="display: none;">';
			 $html .='</div>';
			 $html .='<span class="photo-delete-icon"><img src="'.site_url().'system/img/photo-delete-icon.png"></span>';
			 $html .='</li>';
		 }
		 echo $html;
		  	
	}

} 

//////////////////////////////////////////////////////////////////////////////////////////
public function addorder()	{ 		
		$res['status']='error';
		  
		$userdata = userSession();	
	    $userid =$userdata['id'];	
		
		$adminData =   array();
		$adminData['page_title']="Add Order"; 
		if($_POST){
						$data = $_POST;
						$data['fname'] = ucwords($_POST['fname']);
						$data['sname'] = ucwords($_POST['sname']);					
						$data['street'] = ucwords($_POST['street']);  	  	
						$data['city'] = ucwords($_POST['city']);
						$data['landmark'] = ucwords($_POST['landmark']);
						$newodata=array('fname'=>$data['fname'],'lname'=>$data['sname'],'street'=>$_POST['street'],'phoneno'=>$_POST['phone'],'city'=>$data['city'],'state'=>$data['state'],'landmark'=>$data['landmark'],'user_id'=>$userid);
						$id=$this->main_model->insertorder($newodata);
						$res['status']='user_added';
						$res['html']='<div><p>Order submitted successfully</p>Instructions<br>Order Id:'.$id.'</div>';
						echo json_encode($res);
						die;
		}					
		$adminContent['content'] = $this->load->view('admin/addorder.php',$adminData,true);	
		$this->load->view('layouts/admindefault.php',$adminContent);     
	}	
////////////////////////////////////////////////////////////////////////////////////////////	    
public function addrideform() {       
        $userdata = userSession();	
	    $userid =$userdata['username'];				
		if($_FILES['picture']['name'] != ""){
		
		$path="./uploads/gallery"; 
		$t1=time();
		$imagename=cleanString($t1.$_FILES['image']['name']);		
		$tmpname = $_FILES['image']['tmp_name'];
		@move_uploaded_file($_FILES['image']['tmp_name'],$path.'/temp/'.$imagename);
		
		}else{
		$imagename='';		
		}  
		$data=array('picture'=>$imagename);
		$this->main_model->updateride($userid,$data);
			
		$this->db->trans_complete();	
		
		echo base_url()."system/uploads/".$imagename;	
		die;  
  } 
    	
	
///////////////////////////////////////////////////////
public function editstandardspcform() {   
 	 if(!ensureUser_popup())
				echo "LO";
	else
		{	  
				$userdata = userSession();	
				$userid =$userdata['id'];	
				$engine = $this->input->post('engine');
				$Bhp = $this->input->post('Bhp');
				$bstyle = $this->input->post('b_style');
				$transmission = $this->input->post('transmission');
				$fuel = $this->input->post('fuel');
				$mileage = $this->input->post('mileage');
				$dtype = $this->input->post('d_type');		
				$data=array('engine'=>$engine,'body_style'=>$bstyle,'bhp'=>$Bhp,'drive_type'=>$dtype,'transmission'=>$transmission,'fuel'=>$fuel,'mileage'=>$mileage);
				$this->main_model->updateride_std($userid,$data);			
				$this->db->trans_complete();
				print_r($_POST);		
				die;  
		}
  } 
///////////////////////////////////////////////////////////////////////////////
public function editflash() { 
       
	   if(ensureUser_popup())
			{
					if(isset($_POST['fleshuserid']))
					{
						$friendid = $_POST['fleshuserid'];
						$reflesh='flashed';
					}
					elseif(isset($_POST['fleshuserid2']))
					{
						$friendid = $_POST['fleshuserid2'];
						$reflesh='re-flashed';
					}
					else
					{              
					 $friendid = $_POST['fleshuserid'];
					}
					
					$userdata = userSession();	
					$userid =$userdata['id'];		
					
					$dataflesh=array('userid'=>$userid,'friendid'=>$friendid,'date'=>date('Y-m-d H:i:s'));
					$this->main_model->addflesh($dataflesh);
					$this->db->trans_complete();		
					/*$totalflesh=getFlashes($friendid);
					$newflesh = $totalflesh+1;
					$data=array('flashes'=>$newflesh);*/		
					/*$this->main_model->updateflesh($userid,$data);	*/		
					echo '<a  href="javascript: void(0);" class="otheractionbtn blur" id="popupNotification" ><span class="flashLightsBtn"></span><span>Re-Flash</span></a>';
					/*if setting set then send email check */
					$datavalue=$this->main_model->getemailbyid($friendid); 
					
					$flash=0;
					$flash=$datavalue[0]['email_on_flash'];
					$reflash=0;
					$reflash=$datavalue[0]['email_on_reflash'];
							
					if(($flash=='1' && isset($_POST['fleshuserid'])) || ($reflash=='1' && isset($_POST['fleshuserid2'])))
					{			
						
					 $this->load->library('email');		 
					 $config['mailtype'] = 'html';
					 $this->email->initialize($config);		  	 
					 $this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name'));		 		
					 
					 $email=$datavalue[0]['email_id'];
					 $this->email->to($email);        
					 $this->email->subject('Someone '.$reflesh.' lights at you.'); 
					 
					 $data['first_name']=$datavalue[0]['first_name'];
					 $data['last_name']=$datavalue[0]['last_name'];
					 $data['emid']=$datavalue[0]['email_id'];
					 $data['receiver']=$data['emid'];
					 $data['flasher_first_name']=$userdata['first_name'];
					 $data['flasher_last_name']=$userdata['last_name'];
					 
					
					 $getRideInfo=getRideInfo($userdata['id']);
					 
					 $getListVehicleBrandRideInfo=getListVehicleBrand($getRideInfo['type'],1);
					 $brandRideInfo=$getListVehicleBrandRideInfo[$getRideInfo['make']];
					 
					 $data['make']=ucfirst($brandRideInfo);
					 $modelRideInfo=getModelText($getRideInfo['model'], $getRideInfo['type']);
					 $data['model']=ucfirst($modelRideInfo);
					 
					 
					  $g =$userdata['gendor'];
					  if($g=='male')
					   {
						 $data['hisher']='his';  
					   }
					   else
					   {
						   $data['hisher']='her';  
					   }
					  
					   $data['gdr']=himHer($g);	
					  
					 $data['ref']=$reflesh; 		  		       
					 $sendmailtemplate=$this->load->view('emails/sendEmail.php',$data,TRUE);
					 $this->email->message($sendmailtemplate);
					 $this->email->send();
					}
			}
			else
				echo 'LO';
 }
///////////////////////////////////////////////////////////////////////////////
public function removeflash() {        
	    $friendid = $_POST['fleshuserid'];
	    $userdata =userSession();	
	    $userid =$userdata['id'];
	    $this->main_model->rflesh($userid,$friendid);
		
	    $totalflesh = getFlashes($friendid);		
	    $newflesh = $totalflesh-1;
		
		$data=array('flashes'=>$newflesh);
		$this->main_model->updateflesh($userid,$data);			
		$this->db->trans_complete();
		echo '<a href="javascript: void(0);" class="btnBgStyle riderFlashLyt btnEqualAll" onclick="return flash_lights('.$friendid.');" ><p><span class="flashLightsBtn"></span><span>Flash Lights</span></p></a>';		
		die;    
  }  
//////////////////////////////////////////////////////////////////////////////
public function friendrequest() {        
	    
		$frdid = $_POST['frdid'];
		$user=userSession();	
		$userid = $user['username'];
		$useri_d = $user['id'];
		//echo $frdid."<br>".$userid; die('fkjdhgkdfjg');
		
		if(friendshipStatus($useri_d,$frdid)==4)
		{
				$data= array('user_id'=>$useri_d,'friend_id'=>$frdid,'status'=>2,'gedi_status'=>0);	
				$this->main_model->insertfriend($data); 
				$this->db->trans_complete();
				
				$this->load->helper('notification');
				addNotificationFriendRequest($frdid);
		}
		
		echo '<a onclick="return cancel_request('.$frdid.');" href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll"><p><span class="addFrdPlusIcon"></span><span>Cancel Request</span></p></a>';
		die; 
		
  }
//////////////////////////////////////////////////////////////////////////////
public function friendrequestconfirm() {        
	    
		$frdid = $_POST['frdid'];
		$confirmfrndusername = getUserInfo($frdid);	
		//see($confirmfrndusername);
		$cfuname = $confirmfrndusername['username'];
		
		$loginuserid = userSession();
		$userid = $loginuserid['username'];
	    $luserid =$loginuserid['id'];		
		$this->main_model->confirmfriend($userid,$frdid,$cfuname,$luserid);		
		$this->db->trans_complete();
		
		$this->load->helper('notification');
		addNotificationFriendRequestAccept($frdid);
		
		echo '<div style="position:relative" class="btn-box">
              <a class="optionAddFrdFlashBtn friendsOptionBtn" id="optionAddFrdFlashBtn-2" href="javascript:void(0);" onclick="return remove_friend('.$frdid.');">Unfriend</a>
              </div>';
		die;  
  }  
 //////////////////////////////////////////////////////////////////////////////
public function removefriend() {        
	     
		if(!ensureUser_popup())
			echo "LO";
		else
		{
			$removefrndid = $_POST['userid'];
			$removefrndusername = $this->main_model->otheruser_detail($removefrndid);		
			$rfuname = $removefrndusername[0]['username'];
			
			
			$loginuserid = userSession();
			$userid = $loginuserid['username'];
			$luserid =$loginuserid['id'];		
			$this->main_model->cancel_friend_request($userid,$removefrndid,$rfuname,$luserid); 
			$this->db->trans_complete();
			echo '<a onclick="return friend_request('.$removefrndid.');" href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll"><p><span class="addFrdPlusIcon"></span><span>Add Friend</span></p></a>';			
			die;   
		}
  } 
  
  //////////////////////////////////////////////////////////////////////////////
public function deletefriend() {        
	     
		$removefrndid = $_POST['userid'];
		$removefrndusername = $this->main_model->otheruser_detail($removefrndid);		
		$rfuname = $removefrndusername[0]['username'];
		
		$loginuserid = userSession();
		$userid = $loginuserid['username'];
	    $luserid =$loginuserid['id'];		
		$this->main_model->cancel_friend_request($userid,$removefrndid,$rfuname,$luserid); 
		$this->db->trans_complete();
		echo 'deletefriendrequest';			
		die;   
  } 
 //////////////////////////////////////////////////////////////////////////////
public function cancel_request() {        
	     
		$removefrndid = $_POST['userid'];
		$removefrndusername = $this->main_model->otheruser_detail($removefrndid);		
		$rfuname = $removefrndusername[0]['username'];
		
		$loginuserid = userSession();
		$userid = $loginuserid['username'];
	    $luserid =$loginuserid['id'];		
		$this->main_model->cancel_friend_request($userid,$removefrndid,$rfuname,$luserid); 
		$this->db->trans_complete();
		//echo '<a onclick="return friend_request('.$removefrndid.');" href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll"><p><span class="addF"></span><span>
		echo '<a onclick="return friend_request('.$removefrndid.');" href="javascript: void(0);" class="btnBgStyle addRiderFrd btnEqualAll"><p><span class="addFrdPlusIcon"></span><span>Add Friend</span></p></a>';			
		die;   
		}
		
		function thankyou()
		{
			 $arData =array();
		/*$userdata = $this->session->userdata('User');
	    $userid =$userdata['username'];
		$data=array('first_login'=>1);
		$query = $this->main_model->update($userdata['username'],$data);
		$arData['Userdata'] = $this->main_model->user_detail($userid);		*/
		
		$arContent['content'] = $this->load->view('users/thankyou.php',$arData,true);	
		$this->load->view('layouts/default.php',$arContent);		
		}
		
		
		function addNewVehicleBrand()
		{
			if(ensureUser_popup())
			{
				$data=$_POST;
				if(!empty($data))
				{
					echo $this->main_model->addNewVehicle($data,'brand');
				}
			}
			else
				echo 'LO';			
		}
		
		function addNewVehicleModel()
		{
			if(ensureUser_popup())
			{
				$data=$_POST;
				if(!empty($data))
				{
					echo $this->main_model->addNewVehicle($data,'model');
				}
			}
			else
				echo 'LO';			
		}
		
		function saveUserLocation()
		{
			$data=$_POST;
			$this->ensureUser();
			$this->user_model->saveUserLocation($data);
		}


	public function citySuggestion()	
		{ 	
			if(!ensureUser_popup())
			echo "LO";
		else
			{	
				if(isset($_POST['queryString'])) {			
					$queryString = $_POST['queryString'];	
					$arData['queryString'] =trim($queryString);	
					$arData['state'] =$_POST['state'];			
					if(strlen($queryString) >0) {
						$arData['cities'] = $this->main_model->citySuggestion($arData);				
					 }
				 }
				//$arData['friendlist'] = $this->main_model->frd_list_to_add($userid);
				$arContent['content'] = $this->load->view('users/citySuggestion.php',$arData,true);
				
				$arContent['content_for'] = 'headersdata';	
				$this->load->view('layouts/empty.php',$arContent);    
			}
	  } 
	  
function saveMyLoc()
{
	if(!ensureUser_popup())
			echo "LO";
		else
			{	
				if(isset($_POST['city']))
					$this->main_model->saveMyLoc($_POST);
			}
}
	  
}