<?php
function db_connect() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die();
    }
    return $conn;
}

function fetch_news() {
    $conn = db_connect();
    $url = "https://www.kompas.com/";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $html = curl_exec($ch);
    curl_close($ch);
    
    if (!$html) {
        $html = @file_get_contents($url);
    }
    
    if (!$html) {
        return false;
    }
    
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
    $xpath = new DOMXPath($dom);
    
    $news = [];
    
    $articles = $xpath->query("//div[contains(@class, 'article__list')]//article");
    
    if ($articles->length == 0) {
        $articles = $xpath->query("//div[contains(@class, 'latest')]//article");
    }
    
    if ($articles->length == 0) {
        $articles = $xpath->query("//article[contains(@class, 'article')]");
    }
    
    foreach ($articles as $article) {
        $item = [
            'title' => '',
            'link' => '',
            'image' => '',
            'category' => 'Berita',
            'date' => date('d F Y')
        ];
        
        $title_elements = $xpath->query(".//h2 | .//h3", $article);
        if ($title_elements->length > 0) {
            $item['title'] = trim($title_elements->item(0)->textContent);
        }
        
        $link_elements = $xpath->query(".//a", $article);
        if ($link_elements->length > 0) {
            $href = $link_elements->item(0)->getAttribute('href');
            if (strpos($href, 'http') === false) {
                $href = 'https://www.kompas.com' . $href;
            }
            $item['link'] = $href;
        }
        
        $img_elements = $xpath->query(".//img", $article);
        if ($img_elements->length > 0) {
            $item['image'] = $img_elements->item(0)->getAttribute('src');
            if (!$item['image']) {
                $item['image'] = $img_elements->item(0)->getAttribute('data-src');
            }
            if (!$item['image']) {
                $item['image'] = 'https://images.unsplash.com/photo-1588681664899-f142ff2dc9b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
            }
        }
        
        $cat_elements = $xpath->query(".//span[contains(@class, 'category')] | .//div[contains(@class, 'kanal')]", $article);
        if ($cat_elements->length > 0) {
            $item['category'] = trim($cat_elements->item(0)->textContent);
        }
        
        $date_elements = $xpath->query(".//div[contains(@class, 'date')] | .//time", $article);
        if ($date_elements->length > 0) {
            $item['date'] = trim($date_elements->item(0)->textContent);
        }
        
        if (!empty($item['title']) && !empty($item['link']) && strlen($item['title']) > 10) {
            $news[] = $item;
            
            if (count($news) >= 12) {
                break;
            }
        }
    }
    
    if (empty($news)) {
        $news = backup_scrape($html);
    }
    
    if (!empty($news)) {
        $conn->query("DELETE FROM berita");
        
        $stmt = $conn->prepare("INSERT INTO berita (title, link, image, category, date) VALUES (?, ?, ?, ?, ?)");
        
        foreach ($news as $item) {
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

function backup_scrape($html) {
    $news = [];
    $current_date = date('d F Y');
    
    preg_match_all('/<a[^>]*href="([^"]*kompas\.com[^"]*)"[^>]*>.*?<h[23][^>]*>(.*?)<\/h[23]>/si', $html, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $match) {
        if (count($match) >= 3) {
            $link = $match[1];
            $title = strip_tags($match[2]);
            
            if (strpos($link, 'http') === false) {
                $link = 'https://www.kompas.com' . $link;
            }
            
            preg_match('/<img[^>]*src="([^"]*)"[^>]*>/i', $html, $img_match);
            $image = $img_match[1] ?? 'https://images.unsplash.com/photo-1588681664899-f142ff2dc9b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80';
            
            preg_match('/<span[^>]*class="[^"]*category[^"]*"[^>]*>(.*?)<\/span>/i', $html, $cat_match);
            $category = $cat_match[1] ?? 'Berita';
            
            $news[] = [
                'title' => trim($title),
                'link' => $link,
                'image' => $image,
                'category' => trim($category),
                'date' => $current_date
            ];
            
            if (count($news) >= 8) {
                break;
            }
        }
    }
    
    return $news;
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
