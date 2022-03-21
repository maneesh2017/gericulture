<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Alluser extends CI_Controller {


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
    }
	
//////////index function statrt here//////////////
//////////index function statrt here//////////////
public function index()	{ 		
			
		$arData =   array();
		$arData['Userdetail'] =userSession();
		$userid = $arData['Userdetail']['username'];   
		$user_id = $arData['Userdetail']['id'];		
		$arData['alluserlist'] = $this->main_model->all_userlist($userid);
		$arContent['content'] = $this->load->view('alluser/index.php',$arData,true);
		$this->load->view('layouts/default-user.php',$arContent); 
	}     

////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////
}
