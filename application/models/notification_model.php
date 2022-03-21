<?php 

class Notification_model extends CI_Model 
{ 

	   function notificationList($id)
	   {
			$sql="select * from `notifications` where `noti_for`='".$id."' and `noti_read`='0' order by `noti_date` DESC";
			$query=$this->db->query($sql);
			//echo "<br>".$this->db->last_query();
			return $query->result_array();
	   }
	   
	   function addNotification($data)
		  {         
			  if(!isset($data['object_id']))
				  $data['object_id']=0;
				  
			  $sql="insert into `notifications` (`noti_for`,`noti_from`,`noti_type`,`noti_date`,`object_id`) VALUES (?,?,?,?,?)";
			  $this->db->query($sql,array($data['noti_for'],$data['noti_from'],$data['noti_type'],$data['noti_date'],$data['object_id']));
		  }
		  
		 
	  function notificationTypeList()
	  {
			$sql="select * from `notification_type` order by `id`";
			$query=$this->db->query($sql); 
			return $query->result_array();
	  }
	  
	  function getUserNotificationUnread($id)
	  {
			$sql="select * from `notifications` where `noti_for`='".$id."' order by `noti_date` DESC";
			$query=$this->db->query($sql); 
			return $query->result_array();
	  }
	
		
	
}
