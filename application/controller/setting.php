<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Setting extends CI_Controller {


	
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('setting_model');
	
    }
/////////////////////////////////////////////////////////////////////////////////
function settingUser()
 	{
		return ensureUser();
	 }	
	 
//////////Login function statrt here//////////////
public function index() {  
 
	   
	    	$this->settingUser();
		$arData =   array();
		$arData['page_title']="Settings"; 	
	    	$arData['udetail'] =userSession();
		$userid = $arData['udetail']['username'];
		$user_id = $arData['udetail']['id'];
		$arData['userb_id']=$arData['udetail']['id'];          
		$arData['udata'] = $this->setting_model->user_detail($userid);
		$arData['ridetdata'] = $this->setting_model->ride_info($user_id);
		$arContent['content'] = $this->load->view('setting/index.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent);    
		
  }  
 
 public function emailNotiSetting()
 {
		 $arData =   array();
		 $arData['udetail'] =userSession();
		 $user_id = $arData['udetail']['id'];
		 $data=$_POST;

		 $this->setting_model->emailNotiSetting($data,$user_id );
} 


public function connectFacebook()
 {
		 $arData =   array();
		 $arData['udetail'] =userSession();
		 $user_id = $arData['udetail']['id'];
		 $data=$_POST;

		 $this->setting_model->connectFacebook($data,$user_id );
} 






  public function changePasswordPop($pass)
  {
  $arData =   array();
		 $arData['udetail'] =userSession();
		 $user_id = $arData['udetail']['id'];
		 

		 $this->setting_model->changePasswordPop($pass,$user_id );
  
  }
  
  public function changeEmailPop($email)
  {
  $arData =   array();
		 $arData['udetail'] =userSession();
		 $user_id = $arData['udetail']['id'];
		 

		 $this->setting_model->changeEmailPop($email,$user_id );
  
  }
  
  public function changeVehiclePop($vno)
  {
          $arData =   array();
		  $arData['udetail'] =userSession();
		  $user_id = $arData['udetail']['id'];
          $res=$this->setting_model->changeVehiclePop($vno);
		  
		  
		   if(!empty($res))
		   {
		       echo 1;
		   }
		   else
		   {
			  $this->setting_model->changeVehiclePopUpdate($vno,$user_id );
			  echo 2;
		   }
 }
 
  
///////////////////////////////////////////////////////////////////  
public function changepassword() {  
 
	   if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{
		 // $this->settingUser();
		  $arData =   array();
		  $arData['page_title']="Change Password"; 	   
		  $arContent['content'] = $this->load->view('setting/changepassword.php',$arData,true);	 
		  $this->load->view('layouts/empty.php',$arContent);    
		}
		
  }

///////////////////////////////////////////////////////////////////  
public function cvehicledetails() {   
	   
	   if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	else
		{
		 // $this->settingUser();
		  $arData =   array();
		  $arData['page_title']="Change Vehicle Details";
		  $arData['udetail'] =userSession();
		  $userid = $arData['udetail']['id'];	
		  $arData['regno'] = $arData['udetail']['username'];		 	
		  $arData['vdetails'] = $this->setting_model->ride_info($userid);	   
		  $arContent['content'] = $this->load->view('setting/cvehicledetails.php',$arData,true);	 
		  $this->load->view('layouts/empty.php',$arContent);    
		}
		
  }
  
////////////////////////////////////////////////////////////////////////
public function uvdetail()	{ 	  	
	
	if(!ensureUser_popup())
		echo "LO";
	else
		{	
				  $arData =   array(); 
				  $arData['Userdetail'] =userSession();
				  $userid = $arData['Userdetail']['id'];
				  if($_POST){		
						  $brand = $_POST['brand']; 
						  $model = $_POST['model'];
						  $type = $_POST['type'];		
						  $data = array('make' => $brand,'model' => $model,'type' => $type);
						  $this->db->trans_start();
						  $this->setting_model->updatevdetail($userid,$data);
						  $this->db->trans_complete(); 
						  echo "success";
						  die;		
					  
					  }
		}
}  
////////////////////////////////////////////////////////////////////////
public function activate()	{ 		

	if(!ensureUser_popup())
		echo "LO";
	else{
				$arData =   array(); 
				$arData['Userdetail'] =userSession();
				$userid = $arData['Userdetail']['username'];
				if($_POST){
						
						$newpass = $_POST['password']; 
						$cpass = $_POST['cpassword'];
						$opassword = $_POST['opassword']; 
						$this->load->library('form_validation');
						$query = $this->setting_model->oldloginpwd($opassword,$userid);		
						if($query->num_rows > 0 ) {
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
						$newcpass=MD5($newpass);
						$data = array('password' => $newcpass);
						$this->db->trans_start();
						$this->setting_model->updatepassword($userid,$data);
						$this->db->trans_complete(); 
						echo "success";
						die;		
					  }else{
							echo "match";
							die;
						  }	
					}
			}
}
 
 
 public function getCarBikeBrands($d)
 {
			
			$res=$this->setting_model->getCarBikeBrands($d);
			
			foreach($res as $k=>$v)
			echo '<option value="'.$v['link'].'">'.$v['brand'].'</option>';   

 
 }


 public function getCarBikeModels($d,$t)
 {
			
			$res=$this->setting_model->getCarBikeModels($d,$t);
			
			foreach($res as $k=>$v)
			echo '<option value="'.$v['link'].'">'.$v['model'].'</option>';   
 }
 
 public function userblocked()
 {
 $arData =   array();
		 	
	    	$arData['udetail'] =userSession();
		$userid = $arData['udetail']['username'];
		$user_id = $arData['udetail']['id'];
		$arData['userb_id']=$arData['udetail']['id'];          
		
		 $arContent['content'] = $this->load->view('setting/userblocked',$arData,true); 
		 $this->load->view('layouts/empty.php',$arContent);  

 } 


function unblockUser($id)
{
	if(!ensureUser_popup())
		echo "LO";
	else
		{	
				  $arData =   array(); 
				  $arData['Userdetail'] =userSession();
				  $userid = $arData['Userdetail']['id'];
				 
				 $this->setting_model->unblockUser($userid,$id);
		}
		
}


/////////////////////////////////////////////////////////













	
/////////////////////////////////////////////////////////	
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */
