$('#tataCaraModal').on('hidden.bs.modal', function () {
    // Find the video element and pause it
    $(this).find('video').each(function() {
        this.pause();
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const accordionItems = document.querySelectorAll('.accordion-item');

    accordionItems.forEach(item => {
        item.addEventListener('click', function() {
            // Toggle the collapse state
            const collapse = this.querySelector('.accordion-collapse');
            collapse.classList.toggle('show');

            // Collapse other items
            accordionItems.forEach(accItem => {
                if (accItem !== item) {
                    accItem.classList.remove('active');
                    accItem.querySelector('.accordion-collapse').classList.remove('show');
                    accItem.querySelector('.profile').classList.remove('collapsed-card');
                }
            });

            // Collapse other images
            const images = this.querySelectorAll('.profile');
            images.forEach(img => {
                if (img !== this.querySelector('.profile')) {
                    img.classList.add('collapsed-card');
                }
            });

            // Add active class to the clicked item
            this.classList.toggle('active');
        });
    });
});

// Sembunyikan tombol "Lihat Semua" setelah diklik
document.getElementById('showAllButton').addEventListener('click', function() {
    document.getElementById('showAllButton').style.display = 'none';
});


