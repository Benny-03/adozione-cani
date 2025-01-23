<?php
require_once '../Database.php';
$host = 'localhost';
$db_name = 'addozioni';
$username = 'root';
$password = '2311';

try{
    $database = new Database($host, $db_name, $username, $password);
    $sql = "SELECT  * FROM razze";
    $stmt = $database->query($sql);
    $ListaRazze = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage()."\n";
}

$input = $_POST;
$id = $input['id'];
$nome = $input['nome'];
$nascita = $input['nascita'];
$citta = $input['citta'];
$regione = $input['regione'];
$desc = $input['desc'];
$razza = $input['razza'];

if($input['sesso'] == 'maschio'){
    $sesso = 0;
}else{
    $sesso = 1;
}

$sqlUpdate = "UPDATE cani set nome='$nome', razza='$razza', nascita='$nascita', citta='$citta', regione='$regione', sesso='$sesso', `desc`='$desc' WHERE id=$id";
$stmtUpdate = $database->query($sqlUpdate);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=devise-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="../style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <p><b>Modifica avvenuta</b></p>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>