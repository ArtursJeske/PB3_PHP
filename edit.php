<?php
$conn = new mysqli("localhost", "root", "", "viesu_gramata");
if ($conn->connect_error) {
    die("Savienojuma kļūda: " . $conn->connect_error);
}

// Pārbauda vai ID ir derīgs
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Nederīgs ID.");
}

$id = $_GET['id'];

// Apstrādā formas nosūtīšanu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vards = trim($_POST["vards"] ?? '');
    $zina = trim($_POST["zina"] ?? '');

    if (empty($vards)) {
        echo "<p class='error'>Vārds ir obligāts.</p>";
    } elseif (empty($zina)) {
        echo "<p class='error'>Ziņa ir obligāta.</p>";
    } elseif (strlen($zina) > 500) {
        echo "<p class='error'>Ziņa nedrīkst pārsniegt 500 simbolus.</p>";
    } else {
        $stmt = $conn->prepare("UPDATE Viesu_gramata SET vards = ?, zina = ? WHERE id = ?");
        $stmt->bind_param("ssi", $vards, $zina, $id);
        $stmt->execute();
        $stmt->close();

        // Pāradresē uz index.php
        header("Location: index.php");
        exit();
    }
}

// Atlasa esošos datus
$stmt = $conn->prepare("SELECT vards, zina FROM Viesu_gramata WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    die("Ieraksts nav atrasts.");
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Rediģēt ierakstu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Rediģēt ierakstu</h1>

<form method="POST" novalidate>
    <label>Vārds:<br>
        <input type="text" name="vards" value="<?= htmlspecialchars($row['vards']) ?>">
    </label><br><br>

    <label>Ziņa:<br>
        <textarea name="zina"><?= htmlspecialchars($row['zina']) ?></textarea>
    </label><br><br>

    <button type="submit">Saglabāt</button>
</form>

<a href="index.php">← Atpakaļ</a>

</body>
</html>