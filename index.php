<?php include 'db.php'; ?>
<h2>Daftar Kontak</h2>
<a href="tambah.php">+ Tambah Kontak</a><br><br>
<table border="1" cellpadding="8">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    $result = mysqli_query($conn, "SELECT * FROM daftar_kontak ORDER BY id DESC");
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>$no</td>
            <td>{$row['nama']}</td>
            <td>{$row['email']}</td>
            <td>{$row['telepon']}</td>
            <td>
                <a href='edit.php?id={$row['id']}'>Edit</a> | 
                <a href='hapus.php?id={$row['id']}' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
            </td>
        </tr>";
        $no++;
    }
    ?>
</table>
