<?php 

class Contact_model extends CI_Model 
{
	
	

 function contact_submit($data)	
	 {
$sql="insert into `contact`(`email`,`contact`,`message`,`plateform`,`date`) values(?,?,?,?,?)";
		 $this->db->query($sql,array($data['UserEmail'],$data['Contact'],$data['Message'],$data['Plateform'],date('Y-m-d H:i:s')));   
	} 
}
?>