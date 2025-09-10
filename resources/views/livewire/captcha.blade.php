<div>
    <style>
        /* Import Google font - Poppins & Noto */
        ::selection {
            color: #fff;
            background: var(--accent-hover-2);
        }

        .brixsar-cap-wraper {
            max-width: 100%;
            width: 100%;
        }

        .brixsar-cap-wraper .captcha-area {
            display: flex;
            height: 65px;
            margin: 1px;
            align-items: center;
            justify-content: space-between;
        }

        .captcha-area .captcha-img {
            height: 100%;
            width: 100%;
            user-select: none;
            background: #000;
            border-radius: 5px;
            position: relative;
        }

        .captcha-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 5px;
            opacity: 0.95;
        }

        .captcha-img .captcha {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 100%;
            color: #fff;
            font-size: 28px;
            text-align: center;
            letter-spacing: 2px;
            transform: translate(-50%, -50%);
            text-shadow: 0px 0px 2px #b1b1b1;
            font-family: 'Noto Serif', serif;
        }

        .brixsar-cap-wraper button {
            outline: none;
            border: none;
            color: #fff;
            cursor: pointer;
            /* background: var(--accent-hover-2); */
            border-radius: 5px;
            margin-left: 2px;
            transition: all 0.3s ease;
        }

        .brixsar-cap-wraper button:hover {
            /* background: #2fa5e9; */
        }

        .captcha-area .reload-btn {
            width: 50%;
            height: 100%;
            font-size: 25px;
        }

        .captcha-area .reload-btn i {
            transition: transform 0.3s ease;
        }

        .captcha-area .reload-btn:hover i {
            transform: rotate(15deg);
        }

        .brixsar-cap-wraper .input-area-brix {
            height: 60px;
            width: 100%;
            margin-top: 5px;
            position: relative;
            margin-bottom: 5px !important;
        }

        .input-area-brix input {
            width: 100%;
            height: 100%;
            outline: none;
            padding-left: 2px;
            font-size: 20px;
            border-radius: 5px;

            border: 1px solid #bfbfbf;
        }

        .input-area-brix input:is(:focus, :valid) {
            padding-left: 19px;
            border: 2px solid var(--accent-hover-2);
        }

        .input-area-brix input::placeholder {
            color: #bfbfbf;
        }

        .input-area-brix .check-btn {
            position: absolute;
            background-color: #000;
            right: 7px;
            top: 50%;
            font-size: 17px;
            height: 45px;
            padding: 0 20px;
            opacity: 0;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .input-area-brix input:valid+.check-btn {
            opacity: 1;
            pointer-events: auto;
        }

        .brixsar-cap-wraper .status-text {

            font-size: 18px;
            text-align: center;
            margin: 20px 0 -5px;
        }
    </style>
    <style>
        .tick-icon {
            width: 40px;
            height: 40px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .tick-circle {
            fill: none;
            stroke: #bd9731;
            stroke-width: 4;
            stroke-dasharray: 125;
            stroke-dashoffset: 125;
            animation: dash 0.5s ease-out forwards;
        }

        .tick-check {
            fill: none;
            stroke:#bd9731;
            stroke-width: 4;
            stroke-dasharray: 50;
            stroke-dashoffset: 50;
            animation: dash-check 0.3s ease-out 0.5s forwards;
        }

        @keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes dash-check {
            to {
                stroke-dashoffset: 0;
            }
        }
    </style>
    <div class="brixsar-cap-wraper" x-data="{ matched: @entangle('isMatched') }">

        <div class="captcha-area">
            <div class="captcha-img">
                <img src="{{asset('images/captcha-bg.png')}}" alt="Captcha Background">
                <span class="captcha">{{ $captcha }}</span>
            </div>
            <button type="button" wire:click="generateCaptcha" class="reload-btn th-btn">
                <i class="fas fa-redo-alt"></i>
            </button>
        </div>

        <input type="hidden" name="g-recaptcha-response" value="{{$isMatched}}">

        @if (!$isMatched)
        <div class="input-area-brix">
            <input type="text" placeholder="Enter captcha" wire:model="input" maxlength="6" required>
            <button type="button" class="check-btn" wire:click="checkCaptcha">Check</button>
        </div>
        @endif

        @if ($status === 'success')
        <div class="status-text" style="color: var(--primary-color); text-align:center;">
            <svg class="tick-icon" viewBox="0 0 52 52">
                <circle class="tick-circle" cx="26" cy="26" r="20" />
                <path class="tick-check" d="M14 27 l8 8 l16 -16" />
            </svg>
        </div>
        @elseif ($status === 'failed')
        <div class="status-text" style="color: red; text-align:center;">
            Captcha not matched. Please try again!
        </div>
        @endif

        @error('g-recaptcha-response')
        <small class="text-danger"><i class="fas fa-ban"></i> Please complete the reCAPTCHA to proceed</small>
        @enderror

    </div>

</div>