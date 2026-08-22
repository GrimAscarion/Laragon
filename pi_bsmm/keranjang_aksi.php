<?php
session_start();
require_once 'config/koneksi.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['customer_id'];
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'add') {
    $sparepart_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($sparepart_id > 0) {
        $stmt_cek = $pdo->prepare("SELECT id, qty FROM keranjang WHERE customer_id = ? AND sparepart_id = ?");
        $stmt_cek->execute([$user_id, $sparepart_id]);
        
        if ($stmt_cek->rowCount() > 0) {
            $data = $stmt_cek->fetch();
            $new_qty = $data['qty'] + 1;
            $cart_id = $data['id'];
            $stmt_update = $pdo->prepare("UPDATE keranjang SET qty = ? WHERE id = ?");
            $stmt_update->execute([$new_qty, $cart_id]);
        } else {
            $stmt_insert = $pdo->prepare("INSERT INTO keranjang (customer_id, sparepart_id, qty) VALUES (?, ?, 1)");
            $stmt_insert->execute([$user_id, $sparepart_id]);
        }
        
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'katalog.php';
        
        $_SESSION['pesan_keranjang'] = "Produk berhasil ditambahkan ke keranjang!";
        header("Location: " . $redirect);
        exit;
    }
} 
elseif ($action == 'delete') {
    $cart_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    $stmt_delete = $pdo->prepare("DELETE FROM keranjang WHERE id = ? AND customer_id = ?");
    $stmt_delete->execute([$cart_id, $user_id]);
    
    $_SESSION['pesan_keranjang'] = "Produk dihapus dari keranjang.";
    header("Location: profil_akun.php?tab=keranjang");
    exit;
}
elseif ($action == 'update') {
    $cart_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $op = isset($_GET['op']) ? $_GET['op'] : '';
    
    $stmt_cek = $pdo->prepare("SELECT qty FROM keranjang WHERE id = ? AND customer_id = ?");
    $stmt_cek->execute([$cart_id, $user_id]);
    
    if ($stmt_cek->rowCount() > 0) {
        $data = $stmt_cek->fetch();
        $qty = $data['qty'];
        
        if ($op == 'plus') {
            $qty++;
        } elseif ($op == 'min' && $qty > 1) {
            $qty--;
        }
        
        $stmt_update = $pdo->prepare("UPDATE keranjang SET qty = ? WHERE id = ?");
        $stmt_update->execute([$qty, $cart_id]);
    }
    
    header("Location: profil_akun.php?tab=keranjang");
    exit;
}

header("Location: index.php");
exit;
?>