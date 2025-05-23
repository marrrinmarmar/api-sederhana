<?
class Api{
    private $hostname;
    private $username;
    private $password;
    function __construct($host,$user,$pass)
    {
        //inisialisasi
        $this->hostname = $host;
        $this->username = $user;
        $this->password = $pass;
        $this->setupDb();
    }
    function setupDb(){
        #YANG PERTAMA BUAT DATABASE SETELAH BUAT FUNCTION
        $queryDB = "CREATE DATABASE IF NOT EXISTS MONEYMANAGEMENTCRUD";
        $queryTBKELUAR = "CREATE TABLE IF NOT EXISTS PENGELUARAN (id int,jenis varchar,ket text, jumlah int)";
        $queryTBDAPAT = "CREATE TABLE IF NOT EXISTS PENDAPATAN (id int,jenis varchar,ket text, jumlah int)";
        $conn = mysqli_connect( $this->hostname, $this->username, $this->password, "MONEYMANAGEMENTCRUD");
        mysqli_query(mysqli_connect(),$queryDB);
        mysqli_multi_query($this->dbconnection(),$queryTBKELUAR(),$queryTBDAPAT());
    }
    function dbconnection(){
        return mysqli_connect( $this->hostname, $this->username, $this->password, "MONEYMANAGEMENTCRUD");
    }
}
if(isset($_POST['Test'])){
    $host = $_POST['connect'][0];
    $user = $_POST['connect'][1];
    $pass = $_POST['connect'][2];
    $id = $_POST['data'][0];
    new Api($host,$user,$pass);
    echo mysqli_connect($host,$user,$pass);
}
?>