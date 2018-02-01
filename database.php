<?php
class DB{
    public $conn;
    function __construct()
    { //connect
        $dbhost = "localhost";
        $account = "*******";
        $password = "******";
        $dbname = "messagedb";
       
        
        $this->conn = mysqli_connect($dbhost,$account,$password,$dbname);        
        if (!$this->conn) {
            die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
        }else{
            echo 'Connect success... ' . mysqli_get_host_info($this->conn) . "\n";
        }

    }
    function __destruct()
    {   //disconnect
       //$this->conn->close();
       mysqli_colse($this->conn);
    }

}

?>