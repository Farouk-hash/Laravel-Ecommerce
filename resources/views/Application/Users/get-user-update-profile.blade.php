<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Edit Profile">
    <meta name="csrf-token" content="{{csrf_token()}}">
    
    <!-- title -->
    <title>Edit Profile - {{$title ?? 'Update Your Information'}}</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{asset('assets/css/all.min.css')}}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.css')}}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.css')}}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <!-- mean menu css -->
    <link rel="stylesheet" href="{{asset('assets/css/meanmenu.min.css')}}">
    <!-- main style -->
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{asset('assets/css/responsive.css')}}">
    
    <style>
        :root {
            --primary-color: #051922;
            --secondary-color: #0a2831;
            --accent-color: #28a745;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
            --text-muted: #6c757d;
            --success-bg: #d4edda;
            --success-text: #155724;
            --warning-bg: #fff3cd;
            --warning-text: #856404;
            --info-bg: #cce7ff;
            --info-text: #004085;
            --error-bg: #f8d7da;
            --error-text: #721c24;
        }
        
        .edit-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            padding: 40px 0;
            color: white;
        }
        
        .edit-header h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            color: #fff;
            margin-bottom: 10px;
        }
        
        .breadcrumb-nav {
            color: rgba(255,255,255,0.8);
            font-size: 14px;
        }
        
        .breadcrumb-nav a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
        }
        
        .breadcrumb-nav a:hover {
            color: #fff;
        }
        
        .edit-form-card {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 40px;
            margin-top: -30px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(5,25,34,0.1);
            position: relative;
            z-index: 2;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
        }
        
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.15);
            outline: none;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        
        .form-control.is-valid {
            border-color: var(--accent-color);
        }
        
        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }
        
        .avatar-upload-section {
            text-align: center;
            margin-bottom: 35px;
            padding: 30px;
            background: linear-gradient(135deg, rgba(5,25,34,0.03) 0%, rgba(5,25,34,0.06) 100%);
            border-radius: 15px;
        }
        
        .current-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #fff;
            object-fit: cover;
            box-shadow: 0 8px 25px rgba(5,25,34,0.15);
            margin-bottom: 20px;
        }
        
        .avatar-upload-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .avatar-upload-btn {
            background: var(--accent-color);
            border: none;
            color: #fff;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .avatar-upload-btn:hover {
            background: #218838;
            transform: translateY(-1px);
        }
        
        .file-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        
        .file-name {
            margin-top: 10px;
            font-size: 12px;
            color: var(--text-muted);
        }
        
        .btn-section {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
        }
        
        .btn-save {
            background: linear-gradient(135deg, var(--accent-color) 0%, #218838 100%);
            border: none;
            color: #fff;
            padding: 12px 35px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .btn-save:hover {
            background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(40,167,69,0.3);
            color: #fff;
        }
        
        .btn-cancel {
            background: transparent;
            border: 2px solid var(--text-muted);
            color: var(--text-muted);
            padding: 10px 35px;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 14px;
        }
        
        .btn-cancel:hover {
            background: var(--text-muted);
            color: #fff;
            transform: translateY(-1px);
            text-decoration: none;
        }
        
        .form-row {
            margin-left: -10px;
            margin-right: -10px;
        }
        
        .form-row .form-group {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .alert {
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        
        .alert-success {
            background: var(--success-bg);
            color: var(--success-text);
        }
        
        .alert-danger {
            background: var(--error-bg);
            color: var(--error-text);
        }
        
        .required {
            color: #dc3545;
        }
        
        /* Loading state */
        .btn-save.loading {
            position: relative;
            color: transparent;
        }
        
        .btn-save.loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .edit-form-card {
                padding: 25px;
                margin-top: -20px;
            }
            
            .btn-section {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-save,
            .btn-cancel {
                width: 100%;
                max-width: 250px;
            }
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
</head>
<body>
    <!-- Edit Header -->
    <div class="edit-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2><i class="fas fa-user-edit mr-3"></i>Edit Profile</h2>
                    <div class="breadcrumb-nav">
                        <a href="{{route('user.profile')}}">My Account</a> / Edit Profile
                    </div>
                </div>
            </div>
        </div>
    </div>


     @php
        $imageUrl = $user_information->file_object_key
            ? Illuminate\Support\Facades\Storage::url($user_information->file_object_key)
            : "https://ui-avatars.com/api/?name={$user_information->name}&background=051922&color=ffffff&size=200&rounded=true";
    @endphp

    <!-- Edit Form Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="edit-form-card">
                    
                    <form 
                    action="{{route('user.update-profile', Auth::id())}}" 
                    method="POST" 
                    enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Avatar Upload Section -->
                        <div class="avatar-upload-section">
                            <img 
                            src="{{$imageUrl}}" 
                            alt="Current Avatar" 
                            class="current-avatar" 
                            id="avatarPreview">
                            
                            <div class="avatar-upload-wrapper">
                                <button type="button" class="avatar-upload-btn" onclick="document.getElementById('avatarInput').click();">
                                    <i class="fas fa-camera mr-2"></i>Change Avatar
                                </button>
                                <input type="file" name="avatar" class="file-input" accept="image/*" id="avatarInput" style="display: none;">
                            </div>
                            <div class="file-name" id="fileName">No file selected</div>
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Form Fields -->
                        <div class="form-row">
                            <!-- Full Name -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user mr-2"></i>Full Name <span class="required">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{old('name', $user_information->name ?? '')}}" 
                                           placeholder="Enter your full name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Email -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope mr-2"></i>Email Address <span class="required">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{old('email', $user_information->email ?? '')}}" 
                                           placeholder="Enter your email address"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Phone Number -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone mr-2"></i>Phone Number
                                    </label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{old('phone', $user_information->phone ?? '')}}" 
                                           placeholder="Enter your phone number">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="btn-section">
                            <button type="submit" class="btn-save" id="saveBtn">
                                <i class="fas fa-save mr-2"></i>Save Changes
                            </button>
                            <a href="{{route('user.profile')}}" class="btn-cancel">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Avatar upload preview
            $('#avatarInput').change(function() {
                const file = this.files[0];
                const $fileName = $('#fileName');
                const $preview = $('#avatarPreview');
                
                if (file) {
                    // Update file name
                    $fileName.text(file.name);
                    
                    // Preview image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $preview.attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $fileName.text('No file selected');
                    // Reset to original avatar - FIXED THE TYPO HERE
                    $preview.attr('src', `https://ui-avatars.com/api/?name={{$user_information->name ?? 'User'}}&background=051922&color=ffffff&size=200&rounded=true`);
                }
            });
            
            // Form submission with loading state
            $('#profileForm').submit(function() {
                const $saveBtn = $('#saveBtn');
                $saveBtn.addClass('loading');
                $saveBtn.prop('disabled', true);
            });
            
        });
    </script>
</body>
</html>