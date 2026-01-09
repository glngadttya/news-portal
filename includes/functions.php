<?php
function db_connect() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Database error: " . $conn->connect_error);
    }
    return $conn;
}

function fetch_news() {
    $conn = db_connect();
    $api_url = 'https://api.siputzx.my.id/api/berita/kompas';
    
    $json = @file_get_contents($api_url);
    if (!$json) {
        return false;
    }
    
    $data = json_decode($json, true);
    
    if ($data['status'] && !empty($data['data'])) {
        $conn->query("DELETE FROM berita");
        
        $stmt = $conn->prepare("INSERT INTO berita (title, link, image, category, date) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($data['data'] as $item) {
            if (!empty($item['link']) && !empty($item['title'])) {
                $stmt->bind_param("sssss", 
                    $item['title'],
                    $item['link'],
                    $item['image'],
                    $item['category'],
                    $item['date']
                );
                $stmt->execute();
            }
        }
        
        $stmt->close();
        
        $next_time = date('Y-m-d H:i:s', time() + 7200);
        $conn->query("UPDATE settings SET value='$next_time' WHERE name='next_update'");
        
        return true;
    }
    
    return false;
}

function get_news() {
    $conn = db_connect();
    $result = $conn->query("SELECT * FROM berita ORDER BY id DESC LIMIT 20");
    $news = [];
    while ($row = $result->fetch_assoc()) {
        $news[] = $row;
    }
    return $news;
}

function check_update_time() {
    $conn = db_connect();
    $result = $conn->query("SELECT value FROM settings WHERE name='next_update'");
    
    if ($result->num_rows == 0) {
        $next_time = date('Y-m-d H:i:s', time() + 7200);
        $conn->query("INSERT INTO settings (name, value) VALUES ('next_update', '$next_time')");
        return true;
    }
    
    $row = $result->fetch_assoc();
    $next_update = strtotime($row['value']);
    
    if (time() >= $next_update) {
        return true;
    }
    
    return false;
}
?>