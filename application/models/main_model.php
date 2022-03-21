<?php 

class Main_model extends CI_Model 
{ 
function getStateID($vno)
		{
			$sql="SELECT id FROM `states` WHERE `rto` = '$vno' ";
			$result = $this->db->query($sql);
			$row = $result->row_array(); 
			return $row;
		}
		
function selectUserId($vname)
	{
		$sql="select id from `users` where `username`='$vname'";				
	    $result = $this->db->query($sql);
		$row = $result->row_array(); 
		//echo $this->db->last_query();
		return $row['id'];
	}

 function checkduplicaterc($data)
	{         
	
		$sql="select * from `users` where `username`=?";
		$query = $this->db->query($sql,array($data['reg']));
		if($query->num_rows()>0)
		return 'yes';
		else
		return 'no';
	}
	
function checkduplicateemail($data)
	{
		$sql="select * from `users` where `email_id`=? ";
		$query=$this->db->query($sql,array(trim($data['email'])));
		if($query->num_rows()>0)
			return 'yes';
		else
		  return 'no';
	}
	
 function adduser($data)	
	 {
		 
		 $activation_code = getRandomString();
		 $sql="insert into `users` (`first_name`,`last_name`,`username`,`email_id`,`password`,`state`,`activation_code`,`created`) values(?,?,?,?,?,?,?,?)";
		 $this->db->query($sql,array($data['fname'],$data['sname'],$data['reg'],$data['email'],MD5($data['pwd']),$data['state'],$activation_code,date('Y-m-d H:i:s')));   
		 
		 $user_id=$this->db->insert_id();
		 $sql_ride="insert into `rides` (`user_id`,`created`) values(?,?)";
		 $this->db->query($sql_ride, array($user_id,date('Y-m-d H:i:s')));
		 
	 	return $activation_code;
	 } 
	 
function updatebyemail($userdetail)	
	 {
		$activation_code=$userdetail['activation_code']; 	 
		//$data = array('created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s'));
		$data = array('modified'=>date('Y-m-d H:i:s'));
		$this->db->where('email_id',$userdetail['email'] );		
		$affectedFlag = $this->db->update('users',$data);
	 	return $activation_code;
	 } 	 
function updatebyemailnew($userdetail)	
	 {
		$activation_code=$userdetail['activation_code']; 	 
		//$data = array('created'=>date('Y-m-d H:i:s'),'modified'=>date('Y-m-d H:i:s'));
		$data = array('modified'=>date('Y-m-d H:i:s'));
		$this->db->where('email_id',$userdetail['email_id'] );		
		$affectedFlag = $this->db->update('users',$data);
	 	return $activation_code;
	 } 	
	  
function activate($userData)
    {		
		
		//$sql1="select * from `users` where `email_id`=? and `activation_code`=?";
		//$query=$this->db->query($sql1,array($userData['email'],$userData['activation_code']));
		$this->db->where('id',$userData['id']);
        $this->db->where('activation_code',$userData['activation_code']);
		$query = $this->db->get('users');		
		//echo '<br>'.$this->db->last_query();		
		
		if($query->num_rows()==0)   
			return 'not found';
		
		    
		$row =$query->row_array();
		if($row['status']==1){			
		 return 'active'; 
		     
		}
			
	     $createddate = $userData['date'];     
		 $currentdate =date('Y-m-d H:i:s');
		 $hourdiff = (strtotime($currentdate) - strtotime($createddate))/3600;
	     
		 
		 ////////Get minutes for testing
		 /*$to_time = strtotime($currentdate);
$from_time = strtotime($createddate);
  $hourdiff =round(abs($to_time - $from_time) / 60,2);
		 /////////*/
		 
		 
	    if($hourdiff<24)
		{ 
			$data = array('status' =>1,'modified'=>date('Y-m-d H:i:s'));
			$this->db->where('id',$userData['id'] );
			$this->db->where('activation_code',$userData['activation_code'] );
			$affectedFlag = $this->db->update('users',$data);
			return 'found';
	    }
		 else
		{  		
			return 'expired';
	    }
		
    }	 
	

///////////////////////////////////////////////////////	
	
function signin($data) 
	{
		  $sql="Select * from `users` where `rc_no` = ? and `password` = ? and `status`=?";
		  $query	=	$this->db->query($sql,array($data['registration-email'],MD5($data['pwd']),'1'));
		 // echo $this->db->last_query();
		 $row=array();
		  if ($query->num_rows() > 0)
			  {		
				  $row = $query->row_array(); 
				  return $row;
			  }
			  else
			  {
				 $sql1="Select * from `users` where `rc_no` = ? and `password` = ?";
		  		 $query1	=	$this->db->query($sql1,array($data['registration-email'],MD5($data['pwd'])));
				  $row = $query1->row_array(); 
				  if(!empty($row))
				  {
				  		if($row['status']==0)
							return 'not_active';
						elseif($row['status']==2)
							return 'blocked';
				  }
				  else	
				  return false;
			  }
	}
	
	
	function getForgotPasswordCode($email)
    {
		$sql = "SELECT `id`, `fname`, `lname` FROM `users` where `email` = ?";
		$query	=	$this->db->query($sql,array($email));
		//echo $str = $this->db->last_query();
		if ($query->num_rows() > 0)
				{					
					$row = $query->row_array(); 
		
					// set forgotten_password_code
					$forgotten_password_code =getRandomString();	
					$row['forgot_password_code'] = $forgotten_password_code;
					
					$sql1 = "UPDATE `users` set `forgot_password_code`=?,`code_used`='0' 	where `email`=?";
					$this->db->query($sql1,array($forgotten_password_code, $email));
					//echo $str = $this->db->last_query();
					$affectedFlag = $this->db->affected_rows();			
					
					if($affectedFlag>0)
						return $row;
					else
						return $affectedFlag;
					
				}
		else
				{
					return false;
				}
    }	
	
	function getUsernameByEmailPasswordCode($userData)
	{
		
		$sql = "SELECT `fname`,`lname` FROM `users` where `id` = ?  and `email` = ? and `forgot_password_code` = ? and `code_used`='0'";
		$query	=	$this->db->query($sql,array($userData['id'],$userData['email'],$userData['forgot_password_code']));
		$str = $this->db->last_query();
		if ($query->num_rows() > 0)
		{					
			$row = $query->row_array(); 			
			return $row;
		}
		else
		{
			return false;
		}
		
	}
	
	function resetpassword($userData)
	{
		$sql = "UPDATE `users` set `password`=? ,`code_used`='1' where `id`=?  and `email`=? and `forgot_password_code`=?";
		$this->db->query($sql,array(MD5($userData['password']),$userData['id'],$userData['email'],$userData['forgot_password_code']));
		//echo $str = $this->db->last_query();
		$affectedFlag = $this->db->affected_rows();			
		
		if($affectedFlag>0)
			return $userData;
		else
			return $affectedFlag;	
	}
	
	
	function check_basic_details($id)
	{
		$basic_v=0;
		$basic_p=0;
		
		$sql_v="select * from `rides` where `type`!='' and `brand`!='' and `model`!='' and `user_id`=?";
		$query_v=$this->db->query($sql_v,array($id));
		//echo $this->db->last_query();
		if($query_v->num_rows()>0)
			$basic_v=1;
		
		$sql_p="select * from `personal` where `dob`!='' and `phone`!='' and `gender`!='' and `user_id`=?";
		$query_p=$this->db->query($sql_p,array($id));
		
		if($query_p->num_rows()>0)
			$basic_p=1;
			
		if($basic_v==0)
			return 'basic-v';
		else
		{
			if($basic_p==0)	
				return 'basic-p';
			else
				return 'wall';	
		}		
	}
	

///////////////////////////////////////////////////////////////////
function userlogin($username,$password)	{
	$pwd=MD5($password);
	//$this->db->where('username',$username && 'password',$pwd);
	//$result =$this->db->get('users');
	//$result = $this->db->query("select * from users where username = '$username' and password = '$pwd' && status=1");
	$result = $this->db->query("select * from users where username = '$username' and password = '$pwd' ");    		
	return $result;
	}

///////////////////////////////////////////////////////////////////
// function gerifriend(){
		        
	// $userdata = $this->session->userdata('User');
	// $userid =$userdata['username'];
	// $result = $this->db->query("SELECT * FROM users INNER JOIN friends ON users.username = friends.user_id WHERE friends.user_id = $userid");
	// return $result;
	// }
	
///////////////////////////////////////////////////////////////////
function geri_frd_count_list($userid){ 
		         
	//$result = $this->db->query("Select count(*) as Totalfrd from users Join friends on users.id = friends.friend_id where friends.user_id=$userid && friends.gedi_status = 1");
	$result = $this->db->query("Select count(*) as Totalfrd from users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && friends.status=1 && friends.gedi_status = 1");
	return $result->result_array();	
	} 
///////////////////////////////////////////////////////////////////
function geri_frd_list($userid){        
	
	//$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id WHERE friends.user_id ='".$userid."' && friends.gedi_status = 1 Group by users.id");
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && friends.status=1 && friends.gedi_status = 1"); 

	return $result->result_array();	
	}
///////////////////////////////////////////////////////////////////
function frd_of_frd_list($userid){      
	
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && friends.status=1 ");
	return $result->result_array();	
	}	
	
///////////////////////////////////////////////////////////////////
function show_geri_frd_list($userid){      
	
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && friends.status=1 && friends.gedi_status = 1");
	return $result->result_array();	
	}	
///////////////////////////////////////////////////////////////////
function count_show_geri_frd_list($userid){      
	
	$result = $this->db->query("SELECT count(*) as gedifrd FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && friends.status=1 && friends.gedi_status = 1");
	return $result->result_array();	
	}	
///////////////////////////////////////////////////////////////////
function get_friend($frdid,$userid){      
	
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id WHERE friends.user_id =$frdid && friends.gedi_status = 1 && friend_id=$userid");
	return $result->result_array();	
	}	
///////////////////////////////////////////////////////////////////
function search_frd_list($sdata,$userid){      
	
	//$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id =$userid && friends.gedi_status = 0 && first_name LIKE '$sdata%' ");
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id =$userid && friends.gedi_status = 0 && (first_name LIKE '$sdata%') ");
	//$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='.$userid.' && friends.gedi_status = 0 && first_name LIKE '$sdata%'");
	return $result->result_array();	
	}
///////////////////////////////////////////////////////////////////
function search_frd_list_reg($regtags,$userid){      
	
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id =$userid && friends.gedi_status = 0 && (username LIKE '$regtags%') ");
	return $result->result_array();	
	}
///////////////////////////////////////////////////////////////////
function searchresult($userid,$flname,$modelname){      
	
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && (first_name LIKE '".$flname."%' ||  model LIKE '".$modelname."%') Group by users.id ");
	
	return $result->result_array();	 
	}
///////////////////////////////////////////////////////////////////
function searchresult_model($userid,$modelname){      
	
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && (rides.model LIKE '".$modelname."%') Group by users.id ");
	
	return $result->result_array();	 
	}
///////////////////////////////////////////////////////////////////
function searchresult_fname($userid,$flname){      
	
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && (users.first_name LIKE '".$flname."%') Group by users.id ");
	
	return $result->result_array();	 
	}	
///////////////////////////////////////////////////////////////////
// function ($userid){
		        
	// $result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && friends.status=1 Limit 10");
	// return $result->result_array();	
	// }	
///////////////////////////////////////////////////////////////////
function ride_geri_frd_list($userid){
		        
	
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id WHERE friends.user_id =$userid && friends.gedi_status = 0");
	return $result->result_array();	
	}
///////////////////////////////////////////////////////////////////
function geri_frd_list_count($userid){
		        
	
	$result = $this->db->query("SELECT count(*) as frdcount FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id WHERE friends.user_id =$userid && friends.gedi_status = 1");
	return $result->result_array();	
	}	
	
///////////////////////////////////////////////////////////////////
function frd_list($userid){
		        
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id  WHERE friends.user_id ='".$userid."' Group by users.id "); 
	return $result->result_array();	
	}

function frd_listc($userid){
		        
	$result = $this->db->query("SELECT count(*)  as cfl FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id WHERE friends.user_id ='".$userid."' Group by users.id "); 
	return $result->result_array();	
	}

///////////////////////////////////////////////////////////////////
function fuid($userid){
		        
	$result = $this->db->query("select id from users where username ='".$userid."'");
	return $result->result_array();	
	}	
	
//////////////////////////////////////////////////////////////////	
function deletefriend($userid,$id){
			$this->db->where('friend_id', $id);
			$this->db->where('user_id', $userid);
			$this->db->delete('friends');
		}	
///////////////////////////////////////////////////////////////////
function all_frd_list($userid){
	
	$friendList=friendList($userid);
	
	$sql="select `users`.`id`, `users`.`first_name`, `users`.`last_name`, `users`.`username`, `users`.`gendor`, `users`.`city`, `users`.`state`, `users`.`occupation`, `users`.`course`, `users`.`college`,`rides`.`make`,`rides`.`model` from `users` JOIN `rides` ON (`users`.`id`=`rides`.`user_id`)  where `users`.`id` IN('".implode("','",$friendList)."')";
	$result = $this->db->query($sql);
	//echo $this->db->last_query();
	return $result->result_array();	
	} 
///////////////////////////////////////////////////////////////////
function all_userlist($userid){
		        
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN rides ON users.id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE users.username  NOT IN ( '".$userid."' ) Group by users.id Limit 10");
	return $result->result_array();	
	}	
///////////////////////////////////////////////////////////////////
function notificationlist($userid){
		        
	//$result = $this->db->query("");
	//return $result->result_array();	
	}		
///////////////////////////////////////////////////////////////////
function count_compliments($userid){
		        
		$this->db->where('user_id',$userid);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get('compliements');
	    return $query->result_array();
	
	}	
	
///////////////////////////////////////////////////////////////////
function getemailbyid($userid)
{
	$this->db->where('id',$userid);	
		$query = $this->db->get('users');
	    return $query->result_array();
}
function getdetailbyemail($userid){
		        
		$this->db->where('email_id',$userid);	
		$query = $this->db->get('users');
	    return $query->result_array();
	
	}	
		
///////////////////////////////////////////////////////////////////
function count_horns($userid){
		        
		$this->db->where('user_id',$userid);
		$this->db->where('status',1);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$this->db->select('horn');
		$query = $this->db->get('photos');
	    return $query->result_array();
	
	}
///////////////////////////////////////////////////////////////////
function segmentdetail($userid){
		        
		$this->db->where('id',$userid);	
		$query = $this->db->get('users');
	    return $query->result_array(); 
	
	}	
///////////////////////////////////////////////////////////////////
function popularide(){
		        
		 
		$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN rides ON users.id = rides.user_id JOIN ride_images ON rides.user_id = ride_images.user_id  GROUP BY users.id  order by rides.flashes Desc Limit 6");
		//echo $this->db->last_query();    
		return $result->result_array(); 
	}
	
///////////////////////////////////////////////////////////////////

function browse_ride_radius($data)
	{
		if($data['city']!='' && $data['km']!=0 && $data['km']!='' && $data['locationSearch']==1)
		{
			$sqlCity="select * from `cities` where `id`='".$data['city']."'";
			$queryCity=$this->db->query($sqlCity);
			$resCity=$queryCity->row_array();
			
			$sqlMap="SELECT id, ( 6371 * acos( cos( radians(".$resCity['latitude'].") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$resCity['longitude'].") ) + sin( radians(".$resCity['latitude'].") ) * sin( radians( latitude ) ) ) ) AS distance FROM `cities`   HAVING distance < ".$data['km']." ORDER BY distance";
			$queryMap=$this->db->query($sqlMap);
			//echo $this->db->last_query();
			$queryMapRes=$queryMap->result_array();
			//see($queryMapRes);
			return $queryMapRes;
		}
		else
			return array();
	
		/*$userdetail =userSession();
		$getUserInfo=getUserInfo($userdetail['id']);
		//$getUserInfo['lat']=$getUserInfo['lng']=0.00000000;
		if($getUserInfo['lat']!=0 && $data['km']!=0)
		{
			$sqlMap="SELECT id, ( 6371 * acos( cos( radians(".$getUserInfo['lat'].") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$getUserInfo['lng'].") ) + sin( radians(".$getUserInfo['lat'].") ) * sin( radians( lat ) ) ) ) AS distance FROM `users` where `status`=1 and `first_login`=1 and `users`.`role`!='admin' and `users`.`id`!='".$userdetail['id']."'  HAVING distance < ".$data['km']." ORDER BY distance";
			$queryMap=$this->db->query($sqlMap);
			$queryMapRes=$queryMap->result_array();
			//see($queryMapRes);
			return $queryMapRes;
		}
		else
			return array();*/
	}

function browse_ride_count($data){	        
		 $userdetail =userSession();
		 $blockedMe=whoBlockedMe();
		
		$sql="select `rides`.*, `users`.`username`, `users`.`first_name`, users.city,users.state, `users`.`last_name`,`users`.`gendor`,`users`.`DOB`,users.email_id  from `rides` JOIN `users` ON(`rides`.`user_id`=`users`.`id`)  where"; 
		
		if($data['brand']!='0')
			$sql .=" `rides`.`make`='".$data['brand']."' and ";
		
		if( $data['model']!='0')
			$sql .=" `rides`.`model` like '%".$data['model']."%' and ";	
			
		if($data['type']!='0')
			$sql .=" `rides`.`type`='".$data['type']."' and ";
		
		if(trim($data['year_model'])!='')
			$sql .=" `rides`.`year_model`='".$data['year_model']."' and ";	
			
		/*if(trim($data['state'])!='0')
			$sql .=" `users`.`state`='".$data['state']."' and ";	
			
		if(trim($data['city'])!='')
			$sql .=" `users`.`city` like '%".$data['city']."%' and ";*/
			
			if(trim($data['first_name'])!='')
			$sql .=" `users`.`first_name` like '%".$data['first_name']."%' and ";
				
				if(trim($data['sur_name'])!='')
			$sql .=" `users`.`last_name` like '%".$data['sur_name']."%' and ";
			
			if(trim($data['gender'])!='0')
			$sql .=" `users`.`gendor`='".$data['gender']."' and ";
			
			/*if(trim($data['email'])!='')
			$sql .=" `users`.`email_id` like '%".$data['email']."%' and ";*/
				
					if(($data['vehiclenumber'])=='1')
			$sql .=" `users`.`username` like '".$data['vehicle_number']."%' and ";
			
			if(($data['vehiclenumber'])=='2')
			$sql .=" `users`.`username` like '%".$data['vehicle_number']."' and ";
			
			if(($data['vehiclenumber'])=='3')
			$sql .=" `users`.`username` like '%".$data['vehicle_number']."%' and ";
			
			if(($data['age_range'])!='0'){
				$getDobByAgeRange=getDobByAgeRange($data['age_range']);
			$sql .=" `users`.`DOB` <='".$getDobByAgeRange[0]."'and `users`.`DOB`>'". $getDobByAgeRange[1]." 'and ";
			}
			
			if(!empty($blockedMe))
			$sql.=" `rides`.`user_id` NOT IN('".implode("','",$blockedMe)."') and";
		
		$sql .=" `rides`.`user_id`!='".$userdetail['id']."' and `users`.`status`!='0' and `users`.`first_login`='1'   and `users`.`role`!='admin'";		
		
		if($data['locationSearch']==1)
		{
			$sql .=" and  `users`.`city` IN(".implode(',',$data['browse_ride_radius']).")";
		}
		//echo 	$sql;
		
		$query=$this->db->query($sql);
		//echo $this->db->last_query().'<br>';
		return $query->num_rows();
	}
	
function browse_ride($data,$queryInput){	        
		
		$userdetail =userSession();
		$blockedMe=whoBlockedMe();
		
		$sql="select `rides`.*, `users`.`username`, `users`.`first_name`, `users`.`last_name`, users.city, users.state,`users`.`gendor`,`users`.`DOB`,users.email_id, `users`.`lat`, `users`.`lng` from `rides` JOIN `users` ON(`rides`.`user_id`=`users`.`id`)   where";
		
		if($data['brand']!='0')
			$sql .=" `rides`.`make`='".$data['brand']."' and ";
		
		if( $data['model']!='0')
			$sql .=" `rides`.`model` like '%".$data['model']."%' and ";	
			
		if($data['type']!='0')
			$sql .=" `rides`.`type`='".$data['type']."' and ";
		
		if(trim($data['year_model'])!='')
			$sql .=" `rides`.`year_model`='".$data['year_model']."' and ";	
			
		/*if(trim($data['state'])!='0')
			$sql .=" `users`.`state`='".$data['state']."' and ";	
			
		if(trim($data['city'])!='')
			$sql .=" `users`.`city` like '%".$data['city']."%' and ";*/
			
			if(trim($data['first_name'])!='')
			$sql .=" `users`.`first_name` like '%".$data['first_name']."%' and ";
				
				if(trim($data['sur_name'])!='')
			$sql .=" `users`.`last_name` like '%".$data['sur_name']."%' and ";
			
			if(trim($data['gender'])!='0')
			$sql .=" `users`.`gendor`='".$data['gender']."' and ";
			
			/*if(trim($data['email'])!='')
			$sql .=" `users`.`email_id` like '%".$data['email']."%' and ";*/
				
				if(($data['vehiclenumber'])=='1')
			$sql .=" `users`.`username` like '".$data['vehicle_number']."%' and ";
			
			if(($data['vehiclenumber'])=='2')
			$sql .=" `users`.`username` like '%".$data['vehicle_number']."' and ";
			
			if(($data['vehiclenumber'])=='3')
			$sql .=" `users`.`username` like '%".$data['vehicle_number']."%' and ";
			
				if(($data['age_range'])!='0'){
				$getDobByAgeRange=getDobByAgeRange($data['age_range']);
			$sql .=" `users`.`DOB` <='".$getDobByAgeRange[0]."'and `users`.`DOB` >'". $getDobByAgeRange[1]." 'and ";
			}
			
		if(!empty($blockedMe))
			$sql.=" `rides`.`user_id` NOT IN('".implode("','",$blockedMe)."') and";
		
		$sql .=" `rides`.`user_id`!='".$userdetail['id']."'  and `users`.`status`!='0' and `users`.`first_login`='1'   and `users`.`role`!='admin'  ";
		
		if($data['locationSearch']==1)
		{
			$sql .=" and `users`.`city` IN(".implode(',',$data['browse_ride_radius']).")  ORDER BY FIELD( `users`.`id`, ".implode(',',$data['browse_ride_radius']).")";
		}
	
		$sql .=" limit ".$queryInput['page'].",".$queryInput['limit'] ;	
		
		$query=$this->db->query($sql);
		//echo $this->db->last_query().'<br>';
		
	 $res =$query->result_array();
	 //see($res);
	 return $res;
	}	
	
///////////////////////////////////////////////////////////////////

function browse_people($data,$offset,$result_per_page){	        
		 
		$sql="SELECT `u`.*, `r`.`model` FROM `users` u JOIN `rides` r ON(`u`.`id`=`r`.`user_id`)  where ";

		if(trim($data['fname'])!='')
			$sql .=" `u`.`first_name` like '%".$data['fname']."%' and ";	
		
		if(trim($data['surname'])!='')
			$sql .=" `u`.`last_name` like '%".$data['surname']."%' and ";
		
		if($data['gender']!='0')
			$sql .=" `u`.`gendor`='".$data['gender']."' and ";
			
		if($data['occupation']!='0')
			$sql .=" `u`.`occupation`='".$data['occupation']."' and ";
		
		if($data['state']!='0')
			$sql .=" `u`.`state`='".$data['state']."' and ";	
			
		if(trim($data['city'])!='')
			$sql .=" `u`.`city` like '%".$data['city']."%' and ";		
		
		$userdetail =userSession();
		$sql .=" `u`.`id`!='".$userdetail['id']."' limit ".$offset.', '.$result_per_page;					
			
		$result = $this->db->query($sql);
	    return $result->result_array();	
	}	

function browse_people_count($data){
		        
		$sql="SELECT `u`.*, `r`.`model` FROM `users` u JOIN `rides` r ON(`u`.`id`=`r`.`user_id`)  where ";
		
		if(trim($data['fname'])!='')
			$sql .=" `u`.`first_name` like '%".$data['fname']."%' and ";	
		
		if(trim($data['surname'])!='')
			$sql .=" `u`.`last_name` like '%".$data['surname']."%' and ";
		
		if($data['gender']!='0')
			$sql .=" `u`.`gendor`='".$data['gender']."' and ";
			
		if($data['occupation']!='0')
			$sql .=" `u`.`occupation`='".$data['occupation']."' and ";
		
		if($data['state']!='0')
			$sql .=" `u`.`state`='".$data['state']."' and ";	
			
		if(trim($data['city'])!='')
			$sql .=" `u`.`city` like '%".$data['city']."%' and ";	
			
		$userdetail =userSession();
		$sql .=" `u`.`id`!='".$userdetail['id']."'";	
		
		$result = $this->db->query($sql);
		//echo $this->db->last_query();
		return $result->num_rows();
	}


		
///////////////////////////////////////////////////////////////////
function user_list_blow_horn(){
		        
		
		$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN horns ON users.id = horns.user_id JOIN photos ON photos.id = horns.pic_id  WHERE photos.id = 1");
	    return $result->result_array();
	
	}	
		
///////////////////////////////////////////////////////////////////
function frd_list_to_add($userid){
		        
	$result = $this->db->query("SELECT *,users.id as usersid FROM users JOIN friends ON users.id = friends.friend_id JOIN rides ON friends.friend_id = rides.user_id JOIN ride_images ON users.username = ride_images.user_id WHERE friends.user_id ='".$userid."' && friends.gedi_status = 0 GROUP By users.id ");
	return $result->result_array();	
	}
	 
///////////////////////////////////////////////////////////////////	
	function frd_list_to_add_new($userid,$queryString,$code){
	
	$friendList=friendList($userid);
	
	$sql="select `users`.`id` as `user_id`, `users`.`first_name`, `users`.`last_name`, `users`.`username`, `users`.`gendor`, `users`.`city`, `users`.`state`, `users`.`occupation`, `users`.`course`, `users`.`college`,`rides`.`make`,`rides`.`model` from `users` JOIN `rides` ON (`users`.`id`=`rides`.`user_id`)  where `users`.`id` IN('".implode("','",$friendList)."')";
	
	if($code=='name')
		$cmn_whr=" and (`users`.`first_name` LIKE '%".$queryString."%'  OR `users`.`last_name` LIKE '%".$queryString."%'  OR CONCAT(`users`.`first_name`,' ',`users`.`last_name`)LIKE '%".$queryString."%'  OR `users`.`email_id` LIKE '%".$queryString."%' ) ";
	elseif($code=='uname')	
		$cmn_whr=" and ( `users`.`username` LIKE '%".$queryString."%') ";
		
	$sql .=$cmn_whr;
	$query=$this->db->query($sql);
	//echo $this->db->last_query();
	$result=$query->result_array();
	//see($result);
	return $result;	
	}
	
///////////////////////////////////////////////////////////////////	
	function frd_list_to_header($input){
	$queryString=trim($input);
	$userdetail =userSession();
	$blockedMe=whoBlockedMe();
	//$sql="SELECT *,users.id as usersid FROM users LEFT JOIN rides ON users.id= rides.user_id  WHERE (users.first_name LIKE '%".$queryString."%'  OR users.last_name LIKE '%".$queryString."%'  OR CONCAT(users.first_name,' ',users.last_name )LIKE '%".$queryString."%'  OR users.email_id LIKE '%".$queryString."%' OR users.username LIKE '%".$queryString."%') and `users`.`id`!='".$userdetail['id']."'  and `users`.`status`!='0' ";
	$sql="SELECT *,users.id as usersid FROM users LEFT JOIN rides ON users.id= rides.user_id  WHERE ( users.username LIKE '%".$queryString."%') and `users`.`id`!='".$userdetail['id']."'  and `users`.`status`!='0' and `users`.`first_login`!='0' and `users`.`role`!='admin' ";
	
	if(!empty($blockedMe))
		$sql.=" and `rides`.`user_id` NOT IN('".implode("','",$blockedMe)."')";
	
	$sql .=" limit 6";
			
	$result = $this->db->query($sql);
	//echo $this->db->last_query()."<br>";
	return $result->result_array();	
	}				
//////////////////////////////////////////////////////////////////	
function user_detail($userid){		
		$this->db->where('id',$userid);	  
		$query = $this->db->get('users');
		//echo $this->db->last_query().'<br>';
		 return $query->result_array();		
	}
//////////////////////////////////////////////////////////////////	
function otheruser_detail($userid){		
		$this->db->where('id',$userid);	  
		$query = $this->db->get('users');
		//echo $this->db->last_query();
		 return $query->result_array();	
	}	
//////////////////////////////////////////////////////////////////	
function ride_detail($userid){	
	
		$this->db->where('user_id',$userid);
		$this->db->order_by('id','desc');
		$this->db->limit(1);		
		$query = $this->db->get('rides');
		 return $query->result_array();
				
	
	}
	
//////////////////////////////////////////////////////////////////	
/*function ride_detail_others($userid){	
	
		$this->db->where('user_id',$userid);
		$this->db->order_by('id','desc');
		$this->db->limit(1);		
		$query = $this->db->get('rides');
		 return $query->result_array();
				
	
	}*/	
//////////////////////////////////////////////////////////////////	
function ride_image($userid){	
	
		$this->db->where('user_id',$userid);	  
		$query = $this->db->get('ride_images');
		return $query->result_array();
	}	
	
	
	
///////////////////////////////////////////////////////////	
function ride_image_others($userid){	
	
		//$this->db->where('user_id',$userid);	  
		//$query = $this->db->get('ride_images');		
		$sql = "SELECT * from `photos` where `user_id`=? and `pic_type`=? and `default`=?";
		$query=$this->db->query($sql,array($userid,'2','1'));
		$res=$query->row_array();
	     return $res;	
		// return $query->result_array();		
	
	}	
	function user_image_others($userid){	
	
		//$this->db->where('user_id',$userid);	  
		//$query = $this->db->get('ride_images');		
		$sql = "SELECT * from `photos` where `user_id`=? and `pic_type`=? and `default`=?";
		$query=$this->db->query($sql,array($userid,'1','1'));
		$res=$query->row_array();
	     return $res;	
		// return $query->result_array();		
	
	}	
///////////////////////////////////////////////////////////////////////////////
function ride_info($id)  
	{
		 
		$sql="select * from `rides` where `user_id`=?";
		$query=$this->db->query($sql,array($id));		
		$result=array();
		if($query->num_rows()>0)
			$result=$query->row_array();
		return $result;	
	}	


		
///////////////////////////////////////////////////////////////////
function count_photos($userid){	
	
	$sql_photo="select * from `photos` where `user_id` ='".$userid."'";
	$res_photo = $this->db->query($sql_photo);
	//echo $this->db->last_query();
	$photos =$res_photo->num_rows();
	return $photos;	
	}

///////////////////////////////////////////////////////////////////
function statuspic($userid){	
	
	$result = $this->db->query("Select *  from  photos where user_id ='".$userid."' && status=1 && pic_type=3  order by id Desc Limit 1");
	//echo $this->db->last_query();
	return $result->result_array();;
	}
///////////////////////////////////////////////////////////////////
function countnewstatus_complts($userid,$picid){	
	
	$result = $this->db->query("Select count(*) as c_com from  compliements where friend_id ='". $userid."' && photo_id='".$picid."'");
	return $result->result_array();;
	}

//////////////////////////////////////////////////////////////////
function insert($data){

$sql=" select * from blocks where user_blocked=? and blocked_by=? ";	
			   $query=$this->db->query($sql,array($data['user_id'],$data['friend_id']));
			   $res=$query->result_array();
			   if(empty($res))
			   {
			$this->db->insert('messages',$data);			
			return $this->db->insert_id();
			}
		}
function replymsginsert($data){
			$this->db->insert('messages',$data);			
			return $this->db->insert_id();
		}		
//////////////////////////////////////////////////////////////////
function insertfeature($data){
			$this->db->insert('accessories',$data);			
			return $this->db->insert_id();
		}
//////////////////////////////////////////////////////////////////
function insertfriend($data){
			$this->db->insert('friends',$data);			
			return $this->db->insert_id();
		}	  	
//////////////////////////////////////////////////////////////////
function remove_friend($data,$user_id,$friend_id){

			$this->db->where('friend_id',$friend_id );
			$this->db->where('user_id',$user_id);	
			$this->db->update('friends',$data);			
		}
		
//////////////////////////////////////////////////////////////////
function confirmfriend($userid,$frdid,$cfuname,$luserid){
			//$query = $this->db->query("UPDATE friends SET status='1' WHERE (user_id='".$userid."' AND friend_id='".$frdid."' ) OR (user_id='".$cfuname."' AND friend_id='".$luserid."') ");
			$query = $this->db->query("UPDATE friends SET status='1' WHERE (user_id='".$luserid."' AND friend_id='".$frdid."' ) OR (user_id='".$frdid."' AND friend_id='".$luserid."') ");
						
		}		
//////////////////////////////////////////////////////////////////
function cancel_friend_request($user_id,$friend_id,$rfuname,$luserid){
		
			$sql="DELETE FROM friends WHERE (user_id='".$friend_id."' AND friend_id='".$luserid."' ) OR (user_id='".$luserid."' AND friend_id='".$friend_id."')";
			$query = $this->db->query($sql);		
		}
//////////////////////////////////////////////////////////////////
function frd_request($userid){
			$sql_cmn="select `friends`.*, `users`.`first_name`, `users`.`last_name`, `users`.`username`, `users`.`gendor`, `users`.`city`, `users`.`state`, `users`.`occupation`, `users`.`course`, `users`.`college`,`rides`.`make`,`rides`.`model` from `friends` ";
			$sql=$sql_cmn . "  JOIN `users` ON (`friends`.`user_id`=`users`.`id`) JOIN `rides` ON (`friends`.`user_id`=`rides`.`user_id`)   where `friends`.`friend_id`='".$userid."'  and `friends`.`status`='2'  ";
			
			$query = $this->db->query($sql);
			//echo '<br>'.$this->db->last_query();
			return $query->result_array();;		
		}
			
				
//////////////////////////////////////////////////////////////////
function add_frnd_to_circle($data,$user_id,$friend_id){

			$this->db->where('friend_id',$friend_id );
			$this->db->where('user_id',$user_id);	
			$this->db->update('friends',$data);			
		}
//////////////////////////////////////////////////////////////////
function getfrnddata($user_id,$friend_id){
			$this->db->select('*');
			$this->db->where('friend_id',$friend_id );
			$this->db->where('user_id',$user_id);	
			$query = $this->db->get('friends');
			return $query->result_array();	
		}
//////////////////////////////////////////////////////////////////
function replymsgdetail($friend_id){
			$this->db->select('*');
			$this->db->where('id',$friend_id );			
			$query = $this->db->get('messages');
			return $query->result_array();	
		}		
//////////////////////////////////////////////////////////////////
function remove_frnd_from_circle($data,$user_id,$friend_id){

			$this->db->where('friend_id',$friend_id );
			$this->db->where('user_id',$user_id);	
			$this->db->update('friends',$data);			
		}
/////////////////////////////////////////////////////////////////
function delete_message($id){
	
			$LoggedInUser=userSession();
			
			$sql="select * from `messages` where `id`='".$id."' and (`friend_id`=? or `user_id`=?)";
			$query=$this->db->query($sql,array($LoggedInUser['id'],$LoggedInUser['id']));
			if($query->num_rows()>0)
			{
				$msgInfo=$query->row_array();
				if($msgInfo['user_id']==$LoggedInUser['id'])//if m sender
				{
					$sql_up="update `messages` set `del_from`='1' where `id`='".$id."'";
					$this->db->query($sql_up);
				}
				elseif($msgInfo['friend_id']==$LoggedInUser['id'])//if m receiver
				{
					$sql_up="update `messages` set `del_to`='1' where `id`='".$id."'";
					$this->db->query($sql_up);
				}
			}
			
			$sql="delete from `messages` where `id`='".$id."' and `del_from`='1' and `del_to`='1'";
			$query=$this->db->query($sql);
		}		
	
/////////////////////////////////////////////////////////////////
function delete_allmessage($id,$userid){
			$this->db->where('user_id', $id);
			$this->db->where('friend_id',$userid);
			$this->db->delete('messages');
		}		
		
//////////////////////////////////////////////////////////////////	
function friendrequeststatus($userid,$loginuid){	
		
		 
		$result = $this->db->query("select status from friends where friend_id = '".$userid."'  && user_id = '".$loginuid."' limit 1");		
		 return $result->result_array();
				
	
	}		
/////////////////////////////////////////////////////////////////
function get_ride_id($user_id){
			
			$result = $this->db->query("select id from rides where user_id = '".$user_id."'");
			return $result->result_array();   
		}

/////////////////////////////////////////////////////////////////
function ride_info_feature_others($user_id){
			
			$result = $this->db->query("select * from accessories where user_id ='". $user_id."'");			
			return $result->result_array();   
		}		

///////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////
function count_friendsnew($userid,$user_id){	
	
	$result = $this->db->query("select COUNT(friends.id) as cfriends from friends WHERE (friends.user_id ='".$user_id."' && friends.status=1) OR (friends.friend_id='".$user_id."' AND friends.status=1 ) ");
	//echo $this->db->last_query();
	return $result->result_array();
	}	
	
///////////////////////////////////////////////////////////////////
function friendlist($userid){	
	
	$result = $this->db->query("SELECT friend_id FROM friends WHERE user_id ='".$userid."' && block_status =0");
	return $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
// function friendlist_addgericircle($userid){	
	
	// $result = $this->db->query("SELECT friend_id FROM friends WHERE user_id =$userid && block_status =0 && geri_status=0");
	// foreach($result as $result){ 
	// $result['firend_id'];
	// $newresult .= $this->db->query("SELECT * FROM users WHERE friend_id =$result['firend_id']");
	// }
	// return $newresult->result_array();
	// }	
	
//////////////////////////////////////////////////////////////////	
function watch_image($userid){	
	
		$this->db->where('user_id',$userid);
		$this->db->where('pic_type',3);	
		$this->db->order_by('id','desc');
		$this->db->limit(1);  
		$query = $this->db->get('photos');
		return $query->result_array();	
	}
	
//////////////////////////////////////////////////////////////////	
function fleshcheck($userid,$friendid){	
		$this->db->where('userid',$userid);
		$this->db->where('friendid',$friendid);	
		$query = $this->db->get('flashes');
		return $query->result_array();	
	}
//////////////////////////////////////////////////////////////////	
function frndcheck($username,$userid,$fname,$fid){
		//$this->db->select('status');
		//$this->db->where('friend_id',$userid);
		//$this->db->where('user_id',$username);			
		//$query = $this->db->get('friends');
		$query = $this->db->query("SELECT status FROM friends WHERE (user_id='".$username."' AND friend_id='".$userid."' ) OR (user_id='".$fname."' AND friend_id='".$fid."')");		
		return $query->result_array();	
	}		
///////////////////////////////////////////////////////////////////
function msglist($username,$userid){		
   //$result = $this->db->query("SELECT user_id FROM messages WHERE friend_id ='".$userid."'");	
   // $result = $this->db->query("SELECT * , users.id AS usersid
				// FROM users
				// JOIN messages ON users.id = messages.user_id
				// JOIN rides ON messages.user_id = rides.user_id
		 		// JOIN ride_images ON users.username = ride_images.user_id
				// WHERE messages.friend_id = '".$userid."' ORDER BY messages.id DESC Limit 15");
   $result = $this->db->query("SELECT * , users.id AS usersid
				FROM users
				JOIN messages ON users.username = messages.friend_id
				JOIN rides ON messages.user_id = rides.user_id
				JOIN ride_images ON users.username = ride_images.user_id
				WHERE messages.friend_id = '".$username."' OR messages.user_id ='".$userid."' 
				group by users.username  ORDER BY messages.id DESC Limit 15");
   return $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function frndmsg($loginuid,$userid,$loginuserid,$friendid){		
  
	
	$result = $this->db->query("SELECT * FROM (SELECT * FROM messages WHERE friend_id ='".$loginuid."'
AND user_id ='".$userid."' ORDER BY created ASC ) AS x UNION
SELECT * FROM ( SELECT * FROM messages WHERE friend_id ='".$friendid."'
AND user_id ='".$loginuserid."' ORDER BY created ASC ) AS x ORDER BY created ASC");
	return $result->result_array();
	}
	
///////////////////////////////////////////////////////////////////
// function msglist($userid){		
   // $result = $this->db->query("SELECT * FROM users WHERE id = $userid");	
   // return $result->result_array();
	// }
///////////////////////////////////////////////////////////////////
function login_user_detail($id){		
  
	/*$result = $this->db->query("SELECT profile_pic FROM users WHERE username = '".$id."'");
	return $result->result_array();*/
	}
///////////////////////////////////////////////////////////////////
function getlastrecord($username,$id){		
  
	$result = $this->db->query("SELECT MAX(ID) AS LastID,friend_id,user_id FROM messages where friend_id ='".$username."' or user_id ='".$id."'");
	return $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
function friend_user_detail($id){		
  
	$result = $this->db->query("SELECT profile_pic,first_name,last_name FROM users WHERE id = '".$id."'");
	return $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function get_sent_msg_user_id($id){		
  
	$result = $this->db->query("SELECT username FROM users WHERE id = '".$id."'");
	return $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
function friendusername($id){		
  
	$result = $this->db->query("select username from users where id='".$id."'");
	return $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
function msgcount($userid){	
	
	$result = $this->db->query("select *,COUNT(friend_id) as totalmsg from messages where friend_id ='".$userid."'  && status=0");	
	// $this->db->select('*,COUNT(messages.friend_id) as totalmsg');
	// $this->db->from('messages');
	// $this->db->join('users', 'messages.id = users.id');
	// $this->db->where('messages.friend_id',$userid);	
	// $this->db->where('messages.status',0);	
	// $result = $this->db->get();
	
	
	return $result->result_array();
	}	
//////////////////////////////////////////////////////////////////
function update($userid,$data){			
			$this->db->where('username', $userid);
			$this->db->update('users',$data);
			//echo $this->db->last_query();
		}
//////////////////////////////////////////////////////////////////
function insertuserstatus($userid,$data){			
			
			$this->db->insert('photos',$data);
			//echo $this->db->last_query();
			return $this->db->insert_id();
			redirect();
		}		
		
//////////////////////////////////////////////////////////////////
function updatemessage($fid,$uid){	
			$data =array('status'=>1);
			$this->db->where('friend_id', $fid);
			$this->db->where('user_id', $uid);
			$this->db->update('messages',$data);
		}		
//////////////////////////////////////////////////////////////////
function updateride($userid,$data){			
			$this->db->where('user_id', $userid);
			$this->db->update('ride_images',$data);
		}

//////////////////////////////////////////////////////////////////
function addride($data){
	
			$this->db->insert('ride_images',$data);			
			return $this->db->insert_id();
			
		}
			
/////////////////////////////////////////////////////////////////
function updateride_std($userid,$data){			
			$this->db->where('user_id', $userid);
			$this->db->update('rides',$data);
			//echo 'hello'.$this->db->last_query();
		}
/////////////////////////////////////////////////////////////////
function addride_std($data){			
			$this->db->insert('rides',$data);			
			return $this->db->insert_id();
			
		}		
/////////////////////////////////////////////////////////////////
function addflesh($data){
               $sql=" select * from blocks where user_blocked=? and blocked_by=? ";	
			   $query=$this->db->query($sql,array($data['userid'],$data['friendid']));
			   $res=$query->result_array();
			   if(empty($res))
			   {			
			$this->db->insert('flashes',$data);			
			return $this->db->insert_id();
			}
		}
		
/////////////////////////////////////////////////////////////////
function rflesh($userid,$frdid){			
			$this->db->where('userid', $userid);
			$this->db->where('friendid', $frdid);
			$this->db->delete('flashes');			
		}					
/////////////////////////////////////////////////////////////////
function blockProfile($userid,$sender_id){
            
            if(isset($_POST["block"]))
			{
				$check="select * from blocks where user_blocked=$userid and blocked_by=$sender_id ";
				$norows=$this->db->query($check);
				$res=$norows->result_array();
				
				if(empty($res))
				{
				$sql=" insert into blocks (user_blocked,blocked_by,date) values(?,?,?)";
				$this->db->query($sql,array($userid,$sender_id,date('Y-m-d H:i:s')));
				}
			}
			elseif(isset($_POST["unblock"]))
			{
				$sql=" delete from  blocks where user_blocked=? and blocked_by=?";
				$this->db->query($sql,array($userid,$sender_id));
			}
		}
		
function reportAbuse($userid,$sender_id,$abuse)
{
		   if(isset($_POST["report"]))
		   {
		   			  $sql=" insert into report_abuse (user_reported,reported_by,reason,date) values(?,?,?,?)";
					  $this->db->query($sql,array($userid,$sender_id,$abuse,date('Y-m-d H:i:s')));
			}
}

/////////////////////////////////////////////////////////////////
function fleshuserdetail($userid){				
			$this->db->select('flashes');
			$this->db->where('user_id',$userid);			
			$query = $this->db->get('rides');
			return $query->result_array();			
		}
/////////////////////////////////////////////////////////////////
function addfrdgc($userid,$data){			
			$this->db->where('friend_id',$userid);
			$this->db->update('friends',$data);
		}			

/////////////////////////////////////////////////////////////////
function updateflesh($userid,$data){			
			$this->db->where('user_id',$userid);
			$this->db->update('rides',$data);
		}	
//////////////////////////////////////////////////////////////////	
		
function friendsoffriends($user_id)
{
	//My friends
	$friendList=friendList($user_id);
	$fof=array();
	foreach($friendList as $k=>$fl)
	{
		//Friends of my friends
		$ff=friendList($fl);
		$me=array_search($user_id,$ff);//Rmoving myself
		unset($ff[$me]);
		
		$fof=array_merge($fof,$ff);
	}
	
	//see($fof);
	
	$result = array_intersect($friendList, $fof);
	//see($result);
	
	//Removing my friends from the list so that it gives me the list of those persons who are not my friends
	foreach($result as $rk=>$rv)
		unset($fof[$rk]);
	
	
	foreach($fof as $ffk=>$ffv)
	{
		if(friendshipStatus($user_id,$ffv)!=4)
			unset($fof[$ffk]);
	}
	//see($fof);
	if(empty($fof))
		return array();
	
	$sql="select `users`.`id`, `users`.`first_name`, `users`.`last_name`, `users`.`username`, `users`.`gendor`, `users`.`city`, `users`.`state`, `users`.`occupation`, `users`.`course`, `users`.`college`,`users`.`DOB`,`rides`.`make`,`rides`.`model` from `users` JOIN `rides` ON (`users`.`id`=`rides`.`user_id`)  where `users`.`id` IN('".implode("','",$fof)."')";
	$query=$this->db->query($sql);
	//echo $this->db->last_query();
	return $query->result_array();	
	
	//see($fof);	
	//return $fof;
}


function getFlashesNew($id)
{
$sql="select * from flashes where friendid=? ";
$query=$this->db->query($sql,$id);
$res=$query->result_array();
return count($res);
}


function getStatusUserMessages($friendid,$userid)
{
$sql="select * from messages where user_id=? and friend_id=? and `del_from`='0'";
$query=$this->db->query($sql,array( $userid,$friendid));
$res=$query->result_array();

$sql="select * from messages where user_id=? and friend_id=? and `del_to`='0' ";
$query=$this->db->query($sql,array( $friendid,$userid));
$res1=$query->result_array();

if((!empty($res))||(!empty($res1)))
{
return 'yes';
}

}


function makeSeen($id)
{
$sql="update flashes set seen='1' where friendid=?";
$query=$this->db->query($sql,$id);

}





	
		
function deleteconv($id)
{
	 $LoggedInUser=userSession();
	$sql="select * from `messages` where (`user_id`='".$id."' and `friend_id`='".$LoggedInUser['id']."') OR (`user_id`='".$LoggedInUser['id']."' and `friend_id`='".$id."')";
	$query=$this->db->query($sql);
	$msgs=$query->result_array();
	
	foreach($msgs as $msgK=>$msgV)
		  {
			  $this->delete_message($msgV['id']);
		  }
}





function get_block_status($id)
{

$userdata = userSession();	
	    $userid =$userdata['id'];
$sql="select * from blocks where user_blocked=? and blocked_by=? ";	
			   $query=$this->db->query($sql,array($userid,$id));
			   $res=$query->result_array();
			   return $res;
}
//////////////////////////////////////////////////////////////////	


/*function addNewVehicle($data,$brandModel)
	{
			   $userdata = userSession();	
	    	   $userid =$userdata['id'];
		
			   $sql="insert into `suggested_brands` (`type`,`suggestion`,`brand`,`model`,`user_id`,`date`) values(?,?,?,?,?,?)";
			   $query=$this->db->query($sql,array($data['vtype'],$brandModel,$data['brand'],$data['model'],$userid,date('Y-m-d H:i:s')));
			   return $this->db->insert_id();
	}*/
	
	function addNewVehicle($data,$brandModel)
	{
			   $userdata = userSession();	
	    	   $userid =$userdata['id'];

			  $brandArray=explode('-',$_POST['brand']);
			  $modelArray=explode('-',$_POST['model']);
			  if($brandModel=='brand')
				  $brand=$brandArray[1];
			  else	 
			  { 
			 	  //$brand=$brandArray[0]; 
				  $brand=$_POST['brand']; 
			  }
			  $model=$modelArray[1];
			  
			   $sql="insert into `suggested_brands` (`type`,`suggestion`,`brand`,`model`,`user_id`,`date`) values(?,?,?,?,?,?)";
			   $query=$this->db->query($sql,array($data['type'],$brandModel,$brand,$model,$userid,date('Y-m-d H:i:s')));
			   return 'suggestion-'.$this->db->insert_id();
	}
	
	function addNewVehicleDelete()
	{
			   $userdata = userSession();	
	    	   $userid =$userdata['id'];

			   $sql="delete from `suggested_brands` where `user_id`=? and `reviewed`=?";
			   $query=$this->db->query($sql,array($userid,'0'));
			  // echo $this->db->last_query();
	}

function delete_remember_cookie($id)
	{
	$sql="delete from `remember_cookies` where `user_id`='$id'";
	$this->db->query($sql);
	//echo $this->db->last_query();
	}

	//saving cookie
function remember_cookie($cookieemail,$cookieuserid)
	{	
	
	$sql = "INSERT INTO `remember_cookies` (user_id,cookie_name) 
							VALUES (?,?) ";
		
		$this->db->query($sql,array($cookieuserid,$cookieemail));
	
	//echo "<br>" .$str = $this->db->last_query();exit;
	}
	
	//checking cookie
	function remember_cookie2_check($cookie2)
	{	
	
	$sql = "select * from users where `id`='$cookie2' LIMIT 0,1";
		
		$query=$this->db->query($sql);
	
	//echo "<br>" .$str = $this->db->last_query();exit;
	
	if ($query->num_rows() > 0)
		{		
			$row = $query->row_array(); 
		
		return $row;
		}
		else
		{
			return false;
		}
	
	}
	
  
	
	
		//checking cookie
function remember_cookie_check($cookie1)
	{	
	
	$sql = "select * from `remember_cookies` where cookie_name='$cookie1'";
		
		$query=$this->db->query($sql);
	
	//echo "<br>" .$str = $this->db->last_query();exit;
	if($query){
	if ($query->num_rows() > 0)
		{		
			$row = $query->row_array(); 
			
		return $row;
		}
		else
		{
			return false;
		}}
	
	}		
	
function whoBlockedMe()
{
		$userdetail =userSession();
		
		$sqlBlocked="select * from `blocks` where `user_blocked`='".$userdetail['id']."'";
		$queryBlocked=$this->db->query($sqlBlocked);
		$blockedMeArray=$queryBlocked->result_array();
		$blockedMe=array();
		foreach($blockedMeArray as $blockedMeArra)
			$blockedMe[]=$blockedMeArra['blocked_by'];
		return $blockedMe;
}	

function citySuggestion($input)
	{
		$queryString=trim($input['queryString']);
		
		$sql="SELECT * FROM `cities` WHERE `r1`='".$input['state']."' and (`locality` LIKE '".$queryString."%')";
		$result = $this->db->query($sql);
		$city=$result->result_array();
		
		$sqlD="SELECT * FROM `cities` WHERE `r1`='".$input['state']."' and (`r3` LIKE '".$queryString."' and  `locality` LIKE '".$queryString."')";
		$resultD = $this->db->query($sqlD);
		//echo $this->db->last_query()."<br>";
		$district=$resultD->result_array();	
		$district=array();
		return array_merge($district,$city);
	}
	
	
function saveMyLoc($data)
	{
		$userdetail =userSession();
		$sql="update `users` set `city`='".$data['city']."', `state`='".$data['state']."' where `id`='".$userdetail['id']."'";
		$this->db->query($sql);
	}
	
	function update_email($useremail,$uid)
	{ 
			$sql="update `users` set `email_id`='".$useremail."' where `id`='".$uid."'";
		$this->db->query($sql);
		//echo $this->db->last_query();
	}
}