<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <style>
        table{
            border-collapse:collapse
        }

    </style>
</head>
<body>
    <h1>Data Transaksi</h1>
    <table border="1" cellpadding="8" >
        <tr>
            <th>#</th>
            <th>Nomor Transaksi</th>
            <th>Tanggal</th>
            <th>Nama Produk</th>
            <th>Harga Satuan</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php 
            include('koneksi.php');

            $sql = "SELECT * FROM transaksi JOIN produk ON transaksi.kode_produk = produk.kode_produk";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $nomor = 1;
            while($transaksi = $result->fetch_object()) {
                $total = "Rp".number_format($transaksi->total, 2, ',', '.');
                $harga = "Rp".number_format($transaksi->harga, 2, ',', '.');
                
                echo "<tr>";
                echo "<td>$nomor</td>";
                echo "<td>$transaksi->nomor</td>";
                echo "<td>$transaksi->tanggal</td>";
                echo "<td>$transaksi->nama_produk</td>";
                echo "<td>$harga</td>";
                echo "<td>$transaksi->jumlah</td>";
                echo "<td>$total</td>";
                echo "<td align='center'>
                 <button onclick=\"window.location.href='updatetransaksi.php?nomor=$transaksi->nomor'\">Edit</button>
        <br><br>
        <button onclick=\"if(confirm('Yakin ingin menghapus transaksi ini?')) window.location.href='hapustransaksi.php?nomor=$transaksi->nomor'\">
            Hapus
        </button>
                </td>";
                echo "</tr>";
                $nomor++;
            }
        ?>
    </table>
    <br>
    <br>
    <button type="button" onclick="location.href='index.php'">Back</button>
</body>
</html>