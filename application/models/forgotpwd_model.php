<?php

class Forgotpwd_model extends CI_Model 
{

///////////////////////////////////////////////		
	function emaildetail($useremailid)
	{ 
	$result = $this->db->query("select * from users where email_id = '".$useremailid."' ");    		
	return $result;	
    }
    
/////////////////////////////////////////////////
///////////////////////////////////////////////		
	function userdetailbyvno($useremailid)
	{ 
	$result = $this->db->query("select * from users where username = '".$useremailid."' ");    		
	return $result;	
    }
    
/////////////////////////////////////////////////
function emailadmindetail($useremailid)
	{ 
	$result = $this->db->query("select * from users where email_id = '".$useremailid."' && role='admin' ");    		
	return $result;	
    }
     
///////////////////////////////////////////////		
	function activate($userData) 
    {		
		
		
		$this->db->where('email_id',$userData['email']);
        $this->db->where('activation_code',$userData['activation_code']);
		$query = $this->db->get('users');				
		if($query->num_rows()==0)   
			return 'not found';		
		$data = array('status' =>1);
		$this->db->where('email_id',$userData['email'] );
		$this->db->where('activation_code',$userData['activation_code'] );
		$affectedFlag = $this->db->update('users',$data); 		
		if($affectedFlag>0)
			return 'found';
		else 
			return 'active';
			
		
    }	
    
   ///////////////////////////////////////////////////////
function activatepassword($user_email)
    {		
		 
		 $createddate = $user_email['activation_code'];     
		 $currentdate =date('Y-m-d H:i:s');
		 $hourdiff = (strtotime($currentdate) - strtotime($createddate))/3600;
	     
		 
		 ////////Get minutes for testing
		   /*$to_time = strtotime($currentdate);
		   $from_time = strtotime($createddate);
  		   $hourdiff =round(abs($to_time - $from_time) / 60,2);*/
		 /////
		 
		 
	    if($hourdiff<24)
		{ 
			return 'found';
	    }
		 else
		{  		
			return 'expired';
	     }
		
    }
  
///////////////////////////////////////////////		
	function updatepassword($useremail,$data)
	{ 
			$this->db->where('email_id', $useremail);
			$this->db->update('users',$data);
		
    }
	      
/////////////////////////////////////////////////////

}
