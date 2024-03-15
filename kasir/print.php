<?php 

  date_default_timezone_set("Asia/Jakarta");
  $tanggalSekarang = date("d-m-Y");
  $jamSekarang = date("h:i A");

	
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
<style>
        @media print {
            body {
                width: 58mm; /* Lebar kertas nota */
                font-family: "Courier", monospace
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

        /* Mengubah ukuran huruf dan angka */
        /* body {
            font-size: 10px;
        } */
        /* table {
            font-size: 10px;
        } */
        .garis {
            text-align: center;
            font-size: 10px;
            margin-left: -40px;
            /* margin-bottom: 10px; */
        }
        .center-text {
            text-align: center;
            font-size: 10px;
            margin-left: -40px; /* Sesuaikan angka ini sesuai dengan kebutuhan Anda */
        }
        .center-tabel {
            text-align: left;
            font-size: 10px;
            margin-left: -10px;
        }
        .center-hasil {
            text-align: center;
            font-size: 10px;
            margin-left: -40px; /* Sesuaikan angka ini sesuai dengan kebutuhan Anda */
        }
        .center-tabel th:first-child,
        .center-tabel td:first-child {
        width: 85px;
        }
        .center-tabel th:last-child,
        .center-tabel td:last-child {
        width: 94px;
        text-align: right;
        }
    </style>
</head>
<body>
    <div class="garis" style="margin-bottom: 10px;">
        ====================================
    </div>
    <div class="center-text">
        Terima kasih telah belanja di toko<br>
        kami. Berikut adalah bukti<br>
        pembayaran belanjaan anda.<br><br>
        Tanggal <?= $tanggalSekarang; ?> <?= $jamSekarang; ?>
        <br><br>
    </div>
    <div class="garis">
        ====================================
    </div>
    <div class="center-tabel" style="margin-bottom: 10px;">
        <table border="0">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
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
    </div>
    <div class="garis">
        ====================================
    </div>
    <div class="center-hasil">
        <p>
            <span style="float: left; margin-left: 32px;">Total Item</span>
            <span style="float: right; margin-right: 32px;"><?= rupiah($total); ?></span>
            <div style="clear: both;"></div>
        </p>
        <p>
            <span style="float: left; margin-left: 32px; margin-top: -5px;">Bayar</span>
            <span style="float: right; margin-right: 32px; margin-top: -5px;"><?= rupiah($bayar); ?></span>
            <div style="clear: both;"></div>
        </p>
        <p>
            <span style="float: left; margin-left: 32px; margin-top: -5px;">Kembalian</span>
            <span style="float: right; margin-right: 32px; margin-top: -5px;"><?= rupiah($kembalian); ?></span>
            <div style="clear: both;"></div>
        </p>

        <b>Kasir: </b><p style="margin-top: 2px; margin-bottom: 15px;">KYKA BEAUTY STORE</p>
        <p style="font-weight: bold; font-size: 9px;">TERIMA KASIH ATAS KEPERCAYAAN ANDA</p>
    </div>
</body>
</html>

 <script type="text/javascript">
 	window.print();
	<?php 
		global $koneksi;

		mysqli_query($koneksi, "DELETE FROM transaksi_temp");
	?>
 </script>