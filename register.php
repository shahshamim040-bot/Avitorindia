<?php
// Database Connection
$conn = new mysqli("localhost", "root", "", "aviator_db");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$msg = "";
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $phone = $_POST['country_code'] . $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $referred_by = $_POST['referred_by'] ?? '';
    
    // Generate Unique Refer Code
    $refer_code = strtoupper(substr(md5(time()), 0, 6));

    $sql = "INSERT INTO users (name, email, country, phone, password, refer_code, referred_by) 
            VALUES ('$name', '$email', '$country', '$phone', '$password', '$refer_code', '$referred_by')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to Telegram and Login
        echo "<script>alert('রেজিস্ট্রেশন সফল হয়েছে!'); window.location.href='login.php';</script>";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Aviator India - Register</title>
    <style>
        body { background: #0f172a; color: #fff; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-box { background: #1e293b; padding: 30px; border-radius: 10px; width: 350px; box-shadow: 0 4px 10px rgba(0,0,0,0.5); }
        input, select { width: 100%; padding: 10px; margin: 8px 0; background: #0f172a; border: 1px solid #475569; color: #fff; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: #22c55e; border: none; color: #fff; font-weight: bold; border-radius: 5px; cursor: pointer; margin-top: 10px; }
        button:hover { background: #16a34a; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Aviator India Reg.</h2>
        <p style="color:red;"><?php echo $msg; ?></p>
        <form method="POST">
            <input type="text" name="name" placeholder="আপনার নাম" required>
            <input type="email" name="email" placeholder="ইমেইল এড্রেস" required>
            <input type="text" name="country" placeholder="দেশের নাম (যেমন: India/Bangladesh)" required>
            <div style="display: flex; gap: 5px;">
                <select name="country_code" style="width: 40%;">
                    <option value="+91">+91 (India)</option>
                    <option value="+880">+880 (BD)</option>
                </select>
                <input type="text" name="phone" placeholder="ফোন নাম্বার" style="width: 60%;" required>
            </div>
            <input type="password" name="password" placeholder="পাসওয়ার্ড" required>
            <input type="text" name="referred_by" placeholder="রেফার কোড (যদি থাকে)" value="<?php echo $_GET['ref'] ?? ''; ?>">
            <button type="submit" name="register">রেজিস্ট্রেশন করুন</button>
        </form>
        <p style="text-align: center; margin-top: 15px;"><a href="login.php" style="color: #38bdf8;">লগইন করুন</a></p>
    </div>
</body>
</html>