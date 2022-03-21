<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forgotpassword extends CI_Controller {
///////////////////////////////////////////////////////////////////
 function __construct() 
  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->library('form_validation');
		$this->load->helper('common_helper');
		$this->load->model('forgotpwd_model');
    }

////////////////////////////////////////////////////////////////
function getRString($length = 6) {
		$validCharacters = "0123456789abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ";
		$validCharNumber = strlen($validCharacters);
	 
		$result = "";
	 
		for ($i = 0; $i < $length; $i++) {
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
	 
		return $result;
	}
////////////////////////////////////////////////////////////	
public function index()	{ 
	
	if(ifUserLoggedIn())
		redirect(site_url(),'refresh');
	
	$arData =   array(); 
	
	if($_POST){    
	$useremail = $_POST['vehicleNumber'];	
	//$query = $this->forgotpwd_model->emaildetail($useremail);	
	$query = $this->forgotpwd_model->userdetailbyvno($useremail);	
	
	if($query->num_rows > 0 ) {	   
	    
		$userdetails = $query->row_array();
		$userfname = $userdetails['first_name'];
		$userlname = $userdetails['last_name']; 
		$useremail=$userdetails['email_id'];
		
		$RideInfo=getRideInfo($userdetails['id']);
		
		if($RideInfo['type']!='')
		{
			$getListVehicleBrand=getListVehicleBrand($RideInfo['type'],1);
			 if(!empty($RideInfo['make']))
			 	$make=$getListVehicleBrand[$RideInfo['make']];
			 $model=getModelText($RideInfo['model'],$RideInfo['type']);
			 $line='Reset the password for your '.$make.' '.$model.'<br>
	   <b style="color:#ffffff; font-size:5px;">hello</b><br>
	   <b style="font-size:18px; font-weight:normal; ">'.strtoupper($userdetails['username']).'</b>';
		}
		else
		$line='Reset your password by clicking the link below';
		   
	    $activation_code=date('Y-m-d' );
		$linkdata = array();   
		$linkdata['email'] = $useremail;	   	
		$linkdata['activation_code'] = $activation_code;
		$activation_link = $this->config->item('base_url')."forgotpassword/changepwd/" . urlencode(base64_encode(json_encode($linkdata)));	
		$this->load->library('email');
		$config['mailtype'] = 'html';  
		$this->email->initialize($config);
		$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));		
		//$this->email->from($from,$this->config->item('email_from_name'));  
		$this->email->to($useremail);           
		$this->email->subject('Reset password'); 
		
		$emailData=array();
		$emailData['userfname']=$userfname;    
		$emailData['userlname']=$userlname;   
		$emailData['line']=$line;    
		$emailData['activation_link']=$activation_link;
		$emailData['receiver']=$useremail;        
		
		$this->email->message($this->load->view('emails/forgot_password.php',$emailData,true));
		$this->email->send();		
		$this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
		$this->email->to($this->config->item('admin_email_address'));
		$this->email->subject('Change User Password - Chandigarh Geri');
		$this->email->message('<p>Password change.</p><p>User, '.$useremail.'</p>');
		$this->email->send();		
	    //$arData['message'] =  'We have sent password reset instructions to your email Id. Please check your email.';	
		$mail= $useremail;
		$mailparts = explode("@", $mail);

	$output='';
	$length=strlen($mailparts[0]);
	if($length<=4)
	{
		$output .=substr($mailparts[0],0,1);
		$output .=str_repeat("*",3);
		$output .=substr($mailparts[0],-1);
	}
	elseif($length==5)
	{
		$output .=substr($mailparts[0],0,2);
		$output .=str_repeat("*",3);
		$output .=substr($mailparts[0],-2);
	}
	
	else
	{
			$output .=substr($mailparts[0],0,2);
			$output .=str_repeat("*",$length-4);
			$output .=substr($mailparts[0],-2);
	}
	$output .= "@" . $mailparts[1];
				
	echo $output;
		die;
		}else{
	          //$arData['error'] =  'Email does Not Exist';
				echo "error";
				die;
	         }
	} 
	$arContent['content'] = $this->load->view('forgotpassword/index.php',$arData,true);	
	$this->load->view('layouts/default.php',$arContent);  
	
  }

///////////////////////////////////////////////////////////////////
/*function changepwd($encodeeddata=null)
	{
		
	if($this->session->userdata("user_id"))
		
			redirect($this->config->item('base_url'),'refresh');

		$data=array();
		$data['page_title']='Reset Password';
		
		$decodeddata = '';
		$send_email=FALSE;		
		
		if(!empty($encodeeddata))
			  {
				  $decodeddata = json_decode(base64_decode(urldecode($encodeeddata)));
				 
				  if(is_object($decodeddata))
					  $decodeddata = (array) $decodeddata;
					  
					  if(
				is_array($decodeddata) 	&& !empty($decodeddata['email']) && !empty($decodeddata['activation_code'])
				)
							  {		
										 
										  $activateFlag = $this->forgotpwd_model->activate($decodeddata);
										
										   
										  if($activateFlag=='found')
										  {
											  $this->session->set_userdata('message','<p  class="success_notify">You have successfully activated your account!</p>');
											  $send_email=TRUE;
											   redirect('user/thankyou',$decodeddata['message']);	
										  }
										  elseif($activateFlag=='active')
										  {
											   $decodeddata['message'] = "<p  class='alert_notify'>This link has expired.Your account has already been activated. <br/>Please sign in to access your account. </p>";
											   redirect('user/thankyou',$decodeddata['message']);
										  }	
										  elseif($activateFlag=='not found')
										  {
											   $decodeddata['message'] = "<p  class='alert_notify'>This link has expired. <br/>Please use new link or sign up again. </p>";
											   redirect('user/thankyou',$decodeddata['message']);
										  }		
							  }
						  else
							  {
								$decodeddata['message'] = "<p  class='error_notify'>You have entered a wrong activation link! Check the email and use proper link to activate your account.</p>";
								redirect('user/thankyou',$decodeddata['message']);
							  }
					  
				  
			  }
		else
			{
				$decodeddata['message'] = "<p  class='error_notify'>You have entered a wrong activation link! Check the email and use proper link to activate your account.</p>";
				redirect('user/thankyou',$decodeddata['message']);
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
				
			}*/
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
			//Sorry!
//Your reset password link was either invalid because it has already been used or it has expired as it is valid only for 24 hours.

		}
		//$newpass = $this->input->post('cpassword');
	    //$useremail = $this->input->post('emailid');
		$newpass=MD5($newpass);
		$data = array('password' => $newpass);
		$this->db->trans_start();
		$this->forgotpwd_model->updatepassword($useremail,$data);
		$this->db->trans_complete(); 
		echo "success";
		die;		
		//$arData['message'] =  'Password have been reset Successfully.';
	}
	$arContent['content'] = $this->load->view('forgotpassword/thankyou',$arData,true);	
	$this->load->view('layouts/defaultbasic.php',$arContent);
	
}	
////////////////////////////////////////////////////////////////////////
public function changepwd($encodeeddata=null)	
{ 
		
	$response="";
	$arData =   array(); 
	if(!empty($encodeeddata))
	{
	    $user_email = json_decode(base64_decode(urldecode($encodeeddata)));
	    if(is_object($user_email))
	    $user_email = (array) $user_email;
	//see($useremail);
	        if(	is_array($user_email) && count($user_email)==2 	&& !empty($user_email['email']) && !empty($user_email['activation_code'])	)
	    {		
				$this->load->model('main_model');	
				$response = $this->forgotpwd_model->activatepassword($user_email);
	
	     }
	       else
		     {
				$response= "wrongLink";	  
		     } 
										   
	     }
	      else
	           {
				  $response= "wrongLink";	  
		       } 
	
		$arData['user_email_id']=$user_email['email'];
	    $arData['page_title'] ='Reset Password';
	    $arData['tabon'] ='resetPassword';
	    $arData['response']=$response;					  
	
	$arContent['content'] = $this->load->view('forgotpassword/changepwd.php',$arData,true);	
	$this->load->view('layouts/default.php',$arContent);
} 

/////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////  
 public function thankyou() {  
 
	    $arData =   array();
		$arContent['content'] = $this->load->view('forgotpassword/thankyou.php',$arData,true);	 
		$this->load->view('layouts/default.php',$arContent);    
		
  }

/////////////////////////////////////////////////////////////

}
?>