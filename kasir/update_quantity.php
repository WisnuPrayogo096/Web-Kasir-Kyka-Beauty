<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id"]) && isset($_POST["newQuantity"])) {
        $id = $_POST["id"];
        $newQuantity = (int)$_POST["newQuantity"];

        if ($newQuantity <= 0) {
            echo "Gagal memperbarui Jumlah: Jumlah beli minimal 1.";
        } else {
            $get_stock_query = "SELECT stok FROM tb_produk p INNER JOIN transaksi_temp t ON p.kdproduk = t.kdproduk WHERE t.id = $id";
            $result_stock = mysqli_query($connection, $get_stock_query);

            if ($result_stock && mysqli_num_rows($result_stock) > 0) {
                $row_stock = mysqli_fetch_assoc($result_stock);
                $stok = (int)$row_stock['stok'];
                if ($newQuantity > $stok) {
                    echo "Gagal memperbarui Jumlah: Jumlah beli melebihi stok.";
                } else {
                    $update_query = "UPDATE transaksi_temp SET jumlah_beli = $newQuantity WHERE id = $id";
                    $result_update = mysqli_query($connection, $update_query);

                    if ($result_update) {
                        $get_product_query = "SELECT harga FROM tb_produk p INNER JOIN transaksi_temp t ON p.kdproduk = t.kdproduk WHERE t.id = $id";
                        $result_product = mysqli_query($connection, $get_product_query);

                        if ($result_product && mysqli_num_rows($result_product) > 0) {
                            $row_product = mysqli_fetch_assoc($result_product);
                            $harga = $row_product['harga'];

                            $newTotal = $harga * $newQuantity;

                            $update_total_query = "UPDATE transaksi_temp SET total = $newTotal WHERE id = $id";
                            $result_update_total = mysqli_query($connection, $update_total_query);

                            if ($result_update_total) {
                                echo "Jumlah dan Total berhasil diperbarui.";
                            } else {
                                echo "Gagal memperbarui Total: " . mysqli_error($connection);
                            }
                        } else {
                            echo "Gagal mendapatkan data produk: " . mysqli_error($connection);
                        }
                    } else {
                        echo "Gagal memperbarui Jumlah: " . mysqli_error($connection);
                    }
                }
            } else {
                echo "Gagal mendapatkan data stok produk: " . mysqli_error($connection);
            }
        }
    } else {
        echo "Permintaan tidak valid.";
    }
}
?>