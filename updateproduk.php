<?php 
include('koneksi.php');

$kode = $_GET['kode'];

// ambil data produk berdasarkan kode
$sql = "SELECT * FROM produk WHERE kode_produk = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $kode);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_object();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
</head>
<body>

<h1>Edit Produk</h1>

<form action="" method="post">
    <table>
        <tr>
            <td>Kode Produk</td>
            <td>:</td>
            <td>
                <input type="text" name="kode_produk" value="<?= $data->kode_produk ?>" readonly>
            </td>
        </tr>

        <tr>
            <td>Nama Produk</td>
            <td>:</td>
            <td>
                <input type="text" name="nama_produk" value="<?= $data->nama_produk ?>">
            </td>
        </tr>

        <tr>
            <td>Harga</td>
            <td>:</td>
            <td>
                <input type="number" name="harga" value="<?= $data->harga ?>">
            </td>
        </tr>

        <tr>
            <td></td>
            <td></td>
            <td>
                <button type="submit" name="update">Update Produk</button>
                <button type="button" onclick="location.href='produk.php'">Kembali</button>
            </td>
        </tr>
    </table>
</form>

</body>
</html>

<?php
// proses update ketika tombol ditekan
if(isset($_POST['update'])) {

    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];

    $sql2 = "UPDATE produk SET nama_produk=?, harga=? WHERE kode_produk=?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("sis", $nama, $harga, $kode);

    if($stmt2->execute()) {
        echo "<script>alert('Produk berhasil diupdate'); location.href='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal update produk');</script>";
    }
}
?>
