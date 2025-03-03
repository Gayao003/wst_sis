<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SIS Admin</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            .input-group-text {
                background-color: #f8f9fa;
                border-right: none;
            }
            .input-group .form-control {
                border-left: none;
            }
            .phone-label {
                margin-left: 40px;
            }
        </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('register') }}">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Enter your first name" required />
                                                        <label for="inputFirstName">First name</label>
                                                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Enter your last name" required />
                                                        <label for="inputLastName">Last name</label>
                                                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required />
                                                <label for="inputEmail">Email address</label>
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>
                                            <div class="form-floating mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text">+63</span>
                                                    <input class="form-control" id="inputPhone" type="tel" name="phone" 
                                                        value="{{ old('phone') }}" 
                                                        placeholder="Phone Number (Optional)" 
                                                        pattern="[0-9]{3} [0-9]{4} [0-9]{3}"
                                                        maxlength="13" />
                                                </div>
                                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputBirthDate" type="date" name="birth_date" value="{{ old('birth_date') }}" required />
                                                <label for="inputBirthDate">Birth Date</label>
                                                <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputStudentId" type="text" name="student_id" value="{{ old('student_id') }}" placeholder="Enter your student ID" required />
                                                <label for="inputStudentId">Student ID</label>
                                                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputCourse" type="text" name="course" value="{{ old('course') }}" placeholder="Enter your course" required />
                                                <label for="inputCourse">Course</label>
                                                <x-input-error :messages="$errors->get('course')" class="mt-2" />
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputYearLevel" type="number" name="year_level" value="{{ old('year_level') }}" placeholder="Enter your year level" min="1" max="5" required />
                                                <label for="inputYearLevel">Year Level</label>
                                                <x-input-error :messages="$errors->get('year_level')" class="mt-2" />
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputSection" type="text" name="section" value="{{ old('section') }}" placeholder="Enter your section" required />
                                                <label for="inputSection">Section</label>
                                                <x-input-error :messages="$errors->get('section')" class="mt-2" />
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Create a password" required />
                                                        <label for="inputPassword">Password</label>
                                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" type="password" name="password_confirmation" placeholder="Confirm password" required />
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="{{ route('login') }}">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script>
        document.getElementById('inputPhone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 10) value = value.slice(0, 10);
            
            if (value.length >= 3) {
                value = value.slice(0, 3) + ' ' + value.slice(3);
            }
            if (value.length >= 8) {
                value = value.slice(0, 8) + ' ' + value.slice(8);
            }
            
            e.target.value = value;
        });
        </script>
    </body>
</html>
