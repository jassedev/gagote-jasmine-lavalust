<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>User Management</title>

    <style>

        /* =========================
           GENERAL DESIGN
        ========================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background:
                linear-gradient(
                    135deg,
                    #12372A,
                    #1F5A44,
                    #2E7D5B
                );
            padding: 40px 20px;
        }


        /* =========================
           MAIN CONTAINER
        ========================== */

        .container {
            max-width: 1150px;
            margin: auto;
        }


        /* =========================
           HEADER
        ========================== */

        .header {
            background: rgba(255, 255, 255, 0.96);
            border-left: 7px solid #B8860B;
            padding: 28px 35px;
            border-radius: 15px;
            margin-bottom: 25px;

            box-shadow:
                0 10px 30px
                rgba(0, 0, 0, 0.25);
        }

        .header h1 {
            color: #12372A;
            font-size: 30px;
            margin-bottom: 8px;
        }

        .header p {
            color: #666;
            font-size: 15px;
        }

        .gold-line {
            width: 80px;
            height: 4px;
            background: #B8860B;
            margin-top: 15px;
            border-radius: 10px;
        }


        /* =========================
           TABLE CARD
        ========================== */

        .table-card {
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;

            box-shadow:
                0 15px 40px
                rgba(0, 0, 0, 0.25);
        }


        /* =========================
           TABLE HEADER
        ========================== */

        .table-title {
            background:
                linear-gradient(
                    90deg,
                    #12372A,
                    #1F5A44
                );

            padding: 20px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title h2 {
            color: white;
            font-size: 20px;
        }

        .badge {
            background: #B8860B;
            color: white;

            padding: 8px 15px;
            border-radius: 20px;

            font-size: 13px;
            font-weight: bold;
        }


        /* =========================
           TABLE
        ========================== */

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #F5E6B3;
        }

        th {
            color: #12372A;
            padding: 18px;
            text-align: left;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 17px 18px;
            color: #444;
            border-bottom: 1px solid #eeeeee;
        }

        tbody tr {
            transition: 0.3s;
        }

        tbody tr:hover {
            background: #FFF9E6;
            transform: scale(1.002);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }


        /* =========================
           ID DESIGN
        ========================== */

        .id-number {
            background: #12372A;
            color: #ffffff;

            width: 35px;
            height: 35px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            font-weight: bold;
        }