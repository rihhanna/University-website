<?php
// معلومات الاتصال بقاعدة البيانات
$serverName = "DESKTOP-1S4V0SB";
$connectionOptions = array(
  "Database" => "University",
  "Uid" => "rihhana",
  "PWD" => "7748"
);

// إنشاء اتصال بقاعدة البيانات
$conn = sqlsrv_connect($serverName, $connectionOptions);

// التحقق من وجود اتصال صحيح
if ($conn === false) {
  die(print_r(sqlsrv_errors(), true));
}

// التحقق من إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // استلام قيمة التخصص من النموذج
  $majorName = $_POST["major_name"];

  // استعلام SQL لإدخال بيانات التخصص
  $sql = "INSERT INTO Majors (major_name) VALUES (?)";

  // تحضير الاستعلام
  $params = array($majorName);
  $stmt = sqlsrv_prepare($conn, $sql, $params);

  // تنفيذ الاستعلام والتحقق من نجاحه
  if (sqlsrv_execute($stmt) === false) {
    die(print_r(sqlsrv_errors(), true));
  }

  // إغلاق الاستعلام واتصال قاعدة البيانات
  sqlsrv_free_stmt($stmt);
  sqlsrv_close($conn);

  // إعادة توجيه المستخدم إلى صفحة نجاح الإضافة
  header("Location: success.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Major</title>
  <style>
    /* أضف الأنماط الخاصة بك هنا */
  </style>
</head>
<body>
  <div class="container">
    <h1>Add Major</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="form-group">
        <label for="major_name">Major Name:</label>
        <input type="text" id="major_name" name="major_name" required>
      </div>
      <button type="submit" class="btn">Add Major</button>
    </form>
  </div>
</body>
</html>