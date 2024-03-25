<?php
class Config
{
    public static function GetConnection()
    {
        try {
            $dsn="mysql:dbname=book57";
            $user="root";
            $pw="";
            $conn= new PDO($dsn,$user,$pw);
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $er) {
            throw $er;
        }
    }
}


?>