<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
#kode bagian satu (eksekusi)
class BelajarMandiri{
    //variabel global
    public $host;
    public $user;
    public $password;
    function __construct($hostname,$username,$pass){
        //inisialisasi
        $this->host = $hostname;
        $this->user = $username;
        $this->password = $pass;
        $this->Setup(); #aktifasi fitur auto struktur db
    }
    function Setup(){
        // query perintah
        $queryDb='CREATE DATABASE IF NOT EXISTS XIPPLG1';
        $queryTb="CREATE TABLE IF NOT EXISTS Barang(id int PRIMARY KEY, Nama text );CREATE TABLE IF NOT EXISTS Siswa(NIS int PRIMARY KEY, Nama text )";
        #EXCUTE
        $conn = mysqli_connect($this->host,$this->user,$this->password);
        mysqli_query($conn, $queryDb);#1 perintah
        mysqli_multi_query($this->connectDb(),$queryTb);
    }
    function connectDb(){
        //menyimpan koneksi ke db
        return mysqli_connect($this->host,$this->user,$this->password,"XIPPLG1");
    }
    
    #fitur untuk update db (update,delete,insert) langsung ketiganya dalam satu fungsi
    function WriteDatabase($query){
        #execute ke database
        return mysqli_query($this->connectDb(),$query);
    }
}
#kode bagian dua menangkap request
if(isset($_POST['build'])){
    new BelajarMandiri("localhost","root",""); #panggil class
} elseif (isset($_POST['command'])){
    $obj = new BelajarMandiri("localhost","root","");
    $query = $_POST['command']; // Ambil query dari POST request
    $obj->WriteDatabase($query);
    $id=$_POST['id'];
    $nama=$_POST['nama'];
    #dijadikan query sql
    $SQL = "INSERT INTO Siswa values($id, '$nama')";
    $obj->WriteDatabase($SQL);
}
#TEST KONEKSI
if(isset($_POST['test'])){
    echo 'terhubung ke API :D';
}
?>