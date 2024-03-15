<?php

include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "update_stok") {
   
    $query_update_stok = "
        UPDATE tb_produk AS p
        JOIN transaksi_temp AS t ON p.kdproduk = t.kdproduk
        SET p.stok = p.stok - t.jumlah_beli
        WHERE p.stok >= t.jumlah_beli
    ";

    $result_update_stok = mysqli_query($connection, $query_update_stok);

    if ($result_update_stok) {
        echo "Stok berhasil diperbarui.";
    } else {
        echo "Gagal mengupdate stok.";
    }
}
?>
