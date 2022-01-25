<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Devute Register</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('theme/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/vendors/base/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('theme/images/logo.png') }}" />
</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <img src="{{ asset('theme/images/logo1.svg') }}" alt="logo">
                        </div>
                        <h4>New here?</h4>
                        <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                        <form class="pt-3" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Full Name" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
                                @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <select class="form-control form-control-lg @error('question') is-invalid @enderror" id="question" name="question" required autocomplete="question">
                                    <option value="">Select security question</option>
                                    <option value="What was your childhood nickname?" {{ old('question') == "What was your childhood nickname?" ? 'selected' : ''}}>What was your childhood nickname?</option>
                                    <option value="In what city did you meet your spouse/significant other?" {{ old('question') == "In what city did you meet your spouse/significant other?" ? 'selected' : ''}}>In what city did you meet your spouse/significant other?</option>
                                    <option value="What is the name of your favorite childhood friend?" {{ old('question') == "What is the name of your favorite childhood friend?" ? 'selected' : ''}}>What is the name of your favorite childhood friend?</option>
                                    <option value="In what city or town was your first job?" {{ old('question') == "In what city or town was your first job?" ? 'selected' : ''}}>In what city or town was your first job?</option>
                                    <option value="What is your oldest cousin's first and last name?" {{ old('question') == "What is your oldest cousin's first and last name?" ? 'selected' : ''}}>What is your oldest cousin's first and last name?</option>
                                </select>
                                @error('question')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="answer" type="text" class="form-control form-control-lg @error('answer') is-invalid @enderror" name="answer" value="{{ old('answer') }}" placeholder="Answer" required autocomplete="answer" autofocus>
                                @error('answer')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                                @error('password')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password-confirm" type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="text-center mt-4 font-weight-light">
                                Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="{{ asset('theme/vendors/base/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="{{ asset('theme/js/off-canvas.js') }}"></script>
<script src="{{ asset('theme/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('theme/js/template.js') }}"></script>
<script src="{{ asset('theme/js/todolist.js') }}"></script>
<!-- endinject -->
</body>

</html>
