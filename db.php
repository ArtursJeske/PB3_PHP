<?php
function getConn() {
    $conn = new mysqli("localhost", "root", "", "viesu_gramata");
    if ($conn->connect_error) {
        die("Savienojuma kļūda: " . $conn->connect_error);
    }
    return $conn;
}