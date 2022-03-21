<?php 

class findfriends_model extends CI_Model { 

function addImportedContacts($data)
{
	foreach($data['contacts'] as $frnd)
	{
		/*$getUserInfoByEmail=getUserInfoByEmail($frnd['email']);
		if(empty($getUserInfoByEmail))
		{*/
			if(!$this->checkIfImported($frnd['email'],$data['user_id']))
			{
				if(trim($frnd['email'])=='')
					continue;
					
				$sql="insert into `findFriends` (`user_id`,`account_email`,`name`,`email`,`site`) values(?,?,?,?,?)";
				$this->db->query($sql, array($data['user_id'],$data['account_email'],$frnd['name'],$frnd['email'],$data['site']));
			}
		/*}*/
	}
}

function checkIfImported($email,$user_id)
{
		$sql="select * from `findFriends` where `email`=? and `user_id`=?";
		$query=$this->db->query($sql,array($email,$user_id));
		if($query->num_rows()>0)
			return true;
		else	
			return false;
}

function getImportedContacts($data)
{
	$sql="select * from `findFriends` where `user_id`=? and `site`=? order by `id` DESC";
	/*if(isset($data['account']))
		$sql .="  and `account_email`='".$data['account']."'";*/
	$query=$this->db->query($sql,array($data['userdata']['id'],$data['site']));
	//echo $this->db->last_query();
	return $query->result_array();
}

function saveInvitedFrnd($email)
{
	$sql="update `findFriends` set `invited`='1' where `email`='".$email."'";
	$this->db->query($sql);
}

function invitationSent($email)
{
	$userdata = userSession();
	$sql="select * from `findFriends` where `email` like ? and `user_id`=? and `invited` = '1'";
	$query=$this->db->query($sql,array($email,$userdata['id']));
	//echo $this->db->last_query();
	if($query->num_rows()>0)
		return true;
	else
		return false;	
}

function getImportedAccounts($site)
{
	$userdata = userSession();
	$sql="select DISTINCT(`account_email`) from `findFriends` where  `user_id`=? and `site` = ? order by `id` DESC";
	$query=$this->db->query($sql,array($userdata['id'],$site));
	//echo $this->db->last_query();
	return $query->result_array();
}

}
?>
