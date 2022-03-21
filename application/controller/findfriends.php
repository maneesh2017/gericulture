<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require "system/twitteroauth/autoload.php";
//require_once("system/twitteroauth/src/TwitterOAuth.php"); 
//use Abraham\TwitterOAuth\TwitterOAuth; 

class findfriends extends CI_Controller {


	/**
	 * Index Page for this controller.	 
	 */
///////////////////////////////////////////////////////////////////
 function __construct()  {      
        parent::__construct();
		$this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');	
		$this->load->model('findfriends_model');
		$this->load->model('main_model');
	}
    
         
//////////index function statrt here//////////////   
public function index()	{ 	 
		ensureUser();
		$userdata = userSession();
		$arData =   array();
		$arData['page_title']="Find Friends";  		
		$arData['site']=4;
		$arContent['content'] = $this->load->view('findfriends/index',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 
	}     
	
function gmail()
{
	 	ensureUser();
		$userdata = userSession();
		$arData =   array();
		$arData['page_title']="Find Friends";  		
		$this->load->model('findfriends_model');
		$arData['site']=1;
		$arData['userdata']=$userdata;
		
		/*if(isset($_GET['account']))
			$arData['account']=$_GET['account'];
		else
			{
				$acconts=getImportedAccounts($arData['site']);
				if(!empty($acconts))
					$arData['account']=$acconts[0];
			}*/
		$arData['contacts']=$this->findfriends_model->getImportedContacts($arData);
		
		if(isset($_GET['account']) && empty($arData['contacts']))
			header('location:'.site_url().'findfriends/gmail');
		
		$arContent['content'] = $this->load->view('findfriends/index',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 
}	


function gmailFriendList()
{
	$gmailAPI=gmailAPI();
	
	$clientid =$gmailAPI['id'];
	$clientsecret = $gmailAPI['secret'];
	$redirecturi = 	site_url()."findfriends/gmailFriendList";
	$maxresults = 1000; // Number of mailid you want to display.
	
	$authcode		= $_GET["code"];
	$userdata = userSession();	

	$fields=array(
	'code'=>  urlencode($authcode),
	'client_id'=>  urlencode($clientid),
	'client_secret'=>  urlencode($clientsecret),
	'redirect_uri'=>  urlencode($redirecturi),
	'grant_type'=>  urlencode('authorization_code') );

	$post = '';
    foreach($fields as $key=>$value)
    {
        $post .= $key.'='.$value.'&';
    }
    $post = rtrim($post,'&');
    $result = $this->curl('https://accounts.google.com/o/oauth2/token',$post);
    $response =  json_decode($result);
    $accesstoken = $response->access_token;
    $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$maxresults.'&alt=json&v=3.0&oauth_token='.$accesstoken;
    $xmlresponse =  $this->curl($url);
    $contacts = json_decode($xmlresponse,true);
	//echo $contacts['feed']['id']['$t'];
	 //see($contacts);
	 $return = array();
	 if (!empty($contacts['feed']['entry'])) 
	 {
		   foreach($contacts['feed']['entry'] as $contact) 
		   {
					 //retrieve Name and email address  
					 
					 if(isset($contact['gd$email']))
					 {
							 $return[] = array (
							 'name'=> $contact['title']['$t'],
							 'email' => $contact['gd$email'][0]['address'],
							 );
					 }
		   } 
	 }
	
		  $result=array();
		  $result['contacts']=$return;
		 //$result['name']=$name;
		  $result['user_id']=$userdata['id'];
		  $result['site']='1';
		  $result['account_email']=$contacts['feed']['id']['$t'];
		 
		 //see($result);
		  $this->load->model('findfriends_model');
		  $this->findfriends_model->addImportedContacts($result);
		  $this->load->view('findfriends/importMessage',$result); 
}

function curl($url, $post = "") {
	$curl = curl_init();
	$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
	curl_setopt($curl, CURLOPT_URL, $url);
	//The URL to fetch. This can also be set when initializing a session with curl_init().
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	//The number of seconds to wait while trying to connect.
	if ($post != "") {
		curl_setopt($curl, CURLOPT_POST, 5);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
	}
	curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
	//The contents of the "User-Agent: " header to be used in a HTTP request.
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
	//To follow any "Location: " header that the server sends as part of the HTTP header.
	curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
	//To automatically set the Referer: field in requests where it follows a Location: redirect.
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	//The maximum number of seconds to allow cURL functions to execute.
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	//To stop cURL from verifying the peer's certificate.
	$contents = curl_exec($curl);
	curl_close($curl);
	return $contents;
}

function yahoo()
 {
	 	ensureUser();
		$userdata = userSession();
		//see($userdata);
		
		$arData =   array();
		$arData['page_title']="Find Friends";
		$this->load->model('findfriends_model');
		$arData['site']=2;
		$arData['userdata']=$userdata;
		/*$arData['account']=0;*/
	
		$arData['contacts']=$this->findfriends_model->getImportedContacts($arData);
		$arContent['content'] = $this->load->view('findfriends/index.php',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 
}

function yahooFriendList()
{
		  $userdata = userSession();	
	
		  $yahooAPI=yahooAPI();
		  $consumer_key=$app_id=$yahooAPI['id'];
		  $consumer_secret=$yahooAPI['secret'];
		  $connected_path = 'yhoo';
		  $re_url = site_url().$connected_path;
		  
		  require_once ('system/yahoo/Yahoo.inc');
		  
		  $session = YahooSession::requireSession($consumer_key,$consumer_secret,$app_id);
	  if (is_object($session))
	  {
		  YahooSession::clearSession();
	  $user = $session->getSessionedUser();
	  $profile = $user->getProfile();
	  $name = $profile->nickname; // Getting user name
	  $guid = $profile->guid; // Getting Yahoo ID
	  $contacts=$user->getContacts()->contacts;
	  //see($profile);
	  //see($contacts->contact);
	  //echo "Hi! ".$name."<br />";
	  
	  foreach($contacts->contact as $contact)
	  {
		  $c=array();
		  foreach($contact->fields as $field)
		  {
			  if($field->type=='name')
				  $c['name']=$field->value->givenName.' '.$field->value->middleName.' '.$field->value->familyName;
			  if($field->type=='email')
				  $c['email']=$field->value;
		  }
		  if(!isset($c['email']))
			  $c=array();
				  
		  if(!empty($c))
			  $email_fr[]=$c;
		  unset($c);
	  }
	  
		  foreach($email_fr as $k=>$friend)
		  {
			  
			  if(!isset($friend['name']))
				  $email_fr[$k]['name']='';
			  //echo "<p>".$friend['name']." (".$friend['email'].")</p>";
		  }
		  
		  $result['contacts']=$email_fr;
		  $result['name']=$name;
		  $result['user_id']=$userdata['id'];
		  $result['site']='2';
		  $result['account_email']=0;
		  
		  $this->load->model('findfriends_model');
		  $this->findfriends_model->addImportedContacts($result);
		  $this->load->view('findfriends/importMessage',$result);
	  
	  }
	  else
	  {
		  header("Location :".$re_url);
	  }
}

function yhoo()
{
	 $yahooAPI=yahooAPI();
	 $consumer_key=$app_id=$yahooAPI['id'];
	 $consumer_secret=$yahooAPI['secret'];
	 $connected_path = 'yhoo';
	 $re_url = site_url().$connected_path;
	
	require_once ('system/yahoo/Yahoo.inc');
	
	$session = YahooSession::requireSession($consumer_key,$consumer_secret,$app_id);
	if (is_object($session))
	{
	}
	else
	{
	header("Location :".$re_url);
	}
}


  function outlook()
  {
 		ensureUser();
		$userdata = userSession();
		$arData =   array();
		$arData['page_title']="Find Friends";  		
		$this->load->model('findfriends_model');
		$arData['site']=3;
		$arData['userdata']=$userdata;
		
		/*if(isset($_GET['account']))
			$arData['account']=$_GET['account'];
		else
			{
				$acconts=getImportedAccounts($arData['site']);
				if(!empty($acconts))
					$arData['account']=$acconts[0];
			}*/
		
		$arData['contacts']=$this->findfriends_model->getImportedContacts($arData);
		$arContent['content'] = $this->load->view('findfriends/index',$arData,true);	
		$this->load->view('layouts/default-user.php',$arContent); 
  }    
  
  
  function outlookFriendList()
  {
	 $outlookAPI=outlookAPI();
	 $client_id=$outlookAPI['id'];
	 $client_secret=$outlookAPI['secret'];
	 $redirect_uri=$outlookAPI['redirect_uri'];
	 
	 $userdata = userSession();	
	 
	 $auth_code = $_GET["code"];
	$fields=array(
	'code'=>  urlencode($auth_code),
	'client_id'=>  urlencode($client_id),
	'client_secret'=>  urlencode($client_secret),
	'redirect_uri'=>  urlencode($redirect_uri),
	'grant_type'=>  urlencode('authorization_code')
	);

	$post = '';
	foreach($fields as $key=>$value) { $post .= $key.'='.$value.'&'; }
	
	$post = rtrim($post,'&');
	$curl = curl_init();
	curl_setopt($curl,CURLOPT_URL,'https://login.live.com/oauth20_token.srf');
	curl_setopt($curl,CURLOPT_POST,5);
	curl_setopt($curl,CURLOPT_POSTFIELDS,$post);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
	$result = curl_exec($curl);
	curl_close($curl);
	$response =  json_decode($result);
	$accesstoken = $response->access_token;
	
	$url = 'https://apis.live.net/v5.0/me/contacts?access_token='.$accesstoken;
	$xmlresponse =   $this->curl_file_get_contents($url);
	$xml = json_decode($xmlresponse, true);
	$contacts_email = "";
	
	$urlUser= 'https://apis.live.net/v5.0/me?access_token='.$accesstoken;
	$xmlresponseUser =   $this->curl_file_get_contents($urlUser);
	$xmlUser = json_decode($xmlresponseUser, true);
	//echo $xmlUser['emails']['account'];
	
	
	$count = 0;
	$email_fr=array();
	foreach ($xml['data'] as $title) 
	{
		$c=array();
		$count++;
		 //echo $count.". ".$title['name'].' - '.$title['emails']['personal'] . "<br><br>";
		 $c['name']=$title['name'];
		 $c['email']=$title['emails']['personal'];
		 $email_fr[]=$c;
	}
	 
	 //see($email_fr);
	 
	  $result=array();
	  $result['contacts']=$email_fr;
	  $result['user_id']=$userdata['id'];
	  $result['site']='3';
	  $result['account_email']= $xmlUser['emails']['account'];
	  
	  //see($result);
	  $this->load->model('findfriends_model');
	  $this->findfriends_model->addImportedContacts($result);
	  $this->load->view('findfriends/importMessage',$result);
  }
  
  function curl_file_get_contents($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
/////////////////////////////////////////////////////////	
	
function inviteByEmail()
	{
		if(ensureUser_popup())
			{
				$data=$_POST;
				if(!empty($data))
				{
								$input['email']=$data['inviteByEmailId'];
								$res=getUserInfoByEmail($input['email']);
								if(!empty($res))
								{
								echo strtoupper($res['username']);
								
								}
								else
								{
								  echo "no";
								  $emaildata['Userdetail'] =userSession();
								  $RideInfo=getRideInfo($emaildata['Userdetail']['id']);
								  $getListVehicleBrand=getListVehicleBrand($RideInfo['type'],1);
								  $emaildata['make']=$getListVehicleBrand[$RideInfo['make']];
								  $emaildata['model']=getModelText($RideInfo['model'],$RideInfo['type']);
								  $emaildata['cover']=getCover($emaildata['Userdetail']['id'],'thumb');
								  $emaildata['profilePic']=getProfilePic($emaildata['Userdetail']['id'],'thumb');
								  $emaildata['reciever']=$input['email'];
								  
								  $this->load->library('email');             
								  $config['mailtype'] = 'html';
								  $this->email->initialize($config);
								  $this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name'));
								  $confirmemailtemplate=$this->load->view('emails/email_invitation',$emaildata,true);
								  $this->email->to($data['inviteByEmailId']);   
								  $this->email->subject('Join me on Geri Culture');
								  $this->email->message($confirmemailtemplate);
								  $this->email->send(); 
								  
								  $this->findfriends_model->saveInvitedFrnd($data['inviteByEmailId']);
								}
				}
			}
			else
				echo 'LO';	
	}
	
	
	function sendInvitationToMany()
	{
		if(ensureUser_popup())
			{
				$data=$_POST;
				if(!empty($data))
				{
								foreach($data['sendInviteTo'] as $email){
								$input['email']=$email;echo $input['email'].' ';
								$res=getUserInfoByEmail($input['email']);
								
								  $emaildata['Userdetail'] =userSession();
								  $RideInfo=getRideInfo($emaildata['Userdetail']['id']);
								  $getListVehicleBrand=getListVehicleBrand($RideInfo['type'],1);
								  $emaildata['make']=$getListVehicleBrand[$RideInfo['make']];
								  $emaildata['model']=getModelText($RideInfo['model'],$RideInfo['type']);
								  $emaildata['cover']=getCover($emaildata['Userdetail']['id'],'thumb');
								  $emaildata['profilePic']=getProfilePic($emaildata['Userdetail']['id'],'thumb');
								  $emaildata['reciever']=$input['email'];
								  
								  $this->load->library('email');             
								  $config['mailtype'] = 'html';
								  $this->email->initialize($config);
								  $this->email->from($this->config->item('email_from_address'),$this->config->item('email_from_name'));
								  $confirmemailtemplate=$this->load->view('emails/email_invitation',$emaildata,true);
								  $this->email->to($input['email']);   
								  $this->email->subject('Join me on Geri Culture');
								  $this->email->message($confirmemailtemplate);
								  $this->email->send(); 
								  
								  $this->findfriends_model->saveInvitedFrnd($input['email']);
								}
				}
			}
			else
				echo 'LO';	
	
	}
	
}
