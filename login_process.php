<?php

session_start();

// Sambungkan ke database
$servername = "localhost"; // Ganti dengan hostname atau IP server MySQL Anda
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$dbname = "iot_Anggrek"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil nilai yang diposting dari form login
$username = $_POST['username'];
$password = $_POST['password'];



// Lakukan escapte karakter khusus untuk mencegah SQL Injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Buat dan jalankan query untuk memeriksa username dan password
$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

// Periksa apakah hasil query mengembalikan baris yang sesuai
if ($result->num_rows > 0) {
    // Login berhasil
    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
} else {
    // Login gagal
    header("Location: login.php?login=failed");
    exit();
}


// Tutup koneksi ke database
$conn-> close();
?>
