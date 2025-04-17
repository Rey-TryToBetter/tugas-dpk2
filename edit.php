<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Edit Kontak</h2>

        <?php
        $id = $_GET['id'];
        $result = mysqli_query($conn, "SELECT * FROM daftar_kontak WHERE id = $id");
        $row = mysqli_fetch_assoc($result);
        ?>

        <form method="post">
            <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $row['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $row['telepon']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $telepon = $_POST['telepon'];

            mysqli_query($conn, "UPDATE daftar_kontak SET nama='$nama', email='$email', telepon='$telepon' WHERE id=$id");
            header("Location: index.php");
        }
        ?>
    </div>
</body>
</html>
