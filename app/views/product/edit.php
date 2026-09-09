<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #f4f7f3 0%, #e7efeb 50%, #edf1ec 100%);
            min-height: 100vh;
            color: #263238;
        }
        .container { width: 72%; max-width: 600px; margin: 0 auto; padding-top: 70px; }
        .module-title { color: #2f6654; font-size: 12px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 12px; }
        .page-title { font-family: Georgia, "Times New Roman", serif; font-size: 48px; font-weight: 400; color: #263238; margin-bottom: 20px; }
        .accent-line { width: 65px; height: 3px; background-color: #b8860b; margin-bottom: 24px; }
        
        .form-card {
            background-color: rgba(255, 255, 255, 0.45);
            border: 1px solid #c5d0cb;
            padding: 30px;
            backdrop-filter: blur(5px);
        }
        .form-group { margin-bottom: 20px; display: flex; flex-direction: column; }
        .form-group label { display: block; font-size: 11px; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase; color: #456052; margin-bottom: 8px; }
        
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px 14px;
            font-size: 14px;
            color: #34423d;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #cbd4d0;
            outline: none;
            transition: border-color 0.2s ease;
            font-family: inherit;
        }
        .form-group textarea { min-height: 90px; resize: vertical; }
        .form-group input:focus, .form-group textarea:focus { border-color: #2f6654; background-color: #fff; }
        
        .btn-submit {
            padding: 12px 24px;
            background-color: #2f6654;
            color: #ffffff;
            border: none;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .btn-submit:hover { background-color: #245042; }

        .btn-back {
            display: inline-block;
            margin-left: 12px;
            padding: 12px 18px;
            border: 1px solid #bfcac5;
            color: #456052;
            background: rgba(255, 255, 255, 0.4);
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-back:hover { background: #fff; color: #263238; }

        .error-list {
            background-color: #fcebe8;
            color: #a83232;
            border: 1px solid #f5c2c2;
            padding: 12px 16px 12px 32px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        @media screen and (max-width: 600px) {
            .container { width: 90%; padding-top: 40px; }
            .page-title { font-size: 36px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="module-title">Inventory Management</div>
        <h1 class="page-title">Edit Product</h1>
        <div class="accent-line"></div>

        <div class="form-card">
            <?php if (!empty($errors)): ?>
                <ul class="error-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <form action="<?= site_url('/product/edit/' . $product['id']); ?>" method="post">
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required><?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" value="<?= htmlspecialchars($product['quantity'], ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>

                <button type="submit" class="btn-submit">Update Product</button>
                <a href="<?= site_url('/product/display'); ?>" class="btn-back">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>