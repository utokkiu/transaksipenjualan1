<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Transaksi</title>
</head>
<body>
    <h1>Input Transaksi</h1>
    <form action="#" method="post">
        <table>
            <tr>
                <td>Nomor Transaksi</td>
                <td>:</td>
                <td>
                    <input type="text" name="nomor" id="nomor" readonly value="<?= uniqid() ?>">
                </td>
            </tr>
            <tr>
                <td>Tanggal Transaksi</td>
                <td>:</td>
                <td>
                    <input type="text" name="tanggal" id="tanggal" readonly value="<?= date('m/d/Y') ?>">
                </td>
            </tr>
            <tr>
                <td>Produk</td>
                <td>:</td>
                <td>
                    <select name="produk" id="produk" onchange="tampilHarga(this.value)">
                        <option disabled selected>- Pilih Produk -</option>
                        <?php 
                            include('koneksi.php');

                            $sql = "SELECT * FROM produk";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while($produk = $result->fetch_object()) {
                                echo "<option value='$produk->kode_produk|$produk->harga'>$produk->nama_produk</option>";
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Harga Satuan</td>
                <td>:</td>
                <td>
                    <input type="number" name="harga" id="harga" readonly>
                </td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td>
                    <input type="number" name="jumlah" id="jumlah" onchange="hitungTotal(this.value)">
                </td>
            </tr>
            <tr>
                <td>Total</td>
                <td>:</td>
                <td>
                    <input type="number" name="total" id="total" readonly>
                </td>
            </tr>
            <tr>
                <td>Pembayaran</td>
                <td>:</td>
                <td>
                    <input type="number" name="bayar" id="bayar">
                    <button type="button" id="hitungBtn" onclick="hitungKembalian()">Hitung</button>
                </td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td>:</td>
                <td>
                    <input type="number" name="kembalian" id="kembalian" readonly>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" id="simpanBtn" disabled>Simpan Transaksi</button>
                    <button type="button" onclick="location.href='index.php'">Kembali ke Menu</button>
                </td>
            </tr>
        </table>
    </form>
    <script>
        function tampilHarga(nilai) {
            var harga = nilai.split('|')[1];
            document.getElementById("harga").value = harga;
            document.getElementById("jumlah").focus();
        }

        function hitungTotal(jumlah) {
            var harga = document.getElementById("harga").value;
            var total = harga * jumlah;
            document.getElementById("total").value = total;
            enableHitungButton();
        }

        function hitungKembalian() {
            var bayar = parseFloat(document.getElementById("bayar").value);
            var total = parseFloat(document.getElementById("total").value);
            var kembalian = bayar - total;

            // Jika kembalian negatif, tidak tampilkan kembalian
            if (kembalian < 0) {
                document.getElementById("kembalian").value = "";
                alert("Pembayaran tidak boleh lebih kecil dari total.");
            } else {
                document.getElementById("kembalian").value = kembalian;
                enableSimpanButton();
            }
        }

        function enableHitungButton() {
            var bayar = parseFloat(document.getElementById("bayar").value);
            var total = parseFloat(document.getElementById("total").value);
            if (bayar >= total) {
                document.getElementById("hitungBtn").disabled = false;
            }
        }

        function enableSimpanButton() {
            var kembalian = document.getElementById("kembalian").value;
            if (kembalian !== "" && parseFloat(kembalian) >= 0) {
                document.getElementById("simpanBtn").disabled = false;
            }
        }
    </script>
</body>
</html>
<?php 
    if(isset($_POST['nomor'])) {
        $nomor = $_POST['nomor'];
        $produk = explode('|', $_POST['produk'])[0];
        $jumlah = $_POST['jumlah'];
        $total = $_POST['total'];
        $bayar = $_POST['bayar'];
        $kembalian = $_POST['kembalian'];

        $sql = "INSERT INTO transaksi(nomor, kode_produk, jumlah, total, bayar, kembali) VALUES(?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiii", $nomor, $produk, $jumlah, $total, $bayar, $kembalian);
        $result = $stmt->execute();

        if($result) {
            echo "Transaksi berhasil disimpan.";
        } else {
            echo "Transaksi gagal disimpan.";
        }
    }
?>
