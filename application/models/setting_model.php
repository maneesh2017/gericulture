<?php 

class Setting_model extends CI_Model 
{
	
	
	
	
	
	
	
/////////////////////////////////////////////
function changepassword($data)
	{         
	

$arData =   array(); 
if($_POST){
		
	  	$newpass = $_POST['password'];
		$cpass = $_POST['cpassword'];
	    $useremail = $_POST['emailid'];
		$this->load->library('form_validation');
		if($newpass=='' && $cpass=='' && $useremail==''){}
		else{
		$this->form_validation->set_rules('password', 'password', 'trim|required|matches[cpassword]');
		$this->form_validation->set_rules('cpassword', 'Password confirmation', 'trim|required|matches[password]');
		}
		if ($this->form_validation->run() == FALSE)
		{
			echo "error";
			die;
		}
		
		$newpass=MD5($newpass);
		$data = array('password' => $newpass);
		$this->db->trans_start();
		$this->forgotpwd_model->updatepassword($useremail,$data);
		$this->db->trans_complete(); 
		echo "success";
		die;		
		
	}
		
	}	
	
////////////////////////////////////////////////////////////////////////	
function ride_info($id)  
	{
		 
		$sql="select * from `rides` where `user_id`=?";
		$query=$this->db->query($sql,array($id));		
		$result=array();
		if($query->num_rows()>0)
			$result=$query->row_array();
		return $result;	
	}	
//////////////////////////////////////////////////////////////////	
function user_detail($userid){		
		$this->db->where('username',$userid);	  
		$query = $this->db->get('users');
		 return $query->result_array();	 	
	}
//////////////////////////////////////////////////////////////////	
function oldloginpwd($password,$username){	
		$pwd=MD5($password);
		$result = $this->db->query("select * from users where username = '$username' and password = '$pwd' && status=1");    		
	   return $result;
				
	}	
//////////////////////////////////////////////////////////	
	function updatepassword($username,$data)
	{ 
			$this->db->where('username', $username);
			$this->db->update('users',$data);
		
    }
//////////////////////////////////////////////////////////	
	function updatevdetail($username,$data)
	{ 
			$this->db->where('user_id', $username);
			$this->db->update('rides',$data);
		
    }  
	
	
	
	function getCarBikeBrands($d)
	{
		if($d=='car')
		{
			$sql="select * from car_brands order by `brand`";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			return $res;
		}
		if($d=='suv')
		{
			$sql="select * from car_brands order by `brand`";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			return $res;
		}
		elseif($d=='bike')
		{
			$sql="select * from bike_brands order by `brand`";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			return $res;
		}
		elseif($d=='scooter')
		{
			$sql="select * from bike_brands order by `brand`";
			$query=$this->db->query($sql);
			$res=$query->result_array();
			return $res;
		}
	}
	
	 function emailNotiSetting($data,$user_id )
	 {
			 if(isset($data['personalmessage']))
			 {
					 $msg='1';
			 }
			 else
					 $msg='0';
			 
			 if(isset($data['flashlights']))
			 {
					 $flsh='1';
			 }
			 else
					 $flsh='0'; 
			 
			 if(isset($data['reflashlights']))
			 {
					 $reflsh='1';
			 }
			  else
					 $reflsh='0'; 
			 
			$sql="update users set email_on_message=?,email_on_flash=?,email_on_reflash=? where id=? ";
				 $query=$this->db->query($sql,array( $msg,$flsh,$reflsh,$user_id));
		 
	 }
	 
	 function changePasswordPop($pass,$user_id )
	 {
	 
	             $sql="update users set password=? where id=? ";
				 $query=$this->db->query($sql,array(MD5($pass),$user_id));
	
	 }
	
	function changeVehiclePop($vno )
	 {
	 
	               $sql="select * from users where username=? ";
				   $query=$this->db->query($sql,$vno);
				   $res= $query->result_array();
				   return $res;
				 
	
	 }
	
	function changeEmailPop($vno,$user_id  )
	 {
	          /*$vvno=$this->clean($vno);*/
	          $sql="update users set email_id=? where id=? ";
			  $query=$this->db->query($sql,array($vno,$user_id));
			  echo $this->db->last_query();
	 
	 }
	 
function changeVehiclePopUpdate($vno,$user_id  )
	 {
	          /*$vvno=$this->clean($vno);*/
	          $sql="update users set username=? where id=? ";
			  $query=$this->db->query($sql,array($vno,$user_id));
			  //echo $this->db->last_query();
	 
	 }
	 
function clean($string)
{
   
    $string = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);
    return preg_replace('/[^a-zA-Z0-9Ã§&-©‚Âƒâ€˜\s]/', '', $string);
	
	return addslashes(htmlspecialchars(strip_tags(trim($string))));
}


function connectFacebook($data,$user_id )
	 {
	 
	                 $sql="update users set fb_url=? where id=? ";
				    $query=$this->db->query($sql,array( $data['fburl'],$user_id));
	 
	 
	 }
	
	  
function getCarBikeModels($d,$t)
	{
			if($t=='car')
			{
			$mod="select id from car_brands where link like ?";
			$query=$this->db->query($mod,$d);
			$id=$query->result_array();	
			if(!empty($id))
			{
			  $sql="select * from car_models where brand_id=? order by `model`";
			  $query=$this->db->query($sql,$id[0]['id']);
			  $res=$query->result_array();
			}
			else
			{
				 $sug=explode('-',$d);
				if($sug[0]=='suggestion')
				{
				   //$sql="select $d as `link`, `model` from `suggested_brands` where `type`='car' and `brand` like '".$sug[1]."'";
				   $sql="select $d as `link`, `model` from `suggested_brands` where `type`='car' and `id` = '".$sug[1]."'";
				   $query=$this->db->query($sql);
				   $res=$query->result_array();
				}
				else
					$res=array();
			}
			return $res;
			}
			if($t=='suv')
			{
			$mod="select id from car_brands where link like ?";
			$query=$this->db->query($mod,$d);
			$id=$query->result_array();	
			if(!empty($id))
			{
			  $sql="select * from car_models where brand_id=? order by `model`";
			  $query=$this->db->query($sql,$id[0]['id']);
			  $res=$query->result_array();
			}
			else
			{
				 $sug=explode('-',$d);
				if($sug[0]=='suggestion')
				{
				   //$sql="select $d as `link`, `model` from `suggested_brands` where `type`='car' and `brand` like '".$sug[1]."'";
				   $sql="select $d as `link`, `model` from `suggested_brands` where `type`='car' and `id` = '".$sug[1]."'";
				   $query=$this->db->query($sql);
				   $res=$query->result_array();
				}
				else
					$res=array();
			}
			return $res;
			}
			if($t=='bike')
			{	
			$mod="select id from bike_brands where link like ?";
			$query=$this->db->query($mod,$d);
			$id=$query->result_array();
			if(!empty($id))
			{	
			  $sql="select * from bike_models where brand_id=?  order by `model`";
			  $query=$this->db->query($sql,$id[0]['id']);
			  $res=$query->result_array();
			}
			else
			{
				$sug=explode('-',$d);
				if($sug[0]=='suggestion')
				{
				   $sql="select '$d' as `link`, `model` from `suggested_brands` where `type`='bike' and `id` = '".$sug[1]."'";
				   $query=$this->db->query($sql);
				   $res=$query->result_array();
				}
				else
					$res=array();
			}
			return $res;
			}
			if($t=='scooter')
			{	
			$mod="select id from bike_brands where link like ?";
			$query=$this->db->query($mod,$d);
			$id=$query->result_array();
			if(!empty($id))
			{	
			  $sql="select * from bike_models where brand_id=?  order by `model`";
			  $query=$this->db->query($sql,$id[0]['id']);
			  $res=$query->result_array();
			}
			else
			{
				$sug=explode('-',$d);
				if($sug[0]=='suggestion')
				{
				   $sql="select '$d' as `link`, `model` from `suggested_brands` where `type`='bike' and `id` = '".$sug[1]."'";
				   $query=$this->db->query($sql);
				   $res=$query->result_array();
				}
				else
					$res=array();
			}
			return $res;
			}

			}
			
	function getUserBlocked($user_id)
		{
		$sql="select *,users.id,users.username,users.first_name,users.last_name ,rides.model,rides.make from blocks join users on(blocks.user_blocked=users.id) join rides on(blocks.user_blocked=rides.user_id ) where blocked_by=?";
		$query=$this->db->query($sql,$user_id);
		$res=$query->result_array();
		return ($res);
		
		}	
		
		function unblockUser($userid,$id)
		{
			$sql="delete from `blocks` where `user_blocked`=? and `blocked_by`=?";
			$this->db->query($sql,array($id,$userid));
			
			$getUserBlockedCount=count(getUserBlocked($userid));
			if($getUserBlockedCount==0)
				echo "No";
			else	
					echo $getUserBlockedCount;
		}
		
			
 //////////////////////////////////////////////////////////	
     
//////////////////////////////////////////////////	
	
	
	
	
	
	
	
	
	
	
	
	
	//////////////////////////////////////////////////////////////////	
		
		
		

		
//////////////////////////////////////////////////////////////////	
	
}
?>
