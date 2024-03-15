<html>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</html>
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
        echo '<script>
    Swal.fire({
        title: "Apakah anda yakin menghapus transaksi?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak"
    }).then((result) => {
        if (result.isConfirmed) {
            // Kode aksi jika user memilih Ya
            window.location.href = "delete_transaction.php?id=' . $id . '&confirm=yes";
        } else {
            // Kode aksi jika user memilih Tidak
            window.location.href = "index.php";
        }
    });
</script>';

    }
} else {
    echo "Invalid request.";
}
?>
