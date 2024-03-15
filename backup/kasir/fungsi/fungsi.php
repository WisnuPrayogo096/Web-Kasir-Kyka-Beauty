<?php 

// koneksi
$koneksi = mysqli_connect('localhost', 'root', '', 'kasir_zibran');  



// summon admin

function summon_admin()
{
	global $koneksi;
	$id = $_SESSION['idkaskit'];
	return mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id ='$id'");
}

// -------------------------------------USER SECTION--------------------------------------------------------------------
// select user by admin

function select_laporan()
{
	global $koneksi;
	return mysqli_query($koneksi, "SELECT * FROM laporan_penjualan");
}


// Insert user

function insert_user()
{
	global $koneksi;
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$nama = $_POST['nama'];
	$level = $_POST['level'];
	$foto = $_FILES['foto']['name'];

	// cek username
	$cek = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username ='$username'");
	$row = mysqli_fetch_row($cek);

	if ($row) {
		echo "username  '%".$username."%' sudah ada";
	}else if($foto != ""){
		
		$allowed_ext = array('png','jpg');
		$x = explode(".", $foto);
		$ekstensi = strtolower(end($x));
		$file_tmp = $_FILES['foto']['tmp_name'];
		$angka_acak = rand(1,999);
   		$nama_file_baru = $angka_acak.'-'.$foto;
   		    if (in_array($ekstensi, $allowed_ext) 	=== true) {
      			move_uploaded_file($file_tmp, 'img/'.$nama_file_baru);
      			$result = mysqli_query($koneksi, "INSERT INTO tb_user SET username='$username', password='$password', nama='$nama', level='$level', foto='$nama_file_baru'");
      			
    }



	
	}else if($foto==""){
		return mysqli_query($koneksi, "INSERT INTO tb_user SET username='$username', password='$password', nama='$nama', level='$level'");
	}
}

// delete user

function delete_user()
{
	global $koneksi;
	$id = $_POST['id'];
	$cekimg = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id='$id'");
	$row = mysqli_fetch_array($cekimg);

	// hapus gambar
	$foto = $row['foto'];
	unlink("img/$foto");
	return mysqli_query($koneksi, "DELETE FROM tb_user WHERE id='$id'");
}

// update user
function update_user()
{
	
	global $koneksi;
	$id = $_POST['id'];
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$nama = $_POST['nama'];
	
	$foto = $_FILES['foto']['name'];

	// unlink
	$unlink = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE id='$id'");
	$row = mysqli_fetch_array($unlink);

	$hapus_foto = $row['foto'];
	
	

	// update

	if(isset($_POST['ubahfoto']))
	{
		if ($row['foto']=="") 
		{
				if ($foto != "") {
				$allowed_ext = array('png','jpg');
				$x = explode(".", $foto);
				$ekstensi = strtolower(end($x));
				$file_tmp = $_FILES['foto']['tmp_name'];
				$angka_acak = rand(1,999);
		   		$nama_file_baru = $angka_acak.'-'.$foto;
		   		    if (in_array($ekstensi, $allowed_ext) === true) {
		      			move_uploaded_file($file_tmp, '../admin/img/'.$nama_file_baru);
		      			$result =  mysqli_query($koneksi, "UPDATE tb_user SET username='$username', password='$password', nama='$nama', foto='$nama_file_baru' WHERE id='$id'");
		      			
		      			
		    }



			}
		}else if ($row['foto']!="") {
			if ($foto != "") {
				$allowed_ext = array('png','jpg');
				$x = explode(".", $foto);
				$ekstensi = strtolower(end($x));
				$file_tmp = $_FILES['foto']['tmp_name'];
				$angka_acak = rand(1,999);
		   		$nama_file_baru = $angka_acak.'-'.$foto;
		   		    if (in_array($ekstensi, $allowed_ext) === true) {
		      			move_uploaded_file($file_tmp, '../admin/img/'.$nama_file_baru);
		      			$result =  mysqli_query($koneksi, "UPDATE tb_user SET username='$username', password='$password', nama='$nama', foto='$nama_file_baru' WHERE id='$id'");
		      			if ($result) {
		      				unlink("../admin/img/$hapus_foto");
		      			}

		      			
		    }



			}
		}	
	}

	if (empty($_POST['foto'])) {
		return  mysqli_query($koneksi, "UPDATE tb_user SET username='$username', password='$password', nama='$nama' WHERE id='$id'");
	}

}

// ---------------------------------------------------TRANSAKSI SECTION----------------------------------------------------------
function insert_transaksi()
{
    global $koneksi;

    if (isset($_POST['simpan'])) {
        $kdproduk = $_POST['simpan']; // Ambil nilai kdproduk dari form
        $select  = mysqli_query($koneksi, "SELECT * FROM transaksi_temp WHERE kdproduk = '$kdproduk'");
        $row = mysqli_fetch_assoc($select);

        if ($row) {
            // Produk sudah ada dalam transaksi, update jumlah pembelian dan total
			$select_harga = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE kdproduk = '$kdproduk'");
			$harga = mysqli_fetch_assoc($select_harga);

            $jumlah_beli = $row['jumlah_beli'] + 1;
            $total = $jumlah_beli * $harga['harga'];
            $update_query = "UPDATE transaksi_temp SET jumlah_beli=$jumlah_beli, total=$total WHERE kdproduk='$kdproduk'";
            mysqli_query($koneksi, $update_query);
        } else {
            // Produk belum ada dalam transaksi, tambahkan produk baru
            $select_produk = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE kdproduk = '$kdproduk'");
            $produk = mysqli_fetch_assoc($select_produk);

            if ($produk) {
                $nm_produk = $produk['nm_produk'];
                $kategori = $produk['kategori'];
                $harga = $produk['harga'];
                $jumlah_beli = 1;
                $total = $harga * $jumlah_beli;

                $insert_query = "INSERT INTO transaksi_temp (kdproduk, nm_produk, kategori, jumlah_beli, total) VALUES ('$kdproduk', '$nm_produk', '$kategori', $jumlah_beli, $total)";
                mysqli_query($koneksi, $insert_query);
            } else {
                echo '<script>alert("Produk tidak ditemukan")</script>';
            }
        }
    }
}

function update_transaksi_1 () {
	global $koneksi;

	if (isset($_POST['simpan_transaksi'])) {
		$kdproduk = $_POST['simpan_transaksi'];
		$select  = mysqli_query($koneksi, "SELECT * FROM transaksi_temp WHERE kdproduk = '$kdproduk'");
        $row = mysqli_fetch_assoc($select);

		if ($row) {
			$id = $_POST['id'];
			$jumlah_beli = $_POST['jumlah_beli'];
			$stok = $_POST['stok'];
			$kurang_stok = $stok - $jumlah_beli;

			$select  = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE kdproduk = '$kdproduk'");
    		$r = mysqli_fetch_assoc($select);
			$harga = $r['harga'];
			$harga_baru = $jumlah_beli * $harga;

			$query_1 = mysqli_query($koneksi, "UPDATE transaksi_temp SET jumlah_beli='$jumlah_beli', total='$harga_baru' WHERE kdproduk='$kdproduk'");
		}
	}
}

// function update_transaksi_1()
// {
// 	global $koneksi;
// 	$id = $_POST['id'];
// 	$kdproduk = $_POST['simpan_transaksi'];
// 	$jumlah_beli = $_POST['jumlah_beli'];
// 	$stok = $_POST['stok'];
// 	// Ubah stok tb_produk
// 	$kurang_stok = $stok - $jumlah_beli;
	
	
// 	// $query =  mysqli_query($koneksi, "UPDATE tb_produk SET stok='$kurang_stok' WHERE kdproduk='$kdproduk'");
// 	$select  = mysqli_query($koneksi, "SELECT * FROM tb_produk WHERE kdproduk = '$kdproduk'");
//     $row = mysqli_fetch_assoc($select);
	

// 	$harga = $row['harga'];
// 	// jumlah harga
// 	$harga_baru = $jumlah_beli * $harga;

// 	// // query validasi
// 	// $val = mysqli_query($koneksi, "SELECT * FROM transaksi_temp WHERE kdproduk='$kdproduk'");
// 	// $row = mysqli_fetch_row($row);

// 	// if ($row) {
		

// 	// }else{
// 	// 	$query_2 = mysqli_query($koneksi, "UPDATE transaksi_temp SET jumlah_beli='$jumlah_beli', total='$harga_baru' WHERE id='$id'");
// 	// }

// 	// update transaksi temp
// 	$query_1 = mysqli_query($koneksi, "UPDATE transaksi_temp SET jumlah_beli='$jumlah_beli', total='$harga_baru' WHERE kdproduk='$kdproduk'");
// 	// update laporan penjualan
// 	// $query_2 = mysqli_query($koneksi, "UPDATE laporan_penjualan SET jumlah_beli='$jumlah_beli', total='$harga_baru' WHERE kdproduk='$kdproduk'");
// }

// url
function url()
{
	return $url = "//localhost/web-kasir/vendors/";
}

function rupiah($angka){
	$hasil = "Rp. ". number_format($angka,2,',','.');
	return $hasil;
}

 ?>
