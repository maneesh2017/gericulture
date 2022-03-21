<?php

class User_model extends CI_Model 
{

	function get_user($id)
	{
		$sql="select * from `users` where `id`=?";
		$query=$this->db->query($sql,array($id));	
		$result=array();
		if($query->num_rows()>0)
		{
			$result=$query->row_array();
		}
		
		return $result;
	}

	
	
	
	
	function submit_basic_vehicle_details($data)
	{
		$sql="insert into `rides` (`user_id`,`type`,`brand`,`model`) values(?,?,?,?)";	
		$userSession=userSession();
		$this->db->query($sql,array($userSession['username'],$data['type'],$data['brand'],$data['model']));
	}
	
	function submit_basic_personal_details($data)
	{
		$sql="insert into `personal` (`user_id`,`dob`,`gender`,`phone`) values(?,?,?,?)";	
		$userSession=userSession();
		$this->db->query($sql,array($userSession['username'],$data['year'].'-'.$data['month'].'-'.$data['day'],$data['gender'],$data['telphone']));
	}
	
	function upload_cover_image($img,$id)
	{
		
		$sql="Insert into `photos_ride` (`user_id`,`name`,`default`) values(?,?,?)";
		$this->db->query($sql,array($id,$img,'1'));	
	}
	
	function cover_image($id)
	{
		$sql="select * from `photos_ride` where  `default`=? and `user_id`=?";
		$query=$this->db->query($sql,array('1',$id));
		
		$result=array();
		if($query->num_rows()>0)
			$result=$query->row_array();
		return $result;	
	}
	
	function upload_profile_pic($img,$id)
	{
		$sql="Insert into `photos_me` (`user_id`,`name`,`default`) values(?,?,?)";
		$this->db->query($sql,array($id,$img,'1'));	
	}
	
	
	function ajax_profile_image($id)
	{
		$sql="select * from `photos_me` where `default`=? and `user_id`=?";
		$query=$this->db->query($sql,array('1',$id));
		// echo $this->db->last_query();
		$result=array();
		if($query->num_rows()>0)
			$result=$query->row_array();
		return $result;	
	}
	
	function ride_info($id)
	{
		
		$sql="select * from `rides` where `user_id`=?";
		$query=$this->db->query($sql,array($id));		
		$result=array();
		if($query->num_rows()>0)
			$result=$query->row_array();
		return $result;	
	}
	
	function user_info($id)
	{
		$sql="select * from `users` where `id`=?";
		$query=$this->db->query($sql,array($id));
		
		$result=array();
		if($query->num_rows()>0)
			$result=$query->row_array();
		return $result;	
	}
	
	function personal_info($id)
	{
		$sql="select * from `personal` where `user_id`=?";
		$query=$this->db->query($sql,array($id));
		
		$result=array();
		if($query->num_rows()>0)
			$result=$query->row_array();
		return $result;
	}
	
	function edit_my_ride($data,$userId)
	{   //see($data);
	
		//$sql="update `rides` set `year_model`=?, `exterior_color`=?, `interior_color`=?, `ride_location`=?, `state`=?, `description`=? where `user_id`=?";
		//$this->db->query($sql,array($data['model'],$data['exterior_color'],$data['interior_color'],$data['ride_location'],$data['state'],nl2br($data['description']),$userId));
		// echo $this->db->last_query();
			$this->db->where('user_id', $userId);
			$this->db->update('rides',$data);
		
	}
	
	function edit_stdspc($data)
	{
		$sql="update `rides` set `engine_cc`=?, `bhp`=?, `body_style`=?, `drive_type`=?, `transmission`=?, `fuel`=?, `mileage`=? where `user_id`=?";
		$userSession=userSession();
		$this->db->query($sql,array($data['engine_cc'],$data['bhp'],$data['body_style'],$data['drive_type'],$data['transmission'],$data['fuel'],$data['mileage'],$userSession['username']));
	}
	
	function add_ride_feature($data,$image)
	{
		if($image==0)
			$img='';
		$sql="Insert into `add_features` (`user_id`, `name`, `brand`, `price`, `sname`, `sphone`, `saddress`, `review`, `type`, `rating`, `img`) values(?,?,?,?,?,?,?,?,?,?,?)";
		$userSession=userSession();
		$this->db->query($sql,array($userSession['username'],$data['aname'],$data['abrand'],$data['aprice'],$data['sname'],$data['sphone'],$data['saddress'],$data['review'],$data['feature'],$data['rating'],$image));
	}
	
	function edit_personal_pop_submit($data)
	{
		$sql="update `personal` set `dob`=?, `gender`=?, `city`=?, `state`=?, `about`=? where `user_id`=?";
		$userSession=userSession();
		$this->db->query($sql, array($data['year'].'-'.$data['month'].'-'.$data['day'],$data['gender'],$data['city'],$data['state'],nl2br($data['about']),$userSession['username']));
	
		$sql="update `users` set `fname`=?, `lname`=? where `id`=?";
		$this->db->query($sql, array($data['fname'],$data['lname'],$userSession['username']));
	}
	
	function edit_other_pop_submit($data)
	{
		$sql="update `personal` set `occupation`=?, `college`=?, `course`=? where `user_id`=?";
		$userSession=userSession();
		$this->db->query($sql, array($data['occupation'],$data['college'],$data['course'],$userSession['username']));
	}
	
	function matchOldPass($data)
	{
		$sql="select * from `users` where `id`=? and `password`=?";
		$userSession=userSession();
		$query=$this->db->query($sql,array($userSession['username'],MD5($data['old_password'])));	
		// echo $this->db->last_query();
		if($query->num_rows()>0)
			return 'yes';
		else
			return 'no';	
	}
	
	function update_pass($data)
	{
			$sql="update `users` set `password`=? where `id`=?";
			$userSession=userSession();
			$this->db->query($sql,array(MD5($data['new_password']),$userSession['username']));
			// echo $this->db->last_query();
	}
	
	function vehicleUpdatePopUpSubmit($data)
	{
		$sql="update `rides` set `type`=?, `brand`=?, `model`=? where `user_id`=?";
		$userSession=userSession();
		$this->db->query($sql, array($data['type'],$data['brand'],$data['model'],$userSession['username']));	
		
		$sql1="update `users` set `rc_no`=? where `id`=?";
		$this->db->query($sql1, array($data['rc_no'],$userSession['username']));
	}
	
	
	function update_settings($data)
	{
		$sql="update `users` set `noti_all_off`=?, `noti_req`=?, `noti_comp`=?, `noti_msg`=? where `id`=?";
		$userSession=userSession();
		$this->db->query($sql,array($data['noti_all_off'],$data['noti_req'],$data['noti_comp'],$data['noti_msg'],$userSession['username']));	
	}
	
	function active_check($id)
	{
		$sql="select * from `users` where `id`=?";
		$query=$this->db->query($sql,array($id));
		$res=array();
		$res=$query->row_array();
		if($res['status']==1)
			return 'active';
		elseif($res['status']==2)
			return 'blocked';
	}
	
	function change_email($data)
	{
			$sql="select * from `users` where `id`=?";
			$query=$this->db->query($sql,array($data['user_id']));
			$user=array();
			if($query->num_rows()>0)
			{
				$sql1="select * from `users` where `email`=?";
				$query1=$this->db->query($sql1,array($data['email']));
				if($query1->num_rows()>0)
					return false;
				else
					{
						$sql2="update `users` set `email`=? where `id`=?";
						$this->db->query($sql2,array($data['email'],$data['user_id']));
						return true;
					}
			}
			else
				return false;
	}
	
	function getCover($id)
	{
		$sql="select * from `photos` where  `default`='1' and `user_id`=? and `pic_type`='2'";
		$query=$this->db->query($sql,array($id));
		$cover=array();
		$cover=$query->row_array();
		return $cover;
	}
	
	function getProfilePic($id)
		{
		$sql="select * from `photos` where `default`='1' and `user_id`=? and `pic_type`='1'";
		$query=$this->db->query($sql,array($id));
		$profile=array();
		$profile=$query->row_array();
		return $profile;
	}
	
	function uploadPic($data,$image,$type)
	{ 
			if($data['photo_dec']=='Write description for your photo...')
				$data['photo_dec']='';
				
			if($type==1)
			$table="photos_me";
		if($type==2)
			$table="photos_ride";	
    }   
	
	
	
	function getImageCount($userid,$type)
	{
		$sql_photo="select * from `photos` where `user_id` ='".$userid."' and `pic_type`='".$type."'";
		$res_photo = $this->db->query($sql_photo);
		//echo $this->db->last_query();
		$photos =$res_photo->num_rows();
		return $photos;	
	}
	
	
	function user_info_by_email($id)
	{
				$sql="select * from `users` where `email_id` =? ";
				$query = $this->db->query($sql,$id);
				$res=$query->row_array();
				return $res;
		
	}
	
	function saveUserLocation($data)
	{
		$userdata =userSession();	
	    $userid =$userdata['id'];
		$sql="update `users` set `lat`=? , `lng`=? where `id`=?";
		$this->db->query($sql,array($data['lat'],$data['lng'],$userid));
	}
/////////////////////////////////////////////////////

}
