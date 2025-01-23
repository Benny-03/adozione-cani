<?php

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct($host, $db_name, $username, $password) {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->username = $username;
        $this->password = $password;
        $this->conn = null;
        $this->connect();
    }

    public function getConnect(){
        return $this->conn;
    }
    // Connessione al database
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
          throw new Exception("Connection error: " . $e->getMessage());
        }
        return $this->conn;
    }

    // Esecuzione di una query
    public function query($sql) {

        if ($this->conn === null) {
            $this->connect();
        }
        if ($this->conn !== null) {
            $stmt = $this->conn->prepare($sql);
        } else {
            throw new Exception("Database connection is not established.");
        }
        $stmt->execute();
        return $stmt;
    }

    function queryInsert($tabella, $input){
        $keys = array_keys($input);
       
        $key = implode('`,`', $keys);
        $values = implode(',:', $keys);
    
        $sth = $this->conn->prepare("INSERT INTO $tabella (`$key`) VALUES (:$values)");
        
        foreach($input as $key=>$value){
            $sth->bindValue(':'.$key, $value, PDO::PARAM_STR);
        }

        $sth->execute();
    }

    // Chiusura della connessione
    public function close() {
        $this->conn = null;
    }
}

//require_once 'Database.php';

// Configurazione del database
/*
$host = 'localhost:';
$db_name = '';
$username = '';
$password = '';
try{

// Creazione dell'istanza del database
$database = new Database($host, $db_name, $username, $password);


// Esempio di query
$sql = "SELECT * FROM cani";

$stmt = $database->query($sql);

// Recupero dei risultati
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Stampa dei risultati
foreach ($results as $row) {
    echo $row['nome'] . ' - ' . $row['razza'] . '<br>';
}

// Chiusura della connessione
$database->close();

} catch (Exception $e) {
    echo $e->getMessage()."\n";
}
*/
?>