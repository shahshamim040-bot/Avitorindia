<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aviator_db");

// Handle Deposit Approve / Reject
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'approve') {
        $trx = $conn->query("SELECT * FROM transactions WHERE id=$id")->fetch_assoc();
        $u_email = $trx['user_email'];
        $amt = $trx['amount'];
        
        // Add balance to user
        $conn->query("UPDATE users SET balance = balance + $amt WHERE email='$u_email'");
        $conn->query("UPDATE transactions SET status='Success' WHERE id=$id");
    } elseif ($action == 'reject') {
        $conn->query("UPDATE transactions SET status='Rejected' WHERE id=$id");
    }
    header("Location: admin.php");
}

// Handle Notice Update
if (isset($_POST['update_notice'])) {
    $new_notice = $_POST['notice_text'];
    $conn->query("UPDATE notice SET message='$new_notice' WHERE id=1");
}

$deposits = $conn->query("SELECT * FROM transactions WHERE type='Deposit'");
$current_notice = $conn->query("SELECT message FROM notice WHERE id=1")->fetch_assoc()['message'];
?>
<!DOCTYPE html>
<html lang="bn">
<head><title>Admin Panel - Aviator India</title>
<style>
    body { background: #0f172a; color: #fff; font-family: Arial; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #1e293b; }
    th, td { border: 1px solid #334155; padding: 10px; text-align: center; }
    th { background: #334155; }
    .btn { padding: 5px 10px; text-decoration: none; color: #fff; border-radius: 3px; font-size: 12px; }
    .approve { background: #16a34a; }
    .reject { background: #dc2626; }
</style>
</head>
<body>
    <h1>👑 Admin Panel - Aviator India</h1>
    
    <h3>নোটিশ বোর্ড আপডেট করুন</h3>
    <form method="POST">
        <textarea name="notice_text" rows="3" style="width: 100%; background: #1e293b; color: #fff; padding: 10px;"><?php echo $current_notice; ?></textarea>
        <button type="submit" name="update_notice" style="padding: 8px 15px; background: #2563eb; color: #fff; border:none; cursor:pointer;">নোটিশ আপডেট করুন</button>
    </form>

    <h3>ডিপোজিট রিকোয়েস্ট ম্যানেজমেন্ট</h3>
    <table>
        <tr>
            <th>ইউজার ইমেইল</th>
            <th>মেথড</th>
            <th>টাকা</th>
            <th>প্রেরক নাম্বার</th>
            <th>ট্রানজেকশন আইডি</th>
            <th>স্ক্রিনশট</th>
            <th>অবস্থা</th>
            <th>অ্যাকশন</th>
        </tr>
        <?php while($row = $deposits->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['user_email']; ?></td>
            <td><?php echo $row['method']; ?></td>
            <td>৳<?php echo $row['amount']; ?></td>
            <td><?php echo $row['sender_number']; ?></td>
            <td><?php echo $row['trx_id']; ?></td>
            <td><a href="<?php echo $row['screenshot']; ?>" target="_blank" style="color: #38bdf8;">ভিউ</a></td>
            <td><b><?php echo $row['status']; ?></b></td>
            <td>
                <?php if($row['status'] == 'Pending') { ?>
                    <a href="admin.php?action=approve&id=<?php echo $row['id']; ?>" class="btn approve">Approve</a>
                    <a href="admin.php?action=reject&id=<?php echo $row['id']; ?>" class="btn reject">Reject</a>
                <?php } else { echo "Completed"; } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>