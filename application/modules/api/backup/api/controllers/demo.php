

/* 
* _login
*
* This method is used to login
* @method  : POST
* @author  : Chetan Varshney
* @created : Nov 22, 2017
*/

private function _login($Request) {
$app_key = (isset($Request['app_key']) && !empty($Request['app_key'])) ? $Request['app_key'] : '';
$email = (isset($Request['email']) && !empty($Request['email'])) ? $Request['email'] : '';
$password = (isset($Request['password']) && !empty($Request['password'])) ? $Request['password'] : '';
$social_type = (isset($Request['social_type']) && !empty($Request['social_type'])) ? $Request['social_type'] : '';
$social_id = (isset($Request['social_id']) && !empty($Request['social_id'])) ? $Request['social_id'] : '';
$first_name = (isset($Request['first_name']) && !empty($Request['first_name'])) ? $Request['first_name'] : '';
$last_name = (isset($Request['last_name']) && !empty($Request['last_name'])) ? $Request['last_name'] : '';
$country = (isset($Request['country']) && !empty($Request['country'])) ? $Request['country'] : '';
$device_token = (isset($Request['device_token']) && !empty($Request['device_token'])) ? $Request['device_token'] : '';
$device_type = (isset($Request['device_type']) && !empty($Request['device_type'])) ? $Request['device_type'] : '';
//echo $social_type ; die;
if (empty($social_type))
{

$Code = ResponseConstant::UNSUCCESS;
$Message = ResponseConstant::message('REQUIRED_PARAMETER');
$this->sendDaResponse($Code, $Message); // return data
}

if (empty($app_key))
{
$Code = ResponseConstant::UNSUCCESS;
$Message = ResponseConstant::message('REQUIRED_PARAMETER');
$this->sendDaResponse($Code, $Message); // return data
}

$checkAppKey = $this->checkAppKey($app_key);

if($checkAppKey !== 'DA$#123#&789')
{
$Code = ResponseConstant::HEADER_UNAUTHORIZED;
$Message = ResponseConstant::message('HEADER_UNAUTHORIZED');
$this->sendResponse($Code, $Message); // return data
}
//Normal login Start
if($social_type == 3){
if (empty($app_key)  ||  empty($email) || empty($password) )
{
$Code = ResponseConstant::UNSUCCESS;
$Message = ResponseConstant::message('REQUIRED_PARAMETER');
$this->sendDaResponse($Code, $Message); // return data
}else{  
$UsersTableObj = $this->getServiceLocator()->get("UsersTable");

$password = md5($password);   // Password encrypt
$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id','last_knowledge_point','last_global_rank');
$where = array('email'=>$email,'password'=>$password,'is_deleted'=>0);
$table = array('use'=>'users');
$userData = $UsersTableObj->getUser($where,$column,$table);
//print_r($userData);die;

if(!empty($userData))
{
$column = array('device_token'=>$device_token);
$where = array('email'=>$email,'is_deleted'=>0);
$table = 'users';
$userData1 = $UsersTableObj->update($where,$column,$table);


$knowledge_level = $this->knowledgeLevel($userData[0]['knowledge_point']);
$user_rank= $UsersTableObj->calculateGlobalRank($user_id = '',$social_id='',$email);

$result['user_id']=$userData[0]['user_id'];
$result['first_name']=ucfirst($userData[0]['first_name']);
$result['last_name']=ucfirst($userData[0]['last_name']);
$result['entry_coins']=$userData[0]['entry_coins'];
$result['knowledge_point']=$userData[0]['knowledge_point'];
$result['social_type']=$userData[0]['social_type'];
$result['social_id']=$userData[0]['social_id'];
$result['country']=$userData[0]['country'];
$result['email']=$userData[0]['email'];
$result['global_rank']=$user_rank[0]['rank'];
//$result['global_rank']='10';
$result['knowledge_level']= $knowledge_level;
$result['deviation_globl_rank']= $userData[0]['last_global_rank']-$user_rank[0]['rank'];
$result['deviation_knowledge_point']= $userData[0]['knowledge_point']- $userData[0]['last_knowledge_point'] ;

if(!empty($userData[0]['image']))
{
$result['image']=SITE_URL.'/upload/user_image/'.$userData[0]['image'];
}else{
$result['image']=SITE_URL.'/upload/user-img.png';  
}

$Code = ResponseConstant::SUCCESS;
$Message = ResponseConstant::message('Login Success');
$this->sendResponse($Code, $Message,array($result)); // return data

}
else
{
$Code = ResponseConstant::UNSUCCESS;
$Message = ResponseConstant::message('INVALID_CREDENTIALS');
$this->sendResponse($Code, $Message); // return data
}
}
}

//Normal Login End

//Social Login Start

// elseif($social_type==1)
else
{

//if (empty($app_key)  ||  empty($email) || empty($social_id) || empty($social_type))
if (empty($app_key)  || empty($social_id) || empty($social_type) )
{

$Code = ResponseConstant::UNSUCCESS;
$Message = ResponseConstant::message('REQUIRED_PARAMETER');
$this->sendDaResponse($Code, $Message); // return data
}
else
{

/* --------------Image upload start---------------------- */
if(!empty($_FILES['image'])){
$imageArray = '';
if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
$uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/baranoy/public/upload/user_image/";
$imageNameReplace = uniqid('', true);
$uploadResponse = $this->imageUpload($_FILES, "image", $imageNameReplace, $uploadPath);
$imageArray['image'][] = $uploadResponse;
$image = $imageArray['image'][0];
}
}else{
$image = '';
}
/* --------------Image upload end---------------------- */


$UsersTableObj = $this->getServiceLocator()->get("UsersTable");
if(!empty($email)){

$column = array('social_id','social_type');
$where = array('email'=>$email,'is_deleted'=>0);
$table = array('use'=>'users');
$userEmail = $UsersTableObj->getUser($where,$column,$table);
if(empty($userEmail)){   ///// SignUp for Facebook and Google

$column = array('first_name'=>$first_name,
'last_name'=>$last_name,
'email'=>$email,
'country'=>$country,
'image'=>$image,
'social_id'=>$social_id,
'login_type'=> 2,
'social_type'=>$social_type,
'device_token'=>$device_token,
'device_type'=>$device_type,
'last_open_date'=>date('Y-m-d'),
'created_at'=>date('Y-m-d H:i:s')
);
$table = 'users';
///print_r($column); die;
$userSocialData = $UsersTableObj->insert($column,$table);

$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id','login_type');
//$where = array('email'=>$email,'social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
// $where = array('social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
$where = array('email'=>$email,'is_deleted'=>0);
$table = array('use'=>'users');
$userData = $UsersTableObj->getUser($where,$column,$table);
$knowledge_level = $this->knowledgeLevel($userData[0]['knowledge_point']);
$user_rank= $UsersTableObj->calculateGlobalRank($user_id='',$userData[0]['social_id']);
$last_Knowledge_Point = $userData[0]['knowledge_point'];
//echo"<pre>";print_r($user_rank);die;
$last_Global_Rank = $user_rank[0]['rank'];

// device_token update
$column = array('device_token'=>$device_token,'last_global_rank'=>$last_Global_Rank,'last_knowledge_point'=>$last_Knowledge_Point);
//$where = array('social_id'=>$social_id,'is_deleted'=>0);
$where = array('email'=>$email,'is_deleted'=>0);
$table = 'users';
$userData1 = $UsersTableObj->update($where,$column,$table);
$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id','login_type','last_global_rank','last_knowledge_point');
// $where = array('email'=>$email,'social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
// $where = array('social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
$where = array('email'=>$email,'is_deleted'=>0);
$table = array('use'=>'users');
$userData3 = $UsersTableObj->getUser($where,$column,$table);



$result=array();
$result['user_id']=$userData3[0]['user_id'];
$result['first_name']=ucfirst($userData3[0]['first_name']);
$result['last_name']=ucfirst($userData3[0]['last_name']);
$result['entry_coins']=$userData3[0]['entry_coins'];
$result['knowledge_point']=$userData3[0]['knowledge_point'];
$result['social_type']=$userData3[0]['social_type'];
$result['social_id']=$userData3[0]['social_id'];
$result['country']=$userData3[0]['country'];
$result['email']=$userData3[0]['email'];
$result['global_rank']=$user_rank[0]['rank'];
//$result['global_rank']='10';
$result['knowledge_level']= $knowledge_level;
$result['deviation_knowledge_point']= $userData3[0]['knowledge_point']- $userData3[0]['last_knowledge_point'];
$result['deviation_global_rank']= $userData3[0]['last_global_rank']-$user_rank[0]['rank'];



if(!empty($userData3[0]['image']))
{
$result['image']=SITE_URL.'/upload/user_image/'.$userData3[0]['image'];
}else{
$result['image']=SITE_URL.'/upload/user-img.png';  
}

$Code = ResponseConstant::SUCCESS;
$Message = ResponseConstant::message('Login Success');
$this->sendResponse($Code, $Message,array($result)); // return data



}else
{  ////Social Login for Facebook or Google
//echo $social_id ; die;
$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id','login_type');
//$where = array('email'=>$email,'social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
// $where = array('social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
$where = array('email'=>$email,'is_deleted'=>0);
$table = array('use'=>'users');
$userData = $UsersTableObj->getUser($where,$column,$table);
//echo"<pre>";print_r($userData);die;
$knowledge_level = $this->knowledgeLevel($userData[0]['knowledge_point']);
$user_rank= $UsersTableObj->calculateGlobalRank($user_id='',$userData[0]['social_id']);
$last_Knowledge_Point = $userData[0]['knowledge_point'];
//echo"<pre>";print_r($user_rank);die;
$last_Global_Rank = $user_rank[0]['rank'];
//print_r($user_rank); die;
// device_token update
$column = array('device_token'=>$device_token,'last_global_rank'=>$last_Global_Rank,'last_knowledge_point'=>$last_Knowledge_Point);
// $where = array('social_id'=>$social_id,'is_deleted'=>0);
$where = array('email'=>$email,'is_deleted'=>0);
$table = 'users';
$userData1 = $UsersTableObj->update($where,$column,$table);
$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id','login_type','last_global_rank','last_knowledge_point');
// $where = array('email'=>$email,'social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
// $where = array('social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
$where = array('email'=>$email,'is_deleted'=>0);
$table = array('use'=>'users');
$userData3 = $UsersTableObj->getUser($where,$column,$table);

$result=array();
$result['user_id']=$userData3[0]['user_id'];
$result['first_name']=ucfirst($userData3[0]['first_name']);
$result['last_name']=ucfirst($userData3[0]['last_name']);
$result['entry_coins']=$userData3[0]['entry_coins'];
$result['knowledge_point']=$userData3[0]['knowledge_point'];
$result['social_type']=$userData3[0]['social_type'];
$result['social_id']=$userData3[0]['social_id'];
$result['country']=$userData3[0]['country'];
$result['email']=$userData3[0]['email'];
$result['global_rank']=$user_rank[0]['rank'];
//$result['global_rank']='10';
$result['knowledge_level']= $knowledge_level;
$result['deviation_knowledge_point']= $userData3[0]['knowledge_point']- $userData3[0]['last_knowledge_point'];
$result['deviation_global_rank']= $userData3[0]['last_global_rank']-$user_rank[0]['rank'];

if(!empty($userData[0]['image']))
{
$result['image']=SITE_URL.'/upload/user_image/'.$userData[0]['image'];
}else{
$result['image']=SITE_URL.'/upload/user-img.png';  
}

$Code = ResponseConstant::SUCCESS;
$Message = ResponseConstant::message('Login Success');
$this->sendResponse($Code, $Message,array($result)); // return data
}


}else{
//echo "jhk".$social_id; die;
$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id');
$where = array('social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
$table = array('use'=>'users');
$userData = $UsersTableObj->getUser($where,$column,$table);
//echo "<pre>"; print_r($userData); die;
if(!empty($userData)){
$knowledge_level = $this->knowledgeLevel($userData[0]['knowledge_point']);
$user_rank= $UsersTableObj->calculateGlobalRank($user_id='',$social_id);
$last_Knowledge_Point = $userData[0]['knowledge_point'];
$last_Global_Rank = $user_rank[0]['rank'];
// device_token update
$column = array('device_token'=>$device_token,'last_global_rank'=>$last_Global_Rank,'last_knowledge_point'=>$last_Knowledge_Point);
$where = array('social_id'=>$social_id,'is_deleted'=>0);
$table = 'users';
$userData1 = $UsersTableObj->update($where,$column,$table);
$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id','login_type','last_global_rank','last_knowledge_point');

$where = array('social_id'=>$social_id,'is_deleted'=>0);
$table = array('use'=>'users');
$userData4 = $UsersTableObj->getUser($where,$column,$table);

$result=array();
$result['user_id']=$userData4[0]['user_id'];
$result['first_name']=ucfirst($userData4[0]['first_name']);
$result['last_name']=ucfirst($userData4[0]['last_name']);
$result['entry_coins']=$userData4[0]['entry_coins'];
$result['knowledge_point']=$userData4[0]['knowledge_point'];
$result['social_type']=$userData4[0]['social_type'];
$result['social_id']=$userData4[0]['social_id'];
$result['country']=$userData4[0]['country'];
$result['email']=$userData4[0]['email'];
$result['global_rank']=$user_rank[0]['rank'];
//$result['global_rank']='10';
$result['knowledge_level']= $knowledge_level;
$result['deviation_knowledge_point']= $userData4[0]['knowledge_point']- $userData4[0]['last_knowledge_point'];
$result['deviation_global_rank']= $userData4[0]['last_global_rank']-$user_rank[0]['rank'];

if(!empty($userData4[0]['image']))
{
$result['image']=SITE_URL.'/upload/user_image/'.$userData4[0]['image'];
}else{
$result['image']=SITE_URL.'/upload/user-img.png';  
}

$Code = ResponseConstant::SUCCESS;
$Message = ResponseConstant::message('Login Success');
$this->sendResponse($Code, $Message,array($result)); // return data


}else{
$column = array('first_name'=>$first_name,
'last_name'=>$last_name,
'email'=>'',
'country'=>$country,
'image'=>$image,
'social_id'=>$social_id,

'social_type'=>$social_type,
'device_token'=>$device_token,
'device_type'=>$device_type,
'last_open_date'=>date('Y-m-d'),
'created_at'=>date('Y-m-d H:i:s')
);
$table = 'users';
$userSocialData = $UsersTableObj->insert($column,$table);

$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id');
//$where = array('email'=>$email,'social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
$where = array('social_id'=>$social_id,'social_type'=>$social_type,'is_deleted'=>0);
//$where = array('social_id'=>$email,'is_deleted'=>0);
$table = array('use'=>'users');
$userData = $UsersTableObj->getUser($where,$column,$table);
$knowledge_level = $this->knowledgeLevel($userData[0]['knowledge_point']);
$user_rank= $UsersTableObj->calculateGlobalRank($user_id='',$social_id);
$last_Knowledge_Point = $userData[0]['knowledge_point'];
$last_Global_Rank = $user_rank[0]['rank'];
// device_token update
$column = array('device_token'=>$device_token,'last_global_rank'=>$last_Global_Rank,'last_knowledge_point'=>$last_Knowledge_Point);
// $where = array('social_id'=>$social_id,'is_deleted'=>0);
$where = array('social_id'=>$social_id,'is_deleted'=>0);
$table = 'users';
$userData1 = $UsersTableObj->update($where,$column,$table);
$column = array('id as user_id','first_name','last_name','knowledge_point','image','entry_coins','country','email','social_type','social_id','login_type','last_global_rank','last_knowledge_point');

$where = array('social_id'=>$social_id,'is_deleted'=>0);
$table = array('use'=>'users');
$userData5 = $UsersTableObj->getUser($where,$column,$table);



$result=array();
$result['user_id']=$userData5[0]['user_id'];
$result['first_name']=ucfirst($userData5[0]['first_name']);
$result['last_name']=ucfirst($userData5[0]['last_name']);
$result['entry_coins']=$userData5[0]['entry_coins'];
$result['knowledge_point']=$userData5[0]['knowledge_point'];
$result['social_type']=$userData5[0]['social_type'];
$result['social_id']=$userData5[0]['social_id'];
$result['country']=$userData5[0]['country'];
$result['email']=$userData5[0]['email'];
$result['global_rank']=$user_rank[0]['rank'];
//$result['global_rank']='10';
$result['knowledge_level']= $knowledge_level;
$result['deviation_knowledge_point']= $userData5[0]['knowledge_point']- $userData5[0]['last_knowledge_point'];
$result['deviation_global_rank']= $userData5[0]['last_global_rank']-$user_rank[0]['rank'];

if(!empty($userData[0]['image']))
{
$result['image']=SITE_URL.'/upload/user_image/'.$userData[0]['image'];
}else{
$result['image']=SITE_URL.'/upload/user-img.png';  
}

$Code = ResponseConstant::SUCCESS;
$Message = ResponseConstant::message('Login Success');
$this->sendResponse($Code, $Message,array($result)); // return data

}
}
//}

}
}

}