<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kontak</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Tambah Kontak</h2>
        <form method="post">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $telepon = $_POST['telepon'];

            mysqli_query($conn, "INSERT INTO daftar_kontak (nama, email, telepon) VALUES ('$nama', '$email', '$telepon')");
            header("Location: index.php");
        }
        ?>
    </div>
    //rey
</body>
</html>
