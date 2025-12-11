<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk</title>
     <style>
        table{
            border-collapse:collapse
        }

    </style>
</head>
<body>
    <h1>Data Produk</h1>
    <table border="1" cellpadding="8">
        <tr>
            <th>#</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Action</th>
        </tr>
        <?php 
include('koneksi.php');

$sql = "SELECT * FROM produk";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$nomor = 1;

while($produk = $result->fetch_object()) {
    echo "<tr>";
    echo "<td>$nomor</td>";
    echo "<td>$produk->kode_produk</td>";
    echo "<td>$produk->nama_produk</td>";
    echo "<td>Rp" . number_format($produk->harga, 0, ',', '.') . "</td>";

    echo "<td>
            <button onclick=\"window.location.href='updateproduk.php?kode=$produk->kode_produk'\">
                Edit
            </button>
            <button onclick=\"if(confirm('Yakin ingin menghapus produk ini?')) window.location.href='hapusproduk.php?kode=$produk->kode_produk'\">
                Hapus
            </button>
          </td>";

    echo "</tr>";
    $nomor++;
}
?>

    </table>
    <br><button type="button" onclick="location.href='index.php'">Back</button> <button type="button" onclick="location.href='tambahproduk.php'">Tambah Produk</button>

</body>
</html>