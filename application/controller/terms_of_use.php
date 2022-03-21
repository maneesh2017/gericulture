<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class Terms_of_use extends CI_Controller {
 function __construct() 
  { 
         parent::__construct();		
        $this->load->helper('url');
  }
 
 public function index()
 {

           $this->load->library('session');
		$arData =   array();
		$arData['page_title']="Terms of Use";  
		 $arContent['content'] = $this->load->view('terms_of_use.php',$arData,true);
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
 
 
 }
 ?>