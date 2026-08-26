<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aviator_db");
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

$email = $_SESSION['user'];
if (isset($_POST['deposit_submit'])) {
    $method = $_POST['method'];
    $amount = $_POST['amount'];
    $sender = $_POST['sender_number'];
    $trx_id = $_POST['trx_id'];
    
    // Screenshot Upload
    $target = "uploads/" . basename($_FILES['screenshot']['name']);
    move_uploaded_file($_FILES['screenshot']['tmp_name'], $target);

    $conn->query("INSERT INTO transactions (user_email, type, method, amount, sender_number, trx_id, screenshot) 
                  VALUES ('$email', 'Deposit', '$method', '$amount', '$sender', '$trx_id', '$target')");
    echo "<script>alert('ডিপোজিট রিকোয়েস্ট সফলভাবে জমা হয়েছে!'); window.location.href='history.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="bn">
<head><title>Deposit - Aviator India</title>
<style>
    body { background: #0f172a; color: #fff; font-family: Arial; padding: 20px; }
    .box { width: 400px; margin: auto; background: #1e293b; padding: 20px; border-radius: 8px; }
    input, select { width: 100%; padding: 10px; margin: 8px 0; background: #0f172a; border: 1px solid #475569; color: #fff; }
    button { width: 100%; padding: 10px; background: #16a34a; border: none; color: #fff; font-weight: bold; cursor: pointer; }
</style>
</head>
<body>
<div class="box">
    <h2>টাকা ডিপোজিট করুন</h2>
    <p>বিকাশ/নগদ পার্সোনাল নাম্বারে ক্যাশ আউট করুন: <strong>01700000000</strong></p>
    <form method="POST" enctype="multipart/form-data">
        <select name="method">
            <option value="bKash">বিকাশ (bKash)</option>
            <option value="Nagad">নগদ (Nagad)</option>
        </select>
        <input type="number" name="amount" placeholder="টাকার পরিমাণ (Amount)" required>
        <input type="text" name="sender_number" placeholder="যে নাম্বার থেকে টাকা পাঠিয়েছেন" required>
        <input type="text" name="trx_id" placeholder="ট্রানজেকশন আইডি (TrxID)" required>
        <label>পেমেন্ট স্ক্রিনশট:</label>
        <input type="file" name="screenshot" required>
        <button type="submit" name="deposit_submit">ডিপোজিট কনফার্ম করুন</button>
    </form>
    <p><a href="index.php" style="color: #38bdf8;">হোমে ফিরে যান</a></p>
</div>
</body>
</html>