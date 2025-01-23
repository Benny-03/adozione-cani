<?php
require_once 'Database.php';

// Configurazione del database
$host = 'localhost';
$db_name = 'addozioni';
$username = 'root';
$password = '2311';

try{
    $database = new Database($host, $db_name, $username, $password);

    // Esempio di query
    $sql = "SELECT  * FROM cani as c JOIN razze as r ON c.razza = r.id  ";
    $stmt = $database->query($sql);

    // Recupero dei risultati
    $Listadicani = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //var_dump($Listadicani);
    //die();
} catch (Exception $e) {
    echo $e->getMessage()."\n";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=devise-width, initial-scale=1">
        <title>Adozione Cani</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <h1>Adozione Cani</h1>
        <div class="container mt-5">
            <div class="row justify-content-evenly">
                <?php for( $i=0; $i<count($Listadicani); $i++) { 
                        if($Listadicani[$i]['sesso'] == 0) {
                            $sesso = 'maschio';
                            $p = 'o';
                            $p1 = '';
                        }else{
                            $sesso = 'femmina';
                            $p = 'a';
                            $p1 = 'a';
                        }
                ?>
                <div class="col-12 col-md-4">
                    <div class="card mb-4">
                        <img src="<?php echo $Listadicani[$i]['img']?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php if($Listadicani[$i]['nome'] == null){
                                                            echo 'Non ho un nome :(';
                                                         }else{
                                                            echo $Listadicani[$i]['nome'];
                                                         } ?></h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Sono un: <?php echo $Listadicani[$i]['nome_razza']?></li>
                                <li class="list-group-item">Sono nat<?php echo $p?> il: <?php   if ($Listadicani[$i]['nascita'] == null){
                                                                                                    echo $data = '-';
                                                                                                }else{
                                                                                                    $data = date_create($Listadicani[$i]['nascita']);
                                                                                                    echo date_format($data, 'd/m/Y');
                                                                                                }?></li>
                                <li class="list-group-item">A: <?php echo $Listadicani[$i]['citta']?> <?php echo $Listadicani[$i]['regione']?></li>
                                <li class="list-group-item">Sono un<?php echo $p1?>: <?php echo $sesso?></li>
                                <li class="list-group-item">Quest<?php echo $p?> sono io: <?php echo $Listadicani[$i]['desc']?></li>
                            </ul>
                            <div class="d-grid mx-auto">
                                <button class="btn mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?php echo $i?>" aria-expanded="false" aria-controls="collapseExample<?php echo $i?>">Richiedi</button>
                            </div>
                            <div class="collapse mt-3" id="collapseExample<?php echo $i?>">
                                <div class="card card-body">
                                    <form action="invio.php" class="form-richiesta">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <span class="input-group-text">Nome</span>
                                                    <input type="text" aria-label="name" name="name" class="form-control" required maxlength="20">
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <span class="input-group-text">Cognome</span>
                                                    <input type="text" aria-label="surname" name="surname" class="form-control" required maxlength="20">
                                                </div>
                                            </li>
                                            <li class="list-group-item">Hai mai avuto dei cani? 
                                                <div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="cane" id="si" value="si" required>
                                                        <label class="form-check-label" for="si">Si</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="cane" id="no" value="no" required>
                                                        <label class="form-check-label" for="no">No</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="mb-3">
                                                    <label for="motivazione" class="form-label">Perche' l<?php echo $p?> vorresti adottare?</label>
                                                    <textarea class="form-control" id="motivazione" name="motivazione" rows="3" required maxlength="100"></textarea>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email: </label>
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="input-group">
                                                    <span class="input-group-text">Tel.</span>
                                                    <input type="number" aria-label="tel" name="tel" class="form-control" required id="tel">
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="d-grid mx-auto">
                                            <input type="hidden" name="id_cane" value="<?php echo $i?>"> 
                                            <input type="submit" class="btn mt-3" value="Invia">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="modal fade" id="staticModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body" id="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
            const staticModal = new bootstrap.Modal('#staticModal');
            document
                .querySelectorAll('form.form-richiesta')
                .forEach(form => {
                    form.addEventListener('submit', async function(event) {
                        event.preventDefault();
                        const formData = new FormData(event.target);
                        const response = await fetch('invio.php', {
                            method: 'POST',
                            body: formData
                        })
                        result = await response.text()
                        console.log(result)
                        document.getElementById('modal-body').innerHTML = result;
                        staticModal.show();
                    })
                })
        </script>
    </body>
</html>

