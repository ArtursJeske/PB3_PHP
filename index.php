
<!-- Pieslēdzamies CSS failam -->
<link rel="stylesheet" href="style.css">


<!-- Savienojamies ar datubāzi un apstrādājam formu -->

<?php
$conn = new mysqli("localhost", "root", "", "viesu_gramata");
if ($conn->connect_error) {
    die("Savienojuma kļūda: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vards = trim($_POST["vards"] ?? '');
    $zina = trim($_POST["zina"] ?? '');

    if (empty($vards))
    {
        echo "<p class='error'>Lūdzu, aizpildiet vārdu.</p>";
    } 

    elseif (empty($zina))
    {
        echo "<p class='error'> Lūdzu, aizpildiet ziņu.</p>";
    } 
    
    elseif (strlen($zina) > 500)
    {
        echo "<p class='error'>Ziņa nedrīkst būt garāka par 500 simboliem.</p>";
    } 
    
    else {
        $stmt = $conn->prepare("INSERT INTO Viesu_gramata (vards, zina) VALUES (?, ?)");
        $stmt->bind_param("ss", $vards, $zina);
        $stmt->execute();
        $stmt->close();

        echo "<p class='success'>Jūsu ziņa ir veiksmīgi pievienota viesu grāmatai!</p>";
    }
}
?>

<!-- HTML daļa ar formu un ierakstu attēlošanu -->

<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="UTF-8">
    <title>Viesu grāmata</title>
</head>

<body>

<h1>Viesu grāmata</h1>

<form method="POST" >
    <label>Vārds:<br>
        <input type="text" name="vards" placeholder="Ievadi savu vārdu">
    </label><br><br>

    <label>Ziņa:<br>
        <textarea name="zina" placeholder="Ievadi savu ziņu"></textarea>
    </label><br><br>

    <button type="submit">Nosūtīt</button>
</form>

<!-- Attēlojam ierakstus no datubāzes -->

<?php
$result = $conn->query("SELECT id, vards, zina FROM Viesu_gramata");

echo "<h2>Ieraksti</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Vārds</th><th>Ziņa</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["vards"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["zina"]) . "</td>";
    echo "<td><a href= 'edit.php?id=" . $row["id"] . "'>Rediģēt</a></td>";
    echo "<td><form method='POST' action='delete.php' onsubmit='return confirm(\"Vai tiešām vēlaties dzēst šo ierakstu?\");'>
            <input type='hidden' name='id' value='" . $row["id"] . "'>
            <button type='submit'>Dzēst</button>
          </form></td>";
    echo "</tr>";
}

echo "</table>";

$conn->close();
?>

</body>
</html>