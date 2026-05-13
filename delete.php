<?php
$conn = new mysqli("localhost", "root", "", "viesu_gramata");
if ($conn->connect_error) {
    die("Savienojuma kļūda: " . $conn->connect_error);
}

// Pārbauda vai ID ir derīgs
if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
    die("Nederīgs ID.");
}

$id = $_POST['id'];

$stmt = $conn->prepare("DELETE FROM Viesu_gramata WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$conn->close();

header("Location: index.php");
exit();
?>