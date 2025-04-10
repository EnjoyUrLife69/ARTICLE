<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Create Your Account</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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
            --card-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            --input-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            --border-color: #e0e0e0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #F0F0F0;
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

            .card-image .testimonial {
                background-color: rgba(255, 255, 255, 0.1);
                padding: 1.5rem;
                border-radius: 10px;
                margin-top: auto;
                border-left: 3px solid white;
            }

            .card-image .testimonial p {
                font-style: italic;
                margin-bottom: 0.5rem;
            }

            .card-image .testimonial .author {
                font-weight: 600;
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
            margin-bottom: 2rem;
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

        .form-hint {
            display: block;
            font-size: 0.8rem;
            color: var(--light-text);
            margin-top: 0.5rem;
        }

        .form-check {
            display: flex;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            margin-right: 0.75rem;
            margin-top: 0.25rem;
            width: 18px;
            height: 18px;
            cursor: pointer;
            border: 1px solid var(--border-color);
        }

        .form-check-label {
            font-size: 0.95rem;
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

        .form-section {
            background-color: #f9f9f9;
            padding: 1.75rem;
            border-radius: 10px;
            margin-bottom: 1.75rem;
            border-left: 4px solid #000;
        }

        .form-section h3 {
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 1.25rem;
            font-weight: 600;
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

        .textarea-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Custom black and white styles */
        .logo {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 1rem;
            display: inline-block;
            position: relative;
        }

        .logo::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 30px;
            height: 3px;
            background-color: #000;
        }

        /* Progress indicator */
        .progress-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }

        .progress-indicator::before {
            content: "";
            position: absolute;
            top: 15px;
            left: 20px;
            right: 20px;
            height: 1px;
            background-color: var(--border-color);
            z-index: 1;
        }

        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: white;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            position: relative;
            z-index: 2;
        }

        .step.active {
            background-color: black;
            color: white;
            border-color: black;
        }

        .step-label {
            position: absolute;
            top: 35px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.75rem;
            font-weight: 500;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-image">
                <div class="logo">LOGO</div>
                <h2>Join Our Platform</h2>
                <p>Create your account today and become part of our growing community. Whether you're here to explore content or share your own writing, we're excited to have you with us.</p>
                
                <div class="testimonial">
                    <p>"This platform has given me a voice and connected me with an incredible audience. The black and white aesthetic perfectly complements the content focus."</p>
                    <div class="author">— Alex Thompson, Content Creator</div>
                </div>
            </div>
            
            <div class="card-content">
                <div class="app-brand">
                    <h2>CREATE ACCOUNT</h2>
                    <p>Fill in your details to get started</p>
                </div>

                <div class="progress-indicator">
                    <div class="step active">1<span class="step-label">Account</span></div>
                    <div class="step">2<span class="step-label">Profile</span></div>
                    <div class="step">3<span class="step-label">Complete</span></div>
                </div>

                <form id="formAuthentication" method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Username</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your username">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div class="password-toggle">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Create a password">
                            <i class="toggle-icon fas fa-eye-slash" id="togglePassword"></i>
                        </div>
                        <span class="form-hint">Password must be at least 8 characters long, contain uppercase, lowercase letters and numbers.</span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password-confirm">Confirm Password</label>
                        <div class="password-toggle">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password">
                            <i class="toggle-icon fas fa-eye-slash" id="toggleConfirmPassword"></i>
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" name="terms" id="terms" required>
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#" class="link">terms and conditions</a> and <a href="#" class="link">privacy policy</a>
                        </label>
                        @error('terms')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="wants_to_be_writer" id="wants_to_be_writer">
                        <label class="form-check-label" for="wants_to_be_writer">
                            I want to contribute as a writer
                        </label>
                    </div><br>

                    <div id="writer-form" class="form-section fade-in" style="display: none;">
                        <h3>WRITER PROFILE</h3>
                        
                        <div class="form-group">
                            <label for="bio" class="form-label">About You</label>
                            <textarea id="bio" name="bio" class="form-control textarea-control" placeholder="Tell us a little about yourself and your writing experience"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="previous_work" class="form-label">Previous Writing Experience</label>
                            <input type="text" id="previous_work" name="previous_work" class="form-control" placeholder="Provide a link to your previous work (optional)">
                        </div>

                        <div class="form-group">
                            <label for="motivation" class="form-label">Why do you want to be a writer?</label>
                            <textarea id="motivation" name="motivation" class="form-control textarea-control" placeholder="Let us know why you're interested in writing with us"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">CREATE ACCOUNT</button>
                    </div>
                </form>

                <div class="divider"><span>Or sign up with</span></div>

                <div class="social-login">
                    <button type="button" class="social-btn google">
                        <i class="fab fa-google"></i>
                    </button>
                    <button type="button" class="social-btn facebook">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button type="button" class="social-btn twitter">
                        <i class="fab fa-twitter"></i>
                    </button>
                </div>

                <p class="text-center">
                    Already have an account?
                    <a href="{{ route('login') }}" class="link">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('password-confirm');
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            
            // Toggle icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Show/hide writer form with animation
        document.getElementById('wants_to_be_writer').addEventListener('change', function() {
            const writerForm = document.getElementById('writer-form');
            if (this.checked) {
                writerForm.style.display = 'block';
            } else {
                writerForm.style.display = 'none';
            }
        });
    </script>
</body>
</html>