<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Library Management System | Login
    </title>


    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >


    <style>

        body {

            min-height: 100vh;

            margin: 0;

            display: flex;

            align-items: center;

            justify-content: center;

            background:

                linear-gradient(
                    135deg,
                    #0f3d6e,
                    #1558a6,
                    #2575d7
                );

            font-family:

                Arial,
                sans-serif;

        }


        .login-container {

            width: 100%;

            max-width: 450px;

            padding: 20px;

        }


        .login-card {

            background: white;

            border-radius: 24px;

            padding: 40px;

            box-shadow:

                0 25px 60px
                rgba(
                    0,
                    0,
                    0,
                    0.25
                );

        }


        .login-logo {

            width: 80px;

            height: 80px;

            margin:

                0 auto
                20px;

            display: flex;

            align-items: center;

            justify-content: center;

            border-radius: 22px;

            font-size: 35px;

            color: white;

            background:

                linear-gradient(
                    135deg,
                    #1769e0,
                    #2575d7
                );

        }


        .login-card h1 {

            margin: 0;

            text-align: center;

            font-size: 25px;

            font-weight: 700;

            color: #253858;

        }


        .login-card p {

            margin:

                8px
                0
                30px;

            text-align: center;

            color: #8a94a6;

        }


        .form-label {

            font-weight: 600;

            color: #475569;

        }


        .form-control {

            height: 52px;

            border-radius: 12px;

            border:

                1px solid
                #e2e8f0;

        }


        .form-control:focus {

            border-color: #2575d7;

            box-shadow:

                0 0 0 0.2rem
                rgba(
                    37,
                    117,
                    215,
                    0.12
                );

        }


        .input-group-text {

            background: #f8fafc;

            border:

                1px solid
                #e2e8f0;

            border-radius:

                12px
                0
                0
                12px;

            color: #2575d7;

        }


        /*
        |--------------------------------------------------------------------------
        | PASSWORD TOGGLE BUTTON
        |--------------------------------------------------------------------------
        */

        .password-toggle {

            height: 52px;

            width: 55px;

            border:

                1px solid
                #e2e8f0;

            border-left: none;

            border-radius:

                0
                12px
                12px
                0;

            background: #f8fafc;

            color: #64748b;

            cursor: pointer;

            transition:

                all
                0.2s
                ease;

        }


        .password-toggle:hover {

            background: #eef4ff;

            color: #2575d7;

        }


        .password-toggle:focus {

            outline: none;

            box-shadow: none;

        }


        .login-button {

            height: 52px;

            width: 100%;

            border: none;

            border-radius: 12px;

            font-weight: 600;

            color: white;

            background:

                linear-gradient(
                    135deg,
                    #1769e0,
                    #2575d7
                );

            transition:

                transform
                0.2s ease;

        }


        .login-button:hover {

            color: white;

            transform:

                translateY(-2px);

        }


        .system-footer {

            margin-top: 25px;

            text-align: center;

            color: #94a3b8;

            font-size: 13px;

        }


        @media (max-width: 576px) {

            .login-container {

                padding: 15px;

            }


            .login-card {

                padding: 30px 25px;

            }

        }

    </style>

</head>


<body>


<div class="login-container">


    <div class="login-card">


        {{-- LOGO --}}

        <div class="login-logo">

            <i class="bi bi-book-half"></i>

        </div>


        {{-- TITLE --}}

        <h1>

            Library Management System

        </h1>


        <p>

            Please log in to access the library system.

        </p>


        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >

                <i
                    class="bi bi-check-circle-fill me-2"
                ></i>

                {{ session('success') }}


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        {{-- LOGIN ERROR MESSAGE --}}

        @if($errors->has('username'))

            <div
                class="alert alert-danger"
                role="alert"
            >

                <i
                    class="bi bi-exclamation-triangle-fill me-2"
                ></i>

                {{ $errors->first('username') }}

            </div>

        @endif


        {{-- LOGIN FORM --}}

        <form
            method="POST"
            action="{{ route('login.submit') }}"
        >


            @csrf


            {{-- USERNAME --}}

            <div class="mb-3">


                <label
                    class="form-label"
                    for="username"
                >

                    Username

                </label>


                <div class="input-group">


                    <span
                        class="input-group-text"
                    >

                        <i
                            class="bi bi-person-fill"
                        ></i>

                    </span>


                    <input

                        type="text"

                        id="username"

                        name="username"

                        class="
                            form-control
                            @error('username')
                                is-invalid
                            @enderror
                        "

                        value="{{ old('username') }}"

                        placeholder="Enter username"

                        required

                        autofocus

                        autocomplete="username"

                    >


                </div>


                @error('username')

                    <div
                        class="text-danger mt-2 small"
                    >

                        <i
                            class="bi bi-exclamation-circle-fill me-1"
                        ></i>

                        {{ $message }}

                    </div>

                @enderror


            </div>


            {{-- PASSWORD --}}

            <div class="mb-4">


                <label
                    class="form-label"
                    for="password"
                >

                    Password

                </label>


                <div class="input-group">


                    {{-- LOCK ICON --}}

                    <span
                        class="input-group-text"
                    >

                        <i
                            class="bi bi-lock-fill"
                        ></i>

                    </span>


                    {{-- PASSWORD INPUT --}}

                    <input

                        type="password"

                        id="password"

                        name="password"

                        class="
                            form-control
                            @error('password')
                                is-invalid
                            @enderror
                        "

                        placeholder="Enter password"

                        required

                        autocomplete="current-password"

                    >


                    {{-- SHOW / HIDE PASSWORD BUTTON --}}

                    <button

                        type="button"

                        class="password-toggle"

                        id="togglePassword"

                        aria-label="Show password"

                    >

                        <i
                            class="bi bi-eye"
                            id="togglePasswordIcon"
                        ></i>

                    </button>


                </div>


                @error('password')

                    <div
                        class="text-danger mt-2 small"
                    >

                        <i
                            class="bi bi-exclamation-circle-fill me-1"
                        ></i>

                        {{ $message }}

                    </div>

                @enderror


            </div>


            {{-- REMEMBER LOGIN --}}

            <div
                class="
                    form-check
                    mb-4
                "
            >


                <input

                    class="form-check-input"

                    type="checkbox"

                    name="remember"

                    id="remember"

                    value="1"

                >


                <label
                    class="form-check-label"
                    for="remember"
                >

                    Keep me logged in

                </label>


            </div>


            {{-- LOGIN BUTTON --}}

            <button
                type="submit"
                class="login-button"
            >

                <i
                    class="bi bi-box-arrow-in-right me-1"
                ></i>

                Login to Library

            </button>


        </form>


        {{-- SYSTEM FOOTER --}}

        <div class="system-footer">

            <i
                class="bi bi-shield-lock-fill me-1"
            ></i>

            Secure School Library Management System

        </div>


    </div>


</div>


{{-- BOOTSTRAP JAVASCRIPT --}}

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>


{{-- PASSWORD SHOW / HIDE SCRIPT --}}

<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {


            const passwordInput = document.getElementById(
                'password'
            );


            const togglePassword = document.getElementById(
                'togglePassword'
            );


            const togglePasswordIcon = document.getElementById(
                'togglePasswordIcon'
            );


            togglePassword.addEventListener(
                'click',
                function () {


                    if (
                        passwordInput.type === 'password'
                    ) {

                        passwordInput.type = 'text';


                        togglePasswordIcon.classList.remove(
                            'bi-eye'
                        );


                        togglePasswordIcon.classList.add(
                            'bi-eye-slash'
                        );


                        togglePassword.setAttribute(
                            'aria-label',
                            'Hide password'
                        );

                    }

                    else {

                        passwordInput.type = 'password';


                        togglePasswordIcon.classList.remove(
                            'bi-eye-slash'
                        );


                        togglePasswordIcon.classList.add(
                            'bi-eye'
                        );


                        togglePassword.setAttribute(
                            'aria-label',
                            'Show password'
                        );

                    }


                }
            );


        }
    );

</script>


</body>

</html>