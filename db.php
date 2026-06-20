<?php
if (session_status() === PHP_SESSION_NONE) {
session_start();
}
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'student_db';
try {
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
echo "خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage();
exit();
}
function showMessage() {
if (isset($_SESSION['msg'])) {
echo "<div class='alert alert-success'>" . $_SESSION['msg'] . "</div>";
unset($_SESSION['msg']);
}
if (isset($_SESSION['err'])) {
echo "<div class='alert alert-error'>" . $_SESSION['err'] . "</div>";
unset($_SESSION['err']);
}
}
?>