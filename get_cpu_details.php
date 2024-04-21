<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "pc_component");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan nama CPU yang dipilih dari parameter GET
if(isset($_GET['name'])) {
    $cpu_name = $_GET['name'];

    // Bersihkan nama CPU untuk mencegah SQL injection
    $cpu_name = mysqli_real_escape_string($conn, $cpu_name);

    // Query untuk mendapatkan detail CPU
    $sql_cpu = "SELECT * FROM cpu WHERE name = '$cpu_name'";
    $result_cpu = $conn->query($sql_cpu);

    // Menampilkan detail CPU
    if ($result_cpu->num_rows > 0) {
        $row_cpu = $result_cpu->fetch_assoc();
        echo "<h4>Detail CPU:</h4>";
        echo "<p><strong>Name:</strong> " . $row_cpu["name"] . "</p>";
        echo "<p><strong>Price:</strong> " . $row_cpu["price"] . " USD</p>";
        echo "<p><strong>Core Count:</strong> " . $row_cpu["core_count"] . "</p>";
        echo "<p><strong>Core Clock:</strong> " . $row_cpu["core_clock"] . "</p>";
        echo "<p><strong>Boost Clock:</strong> " . $row_cpu["boost_clock"] . "</p>";
        echo "<p><strong>TDP:</strong> " . $row_cpu["tdp"] . "</p>";
        echo "<p><strong>SMT:</strong> " . $row_cpu["smt"] . "</p>";
    } else {
        echo "CPU not found";
    }
} else {
    echo "No CPU selected";
}

// Menutup koneksi database
$conn->close();
?>
