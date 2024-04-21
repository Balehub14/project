<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "pc_component");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan chipset GPU yang dipilih dari parameter GET
if(isset($_GET['chipset'])) {
    $gpu_chipset = $_GET['chipset'];
    
    // Query untuk mendapatkan detail GPU berdasarkan chipset
    $sql_gpu = "SELECT * FROM video_card WHERE chipset = '$gpu_chipset'";
    $result_gpu = $conn->query($sql_gpu);

    // Menampilkan detail GPU
    if ($result_gpu->num_rows > 0) {
        while($row_gpu = $result_gpu->fetch_assoc()) {
            echo "<h4>Detail Kartu Grafis:</h4>";
            echo "<p><strong>Name:</strong> " . $row_gpu["name"] . "</p>";
            echo "<p><strong>Price:</strong> " . $row_gpu["price"] . " USD</p>";
            echo "<p><strong>Chipset:</strong> " . $row_gpu["chipset"] . "</p>";
            echo "<p><strong>Memory:</strong> " . $row_gpu["memory"] . " GB</p>";
            echo "<p><strong>Core Clock:</strong> " . $row_gpu["core_clock"] . "</p>";
            echo "<p><strong>Boost Clock:</strong> " . $row_gpu["boost_clock"] . "</p>";
            echo "<p><strong>Color:</strong> " . $row_gpu["color"] . "</p>";
            echo "<p><strong>Length:</strong> " . $row_gpu["length"] . "</p>";
        }
    } else {
        echo "Kartu Grafis tidak ditemukan";
    }
} else {
    echo "Tidak ada GPU yang dipilih";
}

// Menutup koneksi database
$conn->close();
?>
