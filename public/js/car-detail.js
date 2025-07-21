document.addEventListener('DOMContentLoaded', function () {
    // Image gallery functionality
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const prevBtn = document.getElementById('prevImage');
    const nextBtn = document.getElementById('nextImage');
    const fullscreenBtn = document.getElementById('fullscreenBtn');

    let currentImageIndex = 0;
    const images = Array.from(thumbnails).map(thumb => thumb.src.replace('w=300', 'w=1920'));

    // Thumbnail click handlers
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', () => {
            setActiveImage(index);
        });
    });

    // Navigation buttons
    prevBtn.addEventListener('click', () => {
        currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : images.length - 1;
        setActiveImage(currentImageIndex);
    });

    nextBtn.addEventListener('click', () => {
        currentImageIndex = currentImageIndex < images.length - 1 ? currentImageIndex + 1 : 0;
        setActiveImage(currentImageIndex);
    });

    // Fullscreen functionality
    fullscreenBtn.addEventListener('click', () => {
        if (mainImage.requestFullscreen) {
            mainImage.requestFullscreen();
        }
    });

    function setActiveImage(index) {
        currentImageIndex = index;
        mainImage.src = images[index];

        thumbnails.forEach(thumb => thumb.classList.remove('active'));
        thumbnails[index].classList.add('active');
    }

    // Countdown timer
    function updateCountdown() {
        const endDate = new Date('2024-12-28T15:00:00-08:00');
        const now = new Date();
        const timeLeft = endDate - now;

        if (timeLeft > 0) {
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));

            document.getElementById('countdown').textContent = `${days}d ${hours}h ${minutes}m`;
        } else {
            document.getElementById('countdown').textContent = 'Auction Ended';
        }
    }

    // Update countdown every minute
    updateCountdown();
    setInterval(updateCountdown, 60000);

    // Bid functionality
    const bidInput = document.querySelector('.bid-input');
    const bidBtn = document.querySelector('.btn-bid');

    bidBtn.addEventListener('click', () => {
        const bidAmount = parseInt(bidInput.value);
        const currentBid = 185500;

        if (bidAmount > currentBid) {
            alert(`Bid of $${bidAmount.toLocaleString()} placed successfully!`);
            // Here you would typically send the bid to your backend
        } else {
            alert('Bid must be higher than current bid');
        }
    });

    // Financing calculator
    const loanAmount = document.querySelector('.financing-form input[type="number"]:nth-of-type(1)');
    const downPayment = document.querySelector('.financing-form input[type="number"]:nth-of-type(2)');
    const termSelect = document.querySelector('.financing-form select');
    const monthlyPaymentDisplay = document.querySelector('.monthly-payment .amount');

    function calculatePayment() {
        const loan = parseFloat(loanAmount.value) || 0;
        const down = parseFloat(downPayment.value) || 0;
        const term = parseInt(termSelect.value) || 60;
        const rate = 0.049 / 12; // 4.9% APR monthly

        const principal = loan - down;
        const payment = (principal * rate * Math.pow(1 + rate, term)) / (Math.pow(1 + rate, term) - 1);

        monthlyPaymentDisplay.textContent = `$${Math.round(payment).toLocaleString()}/mo`;
    }

    [loanAmount, downPayment, termSelect].forEach(element => {
        element.addEventListener('input', calculatePayment);
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});