<?php
include('koneksi.php');

if(isset($_GET['kode'])) {
    $kode = $_GET['kode'];

    $sql = "DELETE FROM produk WHERE kode_produk = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $kode);

    if($stmt->execute()) {
        echo "<script>
                alert('Produk berhasil dihapus!');
                window.location.href='produk.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus produk!');
                window.location.href='produk.php';
              </script>";
    }
}
?>
