<!-- resources/views/components/full-page-loading.blade.php -->
<div
    wire:loading.delay
    class="futuristic-loader-rings position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
    style="z-index: 9999;">
    <div class="loader-content text-center">
        <div class="holo-spinner">
            <div></div> <!-- Ring 1 -->
            <div></div> <!-- Ring 2 -->
            <div></div> <!-- Ring 3 -->
        </div>
        <p class="mt-4 fw-bold">PROCESSING DATA...</p>
    </div>
</div>

<style>
    .futuristic-loader-rings {
        background-color: rgba(10, 0, 30, 0.9); /* Dark purple, semi-transparent */
    }

    .futuristic-loader-rings .loader-content p {
        color: #760E25; /* Purple */
        text-transform: uppercase;
        font-family: 'Audiowide', cursive; /* Another futuristic font example */
        letter-spacing: 1.5px;
        text-shadow: 0 0 8px #760E25;
    }

    .holo-spinner {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }

    .holo-spinner div {
        box-sizing: border-box;
        display: block;
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 4px solid transparent; /* Base border */
        animation: holo-spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    }

    /* Ring 1: Main visible ring with gradient */
    .holo-spinner div:nth-child(1) {
        border-top-color: #c88aff; /* Light Purple */
        border-left-color: #c88aff;
        box-shadow: 0 0 15px #c88aff, 0 0 5px #c88aff inset;
        animation-delay: -0.45s;
    }

    /* Ring 2: Secondary, slightly offset */
    .holo-spinner div:nth-child(2) {
        width: 85%;
        height: 85%;
        top: 7.5%;
        left: 7.5%;
        border-right-color: #760E25; /* Deep Purple */
        border-bottom-color: #760E25;
        box-shadow: 0 0 10px #760E25;
        animation-delay: -0.3s;
        opacity: 0.8;
    }

    /* Ring 3: Tertiary, fainter, faster or different effect */
    .holo-spinner div:nth-child(3) {
        width: 70%;
        height: 70%;
        top: 15%;
        left: 15%;
        border-left-color: #e0bfff; /* Very Light Purple */
        border-bottom-color: #e0bfff;
        animation: holo-spin-reverse 1s linear infinite; /* Different animation or speed */
        box-shadow: 0 0 5px #e0bfff;
        opacity: 0.6;
    }

    @keyframes holo-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes holo-spin-reverse {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(-360deg); }
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">