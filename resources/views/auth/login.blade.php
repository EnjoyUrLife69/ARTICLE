<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login to Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #000000;
            --primary-hover: #333333;
            --secondary-color: #f5f5f5;
            --text-color: #000000;
            --light-text: #777777;
            --danger: #d32f2f;
            --success: #388e3c;
            --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            --input-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            --border-color: #e0e0e0;
            --background-color: #F0F0F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--background-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            padding: 2rem 1rem;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
        }

        .card {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            display: flex;
            flex-direction: column;
            border: 1px solid var(--border-color);
        }

        @media (min-width: 992px) {
            .card {
                flex-direction: row;
                max-height: 90vh;
            }
        }

        .card-image {
            display: none;
            background-color: #000000;
        }

        @media (min-width: 992px) {
            .card-image {
                display: block;
                flex: 1;
                background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.85)), url('/api/placeholder/640/480') center/cover;
                padding: 3rem;
                color: white;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .card-image h2 {
                font-size: 2.5rem;
                font-weight: 600;
                margin-bottom: 1rem;
            }

            .card-image p {
                font-size: 1.1rem;
                margin-bottom: 2rem;
                line-height: 1.6;
                color: #e0e0e0;
            }

            .card-image .features {
                margin-top: 2rem;
            }

            .card-image .feature-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 1.5rem;
            }

            .card-image .feature-icon {
                margin-right: 1rem;
                background-color: rgba(255, 255, 255, 0.1);
                height: 36px;
                width: 36px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .card-image .feature-text h4 {
                font-size: 1.1rem;
                margin-bottom: 0.25rem;
            }

            .card-image .feature-text p {
                font-size: 0.9rem;
                margin-bottom: 0;
                opacity: 0.8;
            }
        }

        .card-content {
            flex: 1;
            padding: 2.5rem;
            max-height: 90vh;
            overflow-y: auto;
        }

        .app-brand {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .app-brand h2 {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }

        .app-brand p {
            color: var(--light-text);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            box-shadow: var(--input-shadow);
            background-color: #fafafa;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .password-toggle {
            position: relative;
        }

        .password-toggle .toggle-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--light-text);
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            margin-right: 0.75rem;
            width: 18px;
            height: 18px;
            cursor: pointer;
            border: 1px solid var(--border-color);
        }

        .form-check-label {
            font-size: 0.95rem;
        }

        .forgot-password {
            text-align: right;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: var(--light-text);
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }

        .divider span {
            padding: 0 1rem;
            font-size: 0.9rem;
        }

        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .social-btn:hover {
            background-color: #f8f9fa;
            border-color: #000;
        }

        .social-btn i {
            font-size: 1.2rem;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .link:hover {
            text-decoration: underline;
        }

        .is-invalid {
            border-color: var(--danger) !important;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom black and white styles */
        .logo {
            margin-left: 1rem; 
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 1rem;
            margin-top: 1rem;
            display: inline-block;
            position: relative;
        }


        .input-group {
            position: relative;
        }

        .input-group-text {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--light-text);
            cursor: pointer;
            z-index: 10;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-image">
                <div class="logo-container" style="display: flex; align-items: center; margin-top: -2rem; margin-bottom: 2rem;">
                    <img src="{{ asset('assets/img/open-book.png') }}" style="width: 8%; margin-right: 10px;">
                    <div class="logo">ARTICLES</div>
                </div>
                <h2>Welcome Back</h2>
                <p>Sign in to access your dashboard and continue your journey with us. We've missed you!</p>

                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Secure Access</h4>
                            <p>Your data is always protected with enterprise-grade security</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Powerful Dashboard</h4>
                            <p>Access all your tools and data in one convenient place</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <div class="feature-text">
                            <h4>Real-time Updates</h4>
                            <p>Get instant notifications and stay in the loop</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-content">
                <div class="app-brand">
                    <h2>SIGN IN</h2>
                    <p>Enter your credentials to access your account</p>
                </div>

                <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email or Username</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter your email or username">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0" for="password">Password</label>
                            <a href="{{ route('password.request') }}" class="link" style="font-size: 0.9rem;">Forgot
                                Password?</a>
                        </div>
                        <div class="input-group">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password" placeholder="Enter your password">
                            <span class="input-group-text cursor-pointer"><i class="fas fa-eye-slash"
                                    id="togglePassword"></i></span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">SIGN IN</button>
                    </div>
                </form>

                {{-- <div class="divider"><span>Or sign in with</span></div>

                <div class="social-login">
                    <!-- Tombol Login Google -->
                    <a href="{{ url('login/google') }}" class="social-btn google">
                        <i class="fab fa-google"></i>
                    </a>
                    <button type="button" class="social-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button type="button" class="social-btn twitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                </div> --}}

                <p class="text-center mt-4">
                    New on our platform?
                    <a href="{{ route('register') }}" class="link">Create an account</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);

                    // Toggle icon
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>

</html>
