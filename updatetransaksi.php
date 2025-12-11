<?php
include('koneksi.php');

$nomor = $_GET['nomor'];

// Ambil data transaksi
$sql = "SELECT * FROM transaksi WHERE nomor = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomor);
$stmt->execute();
$data = $stmt->get_result()->fetch_object();

// Ambil detail produk (untuk harga)
$sql_produk = "SELECT * FROM produk WHERE kode_produk = ?";
$stmt2 = $conn->prepare($sql_produk);
$stmt2->bind_param("s", $data->kode_produk);
$stmt2->execute();
$produkData = $stmt2->get_result()->fetch_object();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Transaksi</title>
</head>
<body>

<h1>Update Transaksi</h1>

<form action="" method="post">
<table>
    <tr>
        <td>Nomor Transaksi</td>
        <td>:</td>
        <td><input type="text" name="nomor" value="<?= $data->nomor ?>" readonly></td>
    </tr>

    <tr>
        <td>Produk</td>
        <td>:</td>
        <td>
            <select name="produk" id="produk" onchange="updateHarga(this.value)">
                <?php
                $sql = "SELECT * FROM produk";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();
                while($p = $result->fetch_object()) {
                    $selected = ($p->kode_produk == $data->kode_produk) ? "selected" : "";
                    echo "<option value='$p->kode_produk|$p->harga' $selected>$p->nama_produk</option>";
                }
                ?>
            </select>
        </td>
    </tr>

    <tr>
        <td>Harga</td>
        <td>:</td>
        <td>
            <input type="number" id="harga" name="harga" 
                   value="<?= $produkData->harga ?>" readonly>
        </td>
    </tr>

    <tr>
        <td>Jumlah</td>
        <td>:</td>
        <td>
            <input type="number" id="jumlah" name="jumlah" 
                   value="<?= $data->jumlah ?>" onchange="hitungTotal()">
        </td>
    </tr>

    <tr>
        <td>Total</td>
        <td>:</td>
        <td>
            <input type="number" id="total" name="total" 
                   value="<?= $data->total ?>" readonly>
        </td>
    </tr>

    <tr>
        <td>Pembayaran</td>
        <td>:</td>
        <td>
            <input type="number" id="bayar" name="bayar" 
                   value="<?= $data->bayar ?>" onchange="hitungKembali()">
        </td>
    </tr>

    <tr>
        <td>Kembalian</td>
        <td>:</td>
        <td>
            <input type="number" id="kembalian" name="kembalian" 
                   value="<?= $data->kembali ?>" readonly>
        </td>
    </tr>

    <tr>
        <td></td><td></td>
        <td>
            <button type="submit" name="update">Update Transaksi</button>
            <button type="button" onclick="location.href='data.php'">Kembali</button>
        </td>
    </tr>
</table>
</form>

<script>
function updateHarga(value) {
    let harga = value.split('|')[1];
    document.getElementById("harga").value = harga;
    hitungTotal();
}

function hitungTotal() {
    let harga = document.getElementById("harga").value;
    let jumlah = document.getElementById("jumlah").value;
    let total = harga * jumlah;
    document.getElementById("total").value = total;
}

function hitungKembali() {
    let bayar = document.getElementById("bayar").value;
    let total = document.getElementById("total").value;
    document.getElementById("kembalian").value = bayar - total;
}
</script>

</body>
</html>

<?php
// Proses Update
if(isset($_POST['update'])) {

    $produk = explode('|', $_POST['produk'])[0];
    $jumlah = $_POST['jumlah'];
    $total = $_POST['total'];
    $bayar = $_POST['bayar'];
    $kembali = $_POST['kembalian'];

    $updateSQL = "UPDATE transaksi 
                  SET kode_produk=?, jumlah=?, total=?, bayar=?, kembali=?
                  WHERE nomor=?";
    $stmtUp = $conn->prepare($updateSQL);
    $stmtUp->bind_param("siiiss", $produk, $jumlah, $total, $bayar, $kembali, $nomor);

    if($stmtUp->execute()) {
        echo "<script>alert('Transaksi berhasil diupdate'); location.href='index.php';</script>";
    } else {
        echo "<script>alert('Gagal update transaksi');</script>";
    }
}
?>
