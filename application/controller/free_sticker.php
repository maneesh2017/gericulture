<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_sticker extends CI_Controller
{
  function __construct()  
  {      
	  parent::__construct();
	  $this->load->library('session');
	  $this->load->helper('form');
	  $this->load->helper('url');
	 $this->load->model('User_model');
	 $this->load->model('Sticker_model');
  
  } 

  public function index() 
  {  
      ensureUser();
	  $arData =   array();
	  $arData['page_title']="Free sticker";   
	  $arData['userdata']= userSession();
	  $arData['allstates'] =getStateList();
	  $arData['ifStickerOrdered']=ifStickerOrdered($arData['userdata']['id']);
	  $arContent['content'] = $this->load->view('free_sticker/shipping_detail_form',$arData,true);	 
	  $this->load->view('layouts/default-user.php',$arContent);
	}   

   public function submit()
   {
	   if(ensureUser_popup())
			  {
				  $data=$_POST;			   
				  echo $orderid= $this->Sticker_model->orderdetail_submit($data);
				  
				  //Email to user STARTS
				  $this->load->library('email');             
				  $config['mailtype'] = 'html';
				  $this->email->initialize($config);
				  $this->email->from(email_from_address(),email_from_name());
				  $data['userdata']= userSession();
				  $data['orderid']=$orderid;
				  $data['reciever']=$data['email'];
				  
				  $mailTemplate=$this->load->view('emails/sticker_order.php',$data,true);
				  $this->email->to($data['email']);   
				  $this->email->subject('Your sticker order details');
				  $this->email->message($mailTemplate);
				  $this->email->send();    
				  //Email to user Ends
				}
			  else
				  echo 'LO';	
   }
   
   function testSticker()
   {
				 $data['email']='shalika@evomorf.com';
				//Email to user STARTS
				  $this->load->library('email');             
				  $config['mailtype'] = 'html';
				  $this->email->initialize($config);
				  $this->email->from(email_from_address(),email_from_name());
				  $data['userdata']['first_name']= 'Shalika';
				  $data['orderid']=123;
				  $data['reciever']=$data['email'];
				  $mailTemplate=$this->load->view('emails/sticker_order.php',$data,true);
				  $this->email->to($data['email']);   
				  $this->email->subject('Your sticker order details');
				  $this->email->message($mailTemplate);
				  $this->email->send();    
				  //Email to user Ends
				  echo 'done';
	}
 
}
?>