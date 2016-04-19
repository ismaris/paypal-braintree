<?php
session_start();
$site='https://paypal.scott-mann.net/paypal-braintree/';
$login=$site.'_functions/login.php';

$CAS = $_SESSION['CAS'];
if(empty($CAS)) {
    $_SESSION['CAS']=true;
    header('Location: https://cas.iu.edu/cas/login?cassvc=IU&casurl='.$login);
}

if(isset($CAS)) {
    if($_SESSION['loggedIn']==true){
        header('Location: '.$site);
    }

    if(isset($_GET["casticket"])) {
        $_url = 'https://cas.iu.edu/cas/validate';
        $cassvc = 'IU';
        $casurl = $login;
        $params = "cassvc=$cassvc&casticket=$_GET[casticket]&casurl=$casurl";
        $Furl = "$_url?$params";
        $casResponse=trim(strip_tags(file_get_contents($Furl)));
        list($access, $user) = preg_split("/\s/", $casResponse, 2);
        $user=trim($user);
        $access=trim($access);
    }
     
    if($access=='yes') {
        $_SESSION['loggedIn']=true;
        $_SESSION['user']=$user;                    
        header('Location: '.$site);
    }
}
 
?>
