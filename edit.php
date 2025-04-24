<?php
ob_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kontak</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        header {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        h2 {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .btn-back {
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: color 0.3s;
        }
        
        .btn-back:hover {
            color: var(--secondary-color);
        }
        
        .btn-back i {
            margin-right: 5px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .btn {
            padding: 12px 24px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
        }
        
        .btn:active {
            transform: translateY(1px);
        }
        
        .btn-container {
            display: flex;
            gap: 10px;
        }
        
        .btn-cancel {
            background-color: #95a5a6;
        }
        
        .btn-cancel:hover {
            background-color: #7f8c8d;
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .required {
            color: var(--danger-color);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px auto;
            }
            
            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .form-footer {
                flex-direction: column;
                gap: 15px;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h2>Edit Kontak</h2>
            <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
        </header>

        <?php
        // Validasi ID
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            echo "<div style='color: var(--danger-color); padding: 15px; background-color: #fde0dc; border-radius: 4px; margin-bottom: 20px;'>
                ID kontak tidak valid. <a href='index.php'>Kembali ke daftar</a>
            </div>";
            exit;
        }

        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $result = mysqli_query($conn, "SELECT * FROM daftar_kontak WHERE id = $id");
        
        if (!$result || mysqli_num_rows($result) == 0) {
            echo "<div style='color: var(--danger-color); padding: 15px; background-color: #fde0dc; border-radius: 4px; margin-bottom: 20px;'>
                Kontak tidak ditemukan. <a href='index.php'>Kembali ke daftar</a>
            </div>";
            exit;
        }
        
        $row = mysqli_fetch_assoc($result);
        
        // Process form submission
        if (isset($_POST['submit'])) {
            $nama = mysqli_real_escape_string($conn, $_POST['nama']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
            
            // Basic validation
            $errors = [];
            
            if (empty($nama)) {
                $errors[] = "Nama tidak boleh kosong";
            }
            
            if (empty($email)) {
                $errors[] = "Email tidak boleh kosong";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format email tidak valid";
            }
            
            if (empty($telepon)) {
                $errors[] = "Nomor telepon tidak boleh kosong";
            }
            
            if (empty($errors)) {
                $query = "UPDATE daftar_kontak SET nama='$nama', email='$email', telepon='$telepon' WHERE id=$id";
                $update = mysqli_query($conn, $query);
                
                if ($update) {
                    header("Location: index.php");
                    exit;   
                } else {
                    echo "<div style='color: var(--danger-color); padding: 15px; background-color: #fde0dc; border-radius: 4px; margin-bottom: 20px;'>
                        Gagal mengupdate kontak: " . mysqli_error($conn) . "
                    </div>";
                }
            } else {
                echo "<div style='color: var(--danger-color); padding: 15px; background-color: #fde0dc; border-radius: 4px; margin-bottom: 20px;'>";
                echo "<ul style='margin-left: 20px;'>";
                foreach ($errors as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul></div>";
            }
        }
        ?>

        <form method="post">
            <div class="form-group">
                <label for="nama">Nama <span class="required">*</span></label>
                <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($row['email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="telepon">Telepon <span class="required">*</span></label>
                <input type="text" id="telepon" name="telepon" value="<?= htmlspecialchars($row['telepon']); ?>" required>
            </div>
            
            <div class="form-footer">
                <div class="btn-container">
                    <button type="submit" class="btn" name="submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
                    <a href="index.php" class="btn btn-cancel"><i class="fas fa-times"></i> Batal</a>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Basic client-side validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const telepon = document.getElementById('telepon').value.trim();
            let isValid = true;
            
            if (nama === '') {
                isValid = false;
                document.getElementById('nama').style.borderColor = 'var(--danger-color)';
            }
            
            if (email === '') {
                isValid = false;
                document.getElementById('email').style.borderColor = 'var(--danger-color)';
            }
            
            if (telepon === '') {
                isValid = false;
                document.getElementById('telepon').style.borderColor = 'var(--danger-color)';
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Reset border on input focus
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '';
            });
        });
    </script>
</body>
</html>