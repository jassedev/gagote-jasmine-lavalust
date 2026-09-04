<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Users | User Management</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family: Arial, Helvetica, sans-serif;

            background:
                linear-gradient(
                    135deg,
                    #f4f7f3 0%,
                    #e7efeb 50%,
                    #edf1ec 100%
                );

            min-height: 100vh;

            color: #263238;
        }


        /* MAIN CONTAINER */

        .container {
            width: 72%;
            max-width: 1150px;

            margin: 0 auto;

            padding-top: 70px;
        }


        /* PAGE HEADER */

        .module-title {
            color: #2f6654;

            font-size: 12px;
            font-weight: bold;

            letter-spacing: 3px;

            text-transform: uppercase;

            margin-bottom: 12px;
        }


        .page-title {
            font-family: Georgia, "Times New Roman", serif;

            font-size: 60px;
            font-weight: 400;

            color: #263238;

            margin-bottom: 28px;
        }


        /* GOLD ACCENT */

        .accent-line {
            width: 65px;
            height: 3px;

            background-color: #b8860b;

            margin-bottom: 18px;
        }


        /* TABLE CONTAINER */

        .table-container {
            width: 100%;

            background-color:
                rgba(255, 255, 255, 0.35);

            border: 1px solid #c5d0cb;
        }


        table {
            width: 100%;

            border-collapse: collapse;
        }


        /* TABLE HEADER */

        thead {
            background-color:
                rgba(234, 240, 236, 0.75);
        }


        th {
            padding: 14px 16px;

            text-align: left;

            color: #456052;

            font-size: 11px;

            font-weight: bold;

            letter-spacing: 1.8px;

            text-transform: uppercase;

            border-bottom:
                1px solid #bfcac5;
        }


        /* TABLE BODY */

        td {
            padding: 14px 16px;

            font-size: 15px;

            color: #34423d;

            border-bottom:
                1px solid #cbd4d0;
        }


        tbody tr {
            transition:
                background-color 0.2s ease;
        }


        tbody tr:hover {
            background-color: #f4f1df;
        }


        tbody tr:last-child td {
            border-bottom: none;
        }


        /* ID COLUMN */

        .id {
            color: #2f6654;
            font-weight: 500;
        }


        /* USERNAME */

        .username {
            color: #6d5610;
            font-weight: 500;
        }


        /* EMPTY DATA */

        .empty {
            text-align: center;

            padding: 30px;

            color: #777;
        }


        /* RESPONSIVE DESIGN */

        @media screen and (max-width: 900px) {

            .container {
                width: 90%;
                padding-top: 40px;
            }


            .page-title {
                font-size: 48px;
            }

        }


        @media screen and (max-width: 600px) {

            .container {
                width: 94%;
                padding-top: 30px;
            }


            .page-title {
                font-size: 40px;
            }


            .table-container {
                overflow-x: auto;
            }


            table {
                min-width: 700px;
            }

        }

    </style>

</head>


<body>


    <div class="container">


        <!-- MODULE LABEL -->

        <div class="module-title">

            User Management Module

        </div>


        <!-- MAIN TITLE -->

        <h1 class="page-title">

       Users

        </h1>


        <!-- DARK YELLOW / GOLD ACCENT -->

        <div class="accent-line"></div>