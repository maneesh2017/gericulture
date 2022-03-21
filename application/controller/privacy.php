<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 
 class Privacy extends CI_Controller 
 {
/////////////////////////////////////////	 
function __construct() 
 {      
        parent::__construct();
		$this->load->helper('url');
 }
 //////////////////////////////////// 
 public function index()
 {

		$arData =   array();
		$arData['page_title']="Privacy";  
		 $arContent['content'] = $this->load->view('privacy.php',$arData,true);
		 $session = $this->session->userdata('User');
			if(empty($session))
			{
		$this->load->view('layouts/defaultfortermPrivacy.php',$arContent);
			}
			else
			{
		$this->load->view('layouts/default-user.php',$arContent);
			}
 }
 //////////////////////////////////////////////
 
 }
 ?>