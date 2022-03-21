<?php

class Browse_model extends CI_Model
{
	
	function browse_people_count($data)
	{
		$sql="select u.`id`,u.`fname`,u.`lname`,u.`rc_no`, p.`dob`, p.`gender`, p.`city`,p.`state`, p.`gender`, p.`occupation`, p.`college`, r.`brand`, r.`model` from `users` u Left Join `personal` p on (u.`id`=p.`user_id`) Left Join `rides` r  on (u.`id`=r.`user_id`) where ";
		
		if(isset($data['fname']) && $data['fname']!='')
			$sql .="u.`fname` like '%".$data['fname']."%' and ";

		if(isset($data['lname']) && $data['lname']!='')
			$sql .="u.`lname` like '%".$data['lname']."%' and ";
		
		if(isset($data['gender']) && $data['gender']!='' && $data['gender']!='0')
			$sql .="p.`gender`='".$data['gender']."' and ";
		
		if(isset($data['occupation']) && $data['occupation']!='' && $data['occupation']!='0')
			$sql .="p.`occupation`='".$data['occupation']."' and ";	
		
		if(isset($data['state']) && $data['state']!='' && $data['state']!='0')
			$sql .="p.`state`='".$data['state']."' and ";
		
		if(isset($data['city']) && $data['city']!='')
			$sql .="p.`city` like '%".$data['city']."%' and ";
				
		$sql .="u.`status`=? and u.`id`!=? order by u.`fname`";
		$userSession=userSession();
		$query=$this->db->query($sql,array('1',$userSession['username']));
		//echo $this->db->last_query();
		$result=array();
		if($query->num_rows()>0)
			$result=$query->result_array();	
			
		return $result;
	}
	
	function browse_people($data,$from,$to)
	{
		$sql="select u.`id`,u.`fname`,u.`lname`,u.`rc_no`, p.`dob`, p.`gender`, p.`city`,p.`state`, p.`gender`, p.`occupation`, p.`college`, r.`brand`, r.`model` from `users` u Left Join `personal` p on (u.`id`=p.`user_id`) Left Join `rides` r  on (u.`id`=r.`user_id`) where ";
		
		if(isset($data['fname']) && $data['fname']!='')
			$sql .="u.`fname` like '%".$data['fname']."%' and ";

		if(isset($data['lname']) && $data['lname']!='')
			$sql .="u.`lname` like '%".$data['lname']."%' and ";
		
		if(isset($data['gender']) && $data['gender']!='' && $data['gender']!='0')
			$sql .="p.`gender`='".$data['gender']."' and ";
		
		if(isset($data['occupation']) && $data['occupation']!='' && $data['occupation']!='0')
			$sql .="p.`occupation`='".$data['occupation']."' and ";	
		
		if(isset($data['state']) && $data['state']!='' && $data['state']!='0')
			$sql .="p.`state`='".$data['state']."' and ";
		
		if(isset($data['city']) && $data['city']!='')
			$sql .="p.`city` like '%".$data['city']."%' and ";
				
		$sql .="u.`status`=? and u.`id`!=? order by u.`fname`  limit ".$from.",".$to;
		$userSession=userSession();
		$query=$this->db->query($sql,array('1',$userSession['username']));
		//echo $this->db->last_query();
		$result=array();
		if($query->num_rows()>0)
			$result=$query->result_array();	
			
		return $result;
	}
	
	function browse_rides_count($data)
	{
		$sql="select u.`id`,u.`fname`,u.`lname`,u.`rc_no`,u.`fname`, p.`dob`, p.`gender`, p.`city`,p.`state`, p.`gender`, p.`occupation`, p.`college`, r.`brand`, r.`model` from `users` u Left Join `personal` p on (u.`id`=p.`user_id`) Left Join `rides` r  on (u.`id`=r.`user_id`) where ";
		
		if(isset($data['brand']) && $data['brand']!='' && $data['brand']!='0')
			$sql .="r.`brand` = '".$data['brand']."' and ";
		
		if(isset($data['model']) && $data['model']!='')
			$sql .="r.`model` like '%".$data['model']."%' and ";
		
		if(isset($data['type']) && $data['type']!='' && $data['type']!='0')
			$sql .="r.`type` = '".$data['type']."' and ";
		
		if(isset($data['year']) && $data['year']!='')
			$sql .="r.`year_model` = '".$data['year']."' and ";
		
		if(isset($data['state']) && $data['state']!='' && $data['state']!='0')
			$sql .="r.`state` = '".$data['state']."' and ";
		
		if(isset($data['city']) && $data['city']!='')
			$sql .="r.`city` like '%".$data['city']."%' and ";
		
		$sql .="u.`status`=? and u.`id`!=? order by u.`fname`";
		$userSession=userSession();
		$query=$this->db->query($sql,array('1',$userSession['username']));
		//echo '<br>query = '.$this->db->last_query();
		$result=array();
		if($query->num_rows()>0)
			$result=$query->result_array();	
			
		return $result;
	}
	
	function browse_rides($data,$from,$to)
	{
		$sql="select u.`id`,u.`fname`,u.`lname`,u.`rc_no`,u.`fname`, p.`dob`, p.`gender`, p.`city`,p.`state`, p.`gender`, p.`occupation`, p.`college`, r.`brand`, r.`model` from `users` u Left Join `personal` p on (u.`id`=p.`user_id`) Left Join `rides` r  on (u.`id`=r.`user_id`) where ";
		
		if(isset($data['brand']) && $data['brand']!='' && $data['brand']!='0')
			$sql .="r.`brand` = '".$data['brand']."' and ";
		
		if(isset($data['model']) && $data['model']!='')
			$sql .="r.`model` like '%".$data['model']."%' and ";
		
		if(isset($data['type']) && $data['type']!='' && $data['type']!='0')
			$sql .="r.`type` = '".$data['type']."' and ";
		
		if(isset($data['year']) && $data['year']!='')
			$sql .="r.`year_model` = '".$data['year']."' and ";
		
		if(isset($data['state']) && $data['state']!='' && $data['state']!='0')
			$sql .="r.`state` = '".$data['state']."' and ";
		
		if(isset($data['city']) && $data['city']!='')
			$sql .="r.`city` like '%".$data['city']."%' and ";
		
		$sql .="u.`status`=? and u.`id`!=? order by u.`fname` limit ".$from.",".$to;
		$userSession=userSession();
		$query=$this->db->query($sql,array('1',$userSession['username']));
		$result=array();
		if($query->num_rows()>0)
			$result=$query->result_array();	
			
		return $result;
	}
	
	function flashlights($id)
	{
		$userSession=userSession();
		$user_id=$userSession['username'];
		$sql="select * from `flashes` where `user_id`='".$id."'";
		$query=$this->db->query($sql);
		if($query->num_rows()>0)
		{
			$row=$query->row_array();
			if(!in_array($user_id,explode(',',$row['flashed_by'])))
			{
				$flashed_by=$row['flashed_by'].','.$user_id;
				$sql_update="update `flashes` set `flashed_by`='".$flashed_by."' where `user_id`='".$id."'";
				$this->db->query($sql_update);
			}
		}
		else
		{
			$sql_insert="insert into `flashes` (`user_id`,`flashed_by`) values(".$id.",'".$user_id."')";
			$this->db->query($sql_insert);	
		}
	}
	
	function getFlashes($id)
	{
		$blockedMe=whoBlockedMe();
		
		$sql="select * from `flashes` JOIN users ON ( flashes.userid = users.id ) where `friendid`=?";
		if(!empty($blockedMe))
		 $sql.=" and `userid` NOT IN('".implode("','",$blockedMe)."')";

		$query=$this->db->query($sql,array($id));
		//echo '<br>'.$this->db->last_query();
		$result=array();
		$result=$query->result_array();
		return $result;	
	}
	
	function getFlashesByMe($id)
	{
		$blockedMe=whoBlockedMe();
		
		$sql="select * from `flashes` JOIN users ON ( flashes.friendid = users.id ) where `userid`=?";
		if(!empty($blockedMe))
		 $sql.=" and `friendid` NOT IN('".implode("','",$blockedMe)."')";
		 
		$query=$this->db->query($sql,array($id));
		//echo '<br>'.$this->db->last_query();
		$result=array();
		$result=$query->result_array();
		return $result;	
	}
	
	function search($word)
	{
		if($word=='')
		return array();
		$userSession=userSession();
		$user_id=$userSession['username'];
		$sql="select u.`id`,u.`fname`,u.`lname`,u.`rc_no`, r.`brand`, r.`model` from `users` u JOIN `rides` r ON (u.`id`=r.`user_id`) where (u.`fname` like '%".$word."%' OR u.`lname` like '%".$word."%' OR u.`email` like '%".$word."%' OR u.`rc_no` like '%".$word."%') and u.`id` !='".$user_id."'";	
		$query=$this->db->query($sql);
		//echo $this->db->last_query().'<br>';
		$result=array();
		$result=$query->result_array();
		//see($result);
		return $result;	
	}
	
	function sendrequest($id)
	{
		if($this->friendshipStatus($id)==4)
		{
			$userSession=userSession();
			$user_id=$userSession['username'];
			$sql1="select * from `frequests` where `user_id`='".$id."'";
			$query1=$this->db->query($sql1);	
			if($query1->num_rows()>0)
			{
				$res1=$query1->row_array();
				$check1=explode(',',$res1['sent_by']);
				if(!in_array($user_id,$check1))
					{
						$sql2="update `frequests` set `sent_by`='".$res1['sent_by'].','.$user_id."' where `user_id`='".$id."'";
						$this->db->query($sql2);
					}
			}
			else
			{
				$sql3="insert into `frequests` (`user_id`,`sent_by`) values(?,?)";
				$this->db->query($sql3,array($id,$user_id));
			}
		}
	}
	
	
	function cancel_request($id)
	{
		$userSession=userSession();
		$user_id=$userSession['username'];
		if(friendshipStatus($id)=='2')
		{
			$sql="select * from `frequests` where `user_id`=?";
			$query=$this->db->query($sql,array($id));
			//echo '<br>'.$this->db->last_query();	
			if($query->num_rows()>0)
			{
				$res=$query->row_array();
				$explode_res=explode(',',$res['sent_by']);
				if(count($explode_res)==1)
				{
					$sql_del="delete from  `frequests` where `user_id`=? ";
					$this->db->query($sql_del,array($id));	
					//echo '<br>'.$this->db->last_query();	
				}
				else
				{
					$key_res=array_search($user_id,$explode_res);
					if(is_numeric($key_res))
					{
						unset($explode_res[$key_res]);
						$implode_res=implode(',',$explode_res);
						$sql_update="update `frequests` set `sent_by`=? where `user_id`=?";
						$this->db->query($sql_update, array($implode_res,$id));
						//echo '<br>'.$this->db->last_query();	
					}
				}
			}
		}
	}
	
	
	function decline_request($id)
	{
		$userSession=userSession();
		$user_id=$userSession['username'];
		if(friendshipStatus($id)=='3')
			  {
				  $sql="select * from `frequests` where `user_id`=?";
				  $query=$this->db->query($sql,array($user_id));
				  if($query->num_rows()>0)
				  {
					  $res=$query->row_array();
					  $explode_res=explode(',',$res['sent_by']);
					  if(count($explode_res)==1)
					  {
						  $sql_del="delete from  `frequests` where `user_id`=? ";
						  $this->db->query($sql_del,array($user_id));	
						  //echo '<br>'.$this->db->last_query();	
					  }
					  else
					  {
						  $key_res=array_search($user_id,$explode_res);
						  if(is_numeric($key_res))
						  {
							  unset($explode_res[$key_res]);
							  $implode_res=implode(',',$explode_res);
							  $sql_update="update `frequests` set `sent_by`=? where `user_id`=?";
							  $this->db->query($sql_update, array($implode_res,$user_id));
							  //echo '<br>'.$this->db->last_query();	
						  }
					  }
					  
				  $sql_sel="select * from `rfrequests` where `user_id`=?";
				  $query_sel=$this->db->query($sql_sel,array($user_id));
				  if($query_sel->num_rows()>0)
				  {
					  $res_sel=$query_sel->row_array();
					  
					  $sql_update="update `rfrequests` set `sent_by`=? where `user_id`=?";
					  $this->db->query($sql_update,array($res_sel['sent_by'].','.$id,$user_id));
				  }
				  else
				  {
					  $sql_ins="insert into `rfrequests` (`sent_by`,`user_id`) values(?,?)";
					  $this->db->query($sql_ins,array($id,$user_id));
				  }
				  
			  }
		  }
	}
	
	
	function confirm_request($id)
	{
		$userSession=userSession();
		$user_id=$userSession['username'];
		if(friendshipStatus($id)=='3')
		{
			$sql="select * from `frequests` where `user_id`=?";
			$query=$this->db->query($sql,array($user_id));
			if($query->num_rows()>0)
				  {
					  $res=$query->row_array();
					  $explode_res=explode(',',$res['sent_by']);
					  if(count($explode_res)==1)
					  {
						  $sql_del="delete from  `frequests` where `user_id`=? ";
						  $this->db->query($sql_del,array($user_id));	
						  //echo '<br>'.$this->db->last_query();	
					  }
					  else
					  {
						  $key_res=array_search($user_id,$explode_res);
						  if(is_numeric($key_res))
						  {
							  unset($explode_res[$key_res]);
							  $implode_res=implode(',',$explode_res);
							  $sql_update="update `frequests` set `sent_by`=? where `user_id`=?";
							  $this->db->query($sql_update, array($implode_res,$user_id));
							  //echo '<br>'.$this->db->last_query();	
						  }
					  }
					  
				  $sql_sel="select * from `friends` where `user_id`=?";
				  $query_sel=$this->db->query($sql_sel,array($user_id));
				  if($query_sel->num_rows()>0)
				  {
					  $res_sel=$query_sel->row_array();
					  
					  $sql_update="update `friends` set `friends`=? where `user_id`=?";
					  $this->db->query($sql_update,array($res_sel['friends'].','.$id,$user_id));
					  echo '<br>'.$this->db->last_query();	
				  }
				  else
				  {
					  $sql_ins="insert into `friends` (`friends`,`user_id`) values(?,?)";
					  $this->db->query($sql_ins,array($id,$user_id));
					  echo '<br>'.$this->db->last_query();	
				  }
				  
			  }
		}
	}
	
	/*function canIsend($id)
	{
		$user_id=$this->session->userdata('user_id');
		$sql1="select * from `friends` where `user_id`='".$id."'";
		$query1=$this->db->query($sql1);	
		if($query1->num_rows()>0)
			{
				$res1=$query1->row_array();
				$check1=explode(',',$res1['friends']);
				if(in_array($user_id,$check1))
					return false;
			}
			
		$sql2="select * from `frequests` where `user_id`='".$id."'";
		$query2=$this->db->query($sql2);	
		if($query2->num_rows()>0)
			{
				$res2=$query2->row_array();
				$check2=explode(',',$res2['sent_by']);
				if(in_array($user_id,$check2))
					return false;
			}
		return true;	
	}*/
	
	function friendshipStatus($id)
	{
		$userSession=userSession();
		$user_id=$userSession['username'];
		
		$sql1="select * from `friends` where `user_id`='".$id."'";
		$query1=$this->db->query($sql1);
		if($query1->num_rows()>0)
		{
			$res1=$query1->row_array();
				$check1=explode(',',$res1['friends']);
				if(in_array($user_id,$check1))
					return 1;
		}
		
		$sql1a="select * from `friends` where `user_id`='".$user_id."'";
		$query1a=$this->db->query($sql1a);
		if($query1a->num_rows()>0)
		{
			$res1a=$query1a->row_array();
				$check1a=explode(',',$res1a['friends']);
				if(in_array($id,$check1a))
					return 1;
		}
		
		$sql2="select * from `frequests` where `user_id`='".$id."'";
		$query2=$this->db->query($sql2);
		if($query2->num_rows()>0)
		{
				$res2=$query2->row_array();
				$check2=explode(',',$res2['sent_by']);
				if(in_array($user_id,$check2))
					return 2;
		}
		
		$sql3="select * from `frequests` where `user_id`='".$user_id."'";
		$query3=$this->db->query($sql3);
		if($query3->num_rows()>0)
		{
				$res3=$query3->row_array();
				$check3=explode(',',$res3['sent_by']);
				if(in_array($id,$check3))
					return 3;
		}
		return 4;
	}
	
	
}

?>