<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class cmspages extends CI_Controller {


	/**
	 * Index Page for this controller.	 
	 */
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('admin_model');		
		
    }
    
 //////////////////////////////////////////////////////////////////////////
   
//////////index function statrt here//////////////   
public function view()	{ 
	
		$slug = $this->uri->segment(3);
		$htmlpageid = $this->admin_model->pageid($slug);
		 $pageid=$htmlpageid[0]['id'];
	    $adminData['pagelist']= $this->admin_model->allpagecontent($slug);
	    $pagelisthtml = $this->admin_model->sluglist();	   
	    if(!empty($pagelisthtml)){	    
	    $arrcontent= array_shift($pagelisthtml);
	    	
	    $newarray= $arrcontent['pagelist'];
	    $checkarray= explode(',', $newarray);
	    if(in_array($pageid,$checkarray)){				   	
			 $adminData['htmlcontent']= $arrcontent;			 
			}
	    }
	    
	   
	    //$adminData['sidebarcontent']= $this->admin_model->sidebarcontent($pageid);					
		$adminContent['content'] = $this->load->view('admin/viewcms.php',$adminData,true);	
		$this->load->view('layouts/default-user.php',$adminContent);
	}     
////////////////////////////////////////////////////////////////////////////////

 
	  

    
    
    
/////////////////////////////////////////////////////////	
	
}
