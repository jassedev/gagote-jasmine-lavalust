<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Information System</title>

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
            box-shadow: 0 4px 15px rgba(80, 40, 55, 0.06);
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
            max-width: 1100px;
            margin: 0 auto;
            padding: 70px 30px;
        }

        .welcome {
            background: linear-gradient(
                135deg,
                #ffffff,
                #fff6f9
            );

            border-radius: 24px;
            padding: 55px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow:
                0 20px 45px rgba(111, 58, 78, 0.10),
                0 5px 12px rgba(111, 58, 78, 0.05);

            border: 1px solid #f5e4e9;
        }

        .welcome-text {
            max-width: 650px;
        }

        .welcome-text .tag {
            display: inline-block;
            background: #f8dce6;
            color: #c23869;
            padding: 7px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 18px;
        }

        .welcome h1 {
            font-size: 38px;
            color: #352d31;
            margin-bottom: 15px;
        }

        .welcome h1 span {
            color: #c23869;
        }

        .welcome p {
            color: #786b71;
            line-height: 1.7;
            font-size: 16px;
        }

        /* 3D ICON */
        .welcome-icon {
            width: 150px;
            height: 150px;
            border-radius: 30px;

            background: linear-gradient(
                145deg,
                #f8b8cc,
                #d85d88
            );

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 60px;
            color: white;

            box-shadow:
                12px 12px 25px rgba(191, 71, 112, 0.22),
                inset 3px 3px 7px rgba(255,255,255,0.4);

            transform: rotate(3deg);
        }

        /* CARDS */
        .section-title {
            margin: 45px 0 20px;
            font-size: 22px;
            color: #3d3439;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            border: 1px solid #f1e2e7;

            box-shadow:
                0 10px 25px rgba(100, 55, 70, 0.07);

            transition: 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 15px 30px rgba(100, 55, 70, 0.12);
        }

        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;

            background: #fbe5ec;
            color: #c23869;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 22px;
            margin-bottom: 18px;
        }

        .card h3 {
            margin-bottom: 8px;
            color: #40363b;
        }

        .card p {
            color: #807278;
            font-size: 14px;
            line-height: 1.6;
        }

        .profile-button {
            display: inline-block;
            margin-top: 25px;

            background: #c84d78;
            color: white;

            padding: 12px 22px;
            border-radius: 10px;

            text-decoration: none;
            font-size: 14px;
            font-weight: 600;

            box-shadow: 0 6px 15px rgba(200, 77, 120, 0.25);

            transition: 0.3s ease;
        }

        .profile-button:hover {
            background: #b83e69;
            transform: translateY(-2px);
        }

        /* FOOTER */
        .footer {
            text-align: center;
            margin-top: 45px;
            color: #9a8b91;
            font-size: 13px;
        }

        /* RESPONSIVE */
        @media (max-width: 750px) {

            .navbar {
                padding: 0 5%;
            }

            .welcome {
                flex-direction: column;
                text-align: center;
                padding: 40px 25px;
            }

            .welcome-icon {
                margin-top: 30px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .welcome h1 {
                font-size: 30px;
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
            <a href="<?= site_url('student'); ?>" class="active">
                Home
            </a>

            <a href="<?= site_url('student/profile'); ?>">
                Profile
            </a>
        </div>

    </nav>


    <!-- MAIN CONTENT -->
    <main class="main">

        <section class="welcome">

            <div class="welcome-text">

                <span class="tag">
                    STUDENT INFORMATION SYSTEM
                </span>

                <h1>
                    Welcome to your
                    <span>Student Portal</span>
                </h1>

                <p>
                    Manage and access your student information
                    through a simple, organized, and secure
                    student portal.
                </p>

                <a
                    href="<?= site_url('student/profile'); ?>"
                    class="profile-button">
                    View My Profile
                </a>

            </div>

            <div class="welcome-icon">
                🎓
            </div>

        </section>


        <h2 class="section-title">
            Quick Access
        </h2>


        <section class="cards">

            <div class="card">

                <div class="card-icon">
                    👤
                </div>

                <h3>
                    Student Profile
                </h3>

                <p>
                    View your personal and academic
                    information in one organized place.
                </p>

            </div>


            <div class="card">

                <div class="card-icon">
                    🎓
                </div>

                <h3>
                    Academic Information
                </h3>

                <p>
                    Keep track of your course, year level,
                    and section information.
                </p>

            </div>


            <div class="card">

                <div class="card-icon">
                    🔒
                </div>

                <h3>
                    Secure Information
                </h3>

                <p>
                    Your student information is presented
                    in a clean and organized interface.
                </p>

            </div>

        </section>


        <div class="footer">
            © 2026 Student Information System
        </div>

    </main>

</body>
</html>