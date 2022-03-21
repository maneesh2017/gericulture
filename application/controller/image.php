<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Image extends CI_Controller {


	/**
	 * Index Page for this controller.
	 *	
	 */
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('main_model');
    }
/////////////////////////////////////
public function index() {       
        
		$userdata=userSession();
			
	    $userid =$userdata['username'];				
		if($_FILES['image']['name'] != ""){
		// $path= base_url()."system/uploads/";		
		// $imagename = $_FILES['image']['name'];
		// $tmpname = $_FILES['image']['tmp_name'];
		// @move_uploaded_file($_FILES['image']['tmp_name'],$path.$_FILES['image']['name']);
		$path="./uploads/gallery"; 
		$t1=time();
		$imagename=$t1.$_FILES['image']['name'];
		$imagename = $_FILES['image']['name'];
		$tmpname = $_FILES['image']['tmp_name'];
		@move_uploaded_file($_FILES['image']['tmp_name'],$path.'/temp/'.$imagename);
		
		}else{
		$imagename='';		
		}  
		$data=array('image'=>$imagename);
		$this->main_model->updateride($userid,$data);
			
		$this->db->trans_complete();	
		
		echo base_url()."system/uploads/".$_FILES['image']['name'];

		$arData =   array();					
	$arContent['content'] = $this->load->view('image/index.php',$arData,true);	
		$this->load->view('layouts/default.php',$arContent); 

		
		
  } 
////////////////////////////////////////////////////////////////
 } 