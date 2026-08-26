<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "aviator_db");
$email = $_SESSION['user'];
$user_qry = $conn->query("SELECT * FROM users WHERE email='$email'");
$user = $user_qry->fetch_assoc();

// Fetch Notice
$notice_qry = $conn->query("SELECT message FROM notice WHERE id=1");
$notice = $notice_qry->fetch_assoc()['message'];
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>Aviator India - Play Game</title>
    <style>
        body { background: #090d16; color: #fff; font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .header { background: #111827; padding: 15px; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #1f2937; }
        .notice-board { background: #dc2626; color: white; padding: 10px; text-align: center; font-weight: bold; }
        .game-container { text-align: center; padding: 40px; }
        .plane-box { width: 100%; height: 300px; background: #1e293b; border-radius: 10px; display: flex; justify-content: center; align-items: center; position: relative; overflow: hidden; }
        #multiplier { font-size: 50px; font-weight: bold; color: #22c55e; }
        .btn-group { margin-top: 20px; display: flex; justify-content: center; gap: 15px; }
        .btn { padding: 10px 20px; background: #2563eb; color: #fff; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="notice-board">📢 নোটিশ: <?php echo $notice; ?></div>
    <div class="header">
        <h2>✈️ Aviator India</h2>
        <div>
            <span>ব্যালেন্স: ৳<strong id="user-bal"><?php echo $user['balance']; ?></strong></span> | 
            <a href="profile.php" style="color: #38bdf8; text-decoration: none;">প্রোফাইল</a> | 
            <a href="deposit.php" style="color: #22c55e; text-decoration: none;">ডিপোজিট</a> | 
            <a href="logout.php" style="color: #ef4444; text-decoration: none;">লগআউট</a>
        </div>
    </div>

    <div class="game-container">
        <div class="plane-box">
            <div id="multiplier">1.00x</div>
        </div>
        <div class="btn-group">
            <a href="deposit.php" class="btn" style="background: #16a34a;">টাকা ডিপোজিট করুন</a>
            <a href="withdraw.php" class="btn" style="background: #ca8a04;">উইথড্র করুন</a>
            <a href="history.php" class="btn">অ্যাক্টিভিটি হিস্ট্রি</a>
        </div>
    </div>

    <script>
        // Simple Auto Live Flight Simulation (10 Seconds loop)
        let mult = 1.00;
        let flightInterval;

        function startFlight() {
            mult = 1.00;
            document.getElementById('multiplier').style.color = "#22c55e";
            document.getElementById('multiplier').innerText = mult + "x";
            
            let crashAt = (Math.random() * 5 + 1.2).toFixed(2); // Random crash multiplier
            
            let timer = setInterval(() => {
                mult += 0.05;
                document.getElementById('multiplier').innerText = mult.toFixed(2) + "x";
                if(mult >= crashAt) {
                    clearInterval(timer);
                    document.getElementById('multiplier').style.color = "#ef4444";
                    document.getElementById('multiplier').innerText = "CRASHED! (" + crashAt + "x)";
                    setTimeout(startFlight, 5000); // Restart after 5 seconds
                }
            }, 200);
        }
        setTimeout(startFlight, 2000);
    </script>
</body>
</html>