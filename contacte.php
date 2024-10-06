<?php
include "intern-core/config.php";

// Verifică dacă sesiunea este activă
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['intern-name'] == "") {
    header("Location: index.php");
    exit();
}

// Setează anteturile pentru a forța descărcarea fișierului CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="contacteLBGBrasov.csv"');

// Deschide un "file pointer" pentru ieșire
$output = fopen('php://output', 'w');

// Scrie antetul CSV
fputcsv($output, [
    "Name", "Given Name", "Additional Name", "Family Name", "Yomi Name",
    "Given Name Yomi", "Additional Name Yomi", "Family Name Yomi",
    "Name Prefix", "Name Suffix", "Initials", "Nickname",
    "Short Name", "Maiden Name", "Birthday", "Gender",
    "Location", "Billing Information", "Directory Server",
    "Mileage", "Occupation", "Hobby", "Sensitivity",
    "Priority", "Subject", "Notes", "Group Membership",
    "E-mail 1 - Type", "E-mail 1 - Value",
    "Phone 1 - Type", "Phone 1 - Value"
]);

global $mysql;

// Interogarea bazei de date
$sql = $mysql->query("SELECT * FROM utilizatori WHERE statut IN (0, 2, 4) ORDER BY nume ASC");
while ($f = $sql->fetch_array(MYSQLI_ASSOC)) {
    // Scrie datele utilizatorului în fișierul CSV
    fputcsv($output, [
        "BEST Brasov - " . $f['nume'],
        "BEST Brasov - " . $f['nume'],
        "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "",
        "* My Contacts", "* Email", $f['email'],
        "Mobile", $f['nrtelefon']
    ]);
}

// Închide "file pointer"
fclose($output);
exit(); // Asigură-te că scriptul nu continuă să ruleze după generarea CSV-ului

