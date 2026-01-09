document.addEventListener('DOMContentLoaded', function() {
    // Auto refresh every 2 hours (hidden feature)
    setInterval(function() {
        fetch('update.php').then(() => {
            console.log('Background update completed');
        });
    }, 7200000);
    
    // Filter news by category
    const categoryBtns = document.querySelectorAll('.category-btn');
    const newsCards = document.querySelectorAll('.news-card');
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active button
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filter cards
            newsCards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Smooth hover effects
    const cards = document.querySelectorAll('.news-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });
    
    function updateTime() {
        const dateElement = document.querySelector('.nav-date');
        if (dateElement) {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            dateElement.innerHTML = `<i class="far fa-calendar-alt"></i> ${now.toLocaleDateString('id-ID', options)}`;
        }
    }
    
    setInterval(updateTime, 60000);

    console.log('NewsHub Portal initialized');
});