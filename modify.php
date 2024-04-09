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
    <title>Modifica</title>
    <link rel="stylesheet" href="styles/modify.css">
</head>

<body>
    <?php

    $connection = mysqli_connect("localhost", "root", "");
    mysqli_select_db($connection, "Oreficeria");

    $id = $_POST["objectId"];

    if (isset($_POST["stato"]) && isset($_POST["send_lab"]) && isset($_POST["recv_lab"]) && isset($_POST["send_off"]) && isset($_POST["recv_off"])) {
        $stato = $_POST["stato"];
        $send_lab = $_POST["send_lab"];
        $recv_lab = $_POST["recv_lab"];
        $send_off = $_POST["send_off"];
        $recv_off = $_POST["recv_off"];
        $q_update = "UPDATE Buste SET stato = \"$stato\", send_lab = \"$send_lab\", recv_lab = \"$recv_lab\", send_off = \"$send_off\", recv_off = \"$recv_off\" WHERE ID = $id";
        mysqli_query($connection, $q_update);
    }

    $q_data = <<<QUERY
        SELECT b.tipologia, b.cassetto, b.garanzia, b.importo, b.tempo_stimato, b.stato, b.send_lab, b.recv_lab, b.send_off, b.recv_off, c.cognome, c.nome, c.email, c.telefono, l.ragione_sociale, l.descrizione, l.indirizzo, l.telefono, r.cognome, r.nome, r.email, r.telefono, b.ID
        FROM Buste AS b, Clienti AS c, Laboratori AS l, Referenti AS r
        WHERE b.Cliente = c.ID AND b.Laboratorio = l.ID AND l.Referente = r.ID AND b.ID = $id;
    QUERY;
    $data = mysqli_query($connection, $q_data);

    ?>

    <?php echo "<h1>Modifica dell'ordine $id</h1>";

    $row = mysqli_fetch_array($data);
    if ($row[2]) {
        $garanzia = "sì";
    } else {
        $garanzia = "no";
    }

    echo "<div>";
    echo "<h3>Informazioni oggetto</h3>";
    echo "<form action='modify.php' method='post'>";
    echo "<input type=\"hidden\" name=\"objectId\" value=\"$row[22]\" >";
    echo "<p>Tipologia: $row[0]</p>";
    echo "<p>Cassetto: $row[1]</p>";
    echo "<p>Garanzia: $garanzia</p>";
    echo "<p>Importo: €$row[3]</p>";
    echo "<p>Tempo stimato: $row[4] giorni</p>";
    echo "<p>Stato (attuale: $row[5]):</p>";
    echo "<select name=\"stato\">";
    echo "<option value=\"in corso\">in corso</option>";
    echo "<option value=\"conclusa\">conclusa</option>";
    echo "<option value=\"non riparabile\">non riparabile</option>";
    echo "</select>";
    echo "<p>Inviato al laboratorio: </p> <input name=\"send_lab\" type=\"date\" value=\"$row[6]\">";
    echo "<p>Ricevuto dal laboratorio: </p> <input name=\"recv_lab\" type=\"date\" value=\"$row[7]\">";
    echo "<p>Inviato all'ufficio: </p> <input name=\"send_off\" type=\"date\" value=\"$row[8]\">";
    echo "<p>Ricevuto all'ufficio: </p> <input name=\"recv_off\" type=\"date\" value=\"$row[9]\">";
    echo "</div>";

    echo "<div>";
    echo "<h3>Informazioni cliente</h3>";

    echo "<p>Cognome: $row[10]</p>";
    echo "<p>Nome: $row[11]</p>";
    echo "<p>Email: $row[12]</p>";
    echo "<p>Numero di telefono: $row[13]</p>";
    echo "</div>";

    echo "<div>";
    echo "<h3>Informazioni laboratorio</h3>";

    echo "<p>Ragione sociale: $row[14]</p>";
    echo "<p>Marche trattate: $row[15]</p>";
    echo "<p>Indirizzo: $row[16]</p>";
    echo "<p>Numero di telefono: $row[17]</p>";
    echo "</div>";

    echo "<div>";
    echo "<h3>Informazioni Referente</h3>";

    echo "<p>Cognome: $row[18]</p>";
    echo "<p>Nome: $row[19]</p>";
    echo "<p>Email: $row[20]</p>";
    echo "<p>Numero di telefono: $row[21]</p>";
    echo "</div>";
    ?>

    <input type="submit" value="Aggiorna">

    <button><a href="./view.php">Torna indietro</a></button>

</body>

</html>
