<?php
include "../koneksi.php";

if (isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $searchTerm = mysqli_real_escape_string($connection, $searchTerm);
    $query = "SELECT * FROM tb_produk WHERE nm_produk LIKE '%$searchTerm%' OR kategori LIKE '%$searchTerm%'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['nm_produk'] . "</td>";
            echo "<td>" . $row['kategori'] . "</td>";
            echo "<td>" . $row['stok'] . "</td>";
            echo "<td>" . $row['harga'] . "</td>";
            echo "<td><button class='add-button' data-kdproduk='" . $row['kdproduk'] . "'><i class='fa fa-plus'></button></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No products found.";
    }
}
?>
