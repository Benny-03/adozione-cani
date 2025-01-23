<?php
require_once '../Database.php';
$host = 'localhost';
$db_name = 'addozioni';
$username = 'root';
$password = '2311';

try{
    $database = new Database($host, $db_name, $username, $password);
    $sql = "SELECT  * FROM razze";
    $sql1 = "SELECT  * FROM cani as c JOIN razze as r ON c.razza = r.id  ";
    $stmt = $database->query($sql);
    $stmt1 = $database->query($sql1);
    $ListaRazze = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ListaCani = $stmt1->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage()."\n";
}

$flag = true;
$input = $_POST;

for($i=0; $i<count($ListaCani); $i++){
    if($ListaCani[$i]['nome'] == $input['nome'] && $ListaCani[$i]['razza'] == $input['razza'] && $ListaCani[$i]['nascita'] == $input['nascita'] && $ListaCani[$i]['citta'] == ucwords($input['citta']) && $ListaCani[$i]['regione'] == ucwords($input['regione']) && $ListaCani[$i]['sesso'] == $input['sesso']){
        $flag = false;
    }
}
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
                    <?php if($flag) {
                        echo "<p><b>Il cane e` stato aggiunto</b></p>";
                        $database->queryInsert('cani', $input);
                    }else{
                        echo "<p><b>Il cane e` gia` presente</b></p>";
                    } ?>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>