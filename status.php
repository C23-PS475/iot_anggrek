<?php
// Koneksi ke database MySQL
$koneksi = mysqli_connect("localhost", "root", "", "iot_anggrek");

// Periksa koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}

// Ambil nilai status dari parameter GET
$status = isset($_GET['status']) ? $_GET['status'] : null;

// Periksa apakah status adalah 0 atau 1
if ($status !== null && ($status == '0' || $status == '1')) {
    // Update nilai status di tabel 'status'
    $query = "UPDATE status SET status = '$status'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Jika berhasil diupdate, kirimkan respons JSON
        $response = [
            'success' => true,
            'message' => 'Status berhasil diupdate.',
            'status' => $status
        ];
    } else {
        // Jika gagal diupdate
        $response = [
            'success' => false,
            'message' => 'Gagal mengupdate status.'
        ];
    }
} else {
    // Jika parameter status tidak valid
    $response = [
        'success' => false,
        'message' => 'Parameter status tidak valid.'
    ];
}

// Set header untuk mengirimkan respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
