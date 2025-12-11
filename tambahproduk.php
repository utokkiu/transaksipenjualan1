<?php
include('koneksi.php');

// Proses Tambah Produk
if (isset($_POST['tambah'])) {
    $kode   = $_POST['kode'];
    $nama   = $_POST['nama'];
    $harga  = $_POST['harga'];

    $sql = "INSERT INTO produk (kode_produk, nama_produk, harga) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $kode, $nama, $harga);

    if ($stmt->execute()) {
        echo "<script>
                alert('Produk berhasil ditambahkan!');
                window.location.href='produk.php';
              </script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>
<body>

<h1>Tambah Produk</h1>

<form action="" method="post">
<table>
    <tr>
        <td>Kode Produk</td>
        <td>:</td>
        <td><input type="text" name="kode" required></td>
    </tr>

    <tr>
        <td>Nama Produk</td>
        <td>:</td>
        <td><input type="text" name="nama" required></td>
    </tr>

    <tr>
        <td>Harga</td>
        <td>:</td>
        <td><input type="number" name="harga" required></td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td>
            <button type="submit" name="tambah">Tambah Produk</button>
            <button type="button" onclick="window.location.href='produk.php'">Kembali</button>
        </td>
    </tr>
</table>
</form>

</body>
</html>
