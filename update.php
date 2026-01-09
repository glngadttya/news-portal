<?php
require_once 'includes/init.php';

if (fetch_news()) {
    $message = "✅ Berita berhasil diupdate!";
    $type = "success";
} else {
    $message = "❌ Gagal mengambil berita";
    $type = "error";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Berita</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: Arial, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .message-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        h1 { margin-bottom: 20px; }
        p { margin-bottom: 30px; font-size: 18px; }
        .btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h1 class="<?php echo $type; ?>">
            <?php echo $type == 'success' ? '✅' : '❌'; ?>
            Update Berita
        </h1>
        <p><?php echo $message; ?></p>
        <a href="index.php" class="btn">← Kembali ke Portal</a>
    </div>
</body>
</html>