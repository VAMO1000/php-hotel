<?php

$koneksi = mysqli_connect('localhost', 'root', '', 'hotel');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses login
    if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["role"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $role = $_POST["role"];

        // Lakukan validasi data jika diperlukan

        // Jalankan parameterized query untuk memeriksa data login di database
        $stmt = $koneksi->prepare("SELECT * FROM jawir WHERE username = ? AND password = ? AND role = ?");
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Login berhasil
            // Redirect ke halaman dashboard sesuai dengan role
            if ($role == 'user') {
                header("Location: dashboard_user.php");
            } elseif ($role == 'customer') {
                header("Location: dashboard_customer.php");
            }
            exit();
        } else {
            // Login gagal
            echo "Username, password, atau role salah.";
        }

        $stmt->close();
    }

    // Proses sign up
    if (isset($_POST["sign_up"])) {
        $new_username = $_POST["new_username"];
        $new_password = $_POST["new_password"];
        $new_role = $_POST["new_role"];

        // Lakukan validasi data jika diperlukan

        // Jalankan parameterized query untuk memasukkan data sign up ke dalam database
        mysqli_query($koneksi, "INSERT INTO jawir VALUES(null, '$new_username', '$new_password', '$new_role')");

        // Jika sign up berhasil, redirect kembali ke halaman index.php
        header("Location: dashboard_user.php");
        exit();
    } else {
        // Jika terjadi error, tampilkan pesan error
    }

    // tambah data customer
    if (isset($_POST["add-customer"])) {
        $nm_cust = $_POST["nm_cust"];
        $no_Telp = $_POST["no_Telp"];
        $jk = $_POST["jk"];
        $alamat = $_POST["alamat"];   

    if (isset($_GET['id_cust'])) {
        $id_cust = $_GET['id_cust'];
        mysqli_query($koneksi, "DELETE FROM customer where id_cust = '$id_cust'");            
        header("location: dashboard_user.php");
        }
        
    if (isset($_POST['edit'])) {
        $id_cust = $_POST['id_cust'];
        $nm_cust = $_POST['nm_cust'];
        $no_Telp = $_POST['no_Telp'];
        $jk = $_POST['jk'];
        $alamat = $_POST['alamat'];
        $koneksi->query ("UPDATE customer SET id_cust='$id_cust', nm_cust='$nm_cust', no_Telp='$no_Telp', jk='$jk', alamat='$alamat' where id_cust='$id_cust'");
        header("location:dashboard_user.php");
        }     

        // Lakukan validasi data jika diperlukan

        // Jalankan parameterized query untuk memasukkan data sign up ke dalam database
        mysqli_query($koneksi, "INSERT INTO customer VALUES(null, '$nm_cust', '$no_Telp', '$jk', '$alamat')");

        // Jika sign up berhasil, redirect kembali ke halaman index.php
        header("Location: dashboard_user.php");
       exit();
    } else {
        // Jika terjadi error, tampilkan pesan error
    }

    
}



?>