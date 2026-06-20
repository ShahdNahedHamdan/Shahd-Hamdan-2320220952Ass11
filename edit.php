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
$error_msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$name = $_POST['name'];
$email = $_POST['email'];
$major = $_POST['major'];
if (empty($name) || empty($email) || empty($major)) {
$error_msg = "الحقول لا يمكن أن تكون فارغة.";
} else {
$check = $pdo->prepare("SELECT * FROM students WHERE email = ? AND id != ?");
$check->execute([$email, $id]);
if ($check->rowCount() > 0) {
$error_msg = "البريد الإلكتروني مخصص لطالب آخر.";
} else {
$sql = "UPDATE students SET name = ?, email = ?, major = ? WHERE id = ?";
$update = $pdo->prepare($sql);
$update->execute([$name, $email, $major, $id]);
$_SESSION['msg'] = "تم تحديث البيانات بنجاح.";
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
<title>تعديل طالب</title>
<?php include 'styles.php'; ?>
</head>
<body>
<div class="container">
<div class="main-header">
<h2>تعديل ملف الطالب</h2>
<a href="index.php" class="my-btn my-btn-back">رجوع</a>
</div>
<?php if (!empty($error_msg)) { ?>
<div class="alert alert-error"><?php echo $error_msg; ?></div>
<?php } ?>
<form action="edit.php?id=<?php echo $id; ?>" method="POST" style="background: #161625; padding: 20px; border-radius: 8px;">
<div class="form-group">
<label>الاسم الكامل:</label>
<input type="text" name="name" value="<?php echo $student['name']; ?>" required>
</div>
<div class="form-group">
<label>البريد الإلكتروني:</label>
<input type="email" name="email" value="<?php echo $student['email']; ?>" required>
</div>
<div class="form-group">
<label>التخصص:</label>
<input type="text" name="major" value="<?php echo $student['major']; ?>" required>
</div>
<button type="submit" class="my-btn">تحديث البيانات</button>
</form>
</div>
</body>
</html>