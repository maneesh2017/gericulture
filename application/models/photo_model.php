<?php 

class Photo_model extends CI_Model 
{ 



///////////////////////////////////////////////////////////////////
function my_photos($userid){	
	
	$sql="select * from photos where user_id ='".$userid."' && pic_type=1 && status=1 order by `created` DESC"	;
	
	$result = $this->db->query($sql);
	//echo $this->db->last_query();
	$res=$result->result_array();
	
	return $res;
	}
///////////////////////////////////////////////////////////////////
function others_photos($userid){	
	
	$result = $this->db->query("select * from photos where user_id ='".$userid."' && pic_type=1 && status=1 ");
	//echo $this->db->last_query();
	return $result->result_array();
	}

	
///////////////////////////////////////////////////////////////////
function myridephotos($userid){	
	
	$result = $this->db->query("select * from photos where user_id ='".$userid."' && pic_type=2 && status=1 order by `created` DESC");
	return $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function othersridephotos($userid){	
	
	$result = $this->db->query("select * from photos where user_id ='".$userid."' && pic_type=2 && status=1 ");
	return $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
function mystatusphotos($userid){	
	
	$result = $this->db->query("select * from photos where user_id ='".$userid."' && pic_type=3 && status=1 and `pic_name`!=''  order by `created` DESC");
	return $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function otherstatusphotos($userid){	
	
	$result = $this->db->query("select * from photos where user_id ='".$userid."' && pic_type=3 && status=1 ");
	return $result->result_array();
	}	
//////////////////////////////////////////////////////////////////
function insertdata($data){
			
			$this->db->insert('photos',$data);			
			//echo $this->db->last_query();
			return $this->db->insert_id();			
		}	
		
function insertdata_update($data){
			
			$sql="update `photos` set `default`='0' where `user_id`='".$data['user_id']."' and `pic_type`='".$data['pic_type']."'";
			$this->db->query($sql);
			
			$this->db->insert('photos',$data);			
			return $this->db->insert_id();			
		}			
	
///////////////////////////////////////////////////////////////////
function count_photos($userid){
	
	$sql="select  COUNT(photos.id) as cphotos from photos where user_id ='".$userid."' and pic_type=1 and  status=1 "	;
	$result = $this->db->query($sql);
	
	//echo '<br>'.$this->db->last_query();
	$photos =$result->result_array();
		
	return $photos;
	}

///////////////////////////////////////////////////////////////////
function getusername($userid){	
	
	$result = $this->db->query("select username from users where id ='".$userid."' ");
	return $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
function cride_photos($userid){	
	
	$result = $this->db->query("select COUNT(photos.id) as crphotos from photos where user_id ='".$userid."' and pic_type=2 and status=1 ");
	//echo $this->db->last_query();
	return $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function cstatus_photos($userid){	
	
	$result = $this->db->query("select COUNT(photos.id) as csphotos from photos where user_id ='".$userid."' && pic_type=3 && status=1 ");
	return $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
function lastrowdata($userid){	
	
	$result = $this->db->query("select * from photos where id ='".$userid."' && pic_type=1 && status=1");
	return $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function lastriderowdata($userid){	
	
	$result = $this->db->query("select * from photos where id ='".$userid."' && pic_type=2 && status=1");
	return $result->result_array();
	}	
////////////////////////////////////	

	function deletePhoto($id)
	{
			$sql="select * from `photos` where `id`=?";
			$query=$this->db->query($sql,$id);
			$photo=$query->row_array();
			
			$thumbSizes=thumbSizes('ride');
			foreach($thumbSizes as $sizeK=>$sizeV)
			  {
					if(file_exists('uploads/gallery/'.$sizeK.'/'.$photo['pic_name']))
					 unlink('uploads/gallery/'.$sizeK.'/'.$photo['pic_name']);
			 }
			
			$sql="delete from `photos` where `id`=?";
			$this->db->query($sql,$id); 
	}
	
	function chooseFromPhotoListSubmit($user_id,$type)
	{
		if($type==1)
			$pType=2;
		else if($type==2)	
			$pType=1;
			
		$sql="update `photos` set `default`='0' where `user_id`='".$user_id."' and `pic_type`='".$pType."'";
		$this->db->query($sql);
		
		$sql="update `photos` set `default`='1' where `user_id`='".$user_id."' and `id`='".$_POST['id']."'";
		$this->db->query($sql);
		
		$sql="select * from `photos` where  `id`='".$_POST['id']."'";
		$query=$this->db->query($sql);
		$res=$query->row_array();
		return $res;
	}
}
