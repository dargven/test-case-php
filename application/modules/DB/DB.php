<?php namespace DB;
use PDO;
class DB
{
    private ?\PDO $pdo;

    public function __construct()
    {
        
        $host = $_ENV['HOST_LC1']; // LOCAL на MAMP
        $port = $_ENV['PORT_LC1'];
        $user = $_ENV['USER_LC1'];
        $pass = $_ENV['PASS_LC1'];
            $db = $_ENV['DB_LC1'];

        $connect = "mysql:host=$host;port=$port;dbname=$db;charset=utf8";
        $this->pdo = new PDO($connect, $user, $pass);
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

    private function execute($sql, $params = [])
    {
        $sth = $this->pdo->prepare($sql);
//        var_dump($sth);
        return $sth->execute($params);
    }

    private function query($sql, $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
        return $sth->fetch(PDO::FETCH_OBJ);
    }

    private function queryAll($sql, $params = [])
    {
        $sth = $this->pdo->prepare($sql);
        $sth->execute($params);
//        var_dump($sth, $params);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addOrder($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity,
                             $ticket_kid_price, $ticket_kid_quantity, $barcode, $equalPrice, $user_id
    )
    {
        $this->execute(
            "INSERT INTO orders (event_id, event_date, ticket_adult_price, ticket_adult_quantity,
                             ticket_kid_price, ticket_kid_quantity, user_id,barcode, equal_price, created) VALUES (?,?,?,?,?,?,?,?,?,now())",
            [
                $event_id,
                $event_date,
                $ticket_adult_price,
                $ticket_adult_quantity,
                $ticket_kid_price,
                $ticket_kid_quantity,
                $user_id,
                $barcode,
                $equalPrice,
                
            ]
        );
    }

}
