<?
//contoh
if(isset($_POST['setup'])){
    $user = $_POST['connect'][1];
    $db = $_POST['connect'][3];
    $pass = $_POST['connect'][2];
    $hostname = $_POST['connect'][0];
    echo mysqli_connect($hostname,$user,$pass,$db);
    //.json = {'connect':['127.0.0.1',"admin","root","dbsekolah"],'setup':True}
}
?>