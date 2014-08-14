<?PHP

$msidn =  (isset($_SERVER['HTTP_MSISDN']))?$_SERVER['HTTP_MSISDN']:'';
var_dump($msidn);exit;


if(isset($_GET['nue']))
{
$nue = $_GET['nue'];
if(strlen($nue)==11)  $numx = $_GET['nue'];
if(strlen($nue)==9)   $numx = "51".$_GET['nue'];

}

?>