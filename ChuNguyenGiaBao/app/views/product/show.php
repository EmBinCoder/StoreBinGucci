<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3>Chi tiết sản phẩm</h3>
        </div>

        <div class="card-body">

            <h4 class="card-title">
                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
            </h4>

            <p class="card-text">
                <strong>Mô tả:</strong><br>
                <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
            </p>

            <p class="card-text">
                <strong>Giá:</strong>
                <?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?> VNĐ
            </p>

            <?php if (!empty($product->category_name)): ?>
                <p class="card-text">
                    <strong>Danh mục:</strong>
                    <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            <?php endif; ?>

        </div>

        <div class="card-footer text-right">
            <a href="/ChuNguyenGiaBao/Product/edit/<?php echo $product->id; ?>"
               class="btn btn-warning">
                Sửa
            </a>

            <a href="/ChuNguyenGiaBao/Product"
               class="btn btn-secondary">
                Quay lại
            </a>
        </div>
    </div>

</div>

<?php include 'app/views/shares/footer.php'; ?>