<?php 

class admin_model extends CI_Model { 



/////////////////////////////////////////////
function checkduplicaterc($data)
	{         
	
		$sql="select * from `users` where `username`=?";
		$query = $this->db->query($sql,array($data['username']));
		if($query->num_rows()>0)
		return 'yes';
		else
		return 'no';
	}
/////////////////////////////////////////
function checkduplicateemail($data)
	{
		$sql="select * from `users` where `email_id`=? ";
		$query=$this->db->query($sql,array($data['email']));
		if($query->num_rows()>0)
		return 'yes';
		else
		return 'no';
	}
///////////////////////////////////////////////////////////////	
 function adduser($data)	
	 {
		 $data['username']=strtoupper($data['username']);
		 //$activation_code = getRandomString();
		  $activation_code = "cxcxcxcxc";
		 $sql="insert into `users` (`first_name`,`last_name`,`username`,`email_id`,`password`,`city`,`state`,`occupation`,`college`,`course`,`activation_code`) values(?,?,?,?,?,?,?,?,?,?,?)"; 
		 $this->db->query($sql,array($data['firstname'],$data['lastname'],$data['username'],$data['email'],MD5($data['password']),$data['city'],$data['state'],$data['occupation'],$data['college'],$data['course'],$activation_code));   
	 	return $activation_code;
	 }   
///////////////////////////////////////////////////////////////////
function userlogin($username,$password)	{
		        
	$pwd=MD5($password);	
	$result = $this->db->query("select * from users where username = '$username' and password = '$pwd' && status=1 && role='admin'");    		
	return $result;
	}

/////////////////////////////////////////////////////////////////// 
function userdata($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('users');
		return $query->result_array();	
	} 

/////////////////////////////////////////////////////////////////// 
function photodata($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('photos');
		return $query->result_array();	
	} 
	
/////////////////////////////////////////////////////////////////// 
function pagedata($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('pages');
		return $query->result_array();	
	} 
/////////////////////////////////////////////////////////////////// 
function htmlboxdata($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('htmlboxs');
		return $query->result_array();	
	}
function sluglist()	{		           
	
	$result = $this->db->query("select * from htmlboxs");    		
	return  $result->result_array();   
	}	
/////////////////////////////////////////////	
function sidebarcontent($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('htmlboxs');
		return $query->result_array();	
	}	
/////////////////////////////////////////////	
function pageid($slug)	{		           
	
	    $this->db->where('slug',$slug);	  
		$query = $this->db->get('pages');
		return $query->result_array();	
	}		 
/////////////////////////////////////////////////////////////////// 
function allpagecontent($slug)	{		           
	
	    $this->db->where('slug',$slug);	  
		$query = $this->db->get('pages');
		return $query->result_array();	
	} 			
/////////////////////////////////////////////////////////////////// 
function orderdata($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('orders');
		return $query->result_array();	
	} 
/////////////////////////////////////////////////////////////////// 
function rconflictdata($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('conflictions');
		return $query->result_array();	
	} 
		
/////////////////////////////////////////////////////////////////// 
function contactdata($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('contact');
		return $query->result_array();	
	} 
		
/////////////////////////////////////////////////////////////////// 
function edituser($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('users');
		return $query->result_array();	
	} 
/////////////////////////////////////////////////////////////////// 
function editphoto($id)	{	 	           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('photos');
		return $query->result_array();	
	} 

/////////////////////////////////////////////////////////////////// 
function editpage($id)	{		            
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('pages');
		return $query->result_array();	
	} 

/////////////////////////////////////////////////////////////////// 
function edithtmlbox($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('htmlboxs');
		return $query->result_array();	
	} 		
/////////////////////////////////////////////////////////////////// 
function editorder($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('orders');
		return $query->result_array();	
	} 			
/////////////////////////////////////////////////////////////////// 
function editrconflict($id)	{		           
	
	    $this->db->where('id',$id);	  
		$query = $this->db->get('conflictions');
		return $query->result_array();	  
	} 		      
///////////////////////////////////////////////////////////////////
function alluserdetail()	{		           
	
	$result = $this->db->query("select * from users");    		
	return  $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function allphotodetail()	{		           
	
	$result = $this->db->query("select * from photos where `reviewed`='0'");    		
	return  $result->result_array();
	}

function allphotodetailReviewed()	{		           
	
	$result = $this->db->query("select * from photos where `reviewed`='1'");    		
	return  $result->result_array();
	}	

///////////////////////////////////////////////////////////////////
function allorderdetail()	{		           
	
	$result = $this->db->query("select * from orders");    		
	return  $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function allrcdetail()	{		           
	
	$result = $this->db->query("select * from conflictions order by `date` DESC");    		
	return  $result->result_array();
	}	
///////////////////////////////////////////////////////////////////

function allcontactdetail()	{		           
	
	$result = $this->db->query("select * from contact order by `date` DESC");    		
	return  $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
function allpagesdetail()	{		           
	
	$result = $this->db->query("select * from pages");    		
	return  $result->result_array();
	}
///////////////////////////////////////////////////////////////////
function allhtmlboxdetail()	{		           
	
	$result = $this->db->query("select * from htmlboxs");    		
	return  $result->result_array();
	}
	
function allpagelist()	{	 	            
	
	$result = $this->db->query("select * from pages");    		
	return  $result->result_array();
	}
		
///////////////////////////////////////////////////////////////////
function allbplist()	{		           
	
	$result = $this->db->query("SELECT `report_abuse` . * , CONCAT( `u`.`first_name` , ' ', `u`.`last_name` ) AS `user_reported_name` , CONCAT( `uv`.`first_name` , ' ', `uv`.`last_name` ) AS `reported_by_name`FROM `report_abuse` JOIN `users` `u` ON ( `u`.`id` = `report_abuse`.`user_reported` ) JOIN `users` `uv` ON ( `uv`.`id` = `report_abuse`.`reported_by` )  order by `date` DESC ");    		
	return  $result->result_array();
	}	
//////////////////////////////////////////////
function updateuser($userid,$data)	
	 {
		$this->db->where('id',$userid);		
		$success =$this->db->update('users',$data);
		return $success;
	 	
	 } 
//////////////////////////////////////////////
function updateorder($userid,$data)	
	 {
		$this->db->where('id',$userid);		
		$success =$this->db->update('orders',$data);
		return $success;
	 	
	 } 	
//////////////////////////////////////////////
function updateconflict($userid,$data)	
	 {
		$this->db->where('id',$userid);		
		$success =$this->db->update('conflictions',$data);
		return $success;
	 	
	 } 		 
	 
	 
//////////////////////////////////////////////
function updatepage($userid,$data)	
	 {
		$this->db->where('id',$userid);		
		$success =$this->db->update('pages',$data);
		return $success;
	 	
	 } 
	 		  
//////////////////////////////////////////////
function updatehtmlbox($userid,$data)	
	 {
		$this->db->where('id',$userid);		
		$success =$this->db->update('htmlboxs',$data);
		return $success;
	 	
	 } 	 
//////////////////////////////////////////////////////////////////
function inserorder($data){
			$this->db->insert('orders',$data);			
			return $this->db->insert_id();
		}	
//////////////////////////////////////////////////////////////////
function insertpage($data){
			$this->db->insert('pages',$data);			
			return $this->db->insert_id();
		}	
//////////////////////////////////////////////////////////////////
function inserthtmlbox($data){
			$this->db->insert('htmlboxs',$data);			
			return $this->db->insert_id();
		}				 
//////////////////////////////////////////////
function updatephoto($photoid,$data)	
	 {
		$this->db->where('id',$photoid);		
		$success =$this->db->update('photos',$data);
		return $success;
	 	
	 }

/////////////////////////////////////////////////////////////////// 
function delete($id){
			$this->db->where('id', $id);
			$this->db->delete('users');
		} 
/////////////////////////////////////////////////////////////////// 
function deletephoto($id){
			$this->db->where('id', $id);
			$this->db->delete('photos');
		} 	
/////////////////////////////////////////////////////////////////// 
function deletepage($id){
			$this->db->where('id', $id);
			$this->db->delete('pages');
		} 	
/////////////////////////////////////////////////////////////////// 
function deleteconflict($id){
			$this->db->where('id', $id);
			$this->db->delete('conflictions');
		} 						
/////////////////////////////////////////////////////////////////// 
function deletecontact($id){
			$this->db->where('id', $id);
			$this->db->delete('contact');
		} 						
///////////////////////////////////////////////////////////////////
function deleteorder($id){ 
			$this->db->where('id', $id);
			$this->db->delete('orders');
		} 	 
/////////////////////////////////////////////////////////////////// 
function deletehtmlbox($id){
			$this->db->where('id', $id);
			$this->db->delete('htmlboxs');  
		} 		
///////////////////////////////////////////////


function reviewImages($data)
{
	if(!empty($data['imageSelected']))
	{
		$ids=implode(',',$data['imageSelected']);
		$sql="update `photos` set  `reviewed`='1' where `id` IN($ids) ";
		$this->db->query($sql);
	}
}


function deleteImages($data)
{
	if(!empty($data['imageSelected']))
	{
		$ids=implode(',',$data['imageSelected']);
		
		$sel="select * from `photos` where `id` IN($ids)";
		$query=$this->db->query($sel);
		$res=$query->result_array();
		
		foreach($res as $img)
		{
			unlink('uploads/gallery/large/'.$img['pic_name']);
			unlink('uploads/gallery/small/'.$img['pic_name']);
			unlink('uploads/gallery/temp/'.$img['pic_name']);
			unlink('uploads/gallery/thumb/'.$img['pic_name']);
			unlink('uploads/gallery/verysmall/'.$img['pic_name']);
			
			$sql="delete from `photos`  where `id`='".$img['id']."' ";
			$this->db->query($sql);
		}
		  
		
	}
}




//////////////////////////////////////////////////////////////////	
		
	function newVehicles()	{		           
	
	$result = $this->db->query("select `suggested_brands`.* , CONCAT( `u`.`first_name` , ' ', `u`.`last_name` ) AS `user`   from `suggested_brands` JOIN `users` `u` on(`u`.`id`=`suggested_brands`.`user_id`)  and `reviewed`='0' order by `suggested_brands`.`date` DESC");    		
	//echo $this->db->last_query();
	return  $result->result_array();
	}	
///////////////////////////////////////////////////////////////////
		
	function newVehicle($id)	{		           
		
		$result = $this->db->query("select * from `suggested_brands` where `id`='".$id."'");
		//echo $this->db->last_query();
		return  $result->row_array();
		
		}
		
		
function newcar($id)	
{		           
		
		$result = $this->db->query("select * from `car_models` where `id`='".$id."'");
		//echo $this->db->last_query();
		return  $result->row_array();
		
}	

function CarMakeDetails($id)	
{		           
		
		$result = $this->db->query("select * from `car_brands` where `link` like'".$id."'");
		//echo $this->db->last_query();
		return  $result->row_array();
		
}





function bikeMakeDetails($id)	
{		           
		
		$result = $this->db->query("select * from `bike_brands` where `link` like'".$id."'");
		//echo $this->db->last_query();
		return  $result->row_array();
		
}	
		


	
		
function newBike($id)	
		{		           
		
			$result = $this->db->query("select * from `bike_models` where `id`='".$id."'");
			//echo $this->db->last_query();
			return  $result->row_array();
		
		}			
		
//////////////////////////////////////////////////////////////////	
	
function updateNewVehicleSubmit($data)	
	{		           
		$sql="update `suggested_brands` set ";
		 
		if(isset($data['brand']))
			$sql .=" `brand`='".$data['brand']."', ";
		
     	$sql .=" `model`='".$data['model']."' where `id`='".$data['id']."'";
		
		$result = $this->db->query($sql);
		//echo $this->db->last_query();
		
	}
	
	function reviewNewVehicleSubmit($data)
	{
		$suggestion=$this->newVehicle($data['id']);
		
		$type=$suggestion['type'];
		
		if($suggestion['suggestion']=='brand')
		{
			$brand=str_replace(' ','-',strtolower($suggestion['brand']));
			$sql="insert into `".$type."_brands` (`brand`,`link`)values('".$suggestion['brand']."','".$brand."')";
			$this->db->query($sql);
			$brandId=$this->db->insert_id();
		}
		else
		{
			$sql="select * from `".$type."_brands` where `link`='".$suggestion['brand']."'";
			$query=$this->db->query($sql);
			$res=$query->row_array();
			$brandId=$res['id'];
			$brand=$suggestion['brand'];
		}
		
		$model=str_replace(' ','-',strtolower($suggestion['model']));
		$sql1="insert into `".$type."_models` (`model`,`link`,`brand_id`)values('".$suggestion['model']."','".$model."','".$brandId."')";
		$this->db->query($sql1);
		
		$sql2="update `rides` set `make`='".$brand."' , `model`='".$model."' where `user_id`='".$suggestion['user_id']."'";
		$this->db->query($sql2);
		
		$sql3="update `suggested_brands` set `reviewed`='1' where `id`='".$data['id']."'";
		$this->db->query($sql3);
	}
	
	
function addNewCarModel($data)
	{       
			$link=trim(strtolower($data['model']));
			$link=str_replace(' ','-',$link);
			$link=checkLink($link,'car');
			
			$sql="insert into car_models(`model`,`brand_id`,`link`) values(?,?,?) ";
			$this->db->query($sql,array($data['model'],$data['id'],$link));
	}
	
function addNewCarBrand($data)
	{       $link=trim(strtolower($data['model']));
			$link=str_replace(' ','-',$link);
			$link=checkLinkBrand($link,'car');
			$sql="insert into car_brands(`brand`,`link`) values(?,?) ";
			$this->db->query($sql,array(ucfirst($data['model']),$link));
	}

function addNewBikeBrand($data)
	{       $link=trim(strtolower($data['model']));
			$link=str_replace(' ','-',$link);
			$link=checkLinkBrand($link,'bike');
			$sql="insert into bike_brands(`brand`,`link`) values(?,?) ";
			$this->db->query($sql,array(ucfirst($data['model']),$link));
	}
function addNewBikeModel($data)
	{
			$link=trim(strtolower($data['model']));
			$link=str_replace(' ','-',$link);
			$link=checkLink($link,'bike');
			$sql="insert into bike_models(`model`,`brand_id`,`link`) values(?,?,?) ";
			$this->db->query($sql,array($data['model'],$data['id'],$link));
			
	
    }
	
function checkLink($link,$type)
       {
	      if($type=='car')
	        {
	            $sql=" select * from car_models where `link` like ? ";
			    $query=$this->db->query($sql,$link);
			    $res=$query->row_array();
			    return $res;
	        }
	      if($type=='bike')
	        {
			    $sql=" select * from bike_models where `link` like ? ";
			    $query=$this->db->query($sql,$link);
			    $res=$query->row_array();
			    return $res;
			
	        }
	   
       }
	   
function checkLinkBrand($link,$type)
       {
	      if($type=='car')
	        {
	            $sql=" select * from car_brands where `link` like ? ";
			    $query=$this->db->query($sql,$link);
			    $res=$query->row_array();
			    return $res;
	        }
	      if($type=='bike')
	        {
			    $sql=" select * from bike_brands where `link` like ? ";
			    $query=$this->db->query($sql,$link);
			    $res=$query->row_array();
			    return $res;
			
	        }
	   
       }
	
function editCarModel($data)
     {
	        //$link=trim(strtolower($data['model']));
			//$link=str_replace(' ','-',$link);
			$sql=" update `car_models` set `model`=?  where `id`=?  ";
			$this->db->query($sql,array( $data['model'],$data['id']));
	 
	 }
	 	
function editCarMake($data)
     {
	        //$link=trim(strtolower($data['model']));
			//$link=str_replace(' ','-',$link);
			$sql=" update `car_brands` set `brand`=?  where id=?  ";
			$this->db->query($sql,array( $data['model'],$data['id']));
	 
	 }	
	 
function editBikeMake($data)
     {
	        //$link=trim(strtolower($data['model']));
			//$link=str_replace(' ','-',$link);
			$sql=" update `bike_brands` set `brand`=?  where id=?  ";
			$this->db->query($sql,array( $data['model'],$data['id']));
	 
	 }		 
	 
function deleteCarMakeSubmit($data)
     {
	        //$link=trim(strtolower($data['model']));
			//$link=str_replace(' ','-',$link);
			$sql=" delete from `car_brands` where `id`=?   ";
			$this->db->query($sql,array( $data['id1']));
	 
	 }
	 
function deleteBikeMakeSubmit($data)
     {
	        //$link=trim(strtolower($data['model']));
			//$link=str_replace(' ','-',$link);
			$sql=" delete from `bike_brands` where `id`=?   ";
			$this->db->query($sql,array( $data['id1']));
	 
	 }	  
	 	  
	 
	 	
function editBikeModel($data)
     {
	       // $link=trim(strtolower($data['model']));
			//$link=str_replace(' ','-',$link);
			$sql=" update `bike_models` set `model`=? where id=?  ";
			$this->db->query($sql,array( $data['model'],$data['id']));
	 
	 }	
function deleteCarModelSubmit($data)
      {
			  $sql=" delete from car_models where `id`=? ";
			  $this->db->query($sql,array($data['id']));
			  
	  }	
	  
function deleteBikeModelSubmit($data)
      {
			  $sql=" delete from bike_models where `id`=? ";
			  $this->db->query($sql,array($data['id']));
			  
	  }	

  function sticker_orders($status)
  {
	  $sort='`date`';
	  if($status==1)
	  	$sort='`date_shipped`';
		
	  $sql=" select * from `order_sticker` where `status`='".$status."' order by ".$sort." DESC";
	  $query=$this->db->query($sql);
	  $res=$query->result_array();
	  return $res;
  }	
  
  function stickerShippedPopSubmit($id)
  {
	  $sql=" update `order_sticker` set `status`='1', `date_shipped`='".date('Y-m-d H:i:s')."' where `id`='".$id."'";
	  $this->db->query($sql);
  }
	
}
?>
