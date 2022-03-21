<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Notification extends CI_Controller {


	/**
	 * Index Page for this controller.	 
	 */
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->helper('notification');
		$this->load->model('notification_model');		
    }
	
	
//////////index function statrt here//////////////
public function index()	{ 		
			
		ensureUser();
		$arData =   array();
		
		$arData['Userdetail']=userSession();
		$userid = $arData['Userdetail']['username'];   
		$user_id = $arData['Userdetail']['id'];		
		$arData['notifications'] = $this->notification_model->notificationList($user_id);
		$arContent['content'] = $this->load->view('notification/index.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent); 
	}     

////////////////////////////////////////////////////////////////////////////////////



					
	
/////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////
}
