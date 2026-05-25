@extends('layouts.customer')

@section('content')
<div class="profile-container">
    <style>
        /* Premium Typography & Global Tweaks */
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
        
        .profile-container {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        /* Header Styling */
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f4f7f6 100%);
            padding: 2.5rem 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
            border: 1px solid rgba(255,255,255,0.8);
        }
        
        .page-title {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* Card Styling */
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            border-radius: 24px;
            overflow: hidden;
            position: relative;
        }
        
        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #3498db, #8e44ad);
        }

        /* Form Inputs */
        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .custom-input {
            border: 2px solid #e2e8f0;
            background: #f8fafc;
            padding: 0.85rem 1.2rem;
            border-radius: 12px;
            color: #2d3748;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .custom-input:focus {
            border-color: rgba(52, 152, 219, 0.5);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            outline: none;
        }

        .custom-input:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            border-color: #e2e8f0;
        }

        /* Avatar Upload */
        .avatar-upload-container {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .avatar-preview {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.2);
            object-fit: cover;
            background: linear-gradient(135deg, #3498db, #8e44ad);
        }

        .avatar-placeholder {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.2);
            background: linear-gradient(135deg, #3498db, #8e44ad);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            font-weight: bold;
        }

        .upload-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: white;
            color: #3498db;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .upload-btn:hover {
            transform: scale(1.1);
            color: #2980b9;
        }

        /* Submit Button */
        .btn-save {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
            width: 100%;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(52, 152, 219, 0.4);
            color: white;
            background: linear-gradient(135deg, #2980b9, #2471a3);
        }
    </style>

    <div class="page-header">
        <h2 class="page-title display-6 mb-1">My Profile</h2>
        <p class="text-secondary mb-0 fs-6">Manage your personal information and account settings.</p>
    </div>

    <div class="profile-card">
        <div class="card-body p-4 p-md-5">
            <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="text-center mb-5">
                    <div class="avatar-upload-container">
                        @if($user->profile_image)
                            <img src="{{ asset('storage/'.$user->profile_image) }}" class="avatar-preview">
                        @else
                            <div class="avatar-placeholder">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <label class="upload-btn" title="Upload New Image">
                            <i class="bi bi-camera-fill"></i>
                            <input type="file" name="profile_image" class="d-none" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>
                    @error('profile_image') <div class="text-danger small mt-2 fw-medium"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div> @enderror
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-person me-2 text-primary"></i>Full Name</label>
                            <input type="text" name="name" class="form-control custom-input" value="{{ old('name', $user->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-envelope me-2 text-primary"></i>Email Address</label>
                            <input type="email" class="form-control custom-input" value="{{ $user->email }}" disabled>
                            <small class="text-muted mt-2 d-block"><i class="bi bi-info-circle me-1"></i>Email address cannot be changed.</small>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-telephone me-2 text-primary"></i>Phone Number</label>
                            <input type="text" name="phone" class="form-control custom-input" value="{{ old('phone', $user->phone) }}" placeholder="+1 234 567 8900">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><i class="bi bi-geo-alt me-2 text-primary"></i>Address</label>
                            <input type="text" name="address" class="form-control custom-input" value="{{ old('address', $user->address) }}" placeholder="City, Country">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-4">
                    <div class="col-md-8 col-lg-6">
                        <button type="submit" class="btn-save">
                            <i class="bi bi-check2-circle me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                // If there's an existing image, update its src
                let img = document.querySelector('.avatar-preview');
                if(img) {
                    img.src = e.target.result;
                } else {
                    // If there's a placeholder, replace it with an image
                    let placeholder = document.querySelector('.avatar-placeholder');
                    if(placeholder) {
                        let newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.className = 'avatar-preview';
                        placeholder.parentNode.insertBefore(newImg, placeholder);
                        placeholder.style.display = 'none';
                    }
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
