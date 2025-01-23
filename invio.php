<?php
require_once 'Database.php';
$host = 'localhost';
$db_name = 'addozioni';
$username = 'root';
$password = '2311';

try{
    $database = new Database($host, $db_name, $username, $password);
    $sql = "SELECT  * FROM cani as c JOIN razze as r ON c.razza = r.id  ";
    $stmt = $database->query($sql);
    $Listadicani = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage()."\n";
}

//$inputsg = $_GET; -> prende quello che si trova nell'url dopo il ? strutturato come nome=valore
//$inputsp = $_POST; -> prende quello che viene mandato con il form attraverso method='post'
//$server = $_SERVER; -> mi da informazioni generali su tutto
$input = $_REQUEST; //-> prende sia quello che prenderebbe post che get

$flagEmail = true;
$flagTel = true;
$flagV = true;

$name = $input['name'];
$surname = $input['surname'];
$motivazione = $input['motivazione'];
$email = $input['email'];
$tel = $input['tel'];
$cane = $input['cane'];
$id_cane = $input['id_cane'];


if(!filter_var($email,  FILTER_VALIDATE_EMAIL)){
    $flagEmail = false;
}

if(strlen($tel) != 10){
    $flagTel = false;
}


try{
    $sql1 = "SELECT email FROM richieste";
    $stmt1 = $database->query($sql1);
    $verifica = $stmt1->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo $e->getMessage()."\n";
}
for($i=0; $i<count($verifica); $i++){
    if($email == $verifica[$i]['email']){
        $flagV = false;
    }
}
if($flagEmail && $flagTel){
    if($flagV){
        $database->queryInsert('richieste', $input);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=devise-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php if($flagV == false ){ ?>
            <div class="container col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title" style="background-color: transparent; color: red; font-weight: bold; font-size: 20px;">Richiesta gia' effettuata</div>
                        <h6>Hai gia` effettuato una richiesta, attendi una nostra risposta.</h6>
                    </div>
                </div>
            </div>
        <?php }elseif($flagEmail && $flagTel){ ?>
            <div class="container col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title"><b>La richiesta per l'adozione di <?php echo $Listadicani[$id_cane]['nome'] ?> e' stata presa in carico.</b></div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Riepilogo informazioni:</b></li>
                            <li class="list-group-item">Nome: <?php echo $name ?></li>
                            <li class="list-group-item">Cognome: <?php echo $surname ?></li>
                            <li class="list-group-item">Hai mai avuto cani? <?php echo $cane ?> </li>
                            <li class="list-group-item">Perche` vuoi adottar<?php if($Listadicani[$id]['sesso']==0){echo 'lo';}else{echo 'la';}?> ? <?php echo $motivazione ?></li>
                            <li class="list-group-item">Email: <?php echo $email ?></li>
                            <li class="list-group-item">Tel: <?php echo $tel ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <div class="container col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title" style="background-color: transparent; color: red; font-weight: bold; font-size: 20px;">ERRORE</div>
                        <p><b><?php if($flagEmail == false) { ?>L'email e` sbagliata <?php }?></b></p>
                        <p><b><?php if($flagTel == false) { ?><br>Il telefono e` sbagliato <?php }?></b></p>
                    </div>
                </div>
            </div>
        <?php } ?>
        
    </body>
</html>