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
  <link rel="stylesheet" href="styles/view.css">
</head>

<body>
  <?php
  $connection = mysqli_connect("localhost", "root", "");
  mysqli_select_db($connection, "Oreficeria");

  $filter = "";
  $message = [];

  if (isset($_GET["cliente"]) && (!empty($_GET["cliente"]) || $_GET["cliente"] === "0")) {
    $cliente = $_GET["cliente"];

    $q_clienti = "SELECT nome, cognome FROM clienti WHERE ID = $cliente";
    $clienti = mysqli_fetch_array(mysqli_query($connection, $q_clienti));
    $filter .= "AND c.ID = $cliente ";
    array_push($message, "Cliente: $clienti[1] $clienti[0]");
  }

  if (isset($_GET["laboratorio"]) && (!empty($_GET["laboratorio"]) || $_GET["laboratorio"] === "0")) {
    $laboratorio = $_GET["laboratorio"];

    $q_laboratori = "SELECT ragione_sociale FROM laboratori WHERE ID = $laboratorio";
    $laboratori = mysqli_fetch_array(mysqli_query($connection, $q_laboratori));
    $filter .= "AND l.ID = $laboratorio ";
    array_push($message, "Laboratorio: $laboratori[0]");
  }

  if (isset($_GET["cassetto"]) && ($_GET["cassetto"] === "0" || !empty($_GET["cassetto"]))) {
    $cassetto = $_GET["cassetto"];
    $filter .= "AND b.cassetto = $cassetto ";
    array_push($message, "Cassetto: $cassetto");
  }


  $q_clienti = "SELECT ID, nome, cognome FROM clienti";
  $clienti = mysqli_query($connection, $q_clienti);

  $q_laboratori = "SELECT ID, ragione_sociale FROM laboratori";
  $laboratori = mysqli_query($connection, $q_laboratori);

  $q_buste = <<<QUERY
        SELECT b.ID, c.cognome, c.nome, l.ragione_sociale, b.tipologia, b.garanzia, b.importo, b.stato, b.tempo_stimato stimato
        FROM Buste AS b, Laboratori AS l, Clienti as c
        WHERE b.Cliente = c.ID AND b.Laboratorio = l.ID $filter
        ORDER BY b.ID DESC;
        QUERY;
  $buste = mysqli_query($connection, $q_buste);
  ?>

  <h1>Ordini</h1>

  <form action='' method='get'>
    <div>
      Cliente:
      <select name='cliente' id='cliente'>
        <option value="" selected="selected">Nessun filtro</option>
        <?php
        while ($row = mysqli_fetch_array($clienti)) {
          echo "<option value=\"$row[0]\">$row[2] $row[1]</option>";
        }
        ?>
      </select>
    </div>

    <div>
      Laboratorio:
      <select name='laboratorio' id='laboratorio'>
        <option value="" selected="selected">Nessun filtro</option>
        <?php
        while ($row = mysqli_fetch_array($laboratori)) {
          echo "<option value=\"$row[0]\">$row[2] $row[1]</option>";
        }
        ?>
      </select>
    </div>

    <div>
      Cassetto:
      <select name='cassetto' id='cassetto'>
        <option value="" selected="selected">Nessun filtro</option>
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
    <input type="submit" value="Ricerca">
  </form>


  <?php
  if (!empty($message)) {
    echo "<h3>" . join(", ", $message) . "</h3>";
  }

  if (mysqli_num_rows($buste) > 0) {
    ?>
    <table>
      <thead>
        <th>ID</th>
        <th>Cliente</th>
        <th>Laboratorio</th>
        <th>Tipologia</th>
        <th>Importo</th>
        <th>Stato</th>
        <th>Tempo stimato</th>
        <th></th>
      </thead>
      <tbody>
        <?php
        while ($row = mysqli_fetch_array($buste)) {
          if ($row[5]) {
            $importo = "€0 (in garanzia)";
          } else {
            $importo = "€$row[6]";
          }
          echo "<tr>";
          echo "<td>$row[0]</td>";
          echo "<td>$row[1] $row[2]</td>";
          echo "<td>$row[3]</td>";
          echo "<td>$row[4]</td>";
          echo "<td>$importo</td>";
          echo "<td>$row[7]</td>";
          echo "<td>$row[8] giorni</td>";
          echo "<td>";
          echo "<form action='modify.php' method='post'>";
          echo "<input type=\"hidden\" name=\"objectId\" value=\"$row[0]\" >";
          echo "<input type=\"submit\" value=\"Modifica\">";
          echo "</form>";
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  <?php } else {
    echo "<h3>Non sono presenti oggetti che rispettano questa ricerca.</h3>";
  }
  ?>

  <button><a href=".">Torna alla home</a></button>
</body>

</html>
