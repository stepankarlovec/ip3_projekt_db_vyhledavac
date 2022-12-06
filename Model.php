<?php

class Model{
    public $pdo;
    public function __construct($host='127.0.0.1',$db='',$user='',$pass='',$charset='utf8mb4')
    {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $this->pdo = new PDO($dsn,$user,$pass,$options);
    }

    public function query($sql, $preparedStatement=[]){
        if($preparedStatement) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($preparedStatement);
        }else{
            $stmt = $this->pdo->query($sql);
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}