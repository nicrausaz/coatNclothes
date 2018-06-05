<?php
function getRequestEmail () {
print_r('get');
if($_GET['template']=='config-v1.1.xml'){
if(isset($_GET['emailaddress']))$email=$_GET['emailaddress'];
else die('noEmailAddress');
}else{
$request = file_get_contents("php://input");
// retrieve email address from client request
preg_match( "#\<EMailAddress\>(.*?)\<\/EMailAddress\>#", $request, $email );
}
return filter_var($email[1], FILTER_VALIDATE_EMAIL);

}

function getRequestDomain($email){
var_dump($email);
$domain= explode('@', $email);
return $domain[1];
}
