<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class My_profile extends CI_Controller {


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
	
	
	function ensureUser()
 // get admin_id check whether its equal to administrator, if equal stay otherwise logout
     {
				return  ensureUser();
	 }
	 
	 function index()
	 {
	 	$this->ensureUser();
		$arData =   array();
			$arData['page_title']="My Profile";  
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
	 
}