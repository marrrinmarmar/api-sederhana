<?php
header('Content-Type: application/json');

class Api{
    private $hostname;
    private $username;
    private $password;
    private $conn;

    function __construct($host, $user, $pass)
    {
        $this->hostname = $host;
        $this->username = $user;
        $this->password = $pass;
        $this->setupDb();
    }

    function setupDb(){
        try {
            // Create database
            $conn = mysqli_connect($this->hostname, $this->username, $this->password);
            if (!$conn) {
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }

            // Create database if not exists
            $queryDB = "CREATE DATABASE IF NOT EXISTS PEMERINTAH";
            if (!mysqli_query($conn, $queryDB)) {
                throw new Exception("Error creating database: " . mysqli_error($conn));
            }

            // Select database
            if (!mysqli_select_db($conn, "PEMERINTAH")) {
                throw new Exception("Error selecting database: " . mysqli_error($conn));
            }
            
            // Create tables
            $queryTBKepen = "CREATE TABLE IF NOT EXISTS KEPENDUDUKAN (
                NIK int PRIMARY KEY,
                NAMA varchar(100),
                ALAMAT text
            )";
            
            $queryTBPegaw = "CREATE TABLE IF NOT EXISTS PEGAWAI (
                NIK int PRIMARY KEY,
                NAMA varchar(100),
                JABATAN varchar(50)
            )";
            
            if (!mysqli_query($conn, $queryTBKepen)) {
                throw new Exception("Error creating KEPENDUDUKAN table: " . mysqli_error($conn));
            }
            
            if (!mysqli_query($conn, $queryTBPegaw)) {
                throw new Exception("Error creating PEGAWAI table: " . mysqli_error($conn));
            }
            
            $this->conn = $conn;
            return true;
        } catch (Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function dbconnection(){
        try {
            if (!$this->conn) {
                $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, "PEMERINTAH");
                if (!$this->conn) {
                    throw new Exception("Connection failed: " . mysqli_connect_error());
                }
            }
            return $this->conn;
        } catch (Exception $e) {
            return ["error" => $e->getMessage()];
        }
    }

    function insertData($type, $data) {
        try {
            $conn = $this->dbconnection();
            if (is_array($conn) && isset($conn['error'])) {
                throw new Exception($conn['error']);
            }

            // Validasi data
            if (empty($data['nik']) || empty($data['nama'])) {
                throw new Exception("NIK dan Nama harus diisi");
            }

            if ($type === 'kependudukan') {
                if (empty($data['alamat'])) {
                    throw new Exception("Alamat harus diisi");
                }
                $query = "INSERT INTO KEPENDUDUKAN (NIK, NAMA, ALAMAT) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                if (!$stmt) {
                    throw new Exception("Error preparing statement: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($stmt, "iss", $data['nik'], $data['nama'], $data['alamat']);
            } else if ($type === 'pegawai') {
                if (empty($data['jabatan'])) {
                    throw new Exception("Jabatan harus diisi");
                }
                $query = "INSERT INTO PEGAWAI (NIK, NAMA, JABATAN) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($conn, $query);
                if (!$stmt) {
                    throw new Exception("Error preparing statement: " . mysqli_error($conn));
                }
                mysqli_stmt_bind_param($stmt, "iss", $data['nik'], $data['nama'], $data['jabatan']);
            } else {
                throw new Exception("Invalid data type");
            }

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error inserting data: " . mysqli_stmt_error($stmt));
            }

            mysqli_stmt_close($stmt);
            return ["status" => "success", "message" => "Data berhasil disimpan"];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }

    function getData($table) {
        try {
            $conn = $this->dbconnection();
            if (is_array($conn) && isset($conn['error'])) {
                throw new Exception($conn['error']);
            }

            if ($table === 'kependudukan') {
                $query = "SELECT NIK, NAMA, ALAMAT FROM KEPENDUDUKAN";
            } else if ($table === 'pegawai') {
                $query = "SELECT NIK, NAMA, JABATAN FROM PEGAWAI";
            } else {
                throw new Exception("Invalid table name");
            }

            $result = mysqli_query($conn, $query);
            if (!$result) {
                throw new Exception("Error retrieving data: " . mysqli_error($conn));
            }

            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }

            mysqli_free_result($result);
            return [
                "status" => "success",
                "data" => $data
            ];
        } catch (Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get JSON data
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!$data) {
            throw new Exception("Invalid JSON data");
        }

        // Handle connection request
        if (isset($data['connect'])) {
            $host = $data['connect'][0] ?? '';
            $user = $data['connect'][1] ?? '';
            $pass = $data['connect'][2] ?? '';
            
            if (empty($host) || empty($user)) {
                throw new Exception("Missing connection parameters");
            }
            
            $api = new Api($host, $user, $pass);
            $conn = $api->dbconnection();
            
            if (is_array($conn) && isset($conn['error'])) {
                throw new Exception($conn['error']);
            }
            
            echo json_encode([
                "status" => "success",
                "message" => "Connected successfully",
                "database" => "PEMERINTAH"
            ]);
        }
        // Handle data insertion
        else if (isset($data['type']) && isset($data['data'])) {
            $api = new Api("localhost", "root", "");
            $result = $api->insertData($data['type'], $data['data']);
            echo json_encode($result);
        }
        // Handle data retrieval
        else if (isset($data['type']) && isset($data['data'])) {
            $api = new Api("localhost", "root", "");
            $result = $api->insertData($data['type'], $data['data']);
            echo json_encode($result);
        } else if (isset($data['type']) && $data['type'] === 'get_data' && isset($data['table'])) {
            $api = new Api("localhost", "root", "");
            $result = $api->getData($data['table']);
            echo json_encode($result);
        }
        
        
        else {
            throw new Exception("Invalid request format");
        }
    } catch (Exception $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
}
?>