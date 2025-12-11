<?php
include('koneksi.php');

if (isset($_GET['nomor'])) {

    $nomor = $_GET['nomor'];

    $sql = "DELETE FROM transaksi WHERE nomor = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nomor);

    if ($stmt->execute()) {
        echo "<script>
                alert('Transaksi berhasil dihapus!');
                window.location.href='data.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus transaksi!');
                window.location.href='data.php';
              </script>";
    }
}
?>
