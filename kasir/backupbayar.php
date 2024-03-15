document.getElementById("btnBayar").addEventListener("click", function () {
        const total = parseFloat(document.getElementById("total").innerText);
        const bayar = parseFloat(document.getElementById("inputBayar").value);

        if (isNaN(bayar) || bayar < total) {
            alert("Pembayaran tidak valid. Pastikan jumlah bayar mencukupi.");
            return;
        }

        const kembalian = bayar - total;
        document.getElementById("kembalian").innerText = kembalian.toFixed(2);

        $.ajax({
            url: "update_stok.php",
            type: "POST",
            data: { action: "update_stok" },
            success: function(response) {
               
                $.ajax({
                    url: "move_to_laporan.php",
                    type: "POST",
                    data: { action: "move_to_laporan" },
                    success: function(moveResponse) {
                        alert("Transaksi berhasil. Data telah dipindahkan ke laporan_penjualan.");
                    },
                    error: function() {
                        alert("Gagal memindahkan data ke laporan_penjualan.");
                    }
                });
            },
            error: function() {
                alert("Gagal mengupdate stok.");
            }
        });
    });