<?php
require_once 'db.php';
$conn = getConn();
require_once 'messages.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vards = trim($_POST["vards"] ?? '');
    $zina = trim($_POST["zina"] ?? '');

    if (empty($vards)) {
        $message = "<p class='error'>" . $messages['error_vards'] . "</p>";
    } elseif (empty($zina)) {
        $message = "<p class='error'>" . $messages['error_zina'] . "</p>";
    } elseif (strlen($vards) > 100) {
        $message = "<p class='error'>" . $messages['error_vards_length'] . "</p>";
    } elseif (strlen($zina) > 500) {
        $message = "<p class='error'>" . $messages['error_zina_length'] . "</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO Viesu_gramata (vards, zina) VALUES (?, ?)");
        $stmt->bind_param("ss", $vards, $zina);
        $stmt->execute();
        $stmt->close();
        $message = "<p class='success'>" . $messages['success'] . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Viesu grāmata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Viesu grāmata</h1>
<a href="login.php"> Login </a>
<br><br><br>
<?= $message ?>

<form method="POST">
    <label>Vārds:<br>
        <input type="text" name="vards" placeholder="Ievadi savu vārdu">
    </label><br><br>
    <label>Ziņa:<br>
        <textarea name="zina" placeholder="Ievadi savu ziņu"></textarea>
    </label><br><br>
    <button type="submit">Nosūtīt</button>
</form>

<?php
$result = $conn->query("SELECT id, vards, zina FROM Viesu_gramata");
echo "<h2>Ieraksti</h2>";
echo "<table border='1'>";
echo "<tr><th>ID</th><th>Vārds</th><th>Ziņa</th><th>Darbības</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["vards"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["zina"]) . "</td>";
    echo "<td><a href='edit.php?id=" . htmlspecialchars($row["id"]) . "'>Rediģēt</a></td>";
    echo "<td>
            <form method='POST' action='delete.php' onsubmit='return confirm(\"Vai tiešām vēlaties dzēst šo ierakstu?\");'>
                <input type='hidden' name='id' value='" . htmlspecialchars($row["id"]) . "'>
                <button type='submit'>Dzēst</button>
            </form>
          </td>";
    echo "</tr>";
}

echo "</table>";
$conn->close();
?>

</body>
</html>