<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class verification extends CI_Controller 
{
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
	  
  }
////////////////////////////////////////////////////////////////////////    
 function index()  
 {           
  
	 $session = $this->session->userdata('User');
	 if(empty($session))
	 {
			  redirect(site_url(),'refresh');
			  return false;				
	  }			
	  $arData =   array();
	  $arData['Userdetail']=userSession();
	  $userid = $arData['Userdetail']['username'];
	  $user_id = $arData['Userdetail']['id'];
	  $arContent['content'] = $this->load->view('trial/index.php',$arData,true);	
	  $this->load->view('layouts/defaultbasic.php',$arContent); 	
	  //$this->load->view('layouts/default-user.php',$arContent); 
	   $this->load->view('common/footer_verification.php');   	
 }  
  
/////////////////////////////////////////////////////////////////////////	

public function change_email()
  { 	
	  $userid = $_POST['uid'];
	  $userEmail = $_POST['email'];	   
	  $this->load->model('main_model'); 		
	  $this->db->trans_start();
	  $this->main_model->update_email($userEmail,$userid);
	  $this->db->trans_complete();
	  $newdata = userSession();	 
	  $datavalue=$this->main_model->getemailbyid($userid);
	  //print_r($datavalue);
	  //die();		
	  $activation_code=$this->main_model->updatebyemailnew($newdata);				
									$linkdata = array();
									$emaildata= array();
								   // $emaildata['emaildata']=$data;
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
			  $data['activation_link'] =$emaildata['activation_link'] = $activation_link;				
				$data['emid']=$newdata['email_id'];					
				$data['emaildata']=$emaildata;
				$data['datavalue']=$datavalue;
				$confirmemailtemplate=$this->load->view('emails/resend_verification_email.php',$data,true);
				$this->email->message($confirmemailtemplate);
				$this->email->send(); 
						  //Email to user Ends
						  
						  //Email to Admin
							  $this->email->from($this->config->item('email_from_address'), $this->config->item('email_from_name'));
							  $this->email->to($this->config->item('admin_email_address'));
							  $this->email->subject('Change Email  - Chandigarh Geri');
							  $this->email->message('<p>Email id change by .</p><p>'.$datavalue[0]['first_name'].', '.$datavalue[0]['email_id'].'</p>');

							  $this->email->send();
						  //Email to Admin Ends
						  
						  echo "emailsent";
						  die();
		  
	  
 }
 
 //////////////////////////////////////////////////////////
 public function submitted()
 {
   
 
	    $arData =   array();
		$arContent['content'] = $this->load->view('trial/submitted',$arData,true);	 
		$this->load->view('layouts/default.php',$arContent);    

 }
 //////////////////////////////////////////////////////////  
  public function emailchanged()
 {
   
 
	    $arData =   array();
		$arContent['content'] = $this->load->view('trial/emailchanged',$arData,true);	 
		$this->load->view('layouts/default.php',$arContent);    

 }
 //////////////////////////////////////////////////////////  
}