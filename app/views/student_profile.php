<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Profile</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #fdf7f9;
            color: #3f3439;
        }

        /* NAVIGATION */
        .navbar {
            height: 75px;
            background: rgba(255, 255, 255, 0.95);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 8%;

            border-bottom: 1px solid #f1dce3;

            box-shadow:
                0 4px 15px rgba(80, 40, 55, 0.06);
        }

        .logo {
            font-size: 21px;
            font-weight: 700;
            color: #c84d78;
        }

        .logo span {
            color: #4a3d42;
        }

        .nav-links {
            display: flex;
            gap: 10px;
        }

        .nav-links a {
            text-decoration: none;
            color: #62555b;

            padding: 10px 20px;
            border-radius: 10px;

            font-size: 14px;
            font-weight: 600;

            transition: 0.3s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: #f8dce6;
            color: #c23869;
        }

        /* MAIN */
        .main {
            max-width: 1000px;
            margin: auto;
            padding: 60px 30px;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title span {
            color: #c23869;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .page-title h1 {
            margin-top: 8px;
            font-size: 32px;
            color: #352d31;
        }

        .page-title p {
            margin-top: 7px;
            color: #807278;
        }

        /* PROFILE */
        .profile-container {
            background: white;
            border-radius: 24px;

            border: 1px solid #f1e2e7;

            box-shadow:
                0 20px 45px rgba(100, 55, 70, 0.09);

            overflow: hidden;
        }

        /* PROFILE HEADER */
        .profile-top {
            background: linear-gradient(
                135deg,
                #fbe3eb,
                #fff8fa
            );

            padding: 35px;

            display: flex;
            align-items: center;
            gap: 25px;

            border-bottom: 1px solid #f3e0e6;
        }

        .profile-icon {
            width: 90px;
            height: 90px;

            border-radius: 22px;

            background: linear-gradient(
                145deg,
                #f4a8c1,
                #d45a86
            );

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 40px;
            color: white;

            box-shadow:
                9px 9px 18px rgba(190, 72, 112, 0.20),
                inset 3px 3px 6px rgba(255,255,255,0.35);
        }

        .profile-name h2 {
            color: #3c3338;
            font-size: 24px;
        }

        .profile-name p {
            color: #9a7a86;
            margin-top: 5px;
            font-size: 14px;
        }

        /* INFORMATION */
        .information {
            padding: 35px;
        }

        .information-title {
            color: #4a3d42;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .info-box {
            padding: 20px;

            background: #fdf8fa;

            border: 1px solid #f3e5e9;
            border-radius: 14px;

            transition: 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-3px);

            box-shadow:
                0 8px 20px rgba(100, 55, 70, 0.08);
        }

        .info-label {
            display: block;

            font-size: 11px;
            font-weight: 700;

            color: #c84d78;

            text-transform: uppercase;
            letter-spacing: 0.8px;

            margin-bottom: 8px;
        }

        .info-value {
            display: block;

            font-size: 16px;
            font-weight: 600;

            color: #453b40;

            word-break: break-word;
        }

        .email-box {
            grid-column: span 2;
        }

        /* FOOTER */
        .footer {
            text-align: center;
            margin-top: 35px;

            color: #9a8b91;
            font-size: 13px;
        }

        /* RESPONSIVE */
        @media (max-width: 700px) {

            .navbar {
                padding: 0 5%;
            }

            .profile-top {
                flex-direction: column;
                text-align: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .email-box {
                grid-column: span 1;
            }

            .main {
                padding: 40px 20px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVIGATION -->
    <nav class="navbar">

        <div class="logo">
            Student<span>Portal</span>
        </div>

        <div class="nav-links">

            <a href="<?= site_url('student'); ?>">
                Home
            </a>

            <a
                href="<?= site_url('student/profile'); ?>"
                class="active">
                Profile
            </a>

        </div>

    </nav>


    <!-- MAIN -->
    <main class="main">

        <div class="page-title">

            <span>
                STUDENT PORTAL
            </span>

            <h1>
                Student Profile
            </h1>

            <p>
                View your personal and academic information.
            </p>

        </div>


        <!-- PROFILE CARD -->
        <section class="profile-container">

            <!-- Profile Header -->
            <div class="profile-top">

                <div class="profile-icon">
                    👤
                </div>

                <div class="profile-name">

                    <h2>
                        <?php echo $name; ?>
                    </h2>

                    <p>
                        Student Information
                    </p>

                </div>

            </div>


            <!-- Information -->
            <div class="information">

                <h3 class="information-title">
                    Personal & Academic Information
                </h3>


                <div class="info-grid">

                    <div class="info-box">

                        <span class="info-label">
                            Student ID
                        </span>

                        <span class="info-value">
                            <?php echo $student_id; ?>
                        </span>

                    </div>


                    <div class="info-box">

                        <span class="info-label">
                            Full Name
                        </span>

                        <span class="info-value">
                            <?php echo $name; ?>
                        </span>

                    </div>


                    <div class="info-box">

                        <span class="info-label">
                            Course
                        </span>

                        <span class="info-value">
                            <?php echo $course; ?>
                        </span>

                    </div>


                    <div class="info-box">

                        <span class="info-label">
                            Year Level
                        </span>

                        <span class="info-value">
                            <?php echo $year; ?>
                        </span>

                    </div>


                    <div class="info-box">

                        <span class="info-label">
                            Section
                        </span>

                        <span class="info-value">
                            <?php echo $section; ?>
                        </span>

                    </div>


                    <div class="info-box email-box">

                        <span class="info-label">
                            Email Address
                        </span>

                        <span class="info-value">
                            <?php echo $email; ?>
                        </span>

                    </div>

                </div>

            </div>

        </section>


        <div class="footer">
            © 2026 Student Information System
        </div>

    </main>

</body>
</html>