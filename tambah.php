<?php 
ob_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kontak</title>
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
        input[type="email"],
        select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .help-text {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
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
        
        .phone-input-container {
            display: flex;
            align-items: center;
        }
        
        .phone-select {
            width: 120px;
            margin-right: 10px;
            flex-shrink: 0;
        }
        
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
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
            
            .phone-input-container {
                flex-direction: column;
                align-items: stretch;
            }
            
            .phone-select {
                width: 100%;
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h2>Tambah Kontak</h2>
            <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
        </header>

        <?php
        // Process form submission
        if (isset($_POST['submit'])) {
            $nama = mysqli_real_escape_string($conn, $_POST['nama']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $prefix = mysqli_real_escape_string($conn, $_POST['telepon_prefix']);
            $nomor = substr(mysqli_real_escape_string($conn, $_POST['telepon_nomor']), 0, 15);
            $telepon = "{$prefix}{$nomor}";
            
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
            
            if (empty($nomor)) {
                $errors[] = "Nomor telepon tidak boleh kosong";
            }
            
            if (empty($errors)) {
                $query = "INSERT INTO daftar_kontak (nama, email, telepon) VALUES ('$nama', '$email', '$telepon')";
                $insert = mysqli_query($conn, $query);
                
                if ($insert) {
                    header("Location: index.php");
                    exit;   
                } else {
                    echo "<div class='error-message'>
                        Gagal menambahkan kontak: " . mysqli_error($conn) . "
                    </div>";
                }
            } else {
                echo "<div class='error-message'><ul style='margin-left: 20px;'>";
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
                <input type="text" id="nama" name="nama" value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" required>
                <div class="help-text">Masukkan nama lengkap.</div>
            </div>
            
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                <div class="help-text">Format: nama@domain.com</div>
            </div>
            
            <div class="form-group">
                <label for="telepon">Telepon <span class="required">*</span></label>
                <div class="phone-input-container">
                    <select name="telepon_prefix" class="phone-select" id="telepon_prefix">
                        <option value="+62">Indonesia (+62)</option>
                        <option value="+60">Malaysia (+60)</option>
                        <option value="+65">Singapura (+65)</option>
                        <option value="+1">Amerika Serikat (+1)</option>
                        <option value="+44">Inggris (+44)</option>
                        <option value="+61">Australia (+61)</option>
                        <option value="+81">Jepang (+81)</option>
                        <option value="+82">Korea Selatan (+82)</option>
                        <option value="+86">China (+86)</option>
                        <option value="+91">India (+91)</option>
                        <option value="+66">Thailand (+66)</option>
                        <option value="+84">Vietnam (+84)</option>
                        <option value="+63">Filipina (+63)</option>
                    </select>
                    <input type="text" id="telepon_nomor" name="telepon_nomor" placeholder="8123456789" value="<?= isset($_POST['telepon_nomor']) ? htmlspecialchars($_POST['telepon_nomor']) : ''; ?>" required>
                </div>
                <div class="help-text">Contoh untuk Indonesia: +62 8123456789</div>
            </div>
            
            <div class="form-footer">
                <div class="btn-container">
                    <button type="submit" class="btn" name="submit"><i class="fas fa-plus"></i> Tambah Kontak</button>
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
            const telepon = document.getElementById('telepon_nomor').value.trim();
            let isValid = true;
            
            if (nama === '') {
                isValid = false;
                document.getElementById('nama').style.borderColor = 'var(--danger-color)';
            }
            
            if (email === '') {
                isValid = false;
                document.getElementById('email').style.borderColor = 'var(--danger-color)';
            } else if (!isValidEmail(email)) {
                isValid = false;
                document.getElementById('email').style.borderColor = 'var(--danger-color)';
            }
            
            if (telepon === '') {
                isValid = false;
                document.getElementById('telepon_nomor').style.borderColor = 'var(--danger-color)';
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
        
        // Validate email format
        function isValidEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
        
        // Reset border on input focus
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.borderColor = '';
            });
        });
        
        // Only allow numbers in phone field
        document.getElementById('telepon_nomor').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>