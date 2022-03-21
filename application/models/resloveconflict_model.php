<?php 

class Resloveconflict_model extends CI_Model 
{
	 
	
	
	
//////////////////////////////////////////////////////////////////
function inserconflict($data){
			$this->db->insert('conflictions',$data);			
			return $this->db->insert_id();  
		}		
//////////////////////////////////////////////////////////////////
function updateconflict($user_id,$data){
	
			$this->db->where('user_id',$user_id);	
			$this->db->update('conflictions',$data);	
	}		

 function resolve_conflict_submit($data)	
	 {
		$sql="insert into `conflictions` (`email`,`phone`,`vehicle_no`,`make`,`model`,`type`,`message`,`date`) values(?,?,?,?,?,?,?,?)";
		 $this->db->query($sql,array($data['Email'],$data['Phone'],$data['Vehicle_no'],$data['Make'],$data['Model'],$data['Vehicle_type'],$data['Message'],date('Y-m-d H:i:s')));   
	} 
}
?>