<?php
require_once('DBConnection.php');
class Master extends DBConnection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    public function register()
    {
        extract($_POST);   //extract the key and values
        $data="";
        foreach($_POST as $k =>$v){
            if(!in_array($k,array('id'))){
                if(!empty($data)) $data .=",";
                $data .=" `{$k}` = '{$v}' "; 
            }
        }
      
            $sql = "INSERT INTO `USERS` set {$data} ";
            $insertquery = $this->pdo->prepare($sql);
            $save = $insertquery->execute();

        if($save){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->pdo->error."[{$sql}]";
		}
		return json_encode($resp);
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $statement = $this->pdo->prepare("SELECT * FROM \"admin\" WHERE email = :email AND password = :password");
        $statement->bindParam(':email', $email);
        $statement->bindParam(':password', $password);
        $statement->execute();
        if ($statement->rowCount() > 0) {
            $resp['status'] = 'success';
            return json_encode($resp);
        } else {
            $resp['status'] = 'failed';
            return json_encode($resp);
        }
    }
}
$db= new DBConnection();
$pdo= $db->pdo;
$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'register':
        echo $Master->register();
        break;
    case 'login':
        echo $Master->login();
        break;
}
?>