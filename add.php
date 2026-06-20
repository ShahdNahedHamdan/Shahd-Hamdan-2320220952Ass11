<?php
require_once 'db.php';
$error_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$name = $_POST['name'];
$email = $_POST['email'];
$major = $_POST['major'];
if (empty($name) || empty($email) || empty($major)) {
$error_msg = "الرجاء تعبئة جميع الحقول المطلوبة.";
} else {
$check = $pdo->prepare("SELECT * FROM students WHERE email = ?");
$check->execute([$email]);
if ($check->rowCount() > 0) {
$error_msg = "هذا البريد الإلكتروني مستخدم بالفعل.";
} else {
$sql = "INSERT INTO students (name, email, major) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$name, $email, $major]);
$_SESSION['msg'] = "تم إضافة الطالب الجديد بنجاح.";
header("Location: index.php");
exit();
}
}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>إضافة طالب</title>
<?php include 'styles.php'; ?>
</head>
<body>
<div class="container">
<div class="main-header">
<h2>إدخال بيانات طالب جديد</h2>
<a href="index.php" class="my-btn my-btn-back">إلغاء والعودة</a>
</div>
<?php if (!empty($error_msg)) { ?>
<div class="alert alert-error"><?php echo $error_msg; ?></div>
<?php } ?>
<form action="add.php" method="POST" style="background: #161625; padding: 20px; border-radius: 8px;">
<div class="form-group">
<label>اسم الطالب:</label>
<input type="text" name="name" required>
</div>
<div class="form-group">
<label>البريد الإلكتروني:</label>
<input type="email" name="email" required>
</div>
<div class="form-group">
<label>التخصص الدراسي:</label>
<input type="text" name="major" required>
</div>
<button type="submit" class="my-btn">حفظ الطالب</button>
</form>
</div>
</body>
</html>