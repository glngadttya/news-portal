<?php
require_once 'includes/init.php';
$news = get_news();
$categories = array_unique(array_column($news, 'category'));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NewsHub • Portal Berita Terkini</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <i class="fas fa-newspaper"></i>
                <span>News Breaking</span>
            </div>
            <div class="nav-date">
                <i class="far fa-calendar-alt"></i>
                <?php echo date('d F Y'); ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Berita Terkini & Terpercaya</h1>
            <p class="hero-subtitle">Informasi terbaru dari berbagai kategori berita</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Stats Overview -->
        <div class="overview-cards">
            <div class="overview-card">
                <div class="overview-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="overview-info">
                    <h3><?php echo count($news); ?></h3>
                    <p>Total Berita</p>
                </div>
            </div>
            <div class="overview-card">
                <div class="overview-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="overview-info">
                    <h3><?php echo count($categories); ?></h3>
                    <p>Kategori</p>
                </div>
            </div>
            <div class="overview-card">
                <div class="overview-icon">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="overview-info">
                    <h3>Terbaru</h3>
                    <p>Informasi Real-time</p>
                </div>
            </div>
        </div>

        <!-- News Grid -->
        <?php if (empty($news)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <h3>Belum ada berita tersedia</h3>
                <p>Data berita sedang dimuat</p>
            </div>
        <?php else: ?>
            <!-- Category Filter -->
            <div class="category-filter">
                <button class="category-btn active" data-category="all">Semua</button>
                <?php foreach ($categories as $category): ?>
                    <button class="category-btn" data-category="<?php echo htmlspecialchars(strtolower($category)); ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- News Grid -->
            <div class="news-grid">
                <?php foreach ($news as $item): ?>
                <article class="news-card" data-category="<?php echo htmlspecialchars(strtolower($item['category'])); ?>">
                    <div class="card-image">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                             alt="<?php echo htmlspecialchars($item['title']); ?>"
                             onerror="this.src='https://images.unsplash.com/photo-1588681664899-f142ff2dc9b1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'">
                        <div class="card-category"><?php echo htmlspecialchars($item['category']); ?></div>
                    </div>
                    <div class="card-content">
                        <h3 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h3>
                        <div class="card-meta">
                            <span class="meta-date">
                                <i class="far fa-clock"></i>
                                <?php echo htmlspecialchars($item['date']); ?>
                            </span>
                        </div>
                        <a href="<?php echo htmlspecialchars($item['link']); ?>" 
                           target="_blank" 
                           class="card-action">
                            <span>Baca Artikel</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-brand">
                <i class="fas fa-newspaper"></i>
                <span>NewsHub</span>
            </div>
            <div class="footer-info">
                <p>&copy; <?php echo date('Y'); ?> NewsHub. All rights reserved.</p>
                <p class="footer-sources">Sumber: Kompas</p>
            </div>
            <div class="footer-social">
                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>