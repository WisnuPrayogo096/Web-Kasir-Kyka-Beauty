<?php 
$koneksi = mysqli_connect('localhost', 'root', '', 'kasir_zibran');
global $koneksi;

$data = mysqli_query($koneksi, "SELECT * FROM tb_prod_masuk");
$jumlah_data = mysqli_num_rows($data);

// Set nilai $batas sesuai dengan jumlah data yang ada
$batas = $jumlah_data;

$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

$previous = $halaman - 1;
$next = $halaman + 1;

$total_halaman = ceil($jumlah_data / $batas);

$nomor = $halaman_awal + 1;


// cari
if (isset($_POST['go'])) {
  $cari = $_POST['cari'];
  $data_pro_ma = mysqli_query($koneksi, "SELECT * FROM tb_prod_masuk WHERE nama LIKE '%".$cari."%'");
}else{
  $data_pro_ma = mysqli_query($koneksi, "SELECT * FROM tb_prod_masuk LIMIT $halaman_awal, $batas");
}


foreach ($data_pro_ma as $pro):
  ?>
    



<tr>
                              <td><?= $i++;  ?></td>
                              <td><?=  $pro['noinv'];?></td>
                              <td><?=  $pro['tanggal'];?></td>
                              <td><?= $pro['jam'];?></td>
                              <td><?=  $pro['kdproduk'];?></td>
                              <td><?= $pro['nm_produk'];?></td>
                               <td><?= $pro['kategori'];?></td>
                              <td><?= $pro['stok'];?></td>
                              <td><?=  $pro['jml_masuk'];?></td>
                              <td><?= $pro['admin'];?></td>
</tr>
                              <?php endforeach; ?>
