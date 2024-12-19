
<?php
try {
  $pdo = new PDO("mysql:host=localhost;dbname=db_webmohinh", "root", "");
  // Cài đặt chế độ lỗi cho PDO
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit();
}
?>
