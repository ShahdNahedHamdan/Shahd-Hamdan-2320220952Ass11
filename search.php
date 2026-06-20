
<?php
require_once 'db.php';
$results = [];
$search_word = "";
if (isset($_GET['search_word'])) {
$search_word = $_GET['search_word'];
if (!empty($search_word)) {
$keyword = "%" . $search_word . "%";
$sql = "SELECT * FROM students WHERE name LIKE ? OR email LIKE ? OR major LIKE ? ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$keyword, $keyword, $keyword]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>البحث والفلترة</title>
<?php include 'styles.php'; ?>
</head>
<body>
<div class="container">
<div class="main-header">
<h2>البحث السريع في النظام</h2>
<a href="index.php" class="my-btn my-btn-back">عرض الكل</a>
</div>
<form action="search.php" method="GET" class="search-box">
<input type="text" name="search_word" placeholder="اكتب اسم الطالب، الإيميل أو التخصص..." value="<?php echo $search_word; ?>">
<button type="submit" class="my-btn">ابحث</button>
</form>
<?php if (isset($_GET['search_word'])) { ?>
<h3>نتائج البحث عن: <?php echo $search_word; ?></h3>
<table>
<thead>
<tr>
<th>المعرف</th>
<th>الاسم</th>
<th>البريد</th>
<th>التخصص</th>
<th>العمليات</th>
</tr>
</thead>
<tbody>
<?php if (count($results) > 0) { ?>
<?php foreach ($results as $row) { ?>
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
<td colspan="5" style="text-align: center;">لا توجد أي نتائج مطابقة.</td>
</tr>
<?php } ?>
</tbody>
</table>
<?php } ?>
</div>
</body>
</html>