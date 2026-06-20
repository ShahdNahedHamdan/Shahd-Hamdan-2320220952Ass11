<?php
require_once 'db.php';
if (!isset($_GET['id'])) {
header("Location: index.php");
exit();
}
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$student) {
header("Location: index.php");
exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['agree']) && $_POST['agree'] == 'yes') {
$del = $pdo->prepare("DELETE FROM students WHERE id = ?");
$del->execute([$id]);
$_SESSION['msg'] = "تم مسح سجل الطالب بنجاح.";
}
header("Location: index.php");
exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>حذف السجل</title>
<?php include 'styles.php'; ?>
</head>
<body>
<div class="container">
<div class="main-header">
<h2>تأكيد الحذف من النظام</h2>
<a href="index.php" class="my-btn my-btn-back">إلغاء</a>
</div>
<div style="background: #161625; padding: 30px; border-radius: 8px; text-align: center;">
<p style="font-size: 18px;">هل أنت متأكد من حذف الطالب: <strong><?php echo $student['name']; ?></strong>؟</p>


<form action="delete.php?id=<?php echo $id; ?>" method="POST">
<input type="hidden" name="agree" value="yes">
<button type="submit" class="my-btn my-btn-danger">تأكيد الحذف النهائي</button>
<a href="index.php" class="my-btn my-btn-back">تراجع</a>
</form>
</div>
</div>
</body>
</html>