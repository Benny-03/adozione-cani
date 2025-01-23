<?php
    require_once '../Database.php';
    $host = 'localhost';
    $db_name = 'addozioni';
    $username = 'root';
    $password = '2311';
    
    try{
        $database = new Database($host, $db_name, $username, $password);
        $sql = "SELECT  c.*, r.nome_razza FROM cani as c JOIN razze as r ON c.razza = r.id";
        $sql2 = "SELECT id FROM cani ORDER BY id";
        $sqlr = "SELECT * FROM richieste";
        $stmt = $database->query($sql);
        $stmtr = $database->query($sqlr);
        $stmt2 = $database->query($sql2);
        $Listadicani = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $richieste = $stmtr->fetchAll(PDO::FETCH_ASSOC);
        $listaId = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage()."\n";
    }

    if(count($_POST) != 0){
        $input = $_POST;

        if($input['azione'] == 'Elimina'){
            $id = $input['id-cane'];
            $sqlDelete = "DELETE FROM cani WHERE id=$id";
            $stmtDelete = $database->query($sqlDelete);
        }
        if($input['azione'] == 'Accetta'){
            $id_richiesta = $input['id-richiesta'];
            $sqlUpdate = "UPDATE richieste set esito = 'true' WHERE id = $id_richiesta";
            $stmtUpdate = $database->query($sqlUpdate);
        }
        if($input['azione'] == 'Rifiuta'){
            $id_richiesta = $input['id-richiesta'];
            $sqlUpdate = "UPDATE richieste set esito = 'false' WHERE id = $id_richiesta";
            $stmtUpdate = $database->query($sqlUpdate);
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
        <title>Back Office</title>
    </head>
    <body>
        <h1>Back Office</h1>

        <h3 class="mt-5">Lista cani</h3>
        <table class="table mt-3">
            <thead class="thead">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Razza</th>
                    <th scope="col">Data di nascita</th>
                    <th scope="col">Citta`, Regione</th>
                    <th scope="col">Sesso</th>
                    <th scope="col">Descrizione</th>
                    <th><form action="aggiungi.php" class="form-aggiungi">
                            <input type="submit" class="btn mt-3" value="Aggiungi">
                        </form></th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0; $i<count($Listadicani); $i++){ ?>
                    <tr>
                        <th scope="row"><?php echo $i?></th>
                        <td><?php echo $Listadicani[$i]['nome'] ?></td>
                        <td><?php echo $Listadicani[$i]['nome_razza']?></td>
                        <td><?php echo $Listadicani[$i]['nascita']?></td>
                        <td><?php echo $Listadicani[$i]['citta']?>, <?php echo $Listadicani[$i]['regione']?></td>
                        <td><?php if($Listadicani[$i]['sesso'] == 0) {
                                    echo 'maschio';
                                  }else{
                                    echo 'femmina';
                                  }?></td>
                        <td><?php echo $Listadicani[$i]['desc']?></td>
                        <td><form action="modifica.php" method="post">
                                <input type="hidden" name="id-cane" value="<?php echo $Listadicani[$i]['id']  ?>">  
                                <input type="submit" class="btn mt-3" value="Modifica">
                            </form>
                            <form method="post">
                                <input type="hidden" name="id-cane" value="<?php echo $Listadicani[$i]['id'] ?>">
                                <input type="submit" class="btn mt-3" name="azione" value="Elimina">
                            </form></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3 class="mt-5">Lista Richieste</h3>
        <table class="table mt-3">
            <thead class="thead">
                <tr>
                    <th scope="col">Richiesta n.</th>
                    <th scope="col">Per</th>
                    <th scope="col">Nome, Cognome</th>
                    <th scope="col">Mai avuto cani?</th>
                    <th scope="col">Motivazione</th>
                    <th scope="col">Email, Tel</th>
                    <th scope="col">Esito</th>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0; $i<count($richieste); $i++){ ?>
                    <tr>
                        <th scope="row"><?php echo $richieste[$i]['id'] ?></th>
                        <td><?php echo $Listadicani[$richieste[$i]['id_cane']]['nome'] ?>, <?php echo $Listadicani[$richieste[$i]['id_cane']]['nome_razza'] ?></td>
                        <td><?php echo $richieste[$i]['name']?> <?php echo $richieste[$i]['surname']?></td>
                        <td><?php echo $richieste[$i]['cane']?></td>
                        <td><?php echo $richieste[$i]['motivazione']?></td>
                        <td><?php echo $richieste[$i]['email']?>, <?php echo $richieste[$i]['tel']?></td>
                        <td><?php if(empty($richieste[$i]['esito'])){ ?>
                            <form method="post">
                                <input type="hidden" name="id-richiesta" value="<?php echo $richieste[$i]['id'] ?>">  
                                <input type="submit" class="btn mt-3" name="azione" value="Accetta">
                                <input type="submit" class="btn mt-3" name="azione"  value="Rifiuta">
                            </form>
                            <?php }
                                if($richieste[$i]['esito'] == 'true'){
                                    echo "Accettata";
                                }
                                if($richieste[$i]['esito'] == 'false'){
                                    echo "Rifiutata";
                                } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>