<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['kdproduk']) && isset($_POST['jumlah_beli'])) {
        $kdproduk = $_POST['kdproduk'];
        $jumlah_beli = $_POST['jumlah_beli'];
        $kdproduk = mysqli_real_escape_string($connection, $kdproduk);
        $jumlah_beli = (int)$jumlah_beli;
        $query_produk = "SELECT * FROM tb_produk WHERE kdproduk='$kdproduk'";
        $result_produk = mysqli_query($connection, $query_produk);

        if (mysqli_num_rows($result_produk) > 0) {
            $row_produk = mysqli_fetch_assoc($result_produk);
            $nm_produk = $row_produk['nm_produk'];
            $kategori = $row_produk['kategori'];
            $stok = (int)$row_produk['stok'];
            $checkQuery = "SELECT * FROM transaksi_temp WHERE kdproduk='$kdproduk'";
            $checkResult = mysqli_query($connection, $checkQuery);

            if (mysqli_num_rows($checkResult) > 0) {
                $row_transaksi = mysqli_fetch_assoc($checkResult);
                $current_jumlah_beli = (int)$row_transaksi['jumlah_beli'];
            } else {
                $current_jumlah_beli = 0;
            }
            $total_jumlah_beli = $current_jumlah_beli + $jumlah_beli;

            if ($total_jumlah_beli <= $stok) {
                $harga = (int)$row_produk['harga'];
                $total = $harga * $jumlah_beli;

                if (mysqli_num_rows($checkResult) > 0) {
                    $updateQuery = "UPDATE transaksi_temp SET jumlah_beli=$total_jumlah_beli, total=total+$total WHERE kdproduk='$kdproduk'";
                    mysqli_query($connection, $updateQuery);
                } else {
                    $insertQuery = "INSERT INTO transaksi_temp (kdproduk, nm_produk, kategori, jumlah_beli, total) VALUES ('$kdproduk', '$nm_produk', '$kategori', $jumlah_beli, $total)";
                    mysqli_query($connection, $insertQuery);
                }
                http_response_code(200);
                echo "Product added to cart successfully.";
            } else {
                http_response_code(400);
                echo "Stok Tidak Mencukupi";
            }
        } else {
            http_response_code(404);
            echo "Product not found.";
        }
    } else {
        http_response_code(400);
        echo "Bad request.";
    }
} else {
    http_response_code(405);
    echo "Method not allowed.";
}
?>
