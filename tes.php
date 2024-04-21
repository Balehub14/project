<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih CPU dan Kartu Grafis</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* CSS untuk mengatur ukuran font deskripsi CPU dan GPU */
        .cpu-details, .gpu-details {
            font-size: 14px; /* Atur ukuran font sesuai kebutuhan */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Pilih CPU dan Kartu Grafis Anda</h2>
        <form>
            <div class="form-group">
                <label for="cpuSelect">Pilih CPU:</label>
                <select class="form-control" id="cpuSelect" onchange="showCPUDetails()">
                    <option value="">Silahkan pilih CPU...</option> <!-- Placeholder untuk CPU -->
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "pc_component");
                    if ($conn->connect_error){
                        die("Connect Error: ". $conn->connect_error);
                    }

                    $sql = "SELECT * FROM cpu";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0){
                        while ($row = $result->fetch_assoc()){
                            echo "<option value='". $row["name"] ."'>". $row["name"] ."</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <div id="cpuDetails" class="cpu-details mt-3"></div> <!-- Tambahkan kelas untuk deskripsi CPU -->
            <div class="form-group mt-3">
                <label for="gpuSelect">Pilih Kartu Grafis:</label>
                <select class="form-control" id="gpuSelect" onchange="showGPUDetails()">
                    <option value="">Silahkan pilih Chipset Kartu Grafis...</option> <!-- Placeholder untuk GPU -->
                    <?php
                    $conn = mysqli_connect("localhost", "root", "", "pc_component");
                    if ($conn->connect_error){
                        die("Connect Error: ". $conn->connect_error);
                    }

                    $sql = "SELECT DISTINCT chipset FROM video_card"; // Memilih chipset yang unik
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0){
                        while ($row = $result->fetch_assoc()){
                            echo "<option value='". $row["chipset"] ."'>". $row["chipset"] ."</option>";
                        }
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <div id="gpuDetails" class="gpu-details mt-3"></div> <!-- Tambahkan kelas untuk deskripsi GPU -->
            <button type="button" class="btn btn-secondary" onclick="resetSelection()">Reset</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
    // Fungsi untuk menampilkan detail CPU
    function showCPUDetails() {
        var cpuSelect = document.getElementById("cpuSelect");
        var cpuName = cpuSelect.options[cpuSelect.selectedIndex].value;
        
        // Simpan nilai CPU yang dipilih ke sessionStorage
        sessionStorage.setItem('selectedCPU', cpuName);

        if (cpuName === "") {
            document.getElementById("cpuDetails").innerHTML = "";
            return;
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cpuDetails").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "get_cpu_details.php?name=" + encodeURIComponent(cpuName), true); // Encode CPU name
        xhttp.send();
    }

    // Fungsi untuk menampilkan detail Kartu Grafis
    function showGPUDetails() {
        var gpuSelect = document.getElementById("gpuSelect");
        var gpuChipset = gpuSelect.options[gpuSelect.selectedIndex].value; // Mengambil chipset GPU yang dipilih
        
        // Hapus deskripsi GPU sebelum memuat yang baru
        document.getElementById("gpuDetails").innerHTML = "";

        // Simpan nilai GPU yang dipilih ke sessionStorage
        sessionStorage.setItem('selectedGPU', gpuChipset);

        if (gpuChipset === "") {
            document.getElementById("gpuDetails").innerHTML = "";
            return;
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("gpuDetails").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "get_gpu_details.php?chipset=" + encodeURIComponent(gpuChipset), true); // Encode chipset
        xhttp.send();
    }

    // Fungsi untuk mereset pilihan CPU dan GPU
    function resetSelection() {
        document.getElementById("cpuSelect").value = "";
        document.getElementById("gpuSelect").value = "";
        document.getElementById("cpuDetails").innerHTML = "";
        document.getElementById("gpuDetails").innerHTML = "";
        sessionStorage.removeItem('selectedCPU');
        sessionStorage.removeItem('selectedGPU');
    }

    // Fungsi untuk memuat nilai CPU dan GPU yang dipilih dari sessionStorage saat halaman dimuat
    window.onload = function() {
        var selectedCPU = sessionStorage.getItem('selectedCPU');
        var selectedGPU = sessionStorage.getItem('selectedGPU');

        if (selectedCPU) {
            document.getElementById("cpuSelect").value = selectedCPU;
            showCPUDetails();
        }

        if (selectedGPU) {
            document.getElementById("gpuSelect").value = selectedGPU;
            showGPUDetails();
        }
    };
    </script>
</body>
</html>
