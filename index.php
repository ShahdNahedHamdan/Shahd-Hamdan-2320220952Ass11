<?php
require_once 'db.php';
$limit = 10;
if (isset($_GET['page'])) {
$page = (int)$_GET['page'];
} else {
$page = 1;
}
$offset = ($page - 1) * $limit;
$count_query = $pdo->query("SELECT COUNT(*) FROM students");
$total_rows = $count_query->fetchColumn();
$total_pages = ceil($total_rows / $limit);
$stmt = $pdo->prepare("SELECT * FROM students ORDER BY id DESC LIMIT :offset, :limit");
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>لوحة التحكم - قائمة الطلاب</title>
<?php include 'styles.php'; ?>
</head>
<body>
<div class="container">
<div class="main-header">
<h1>نظام إدارة الطلاب</h1>
<div>
<a href="search.php" class="my-btn my-btn-back">البحث</a>
<a href="add.php" class="my-btn">إضافة طالب جديد</a>
</div>
</div>
<?php showMessage(); ?>
<table>
<thead>
<tr>
<th>المعرف</th>
<th>الاسم</th>
<th>البريد الإلكتروني</th>
<th>التخصص</th>
<th>العمليات</th>
</tr>
</thead>
<tbody>
<?php if (count($students) > 0) { ?>
<?php foreach ($students as $row) { ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['major']; ?></td>
<td>
<a href="edit.php?id=<?php echo $row['id']; ?>" class="my-btn">تعديل</a>
<a href="delete.php?id=<?php echo $row['id']; ?>" class="my-btn my-btn-danger">حذف</a>
</td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td colspan="5" style="text-align: center;">لا توجد بيانات لعرضها.</td>
</tr>
<?php } ?>
</tbody>
</table>
<div class="pagination">
<?php for ($i = 1; $i <= $total_pages; $i++) { ?>
<a href="index.php?page=<?php echo $i; ?>" class="<?php if($page == $i) echo 'active-page'; ?>">
<?php echo $i; ?>
</a>
<?php } ?>
</div>
</div>
</body>
</html>