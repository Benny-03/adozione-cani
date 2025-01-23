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
$id = $input['id-cane'];
$sql1 = "SELECT * FROM cani WHERE id=$id";
$stmt1 = $database->query($sql1);
$Cani = $stmt1->fetchAll(PDO::FETCH_ASSOC);
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
        <h1>Modifica Cane</h1>
        <div class="container col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <form action="confermaModifica.php" method="post" class="form-modifica">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Nome: <input type="text" aria-label="name" name="nome" class="form-control" value="<?php echo $Cani[0]['nome'] ?>"></li>
                            <li class="list-group-item">Razza:  <select class="form-select" aria-label="Default select example" name="razza">
                                                                    <option selected value="<?php echo $ListaRazze[$Cani[0]['razza'] -1]['id'] ?>"><?php echo $ListaRazze[$Cani[0]['razza'] -1]['nome_razza'] ?></option>
                                                                    <?php for($i=0; $i<=count($ListaRazze); $i++) { ?>
                                                                    <option value="<?php echo $i+1?>"><?php echo $ListaRazze[$i]['nome_razza'] ?></option>
                                                                    <?php } ?>
                                                                </select></li>
                            <li class="list-group-item">Data di nascita: <input class="form-control" type="date" id="datepicker" name="nascita" max="<?php echo date('Y-m-d')?>" value="<?php echo $Cani[0]['nascita'] ?>"></li>
                            <li class="list-group-item">Citta`: <input type="text" aria-label="name" name="citta" class="form-control" value="<?php echo $Cani[0]['citta'] ?>"></li>
                            <li class="list-group-item">Regione: <input type="text" aria-label="name" name="regione" class="form-control" value="<?php echo $Cani[0]['regione'] ?>"></li>
                            <li class="list-group-item">Sesso: <select class="form-select" aria-label="Default select example" name="sesso">
                                                                    <?php if($Cani[0]['sesso'] == 1){ ?>
                                                                        <option selected>femmina</option>
                                                                        <option value="maschio">maschio</option>
                                                                    <?php }else{ ?>
                                                                        <option selected>maschio</option>
                                                                        <option value="femmina">femmina</option>
                                                                    <?php } ?>
                                                                </select></li>
                            <li class="list-group-item">Descrizione: <textarea class="form-control" name="desc" rows="3" maxlength="100"><?php echo $Cani[0]['desc'] ?></textarea></li>
                        </ul>
                        <div class="d-grid mx-auto">
                            <input type="hidden" name="id" value="<?php echo $id ?>">
                            <input type="submit" class="btn mt-3" value="Modifica" data-bs-toggle="modal" data-bs-target="#modalModifica">
                        </div>
                    </form>
                    <div class="d-grid mx-auto mt-3">
                        <a href="index.php" class="btn">Torna indietro</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalModifica" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <a href="index.php" type="submit" class="btn">Chiudi</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document
                .querySelectorAll('form.form-modifica')
                .forEach(form => {
                    form.addEventListener('submit', async function(event) {
                        event.preventDefault();
                        const formData = new FormData(event.target);
                        const response = await fetch('confermaModifica.php', {
                            method: 'POST',
                            body: formData
                        })
                        result = await response.text()
                        console.log(result)
                        document.getElementById('modal-body').innerHTML = result;
                    })
                })
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>