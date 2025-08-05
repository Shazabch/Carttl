<!-- resources/views/components/full-page-loading.blade.php -->
<div
    wire:loading.delay
    class="futuristic-loader position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
    style="z-index: 9999;">
    <div class="loader-content text-center">
        <div class="pulsing-core"></div>
        <p class="mt-3 fw-bold">Processing...</p>
    </div>
</div>

<style>
    .futuristic-loader {
        background-color: rgba(0, 5, 20, 0.85); /* Dark blue, semi-transparent */
        /* Subtle animated grid background */
        background-image:
            linear-gradient(rgba(0, 120, 255, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 120, 255, 0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        animation: gridMove 10s linear infinite;
    }

    @keyframes gridMove {
        0% { background-position: 0 0; }
        100% { background-position: 30px 30px; }
    }

    .futuristic-loader .loader-content p {
        color: #760E25; /* Cyan */
        text-transform: uppercase;
        letter-spacing: 2px;
        font-family: 'Orbitron', sans-serif; /* Example futuristic font - include it via CDN or local */
        text-shadow: 0 0 5px #760E25, 0 0 10px #760E25;
    }

    .pulsing-core {
        width: 60px;
        height: 60px;
        margin: 0 auto 15px auto;
        border-radius: 50%;
        background-color: #760E25;
        box-shadow:
            0 0 10px #760E25,
            0 0 20px #760E25,
            0 0 30px #760E25,
            0 0 40px #760E25;
        animation: pulse 1.5s infinite ease-in-out;
        position: relative;
    }
    /* Optional inner rings for more detail */
    .pulsing-core::before,
    .pulsing-core::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        border: 2px solid #760E25;
    }
    .pulsing-core::before {
        width: 80px;
        height: 80px;
        animation: pulse-ring 1.5s infinite ease-in-out .2s;
    }
    .pulsing-core::after {
        width: 100px;
        height: 100px;
        animation: pulse-ring 1.5s infinite ease-in-out .4s;
    }


    @keyframes pulse {
        0%, 100% {
            transform: scale(0.9);
            opacity: 0.7;
        }
        50% {
            transform: scale(1.1);
            opacity: 1;
        }
    }
    @keyframes pulse-ring {
        0%, 100% {
            transform: translate(-50%, -50%) scale(0.8);
            opacity: 0.3;
        }
        50% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.7;
        }
    }

</style>
<!-- Example for Orbitron font from Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">