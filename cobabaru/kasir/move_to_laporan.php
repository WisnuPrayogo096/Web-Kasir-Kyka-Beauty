<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "move_to_laporan") {
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');
    $query_get_data = "SELECT * FROM transaksi_temp";
    $result_get_data = mysqli_query($connection, $query_get_data);

    if (mysqli_num_rows($result_get_data) > 0) {
        while ($row = mysqli_fetch_assoc($result_get_data)) {
            $kdproduk = $row['kdproduk'];
            $nm_produk = $row['nm_produk'];
            $kategori = $row['kategori'];
            $jumlah_beli = $row['jumlah_beli'];
            $total = $row['total'];
            $query_insert_laporan = "INSERT INTO laporan_penjualan (kdproduk, nm_produk, kategori, jumlah_beli, total, tanggal, jam, kasir) VALUES ('$kdproduk', '$nm_produk', '$kategori', $jumlah_beli, $total, '$tanggal', '$jam', 'kasir')";
            $result_insert_laporan = mysqli_query($connection, $query_insert_laporan);

            if ($result_insert_laporan) {
                $query_delete_transaksitemp = "DELETE FROM transaksi_temp WHERE kdproduk = '$kdproduk'";
                $result_delete_transaksitemp = mysqli_query($connection, $query_delete_transaksitemp);

                if (!$result_delete_transaksitemp) {
                    echo "Gagal menghapus data dari transaksi_temp.";
                    exit;
                }
            } else {
                echo "Gagal memindahkan data ke laporan_penjualan.";
                exit;
            }
        }

        echo "Data berhasil dipindahkan ke laporan_penjualan.";
    } else {
        echo "Tidak ada data untuk dipindahkan.";
    }
}
?>
