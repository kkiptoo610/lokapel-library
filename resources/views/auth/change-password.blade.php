<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Change Password | Lokapel School Library
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

            max-width: 500px;

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

            cursor: pointer;

        }


        .change-button {

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


        .change-button:hover {

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

    </style>

</head>


<body>


<div class="password-container">


    <div class="password-card">


        <div class="password-logo">

            <i
                class="bi bi-key-fill"
            ></i>

        </div>


        <h1>

            Change Password

        </h1>


        <p>

            Enter your current password and choose a new secure password.

        </p>


        <form
            method="POST"
            action="{{ route('password.change.update') }}"
        >


            @csrf


            {{-- CURRENT PASSWORD --}}

            <div class="mb-3">


                <label
                    class="form-label"
                >

                    Current Password

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

                        id="current_password"

                        name="current_password"

                        class="
                            form-control
                            @error('current_password')
                                is-invalid
                            @enderror
                        "

                        placeholder="Enter current password"

                        required

                    >


                    <button

                        type="button"

                        class="
                            input-group-text
                            password-toggle
                        "

                        onclick="
                            togglePassword(
                                'current_password',
                                'currentPasswordIcon'
                            )
                        "

                    >

                        <i
                            class="bi bi-eye"
                            id="currentPasswordIcon"
                        ></i>

                    </button>


                </div>


                @error('current_password')

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


            {{-- NEW PASSWORD --}}

            <div class="mb-3">


                <label
                    class="form-label"
                >

                    New Password

                </label>


                <div class="input-group">


                    <span
                        class="input-group-text"
                    >

                        <i
                            class="bi bi-key-fill"
                        ></i>

                    </span>


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

                        placeholder="Enter new password"

                        required

                    >


                    <button

                        type="button"

                        class="
                            input-group-text
                            password-toggle
                        "

                        onclick="
                            togglePassword(
                                'password',
                                'newPasswordIcon'
                            )
                        "

                    >

                        <i
                            class="bi bi-eye"
                            id="newPasswordIcon"
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


            {{-- CONFIRM NEW PASSWORD --}}

            <div class="mb-4">


                <label
                    class="form-label"
                >

                    Confirm New Password

                </label>


                <div class="input-group">


                    <span
                        class="input-group-text"
                    >

                        <i
                            class="bi bi-shield-lock-fill"
                        ></i>

                    </span>


                    <input

                        type="password"

                        id="password_confirmation"

                        name="password_confirmation"

                        class="form-control"

                        placeholder="Confirm new password"

                        required

                    >


                    <button

                        type="button"

                        class="
                            input-group-text
                            password-toggle
                        "

                        onclick="
                            togglePassword(
                                'password_confirmation',
                                'confirmPasswordIcon'
                            )
                        "

                    >

                        <i
                            class="bi bi-eye"
                            id="confirmPasswordIcon"
                        ></i>

                    </button>


                </div>


            </div>


            {{-- CHANGE PASSWORD BUTTON --}}

            <button

                type="submit"

                class="change-button"

            >

                <i
                    class="bi bi-check-circle-fill"
                ></i>

                Change Password

            </button>


        </form>


        <a
            href="{{ route('dashboard') }}"
            class="back-button"
        >

            <i
                class="bi bi-arrow-left"
            ></i>

            Back to Dashboard

        </a>


    </div>


</div>


<script>

    function togglePassword(

        inputId,

        iconId

    ) {


        const input =

            document.getElementById(
                inputId
            );


        const icon =

            document.getElementById(
                iconId
            );


        if (

            input.type ===
            'password'

        ) {

            input.type =
                'text';


            icon.classList.remove(
                'bi-eye'
            );


            icon.classList.add(
                'bi-eye-slash'
            );

        }

        else {

            input.type =
                'password';


            icon.classList.remove(
                'bi-eye-slash'
            );


            icon.classList.add(
                'bi-eye'
            );

        }


    }

</script>


</body>

</html>