<?php 

  date_default_timezone_set("Asia/Jakarta");
  $tanggalSekarang = date("Y-m-d");
  $jamSekarang = date("h:i a");

	
	require 'fungsi.php';
	global $koneksi;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	
	$total = $_POST['total'];
	$bayar = $_POST['inputBayar'];
	$kembalian = $_POST['kembalian'];
}

 ?>

<!DOCTYPE html>
<html>
<head>
    <!-- <style>
        @media print {
            body {
                width: 58mm; /* Lebar kertas nota */
            }

            /* Menghilangkan header dan footer */
            @page {
                margin: 0;
            }

            @page :first {
                margin-top: 0;
            }

            @page :last {
                margin-bottom: 0;
            }
        }
    </style> -->
</head>
<body>
    <center>
        Terima kasih telah belanja di Toko Kami :)<br>
        Berikut adalah bukti pembayaran belanjaan anda <br>
        Tanggal : <?= $tanggalSekarang; ?><br>
        Jam : <?= $jamSekarang; ?>
        . <br><br>

        <table border="1">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah Beli</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                global $koneksi;
                $select = mysqli_query($koneksi, "SELECT * FROM transaksi_temp");

                foreach ($select as $key):
                ?>
                <tr>
                    <td><?= $key['nm_produk']; ?></td>
                    <td><?= $key['jumlah_beli']; ?></td>
                    <td><?= rupiah($key['total']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p>Total : <?= rupiah($total); ?></p>
        <p>Bayar : <?= rupiah($bayar); ?></p>
        <p>Kembalian : <?= rupiah($kembalian); ?></p><br>

        <b>Kasir: </b><p>Kasir Kyka Beauty</p>
    </center>
</body>
</html>

 <script type="text/javascript">
 	window.print();
	<?php 
		global $koneksi;

		mysqli_query($koneksi, "DELETE FROM transaksi_temp");
	?>
 </script>