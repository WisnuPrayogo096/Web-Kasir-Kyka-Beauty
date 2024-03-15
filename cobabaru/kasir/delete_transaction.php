<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    if (isset($_GET["confirm"]) && $_GET["confirm"] === "yes") {
        $delete_query = "DELETE FROM transaksi_temp WHERE id = '$id'";
        $result = mysqli_query($connection, $delete_query);

        if ($result) {
            header("Location: index.php");
            exit(); 
        } else {
            echo "Failed to delete transaction.";
        }
    } else {
        echo "Apakah Anda yakin menghapus transaksi? ";
        echo "<a href=\"delete_transaction.php?id=$id&confirm=yes\">Ya</a> | ";
        echo "<a href=\"index.php\">Tidak</a>";
    }
} else {
    echo "Invalid request.";
}
?>
