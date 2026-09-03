<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Confirm Password | Lokapel School Library
    </title>


    {{-- Bootstrap CSS --}}
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
                    #0B1F3A,
                    #123B6D,
                    #2563EB
                );

            font-family:

                Arial,
                sans-serif;

        }


        .password-container {

            width: 100%;

            max-width: 450px;

            padding: 20px;

        }


        .password-card {

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


        .password-logo {

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
                    #2563EB,
                    #3B82F6
                );

        }


        .password-card h1 {

            margin: 0;

            text-align: center;

            font-size: 25px;

            font-weight: 700;

            color: #253858;

        }


        .password-card p {

            margin:

                10px
                0
                30px;

            text-align: center;

            color: #64748B;

        }


        .form-label {

            font-weight: 600;

            color: #475569;

        }


        .input-group {

            position: relative;

        }


        .form-control {

            height: 52px;

            border-radius: 12px;

            border:

                1px solid
                #E2E8F0;

        }


        .form-control:focus {

            border-color: #2563EB;

            box-shadow:

                0 0 0 0.2rem
                rgba(
                    37,
                    99,
                    235,
                    0.12
                );

        }


        .input-group-text {

            background: #F8FAFC;

            border:

                1px solid
                #E2E8F0;

            color: #2563EB;

        }


        .password-toggle {

            border:

                1px solid
                #E2E8F0;

            background: #F8FAFC;

            color: #2563EB;

            cursor: pointer;

        }


        .confirm-button {

            height: 52px;

            width: 100%;

            border: none;

            border-radius: 12px;

            font-weight: 600;

            color: white;

            background:

                linear-gradient(
                    135deg,
                    #2563EB,
                    #3B82F6
                );

            transition:

                transform
                0.2s ease;

        }


        .confirm-button:hover {

            color: white;

            transform:

                translateY(-2px);

        }


        .back-button {

            display: block;

            margin-top: 20px;

            text-align: center;

            text-decoration: none;

            color: #64748B;

            font-weight: 500;

        }


        .back-button:hover {

            color: #2563EB;

        }


        .security-note {

            margin-top: 25px;

            text-align: center;

            color: #94A3B8;

            font-size: 13px;

        }

    </style>

</head>


<body>


<div class="password-container">


    <div class="password-card">


        {{-- LOCK ICON --}}

        <div class="password-logo">

            <i class="bi bi-shield-lock-fill"></i>

        </div>


        {{-- TITLE --}}

        <h1>

            Confirm Your Password

        </h1>


        {{-- DESCRIPTION --}}

        <p>

            For security, please enter your password before continuing.

        </p>


        {{-- ERROR MESSAGE --}}

        @if($errors->any())

            <div
                class="alert alert-danger"
            >

                {{ $errors->first() }}

            </div>

        @endif


        {{-- PASSWORD FORM --}}

        <form
            method="POST"
            action="{{ route('password.confirm.submit') }}"
        >


            @csrf


            {{-- PASSWORD --}}

            <div class="mb-4">


                <label
                    for="password"
                    class="form-label"
                >

                    Password

                </label>


                <div class="input-group">


                    <span
                        class="input-group-text"
                    >

                        <i
                            class="bi bi-lock-fill"
                        ></i>

                    </span>


                    <input

                        type="password"

                        id="password"

                        name="password"

                        class="form-control"

                        placeholder="Enter your password"

                        required

                        autofocus

                    >


                    {{-- SHOW PASSWORD BUTTON --}}

                    <button

                        type="button"

                        class="
                            input-group-text
                            password-toggle
                        "

                        id="togglePassword"

                    >

                        <i
                            class="bi bi-eye"
                            id="toggleIcon"
                        ></i>

                    </button>


                </div>


                @error('password')

                    <div
                        class="
                            text-danger
                            mt-2
                            small
                        "
                    >

                        {{ $message }}

                    </div>

                @enderror


            </div>


            {{-- CONFIRM BUTTON --}}

            <button

                type="submit"

                class="confirm-button"

            >

                <i
                    class="bi bi-shield-check"
                ></i>

                Confirm Password

            </button>


        </form>


        {{-- BACK TO DASHBOARD --}}

        <a
            href="{{ route('dashboard') }}"
            class="back-button"
        >

            <i
                class="bi bi-arrow-left"
            ></i>

            Back to Dashboard

        </a>


        <div
            class="security-note"
        >

            <i
                class="bi bi-shield-check"
            ></i>

            Secure Library Management System

        </div>


    </div>


</div>


<script>

    const passwordInput =
        document.getElementById(
            'password'
        );


    const togglePassword =
        document.getElementById(
            'togglePassword'
        );


    const toggleIcon =
        document.getElementById(
            'toggleIcon'
        );


    togglePassword.addEventListener(
        'click',
        function () {


            if (
                passwordInput.type ===
                'password'
            ) {

                passwordInput.type =
                    'text';


                toggleIcon.classList.remove(
                    'bi-eye'
                );


                toggleIcon.classList.add(
                    'bi-eye-slash'
                );

            }

            else {

                passwordInput.type =
                    'password';


                toggleIcon.classList.remove(
                    'bi-eye-slash'
                );


                toggleIcon.classList.add(
                    'bi-eye'
                );

            }


        }
    );

</script>


</body>

</html>