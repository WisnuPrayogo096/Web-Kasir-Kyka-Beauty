<?php
include "../koneksi.php";

$query_transaksi = "SELECT * FROM transaksi_temp";
$result_transaksi = mysqli_query($connection, $query_transaksi);

if (mysqli_num_rows($result_transaksi) > 0) {
    while ($row = mysqli_fetch_assoc($result_transaksi)) {
        echo "<tr>";
        echo "<td>" . $row['nm_produk'] . "</td>";
        echo "<td>" . $row['kategori'] . "</td>";
        $query_stok = "SELECT stok FROM tb_produk WHERE kdproduk='" . $row['kdproduk'] . "'";
        $result_stok = mysqli_query($connection, $query_stok);
        if ($result_stok && mysqli_num_rows($result_stok) > 0) {
            $row_stok = mysqli_fetch_assoc($result_stok);
            $stokTersisa = max($row_stok['stok'] - 1, 1);
            echo "<td><input type='number' class='quantity-input' value='" . $row['jumlah_beli'] . "' min='1' max='" . $stokTersisa . "'></td>";
        } else {
            echo "<td><input type='number' class='quantity-input' value='" . $row['jumlah_beli'] . "' min='1'></td>";
        }

        echo "<td>" . $row['total'] . "</td>";
        echo "<td><button class='btn btn-primary update-button' data-id='" . $row['id'] . "'><i class='fa fa-edit'></i></button> <a href='delete_transaction.php?id=" . $row['id'] . "'><button class='btn btn-danger delete-button'><i class='fa fa-trash'></i></button></a>"; 
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No transactions found.</td></tr>";
}
?>