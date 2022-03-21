<?php 

class Helper_model extends CI_Model 
{ 

///////////////////////////////////////////////////////////////// 
function latestStatus($userid){
		        
		$sql="Select *  from  photos where user_id ='". $userid."' && status=1 && pic_type=3  order by `created` Desc Limit 1";
	    $query = $this->db->query($sql); 
		//echo $this->db->last_query();
		$res = $query->row_array();
		return $res;
}


function flashesSeenUnseenCount($user_id)
{
	  $blockedMe=whoBlockedMe();
	  
	  $sql="select distinct userid from flashes  join users on(flashes.userid=users.id ) where friendid=? ";
	  
	  if(!empty($blockedMe))
		$sql.=" and `userid` NOT IN('".implode("','",$blockedMe)."')";
	  
	  $query=$this->db->query($sql,$user_id);
	  //echo "<br>".$this->db->last_query();
	  $res=$query->result_array();
	  return count($res);
}

function flashesSeenUnseenCountByMe($user_id)
{
	  $blockedMe=whoBlockedMe();
	  
	  $sql="select distinct friendid from flashes join `users` on (flashes.friendid=users.id) where userid=? ";
	  
	   if(!empty($blockedMe))
		$sql.=" and `friendid` NOT IN('".implode("','",$blockedMe)."')";
	  
	  $query=$this->db->query($sql,$user_id);
	  //echo $this->db->last_query();
	  $res=$query->result_array();
	  return count($res);
}


function flashesSeenUnseenTop($user_id,$queryInput)
{
	$blockedMe=whoBlockedMe();
	  
	$sql="select count(flashes.id) as count,`friendid`,userid, Max(`date`) as `date`, MIN(`seen`) as `seen`, users.first_name,users.last_name,users.username,users.gendor,users.DOB,rides.model,rides.type,rides.make from flashes join users on(flashes.userid=users.id )join rides on(flashes.userid=rides.user_id ) where friendid=? ";
	
	if(!empty($blockedMe))
		$sql.=" and `userid` NOT IN('".implode("','",$blockedMe)."')";
	
	$sql .="GROUP BY `userid` order by max(`date`) DESC limit ".$queryInput['page'].",".$queryInput['limit'];
	  
	$query=$this->db->query($sql,$user_id);
	//echo $this->db->last_query();
	$res=$query->result_array();
	return $res;
}

function flashesSeenUnseenTopByMe($user_id,$queryInput)
{
	$blockedMe=whoBlockedMe();
	
	$sql="select count(flashes.id) as count,`friendid`,userid, MAX(`date`) as `date`, users.first_name,users.last_name,users.username,users.gendor,users.DOB,rides.model,rides.type,rides.make from flashes join users on(flashes.friendid=users.id )join rides on(flashes.friendid=rides.user_id ) where userid=? ";
	
	if(!empty($blockedMe))
		$sql.=" and `friendid` NOT IN('".implode("','",$blockedMe)."')";
	
	$sql .=" GROUP BY `friendid` order by max(`date`) DESC limit ".$queryInput['page'].",".$queryInput['limit'];
	$query=$this->db->query($sql,$user_id);
	//echo $this->db->last_query();
	$res=$query->result_array();
	return $res;
}

function getModelText($model,$type)
{
	  if($type=='car')
	  {
		  $sql="select model from car_models where link=?";
		  $query=$this->db->query($sql,$model);
		  $res=$query->row_array();
		}
		if($type=='suv')
	  {
		  $sql="select model from car_models where link=?";
		  $query=$this->db->query($sql,$model);
		  $res=$query->row_array();
		}
	  if($type=='bike')
	  {
		  $sql="select model from bike_models where link=?";
		  $query=$this->db->query($sql,$model);
		  $res=$query->row_array();
	  }
	  if($type=='scooter')
	  {
		  $sql="select model from bike_models where link=?";
		  $query=$this->db->query($sql,$model);
		  $res=$query->row_array();
	  }
	 
	  $return='';
	  if(!empty($res['model']))
		  $return=$res['model'];
	  else
	  {
		   $suggestions=$this->getListVehicleSuggestions();
			if(!empty($suggestions))
			  {
				  $modelArray=explode('-',$model);
				  foreach($suggestions as $sugg)
				  {
					  if($modelArray[1]==$sugg['id'])
					  $return=$sugg['model'];
				  }
			  }
	  }
	  return $return;
}

function flashesUnseen($userid)
{
	$blockedMe=whoBlockedMe();
	
	$sql="select  *  from flashes where `friendid`=? and seen=?";
	
	if(!empty($blockedMe))
		$sql.=" and `userid` NOT IN('".implode("','",$blockedMe)."')";
		
	$query=$this->db->query($sql,array($userid,'0'));
	//echo $this->db->last_query();
	$res = $query->result_array();
	return $res;
}


function getPicHorns($picid)
{
		$sql="select `horn` from `photos` where `id`='".$picid."'";
		$query=$this->db->query($sql);
		$horns=$query->row_array();
		return $horns['horn'];
}

function getHornsC($picid)
{
		$sql="select * from `horns_c` where `c_id`='".$picid."'";
		$query=$this->db->query($sql);
		$horns=$query->num_rows();
		return $horns;
}

function ifHornBlowed($pic_id,$user_id)
{
		$sql="select * from `horns` where `pic_id`='".$pic_id."' and `user_id`='".$user_id."'";
		$query=$this->db->query($sql);
		$horns=$query->row_array();
		return $horns;
}

function ifHornCBlowed($pic_id,$user_id)
{
		$sql="select * from `horns_c` where `c_id`='".$pic_id."' and `user_id`='".$user_id."'";
		$query=$this->db->query($sql);
		$horns=$query->row_array();
		return $horns;
}


function friendshipStatus($user1,$user2)
{
	$sql="select * from `friends` where (`user_id`='".$user1."' and `friend_id`='".$user2."') OR (`user_id`='".$user2."' and `friend_id`='".$user1."')";
	$query=$this->db->query($sql);
	if($query->num_rows()>0)
	{
		$result=$query->row_array();
		if($result['status']==1)
			return 1;//friends
		else
			{
				if($result['user_id']==$user1)
					return 2;//Request sent
				else
					return 3;//Request received
			}
	}
	else
		return 4;//not friends
}


function getFlashes($user)
{
		$sql="select `flashes` from `rides` where `user_id`='".$user."'";
		$query=$this->db->query($sql);
		$horns=$query->row_array();
		return $horns['flashes'];
}

function flashedByMe($user_id,$user)
{
		$sql="select * from `flashes` where `userid`='".$user_id."' and `friendid`='".$user."'";
		$query=$this->db->query($sql);
		$horns=$query->row_array();
		return $horns;
}


function flashedTime($my_id,$id)
{
		$sql="select date from flashes where userid=? and friendid=? order by date desc";
		$query=$this->db->query($sql,array($my_id,$id));
		$res=$query->result_array();
		$nowdate = date('Y-m-d H:i:s');
		$tdifference = $res[0]['date'];
		
		return dayDiff(strtotime($nowdate),strtotime($tdifference));
}


function getPicComp($pic_id)
{
		$sql="select `compliements`.*, `users`.`first_name`, `users`.`last_name`, `users`.`gendor` from `compliements` JOIN `users` ON (`compliements`.`user_id`=`users`.`id`) where `compliements`.`photo_id`='".$pic_id."' and `compliements`.`status`='1' order by `compliements`.`created`";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		$horns=$query->result_array();
		return $horns;
}

function getPicCompCount($pic_id)
{
	$count=$this->getPicComp($pic_id);
	return count($count);
}

function friendList($userid)
{
	$sql="select * from `friends` where (`user_id`='".$userid."' OR `friend_id`='".$userid."') and `status`='1' and `block_status`='0' and `block_statusF`='0'";
	$result = $this->db->query($sql);
	//echo $this->db->last_query();
	$frnds=$result->result_array();	  
	
	$friends=array();
	if(!empty($frnds))
	{
			  foreach($frnds as $f)
				  {
					  if($f['user_id']==$userid)
						  $friends[]=$f['friend_id'];
					  else
						  $friends[]=$f['user_id'];	
				  }
	}
	
	return $friends;
}

function getUserMsgsUnread($user_id)
	{
				$blockedMe=whoBlockedMe();
				$sql="select `messages`.`user_id`, MAX( `messages`.`created` ) AS `created_date` , `users`.`first_name`, `users`.`last_name`, `users`.`username`, `users`.`gendor`,rides.make,rides.model,rides.type from `messages` JOIN `users` ON (`messages`.`user_id`=`users`.`id`)  join rides on(messages.user_id=rides.user_id )  where (`friend_id`=? and `del_to`='0')  and `messages`.`status`='0' ";
				
				if(!empty($blockedMe))
					$sql.=" and `rides`.`user_id` NOT IN('".implode("','",$blockedMe)."')";
				
				$sql .="group by `user_id` order by `created_date` DESC limit 6";
				
				$query=$this->db->query($sql,array($user_id,$user_id));
				//echo $this->db->last_query();
				$msgs=$query->result_array();
				return $msgs;
	}
	function getUserMsgsUnread2($user_id)
	{
				$blockedMe=whoBlockedMe();
				$sql="select `messages`.`user_id`, MAX( `messages`.`created` ) AS `created_date` , `users`.`first_name`, `users`.`last_name`, `users`.`username`, `users`.`gendor`,rides.make,rides.model,rides.type from `messages` JOIN `users` ON (`messages`.`user_id`=`users`.`id`)  join rides on(messages.user_id=rides.user_id )  where (`friend_id`=? and `del_to`='0')  and `messages`.`status`='1' ";
				
				if(!empty($blockedMe))
					$sql.=" and `rides`.`user_id` NOT IN('".implode("','",$blockedMe)."')";
				
				$sql .="group by `user_id` order by `created_date` DESC limit 6";
				
				$query=$this->db->query($sql,array($user_id,$user_id));
				//echo $this->db->last_query();
				$msgs=$query->result_array();
				return $msgs;
	}
	function getUserMsgsUnread3($user_id)
	{
		$blockedMe=whoBlockedMe();
		$sql="select `messages`.`user_id`, MAX( `messages`.`created` ) AS `created_date` , `users`.`first_name`, `users`.`last_name`, `users`.`username`, `users`.`gendor`,rides.make,rides.model,rides.type from `messages` JOIN `users` ON (`messages`.`user_id`=`users`.`id`)  join rides on(messages.user_id=rides.user_id )  where (`friend_id`=? and `del_to`='0')  and `messages`.`status`='0' ";
		if(!empty($blockedMe))
					$sql.=" and `rides`.`user_id` NOT IN('".implode("','",$blockedMe)."')";
		$sql .="group by `user_id` order by `created_date` DESC ";
		
		$query=$this->db->query($sql,array($user_id));
		$msgs=$query->result_array();
		$c=count($msgs);
		if($c<6 && $c>0)
				{
					$l=6-$c;
		
 		$sql2="SELECT case  when  `user_id`='".$user_id."' then `friend_id`  when `friend_id`='".$user_id."' then `user_id`  end  as `user` , max(`messages`.`created`) `created_date` FROM `messages` JOIN `users` `u` ON(`u`.`id`=`messages`.`user_id`)  JOIN `users` `uv` ON(`uv`.`id`=`messages`.`friend_id`)  where (`user_id`='".$user_id."' or `friend_id`='".$user_id."')  and  case  when  `user_id`='".$user_id."' then `del_from`='0'  when `friend_id`='".$user_id."' then `del_to`='0'  end ";
		
		if(!empty($blockedMe))
		{
					//$sql2.=" and `user` NOT IN('".implode("','",$blockedMe)."')";
		$sql2.=" and case  when  `user_id`='".$user_id."' then `friend_id` NOT IN('".implode("','",$blockedMe)."')  when `friend_id`='".$user_id."' then `user_id` NOT IN('".implode("','",$blockedMe)."')  end ";
		}
					
		$sql2 .="group by `user` order by `created_date` DESC  limit 6";		
				
				$query2=$this->db->query($sql2);
				//print_r($sql2);
				//echo $this->db->last_query();
				$result=$query2->result_array();
				foreach($result as $k=>$res)
				{
					$result[$k]['user_id']=$res['user'];
					unset($result[$k]['user']);
					$getUserInfo=getUserInfo($res['user']);
					$getRideInfo=getRideInfo($res['user']);
					//see($getUserInfo);
					$result[$k]['first_name']=$getUserInfo['first_name'];
					$result[$k]['last_name']=$getUserInfo['last_name'];
					$result[$k]['gendor']=$getUserInfo['gendor'];
					$result[$k]['username']=$getUserInfo['username'];
					$result[$k]['model']=$getRideInfo['model'];
					$result[$k]['type']=$getRideInfo['type'];
					$result[$k]['make']=$getRideInfo['make'];
				}
				
				}
				
				return $result;
	}
	
	
	
function getUserMsgs($user_id)
	{
				$blockedMe=whoBlockedMe();
				
				
	//			$sql="SELECT case  when  `user_id`='".$user_id."' then `friend_id`  when `friend_id`='".$user_id."' then `user_id`  end  as `user` , max(`messages`.`created`) `created_date` FROM `messages` JOIN `users` `u` ON(`u`.`id`=`messages`.`user_id`)  JOIN `users` `uv` ON(`uv`.`id`=`messages`.`friend_id`)  where (`user_id`='".$user_id."' or `friend_id`='".$user_id."') group by `user` order by `created_date` DESC";
				//$sql="SELECT case  when  `user_id`='".$user_id."' then `friend_id`  when `friend_id`='".$user_id."' then `user_id`  end  as `user` , max(`messages`.`created`) `created_date` FROM `messages` JOIN `users` `u` ON(`u`.`id`=`messages`.`user_id`)  JOIN `users` `uv` ON(`uv`.`id`=`messages`.`friend_id`)  where (`user_id`='".$user_id."' or `friend_id`='".$user_id."')  and  case  when  `user_id`='".$user_id."' then `del_from`='0'  when `friend_id`='".$user_id."' then `del_to`='0'  end group by `user` order by `created_date` DESC";
				
				$sql="SELECT case  when  `user_id`='".$user_id."' then `friend_id`  when `friend_id`='".$user_id."' then `user_id`  end  as `user` , max(`messages`.`created`) `created_date` FROM `messages` JOIN `users` `u` ON(`u`.`id`=`messages`.`user_id`)  JOIN `users` `uv` ON(`uv`.`id`=`messages`.`friend_id`)  where ((`user_id`='".$user_id."'";
				
				if(!empty($blockedMe))
					$sql.=" and `friend_id` NOT IN('".implode("','",$blockedMe)."')";
		
				$sql .=") ";
				
				$sql .="or (`friend_id`='".$user_id."'";
				
				if(!empty($blockedMe))
					$sql.=" and `user_id` NOT IN('".implode("','",$blockedMe)."')";
				
				$sql .="))  and  case  when  `user_id`='".$user_id."' then `del_from`='0'  when `friend_id`='".$user_id."' then `del_to`='0'  end group by `user` order by `created_date` DESC";
				
				$query=$this->db->query($sql);
				$result=$query->result_array();
				//see($result);
				//echo "<br>".$this->db->last_query();
				foreach($result as $k=>$res)
				{
					$result[$k]['user_id']=$res['user'];
					unset($result[$k]['user']);
					$getUserInfo=getUserInfo($res['user']);
					$getRideInfo=getRideInfo($res['user']);
					//see($getRideInfo);
					$result[$k]['first_name']=$getUserInfo['first_name'];
					$result[$k]['last_name']=$getUserInfo['last_name'];
					$result[$k]['gendor']=$getUserInfo['gendor'];
					$result[$k]['username']=$getUserInfo['username'];
					$result[$k]['model']=$getRideInfo['model'];
					$result[$k]['type']=$getRideInfo['type'];
					$result[$k]['make']=$getRideInfo['make'];
				}
				
				//see($result);
				return $result;
				
	}
	
function getMsgByUser($from, $to, $limit, $fromR='')
	{
				$sql="select `messages`.*  from `messages`  where (`messages`.`friend_id`='".$to."' and `messages`.`user_id`='".$from."' and `del_to`='0') OR (`messages`.`user_id`='".$to."' and `messages`.`friend_id`='".$from."'  and `del_from`='0') ";
				$sql .="order by `messages`.`created` DESC ";
				
				if($limit>0)
				{
					$sql .=" limit ";
					if($fromR!='')
						$sql .=$fromR.', ';
					$sql .=$limit;
				}
				
				$query=$this->db->query($sql);
				//echo '<br>'.'limit-='.$limit.'  '.$this->db->last_query();
				$msgs=$query->result_array();
				return $msgs;
	}
	
function markMsgRead($id)
	{
		$sql="update `messages` set `status`='1' where `id`='".$id."'";
		$this->db->query($sql);
	}
	
	
	function getListVehicleBrand($type)
	{
	if($type=='car')
	{
	$sql="select * from car_brands order by `brand`";
	$query=$this->db->query($sql);
	$res=$query->result_array();
	return $res;
	}
	if($type=='suv')
	{
	$sql="select * from car_brands order by `brand`";
	$query=$this->db->query($sql);
	$res=$query->result_array();
	return $res;
	}
	if($type=='bike')
	{
	$sql="select * from bike_brands order by `brand`";
	$query=$this->db->query($sql);
	$res=$query->result_array();
	return $res;
	}
	if($type=='scooter')
	{
	$sql="select * from bike_brands order by `brand`";
	$query=$this->db->query($sql);
	$res=$query->result_array();
	return $res;
	}
	}
		
		
	function getListVehicleModel($make,$type)
	{
		$res=array();
		
	if($type=='car')
	{
			$mod="select id from car_brands where link like ? order by `brand`";
			$query=$this->db->query($mod,$make);
			$id=$query->result_array();	
			
			if(!empty($id))
			{
			  $sql="select * from car_models where brand_id=? order by `model`";
			  $query=$this->db->query($sql,$id[0]['id']);
			  $res=$query->result_array();
			 } 
			  return $res;
	}
	if($type=='suv')
	{
			$mod="select id from car_brands where link like ? order by `brand`";
			$query=$this->db->query($mod,$make);
			$id=$query->result_array();	
			
			if(!empty($id))
			{
			  $sql="select * from car_models where brand_id=? order by `model`";
			  $query=$this->db->query($sql,$id[0]['id']);
			  $res=$query->result_array();
			 } 
			  return $res;
	}
	if($type=='bike')
	{
			$mod="select id from bike_brands where link like ? order by `brand`";
			$query=$this->db->query($mod,$make);
			$id=$query->result_array();	
			
			if(!empty($id))
			{
				$sql="select * from bike_models where brand_id=? order by `model`";
				$query=$this->db->query($sql,$id[0]['id']);
				$res=$query->result_array();
			}
			return $res;
	}
	if($type=='scooter')
	{
			$mod="select id from bike_brands where link like ? order by `brand`";
			$query=$this->db->query($mod,$make);
			$id=$query->result_array();	
			
			if(!empty($id))
			{
				$sql="select * from bike_models where brand_id=? order by `model`";
				$query=$this->db->query($sql,$id[0]['id']);
				$res=$query->result_array();
			}
			return $res;
	}
	}


   function blockedByMe($userid,$blockedid)
   {
   
   $sql=" select * from blocks where user_blocked=? and blocked_by=?";
   $query=$this->db->query($sql,array($blockedid,$userid));
   $res=$query->result_array();
   return $res;
   
   }
   
   function getFamousFlashes()
  {
			$blockedMe=whoBlockedMe();
			$sql=" SELECT count(distinct(`userid`) ) AS `count` ,`friendid`,rides.make, rides.model,rides.type FROM `flashes` join rides on(flashes.friendid=rides.user_id) ";
			if(!empty($blockedMe))
				$sql.=" and `rides`.`user_id` NOT IN('".implode("','",$blockedMe)."')";
				
			$sql.="GROUP BY `friendid` order by `count` DESC limit 5 ";
            $query=$this->db->query($sql);
            $res=$query->result_array();
            return $res;
  }	

	function getListVehicleSuggestions()
	{
		$sql="select * from `suggested_brands` where `reviewed`='0'";
		$query=$this->db->query($sql);
		return $query->result_array();
	}

function getStateList()
	{
		
		$sql="select * from `states` order by `id`";
			
		$query=$this->db->query($sql);
		return $query->result_array();
	}
	function getStateList2()
	{
		
		$userdetail =userSession();
			$user_id=$userdetail['state'];
			if(!empty($user_id))
			{
				$sql="select * from `states` where `id`='".$user_id."'";
			}
			
		$query=$this->db->query($sql);
		return $query->result_array();
	}

function cityNameFromId($id)
{
	  if(!empty($id))
	  {
		$sql="select * from `cities` where `id`='".$id."'";
		$query=$this->db->query($sql);
		//echo $this->db->last_query();
		$res=$query->row_array();
		return $res['locality'];
	  }
}

  function ifStickerOrdered($user_id)
  {
	  $sql="select * from `order_sticker` where `userid`='".$user_id."'";
	  $query=$this->db->query($sql);
	  return $query->row_array();
  }
  
  function getUserStatus($userid)
   {
	   $sql="Select status from users where id =?";
	   $query=$this->db->query($sql,$userid);
	   $result=$query->result_array();
	   $res=$result[0]['status'];
	   return $res;
	 
   }
	
}
?>
