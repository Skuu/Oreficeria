<?php
session_start();
if ($_SESSION['username'] == '') {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricerca</title>
    <link rel="stylesheet" href="styles/insert.css">
</head>

<body>
    <?php

    $connection = mysqli_connect("localhost", "root", "");
    mysqli_select_db($connection, "Oreficeria");


    if (isset($_POST["submit"])) {
        $cliente = $_POST['cliente'];
        $laboratorio = $_POST['laboratorio'];
        $cassetto = $_POST['cassetto'];
        $tipologia = $_POST['tipologia'];
        $garanzia = isset($_POST['garanzia']) && $_POST['garanzia'] === "si" ? 1 : 0;
        $importo = $_POST['importo'];
        $tempo = $_POST['tempo'];
        $stato = "in corso";

        $q_insert = "INSERT INTO Buste (Cliente, Laboratorio, tipologia, garanzia, importo, tempo_stimato, stato, cassetto) VALUES ($cliente, $laboratorio, \"$tipologia\", $garanzia, $importo, $tempo, \"$stato\", $cassetto)";
        $insert = mysqli_query($connection, $q_insert);

        if ($insert) {
            $successful = "L'ordine è stato inserito con successo.";
        }
    }


    $q_clienti = "SELECT ID, nome, cognome FROM clienti";
    $clienti = mysqli_query($connection, $q_clienti);

    $q_laboratori = "SELECT ID, ragione_sociale FROM laboratori";
    $laboratori = mysqli_query($connection, $q_laboratori);

    ?>

    <h1>Aggiungi oggetto</h1>

    <div class="form-container">
        <form action='' method='post'>
            <?php
            if (!empty($successful)) {
                echo "<p style='color: #00ffc8;text-align: center;font-size: large;'><strong>$successful</strong></p>";
            }
            ?>
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <select name='cliente' id='cliente' required>
                    <option value="" selected="selected" disabled>-- seleziona un cliente --</option>
                    <?php
                    while ($row = mysqli_fetch_array($clienti)) {
                        echo "<option value=\"$row[0]\">$row[2] $row[1]</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="laboratorio">Laboratorio</label>
                <select name='laboratorio' id='laboratorio' required>
                    <option value="" selected="selected" disabled>-- seleziona un laboratorio --</option>
                    <?php
                    while ($row = mysqli_fetch_array($laboratori)) {
                        echo "<option value=\"$row[0]\">$row[2] $row[1]</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="cassetto">Cassetto</label>
                <select name='cassetto' id='cassetto' required>
                    <option value="" selected="selected" disabled>-- seleziona un cassetto --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tipologia">Tipologia</label>
                <select name='tipologia' id='tipologia' required>
                    <option value="" selected="selected" disabled>-- seleziona una tipologia --</option>
                    <option value="orologi">orologi</option>
                    <option value="gioielli">gioielli</option>
                </select>
            </div>

            <script>
                document.getElementById('tipologia').addEventListener('change', function () {
                    const selectGaranzia = document.getElementById('garanzia')
                    if (this.value === 'orologi') {
                        selectGaranzia.disabled = false;
                    } else if (this.value === "gioielli") {
                        selectGaranzia.disabled = true;
                        selectGaranzia.getElementsByTagName('option')[0].selected = "selected";
                    }
                });
            </script>

            <div class="form-group">
                <label for="garanzia">Garanzia</label>
                <select name='garanzia' id='garanzia' disabled>
                    <option selected="selected" value="no">No</option>
                    <option value="si">Si</option>
                </select>
            </div>

            <div class="form-group">
                <label for="importo">Importo (€)</label>
                <input type="number" name="importo" id="importo" min="0" required>
            </div>

            <div class="form-group">
                <label for="tempo">Tempo (giorni)</label>
                <input type="number" name="tempo" id="tempo" min="0" required>
            </div>

            <input type="submit" name="submit" value="Inserisci ordine">
        </form>
    </div>

    <button><a href=".">Torna alla home</a></button>
</body>

</html>
