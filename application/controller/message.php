<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller 
{
	
///////////////////////////////////////////////////////////////////
 function __construct()  
 {      
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('main_model');
		$this->load->model('User_model');
    }
	/////////////////////////////////////////////////////////////////////////////////
function ensuremsgUser()
 // get admin_id check whether its equal to administrator, if equal stay otherwise logout
     {
			return ensureUser();
	}
/////////////////////////////////////////////////////////////////	
	public function index()	{ 
		
	   $this->ensuremsgUser();
	   $arData =   array();  	  
	   $LoggedInUser= array();
	   $arData['page_title']="Messages";  
	   $chat= $this->uri->segment(2);
       $arData['chat'] = $chat;
	   $LoggedInUser=userSession();
	   $arData['LoggedInUser'] = $LoggedInUser;
	   
	   $getUserMsgs=getUserMsgs($LoggedInUser['id']);
	   //see($getUserMsgs);
	   foreach($getUserMsgs as $msgK=>$msgV)
	   {
		 			$pPicMsgPath=getProfilePic($msgV['user_id'],'small');
					$getUserMsgs[$msgK]['profile_pic']=$pPicMsgPath;
			
					$getLatestMsgByUser=getLatestMsgByUser($msgV['user_id'],$LoggedInUser['id']);
					$getUserMsgs[$msgK]['latest_message']=$getLatestMsgByUser;
		}
	   //see($getUserMsgs);
	   $arData['messages']=$getUserMsgs;
	   
	   //see($arData['messages']);
	   
	   $arContent['content'] = $this->load->view('messages/message.php',$arData,true);
	   $this->load->view('layouts/default-user.php',$arContent);  
  }
 
/////////////////////////////////////////////////////////////////	
	public function newMsgPopUpForm()	{  	
	   if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	  else
		{	
			 $arData =   array();	   
			 
			 $arData['Userdetail']=userSession();
			 
			 $userid = $arData['Userdetail']['username'];
			 $user_id = $arData['Userdetail']['id'];
			 $arData['friendlist'] = $this->main_model->frd_list_to_add($userid); 	  
			 $arContent['content'] = $this->load->view('messages/sendmsg.php',$arData,true);
			 $this->load->view('layouts/empty.php',$arContent);  
		}
  }
/////////////////////////////////////////////////////////////////////////////////////////  
public function smsgdata()	{ 	
	  
	  if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	  else
		{	
			  $arData =   array();   
			  $arData['Userdetail']=userSession();
			  $userid = $arData['Userdetail']['id'];
			  if(isset($_POST['queryString'])) {			
				  $queryString = $_POST['queryString'];				
				  if(strlen($queryString) >0) {
					  $code='name';
					  $arData['friendlist'] = $this->main_model->frd_list_to_add_new($userid,$queryString,$code);				
				  }
			   }
			  //$arData['friendlist'] = $this->main_model->frd_list_to_add($userid);
				/*$arContent['content'] = $this->load->view('messages/smsgdata.php',$arData,true);	
				$this->load->view('layouts/empty.php',$arContent);    
	  */		
			  $this->load->view('messages/smsgdata.php',$arData);	
		}
  }  
  
  
  public function smsgdata_uname()	{ 	
		
		if(!ensureUser_popup())
			$this->load->view('layouts/if_logged_out.php');
	  else
		{	
			$arData =   array();   
			$arData['Userdetail']=userSession();
			$userid = $arData['Userdetail']['id'];
			if(isset($_POST['queryString'])) {			
				$queryString = $_POST['queryString'];				
				if(strlen($queryString) >0) {
					$code='uname';
					$arData['friendlist'] = $this->main_model->frd_list_to_add_new($userid,$queryString,$code);				
				}
			 }
			
			$this->load->view('messages/smsgdata.php',$arData);	
		}
  }
  
/////////////////////////////////////////////////////////////////	
	public function chatdetail()	{
		
	  if(!ensureUser_popup())
	  {
			 $res['html']='LO';
			 $res['prev']='';
			
			 $json=json_encode($res);
			 echo $json;
			 die;  
	  }
	  else
		{	
		
				  $this->ensuremsgUser();
				 $arData =   array();  	  
				 $LoggedInUser= array(); 
				 
				 $LoggedInUser=userSession();
				 $frndid =$_POST['chatid'];
				 $get_block_status=get_block_status($frndid);
				  if(empty($get_block_status))
				  {
						 $arData['LoggedInUser'] = $LoggedInUser;
						 
						$getMsgByUser=getMsgByUser($frndid,$LoggedInUser['id'],msgPerPage());
					  //see($getMsgByUser);
						 
						 $getMsgByUserAll=count(getMsgByUser($frndid,$LoggedInUser['id'],0,0));
						  
						  $prev=0;
						  if((msgPerPage())<$getMsgByUserAll)
							  $prev=1;
						  $this->chatdetail_part2($frndid,$getMsgByUser,$prev);
				  }
	   }
  } 
  
  function chatdetail_part2($frndid,$getMsgByUser,$prev)
  {
	  $this->ensuremsgUser();
	  $LoggedInUser= array();        
	  $LoggedInUser=userSession();
	  $frndInfo=getUserInfo($frndid);
	   $getCover=getCover($LoggedInUser['id'],'verysmall');
	   $getCoverFriend=getCover($frndid,'verysmall');
	   $myPicPath=getProfilePic($LoggedInUser['id'],'verysmall');
	   $frndPicPath=getProfilePic($frndid,'verysmall');
		
		//see($getMsgByUser);
		$dateOnTop=0;
		 $html='<a href="javascript:void(0);" id="loadPrevMsg" onclick="loadPrevMsg();" style="display:none;"><span><!--Load previous messages--></span></a><a href="javascript:void(0);" id="loadingPrevMsg" style="display:none;"><span><img src="'.system_path().'img/circle-load-small-chat.gif"></span></a><div class="loadPrevMsgP"></div><div class="chatBoxMsg-msgs">'; 
	   if(!empty($getMsgByUser))
	   {
			   $getMsgByUser=array_reverse($getMsgByUser);
			   $date='000-00-00';
			   foreach($getMsgByUser as $mdetail)
					   {
						  if($date!=date('Y-m-d',strtotime($mdetail['created'])) || $date=='0000-00-00')
						  {
							$date=date('Y-m-d',strtotime($mdetail['created']));
						  	if($dateOnTop>0)
								$html .= '<p>'.date("d M Y",strtotime($date)).'</p>';
							$dateOnTop++;
						  }
							
						  if($mdetail['user_id']== $LoggedInUser['id'])
								{
									$html .= '<article style="margin-bottom:20px;" id="myChatMsg-'.$mdetail['id'].'" class="floatRight myChatMsg" date="'.date("d M Y",strtotime($date)).'">
									   <a href="javascript:void(0);" class="deleteChatMsg" onclick="return deleteChatMsg('.$mdetail['id'].');" >Close</a>
									   <figure class="floatRight new-2pics"> <img src="'.$getCover.'" alt="user" /></figure>
									   <div class="floatRight"><!--<p>'.date("jS F Y",strtotime($date)).' '.$mdetail['id'].'</p>-->
										 <hgroup><h5><a href="javascript:void(0);">You</a></h5></hgroup>
										 <p>'.$mdetail['message'].'</p>
									   </div>
									   
									   <span> '.date("g:i a",strtotime($mdetail['created'])).'</span>
									</article>';
								}
							else
							{
								 markMsgRead($mdetail['id']);
								 
								 
									$html .= '<article style="margin-bottom:20px;" id="otherChatMsg-'.$mdetail['id'].'" class="floatLeft otherChatMsg" date="'.date("d M Y",strtotime($date)).'">
					<a href="'.base_url().'profile/'.$frndid.'" class="floatLeft other-new-2pics"><img src="'.$getCoverFriend.'" alt="user" /></a>
										   <span> '.date("g:i a",strtotime($mdetail['created'])).'</span>
										   <div class="floatLeft"><!--<p>'.date("jS F Y",strtotime($date)).' '.$mdetail['id'].'</p>-->
											 <hgroup><h5><a href="'.base_url().'profile/'.$frndid.'">'.$frndInfo['username'].'</a></h5></hgroup>
											 <p>'.$mdetail['message'].'</p>
										   </div>
										  
										   <a href="javascript:void(0);" class="deleteChatMsg" onclick="return deleteChatMsg('.$mdetail['id'].');" >Close</a>
										</article>';	
							}
							
							
							
					   }
					    
					   
	   }
	   
	   $html .= '</div>';
	   $res['html']=$html;
	   $res['prev']=$prev;
	   
	   $json=json_encode($res);
	   echo $json;
	   die;  
	  
  } 
	
/////////////////////////////////////////////////////////////////	
	public function replymsg()	{  

	   $this->ensuremsgUser();
	   $arData = array();  	  
	   $LoggedInUser= array(); 
       
	   $LoggedInUser=userSession();
	   
	   $replymsg =$_POST['replymsg'];
	   $msuser =$_POST['msuser'];
  	   $date=date('Y-m-d H:i:s');
	   $get_block_status=get_block_status($msuser);
	   if(empty($get_block_status))
	   {

$data = array('user_id'=>$LoggedInUser['id'],'message'=>$replymsg,'friend_id'=>$msuser,'created'=>$date);
	   $frienduserdetail =$this->main_model->replymsginsert($data);
	   }
	}
/////////////////////////////////////////////////////////////////	
	public function deletemsg()	{  

	   $this->ensuremsgUser();
	   $id= $this->uri->segment(3);
	   $this->main_model->delete_message($id);
	   //redirect(site_url().'message/','refresh');  
  }  
/////////////////////////////////////////////////////////////////	
	public function deleteallmsg()	{  

	   $this->ensuremsgUser();
	   $id= $this->uri->segment(3);
	   $LoggedInUser= array(); 
       
	   $LoggedInUser=userSession();
	   $userid =$LoggedInUser['username'];
	   $this->main_model->delete_allmessage($id,$userid);
	   redirect(site_url().'message/','refresh');  
  }
  
  function getMsgCount()
  {
	  	$LoggedInUser=userSession();
		$user_id = $LoggedInUser['id'];
	  
	  	$chatid=$_POST['chatid'];
	   
	   $getMsgByUser=getUserMsgsUnread($user_id);
	   
	  
	   //echo count($getMsgByUser);
	   $count=count($getMsgByUser);
	   
	   
	   $getUserMsgs=getUserMsgs($user_id);  
	   
	  //see($getUserMsgs);
	   foreach($getUserMsgs as $msgK=>$msgV)
	   {
		 			$pPicMsgPath=getProfilePic($msgV['user_id'],'small');
					$getUserMsgs[$msgK]['profile_pic']=$pPicMsgPath;
			
					$getLatestMsgByUser=getLatestMsgByUser($msgV['user_id'],$LoggedInUser['id']);
					$getUserMsgs[$msgK]['latest_message']=$getLatestMsgByUser;
		}
	   //see($getUserMsgs);
	   $messages=$getUserMsgs;
	   //see($messages);
	   $html='';
	   if(!empty($messages)){ foreach($messages as $msgK=>$msg ){
		   
		   $newMsgBox=$msgStatus='';
		   if($chatid==$msg['user_id'])
				$newMsgBox='newMsgBox';
			
			if($msg['latest_message']['status']==0 && $msg['latest_message']['user_id']!=$user_id)	
				$msgStatus=' unread ';
			
			 $getListVehicleBrand=getListVehicleBrand($msg['type'],1);
			 $model=getModelText($msg['model'],$msg['type']);
				
		/*$html .=' </div><article id="chat_'.$msg['user_id'].'" onclick="return getchat('.$msg['user_id'].',1);" class="'.$newMsgBox.$msgStatus.'">
          <figure>
		  <img src="'.$msg['profile_pic'].'" alt="user pic" width="75" height="75" />
		  </figure>
          <div class="positionRel">
           <span class="positionAbs">'.date("g:i a, jS F Y",strtotime($msg['latest_message']['created']) ).'</span>
           <hgroup>
		   <h2 style="margin-top:-7px;">
		   <a href="javascript: void(0)" >
		   '.$msg['first_name'].'&nbsp'.$msg['last_name'].'
		   </a>
		   </h2>
		   <h2>'.$msg['username'].' - '.$msg['model'].'</h2>
		   </hgroup>
           <p>'.substr($msg['latest_message']['message'],0,27).'...</p>
           <a class="delete-sidebar Deleteconversation" href="javascript:void(0);" onclick="return deleteconv('.$msg['user_id'].');"><img src="'.$this->config->item('system_path').'img/sidebar-delete-cross.png"></a>
		  </div>
        </article>';*/
		
		
		$html .='   <article id="chat_'.$msg['user_id'].'" onclick="return getchat('.$msg['user_id'].',1);" class="'.$newMsgBox.$msgStatus.'">
          <figure>
		  <img src="'.$msg['profile_pic'].'" alt="user pic" width="75" height="75" />
		  </figure>
          <div class="positionRel" style="position:relative;">

           <hgroup>
		   <h2 style="margin-top:-7px;">
		   <a href="javascript: void(0)" style="text-transform:capitalize; font-weight:normal;" >
		   '.$msg['first_name'].'&nbsp'.$msg['last_name'].'
		   </a>
		   </h2>
		   <h2 style="font-weight:normal;">'.$getListVehicleBrand[$msg['make']].' '.$model.'</h2>
		   </hgroup>
           <p>'.substr($msg['latest_message']['message'],0,27).'</p>
           
           <a class="delete-sidebar Deleteconversation" href="javascript:void(0);" onclick="return deleteconvConf('.$msg['user_id'].');"><img src="'.$this->config->item('system_path').'img/sidebar-delete-cross.png"></a>
           
          </div>
        </article>';
		
	   }}
	   
	   
	   $getUserMsgsUnread=getUserMsgsUnread($user_id);
	   
	  
	   // see($getUserMsgsUnread);
		foreach($getUserMsgsUnread as $msgK=>$msgV)
	   {
		 	$getLatestMsgByUser=getLatestMsgByUser($msgV['user_id'],$user_id);
			$getUserMsgsUnread[$msgK]['message']=$getLatestMsgByUser;
		 } 	
		 
	
			$htm='';	
				if(!empty($getUserMsgsUnread)){ foreach($getUserMsgsUnread as $msginfo)
				{
					$pPicMsgPath=getProfilePic($msginfo['user_id'],'thumb');
					$getCover=getCover($msginfo['user_id'],'verysmall');
					$getListVehicleBrand=getListVehicleBrand($msginfo['type'],1);
					$brand=$getListVehicleBrand[$msginfo['make']];
					$model=getModelText($msginfo['model'], $msginfo['type']);
					
			/*$htm .='
			<li>
			  <a href="'.base_url().'message/'.$msginfo['user_id'].'">
			  <img src="'.$pPicMsgPath.'" alt="user" class="floatLeft" width="38" height="38" />
			   <div class="floatLeft">
				  <h1 class="marginBttm2 floatLeft">'.ucwords($msginfo['first_name']).'&nbsp'.ucwords($msginfo['last_name']).'</h1>
				  <span class="floatRight marginTop4 marginRyt4">
				  '.date("jS F, Y",strtotime($msginfo['message']['created']) ).'</span>
				  <p class="clear">'.substr($msginfo['message']['message'],0,27) .' ...</p>
			   </div></a>
			</li>';*/
			
			$htm .='<li class="message-dropdown">
            <a href="'.base_url().'message/'.$msginfo['user_id'].'">
			  <div class="flashes-dropdown-left">
            <span class="flash-clock">'.flashMsgTimeAgo($msginfo['message']['created']).'</span>
            <figure><img src="'.$getCover.'" alt="user" class="" width="86" height="38" /></figure>
            <img src="'.$pPicMsgPath.'" alt="user" class="floatLeft" width="38" height="38" />
            </div>
			   <div class="floatLeft flashes-dropdown-right">
				   <h1 class="marginBttm2 floatLeft"><b>'.$brand.' '.$model.'</b></h1> 
				    <p class="clear">'.$msginfo['username'].' - '.ucwords($msginfo['first_name']).'&nbsp'.ucwords($msginfo['last_name']).'</p>
                    <span>'.substr($msginfo['message']['message'],0,27).'</span>
			   </div>
             </a>
			</li>';
			
                         }}else {$htm .="<p style='padding:5px 10px 0;'> No new messages. </p>";} 
            $htm .='<li class="justViewAll_1" id="messages-dropdown-arrow-bg"><p><a href="'.base_url().'message">View All Messages</a></p></li>';
		 
	   
	  // echo $html;
	   $res=array('count'=>$count,'list'=>$html,'noti'=>$htm);
	   echo $resJson=json_encode($res);
	   
 }
/////////////////////////////////////////////////////////////////	

	function sendmsgtomany()
	{
		$this->ensuremsgUser();
	   	$arData = array();  	  
	   	$LoggedInUser= array(); 
        $LoggedInUser=userSession();
		
		$data=$_POST;
		$date=date('Y-m-d H:i:s');
		$replymsg =$data['message'];
		
		if(!empty($data['users']) && $data['message']!='')
		{
			foreach($data['users'] as $userK=>$userV)
			{
				 $msuser =$userV;
				 $data = array('user_id'=>$LoggedInUser['id'],'message'=>$replymsg,'friend_id'=>$msuser,'created'=>$date);
				 $this->load->model('main_model');
				 $this->main_model->replymsginsert($data);	
			}
			echo 'sent';
		}
	}
	
	function deleteconv()
	{
		$this->ensuremsgUser();
		if(isset($_POST['id']) && $_POST['id']!='')
		{
			$this->load->model('main_model');
			$this->main_model->deleteconv($_POST['id']);
		}
	}
	
	function loadPrevMsg($frndid,$page)
	{
		$this->ensuremsgUser();
		$LoggedInUser=userSession();
		
		$perpage=msgPerPage();
		$limit=($page-1)*$perpage;
		
		$getMsgByUser=getMsgByUser($frndid,$LoggedInUser['id'],$perpage,$limit);
		$getMsgByUserAll=count(getMsgByUser($frndid,$LoggedInUser['id'],0,0));
		
		$prev=0;
		if(($perpage+$limit)<$getMsgByUserAll)
			$prev=1;
		$this->chatdetail_part2($frndid,$getMsgByUser,$prev);
	}
	
	
	function reloadChat($frndid,$page)
	{
		
		 if(!ensureUser_popup())
		{
			   $res['html']='LO';
			   $res['prev']='';
			  
			   $json=json_encode($res);
			   echo $json;
			   die;  
		}
	  else
		{	
		
		 $get_block_status=get_block_status($frndid);
		 if(empty($get_block_status))
		 {
			$LoggedInUser=userSession();
			
			$perpage=msgPerPage();
			$limit=$page*$perpage;
		
			$getMsgByUser=getMsgByUser($frndid,$LoggedInUser['id'],$limit,0);
			//$getMsgByUserAll=1;
			$getMsgByUserAll=count(getMsgByUser($frndid,$LoggedInUser['id'],0,0));			
			
		$prev=0;
		//if(($perpage+$limit)<$getMsgByUserAll)
		if(($limit)<$getMsgByUserAll)
			$prev=1;
		
			$this->chatdetail_part2($frndid,$getMsgByUser,$prev);
		 }
		 else
		 {
		 	$res['html']='';
			$json=json_encode($res);
	   		echo $json;
	   		die;  
		 }
		}
	}
	
}

/* End of file message.php */
/* Location: ./application/controllers/message.php */
