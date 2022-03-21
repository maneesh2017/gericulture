<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller
{
  function __construct()  
  {      
	  parent::__construct();
	  $this->load->library('session');
	  $this->load->helper('form');
	  $this->load->helper('url');
	  $this->load->model('contact_model');
  
  }
   

  public function index() 
  {  
	   ensureUser();
	  $arData =   array();
	  $arData['userdata'] = userSession();
	  
	  $arContent['content'] = $this->load->view('contact/index',$arData,true);	 
	  if(!ensureUser_popup())
		  $this->load->view('layouts/default.php',$arContent);    
	  else	
		  $this->load->view('layouts/default-user.php',$arContent);    
	  
 }   
 public function submit()
 {
       ensureUser();
	  if(isset($_POST["Contact"]))
	   {
			 $data=$_POST;
			  $this->contact_model->contact_submit($data);
			  // redirect(site_url().'resloveconflict');
		  // header('location:'.site_url().'resloveconflict');
		    echo "done";
			}
	 
 }
  public function submitted()
 {
	    ensureUser();
	    $arData =   array();
		$arContent['content'] = $this->load->view('contact/submitted',$arData,true);	 
		$this->load->view('layouts/default-user.php',$arContent);    

 }
}
?>