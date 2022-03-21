<?php
class Sticker_model extends CI_Model 
{

 function orderdetail_submit($data)	
	 {
		$sql="insert into `order_sticker` (`userid`,`address`,`city`,`state`,`postcode`,`landmark`,`phoneno`,`email`,`date`) values(?,?,?,?,?,?,?,?,?)";
		$this->db->query($sql,array($data['user_id'],$data['address'],$data['city'],$data['state'],$data['postcode'],$data['landmark'],$data['phoneno'],$data['email'],date('Y-m-d H:i:s')));   
		return $this->db->insert_id();   
	}


}
?>