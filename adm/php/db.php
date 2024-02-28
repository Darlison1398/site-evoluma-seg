<?php

//include_once(__DIR__ . '/db-conf.php');
include_once(__DIR__ . '../../../../../evoluma-conf/db-conf.php');

class Db
{

    /*private $host = DBHOST;
    private $db_name = DBNAME;
    private $username = DBUSER;
    private $password = DBPASS;
    private $conn;*/

    const DBDRIVE = 'mysql';
    const DBHOST = 'localhost';
    const DBNAME = 'dbb';
    const DBUSER = 'root';
    const DBPASS = 'Darlin13#5';

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
        } catch (PDOException $e) {

            echo ("Erro ao conectar com o banco de dados: <br/>" . $e->getMessage());
            //phpinfo();
            die();
        }

        return $this->conn;
    }

    public function query($str, $params)
    {

        $r = $this->conn->prepare($str);

        if ($params && is_array($params))
            foreach ($params as $k => $v)
                $r->bindValue(":" . $k, $v);


        $r->execute();

        return $r;
    }

    public function json($str, $params)
    {


        $r = $this->conn->prepare($str);

        // if ($params && is_array($params))
        foreach ((array) $params as $k => $v)
            $r->bindValue(":" . $k, $v);
        // $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        // $stmt->bindParam(':conteudo', $conteudo, PDO::PARAM_LOB);
        // $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        // $stmt->bindParam(':tamanho', $tamanho, PDO::PARAM_INT);

        @$r->execute();

        $d = @$r->fetchAll(PDO::FETCH_ASSOC);


        // var_dump($d);

        return $d;
    }


}

?>