<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Users | User Management</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f5ee;
            color: #203b2d;
            min-height: 100vh;
        }

        .page-container {
            width: 75%;
            max-width: 1150px;
            margin: 0 auto;
            padding: 70px 0;
        }

        /* TOP LABEL */
        .label {
            color: #a66f00;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        /* MAIN TITLE */
        h1 {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 58px;
            font-weight: normal;
            color: #1f4d36;
            margin-bottom: 28px;
            position: relative;
        }

        /* GOLD ACCENT LINE */
        h1::after {
            content: "";
            display: block;
            width: 70px;
            height: 4px;
            background: #a66f00;
            margin-top: 12px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(31, 77, 54, 0.10);
            border-top: 4px solid #1f4d36;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* TABLE HEADER */
        thead {
            background: #1f4d36;
        }

        th {
            padding: 16px 18px;
            text-align: left;
            color: #f4c542;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* TABLE DATA */
        td {
            padding: 16px 18px;
            font-size: 15px;
            color: #294235;
            border-bottom: 1px solid #e4e6dd;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* HOVER EFFECT */
        tbody tr {
            transition: all 0.25s ease;
        }

        tbody tr:hover {
            background: #fff8e6;
            transform: scale(1.005);
        }

        /* ID COLUMN */
        td:first-child {
            color: #a66f00;
            font-weight: bold;
        }

        /* USERNAME COLUMN */
        td:last-child {
            color: #1f4d36;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        /* MOBILE DESIGN */
        @media (max-width: 768px) {

            .page-container {
                width: 90%;
                padding-top: 40px;
            }

            h1 {
                font-size: 45px;
            }

            th,
            td {
                padding: 13px 12px;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>

    <div class="page-container">

        <div class="label">
            User Management Module
        </div>

        <h1>Users</h1>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($users)): ?>

                        <?php foreach ($users as $user): ?>

                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td>
                                    <?= htmlspecialchars($user['firstname']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($user['lastname']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($user['email']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($user['username']) ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5" class="no-data">
                                No users found.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>
</html>