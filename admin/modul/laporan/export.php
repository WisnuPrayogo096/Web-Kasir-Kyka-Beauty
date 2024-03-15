<?php

?>
<html>
<head>
  <title>Stock Terjual</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
<button type="button" class="btn btn-primary" style="background-color: #006400; border-color: #006400;" onclick="goBack()">
  Kembali
</button>
			<h2>Stock Terjual</h2>
				<div class="data-tables datatable-dark">

                <table class="table table-borderless table-striped table-earning" id="mauexport">
                  <thead>
                    <tr>
                       <th>NO</th> 
                    
          
                    
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Jumlah Beli</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Kasir</th>
                        
                           
                                                
                    </tr>
                  </thead>
                <tbody>     
                    <?php 
                     $i = 1;
                     include 'pagingexport.php';
                      

                     ?>

                             
                </tbody>
                    </table>

				</div>
</div>
	
<script>
  function goBack() {
    window.history.back();
  };

  $(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                text: 'Export to CSV',
                filename: function () {
                    return generateFilename();
                }
            },
            {
                extend: 'excel',
                text: 'Export to Excel',
                filename: function () {
                    return generateFilename();
                }
            },
            {
                extend: 'pdf',
                text: 'Export to PDF',
                filename: function () {
                    return generateFilename();
                }
            },
            {
                extend: 'print',
                text: 'Print',
                customize: function(win) {
                    var currentDate = new Date();
                    var formattedDate = currentDate.getDate() + '-' + 
                                       (currentDate.getMonth() + 1) + '-' + 
                                       currentDate.getFullYear() + '_' + 
                                       currentDate.getHours() + '-' + 
                                       currentDate.getMinutes() + '-' + 
                                       currentDate.getSeconds();
                    $(win.document.body).find('h1').text('Laporan Penjualan');
                    $(win.document.body).append('<div>' + formattedDate + '</div>');
                }
            }
        ]
    } );

    function generateFilename() {
        var currentDate = new Date();
        var formattedDate = currentDate.getDate() + '-' + 
                           (currentDate.getMonth() + 1) + '-' + 
                           currentDate.getFullYear() + '_' + 
                           currentDate.getHours() + '-' + 
                           currentDate.getMinutes() + '-' + 
                           currentDate.getSeconds();
        return 'Export Penjualan_' + formattedDate; // Menggunakan tanggal dan jam sebagai nama file
    }
} );

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>