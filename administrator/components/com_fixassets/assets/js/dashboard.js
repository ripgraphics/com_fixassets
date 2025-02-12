document.addEventListener('DOMContentLoaded', function() {
    // Handle active menu items
    const currentUrl = window.location.href;
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('click', function(e) {
            const link = this.querySelector('.stretched-link');
            if (link) {
                window.location.href = link.href;
            }
        });
    });
});