<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Profile extends CI_Controller {


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
	 
		$luserdetail =userSession();
		$fid = $luserdetail['id'];
		$fusername = $luserdetail['username'];
		$userid = $this->uri->segment(2);
		
		//check if I am blocked by this profile
		$get_block_status=get_block_status($userid);
		if(!empty($get_block_status))
			header('location:'.site_url());
		
		$otherusername = $this->main_model->otheruser_detail($userid);
		if(empty($otherusername))
			header('location:'.site_url());
			
		if(($otherusername[0]['status']==0 || $otherusername[0]['first_login']==0) && $luserdetail['username']!='admin')
			redirect(site_url(),'refresh');
			
		$username = $otherusername[0]['username'];
		$arData['about_me'] = $luserdetail;		
		$arData['user_id']=$fid;
		
		$arData['userdata'] = $this->main_model->otheruser_detail($userid);		  
		$arData['rideimage'] = $this->main_model->ride_image_others($userid);
		$arData['userImage']= $this->main_model->user_image_others($userid);
		
		$arData['ridedata'] = $this->main_model->ride_detail($userid);
		$arData['currentstatuspic'] = latestStatus($userid);
		
		$this->load->model('photo_model');
		$arData['othersridephotos'] = $this->photo_model->myridephotos($userid);
		$arData['othersphotos'] = $this->photo_model->my_photos($userid);
		
		$getListVehicleBrand=getListVehicleBrand($arData['ridedata'][0]['type'],1);
		$make=$getListVehicleBrand[$arData['ridedata'][0]['make']];
		$model=getModelText($arData['ridedata'][0]['model'],$arData['ridedata'][0]['type']);
		$arData['page_title']=ucwords($make.' '.$model).' - '.$arData['userdata'][0]['first_name'].' '.$arData['userdata'][0]['last_name']; 
		
		//see($arData['currentstatuspic']);
		$arContent['content'] = $this->load->view('users/aboutOthers.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent);  
  }
	
}