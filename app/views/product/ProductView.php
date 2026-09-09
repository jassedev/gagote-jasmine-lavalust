<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #f4f7f3 0%, #e7efeb 50%, #edf1ec 100%);
            min-height: 100vh;
            color: #263238;
        }
        .container { width: 72%; max-width: 1150px; margin: 0 auto; padding-top: 70px; }
        .module-title { color: #2f6654; font-size: 12px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 12px; }
        
        .header-flex { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 15px; }
        .page-title { font-family: Georgia, "Times New Roman", serif; font-size: 60px; font-weight: 400; color: #263238; }
        .user-greeting { color: #6d5610; font-size: 14px; font-weight: 600; margin-bottom: 10px; }
        
        .accent-line { width: 65px; height: 3px; background-color: #b8860b; margin-bottom: 24px; }

        .top-nav { margin-bottom: 20px; display: flex; gap: 10px; align-items: center; }
        .btn-link {
            display: inline-block;
            padding: 8px 16px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-primary { background-color: #2f6654; color: #fff; }
        .btn-primary:hover { background-color: #245042; }
        .btn-secondary { border: 1px solid #bfcac5; color: #456052; background: rgba(255,255,255,0.4); }
        .btn-secondary:hover { background: #fff; color: #263238; }

        /* TABLE STYLES */
        .table-container { width: 100%; background-color: rgba(255, 255, 255, 0.35); border: 1px solid #c5d0cb; }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: rgba(234, 240, 236, 0.75); }
        th { padding: 14px 16px; text-align: left; color: #456052; font-size: 11px; font-weight: bold; letter-spacing: 1.8px; text-transform: uppercase; border-bottom: 1px solid #bfcac5; }
        td { padding: 14px 16px; font-size: 15px; color: #34423d; border-bottom: 1px solid #cbd4d0; }
        tbody tr { transition: background-color 0.2s ease; }
        tbody tr:hover { background-color: #f4f1df; }
        tbody tr:last-child td { border-bottom: none; }

        .id { color: #2f6654; font-weight: 500; }
        .price { color: #6d5610; font-weight: 600; }
        .actions a { text-decoration: none; font-size: 12px; font-weight: bold; letter-spacing: 1px; text-transform: uppercase; margin-right: 10px; }
        .actions .edit-link { color: #2f6654; }
        .actions .delete-link { color: #a83232; }

        /* NOTIFICATION */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 280px;
            padding: 14px 18px;
            color: #2f6654;
            background: #e7f2ed;
            border: 1px solid #b2cec3;
            border-left: 4px solid #2f6654;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            font-size: 14px;
        }
        .notification button { float: right; margin-left: 16px; color: inherit; background: transparent; border: 0; cursor: pointer; font-size: 18px; line-height: 1; }

        @media screen and (max-width: 900px) {
            .container { width: 90%; padding-top: 40px; }
            .page-title { font-size: 48px; }
        }
        @media screen and (max-width: 600px) {
            .container { width: 94%; padding-top: 30px; }
            .page-title { font-size: 40px; }
            .table-container { overflow-x: auto; }
            table { min-width: 700px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-greeting">Logged in as: <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></div>
        <div class="module-title">Inventory Module</div>
        
        <div class="header-flex">
            <h1 class="page-title">Products</h1>
        </div>
        
        <div class="accent-line"></div>

        <div class="top-nav">
            <?php if ($user_role === 'admin'): ?>
                <a href="<?= site_url('/product/create'); ?>" class="btn-link btn-primary">Add Product</a>
            <?php endif; ?>
            <a href="<?= site_url('/logout'); ?>" class="btn-link btn-secondary">Logout</a>
        </div>

        <?php if (!empty($notification)): ?>
            <div class="notification" role="status" id="notification">
                <button type="button" onclick="document.getElementById('notification').remove();" aria-label="Close notification">&times;</button>
                <?= htmlspecialchars($notification, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <?php if ($user_role === 'admin'): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="<?= ($user_role === 'admin') ? '6' : '5'; ?>" style="text-align: center; color: #777; padding: 30px;">No products available.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="id"><?php echo $product['id']; ?></td>
                                <td><strong><?php echo $product['product_name']; ?></strong></td>
                                <td><?php echo $product['description']; ?></td>
                                <td class="price">$<?php echo number_format($product['price'], 2); ?></td>
                                <td><?php echo $product['created_at']; ?></td>
                                <?php if ($user_role === 'admin'): ?>
                                    <td class="actions">
                                        <a href="<?= site_url('/product/edit/' . $product['id']); ?>" class="edit-link">Edit</a>
                                        <a href="<?= site_url('/product/delete/' . $product['id']); ?>" class="delete-link" onclick="return confirm('Delete this product?');">Delete</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (!empty($notification)): ?>
        <script>
            window.setTimeout(function () {
                var notification = document.getElementById('notification');
                if (notification) { notification.remove(); }
            }, 4000);
        </script>
    <?php endif; ?>
</body>
</html>