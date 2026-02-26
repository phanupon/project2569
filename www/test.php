<?php
$servername = "db"; // ต้องตรงกับชื่อ service ใน docker-compose
$username = "root";
$password = "rootpassword";
$dbname = "my_database"; //ตั้งชื่อให้ตรงกับ docker

// พยายามเชื่อมต่อ 5 ครั้ง ถ้าไม่ได้ให้รอครั้งละ 2 วินาที
$max_retries = 5;
$conn = null;

for ($i = 0; $i < $max_retries; $i++) {
    $conn = @new mysqli($servername, $username, $password, $dbname);
    if (!$conn->connect_error) {
        break;
    }
    echo "กำลังรอการเชื่อมต่อฐานข้อมูล... (ครั้งที่ " . ($i + 1) . ")<br>";
    sleep(2);
}

if ($conn->connect_error) {
    die("เชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

echo "เชื่อมต่อสำเร็จ!";
?>