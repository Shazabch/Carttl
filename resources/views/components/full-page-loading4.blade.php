<!-- resources/views/components/full-page-loading.blade.php -->
<div
    wire:loading.delay
    class="futuristic-loader-scan position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
    style="z-index: 9999;">
    <div class="loader-content text-center">
        <div class="scan-container">
            <div class="scan-path"></div>
            <div class="scan-line"></div>
        </div>
        <p class="mt-4 fw-bold">PROCESSING DATA...</p>
    </div>
</div>

<style>
    .futuristic-loader-scan {
        background-color: rgba(0, 20, 10, 0.9); /* Dark Teal/Green */
    }

    .futuristic-loader-scan .loader-content p {
        color: #00ffaa; /* Neon Green */
        text-transform: uppercase;
        font-family: 'Share Tech Mono', monospace; /* Monospace tech font */
        letter-spacing: 1px;
        text-shadow: 0 0 6px #00ffaa;
    }

    .scan-container {
        width: 100px;
        height: 100px;
        position: relative;
        margin: 0 auto;
        overflow: hidden; /* Important for scanline effect */
    }

    .scan-path {
        width: 100%;
        height: 100%;
        border: 2px solid rgba(0, 255, 170, 0.3); /* Faint path */
        /* You can make this a more complex SVG path for a circuit board look */
        /* For simplicity, a square or circle */
        border-radius: 10px; /* Or 50% for a circle */
        box-sizing: border-box;
    }

    .scan-line {
        position: absolute;
        top: 0;
        left: -100%; /* Start off-screen */
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, transparent, #00ffaa, transparent);
        box-shadow: 0 0 10px #00ffaa;
        animation: scan 2s linear infinite;
        border-radius: 2px;
    }

    /* Optional: a pulsing dot on the path */
    .scan-path::before {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        background-color: #00ffaa;
        border-radius: 50%;
        box-shadow: 0 0 8px #00ffaa;
        animation: path-pulse 2s infinite;
        /* Position this dot along your path if using complex SVG */
        top: -4px; left: 50%; transform: translateX(-50%); /* Example for top-center */
    }


    @keyframes scan {
        0% {
            left: -100%;
            opacity: 0.5;
        }
        50% {
            opacity: 1;
        }
        100% {
            left: 100%;
            opacity: 0.5;
        }
    }

    @keyframes path-pulse {
        0%, 100% { opacity: 0.5; transform: translateX(-50%) scale(0.8); }
        50% { opacity: 1; transform: translateX(-50%) scale(1.1); }
    }

</style>
<link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&display=swap" rel="stylesheet">