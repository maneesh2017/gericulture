<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	/*
	 * Index Page for this controller.
	 *	
	 */
/////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
    }
/////////////////////////////////////////////////////////////////////////////////	
/////////////////////////////////////////////////////////	 
	public function index()
	{
	    if($this->session->userdata('User')){
			redirect(site_url().'my-profile','refresh');
		}else{
			
			
			///checking cookie
				  if(isset($_COOKIE['email']) && isset($_COOKIE['userid']))
				  {
					  $cookie1=$_COOKIE['email'];
					  
					  $this->load->model('main_model');
					  $usercookie	=$this->main_model->remember_cookie_check($cookie1);
					  if($usercookie)
						  {
							  $cookie2=$_COOKIE['userid'];
							  $usercookieData	=$this->main_model->remember_cookie2_check($cookie2);
							  
							  $UserDataSession['id']=$usercookieData['id'];
							  $this->session->set_userdata('User',$UserDataSession);	
							 
							redirect(site_url().'my-profile','refresh');
						  }
				  }
		///checking cookie ends
			
			
			  $arData['msg'] =  array();
		      $arContent['content'] = $this->load->view('pages/index.php',$arData,true);		
		      $this->load->view('layouts/default.php',$arContent);
	         }
	}
////////////////////////////////////////////////////////////////////////	
	
	function onLoad()
	{
		onLoad();
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
