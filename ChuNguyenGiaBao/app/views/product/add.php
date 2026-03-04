<?php require_once 'app/views/shares/header.php'; ?>

<!-- Page heading -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:8px;">
  <div>
    <p style="margin:0;font-size:0.78rem;color:#888;">
      <a href="/ChuNguyenGiaBao/Product/" style="color:#d70018;">Trang chủ</a>
      <span style="margin:0 4px;">›</span> Nhập kho sản phẩm
    </p>
    <h1 style="font-size:1.1rem;font-weight:700;color:#333;margin:4px 0 0;">Thêm sản phẩm mới</h1>
  </div>
  <a href="/ChuNguyenGiaBao/Product"
     style="font-size:0.82rem;padding:7px 14px;border:1px solid #ddd;border-radius:4px;color:#555;background:#fff;text-decoration:none;">
    ← Về danh sách
  </a>
</div>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:6px;font-size:0.88rem;">
    <strong>Vui lòng kiểm tra lại:</strong>
    <ul class="mb-0 mt-1">
      <?php foreach ($errors as $error): ?>
        <li><?php echo htmlspecialchars($error,ENT_QUOTES,'UTF-8'); ?></li>
      <?php endforeach; ?>
    </ul>
    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
  </div>
<?php endif; ?>

<div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;">
  <!-- Card header -->
  <div style="padding:14px 20px;border-bottom:1px solid #f0f0f0;background:#fafafa;">
    <h2 style="font-size:0.92rem;font-weight:700;color:#333;margin:0;">Thông tin sản phẩm</h2>
  </div>
  <div style="padding:24px 20px;">
    <form method="POST" action="/ChuNguyenGiaBao/Product/save" enctype="multipart/form-data">

      <div class="form-row">
        <div class="form-group col-md-6">
          <label style="font-size:0.82rem;font-weight:600;color:#555;">Tên sản phẩm <span style="color:#d70018;">*</span></label>
          <input type="text" name="name" class="form-control"
                 placeholder="Nhập tên sản phẩm..."
                 value="<?php echo htmlspecialchars($_POST['name'] ?? '',ENT_QUOTES,'UTF-8'); ?>"
                 required>
        </div>
        <div class="form-group col-md-6">
          <label style="font-size:0.82rem;font-weight:600;color:#555;">Giá bán (VNĐ) <span style="color:#d70018;">*</span></label>
          <div class="input-group">
            <input type="number" name="price" class="form-control"
                   step="1000" min="0" placeholder="0"
                   value="<?php echo htmlspecialchars($_POST['price'] ?? '',ENT_QUOTES,'UTF-8'); ?>"
                   required>
            <div class="input-group-append">
              <span class="input-group-text" style="background:#d70018;color:#fff;border:none;">₫</span>
            </div>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label style="font-size:0.82rem;font-weight:600;color:#555;">Mô tả sản phẩm <span style="color:#d70018;">*</span></label>
        <textarea name="description" class="form-control" rows="4"
                  placeholder="Nhập mô tả, tính năng nổi bật..." required><?php echo htmlspecialchars($_POST['description'] ?? '',ENT_QUOTES,'UTF-8'); ?></textarea>
      </div>

      <div class="form-group">
        <label style="font-size:0.82rem;font-weight:600;color:#555;">Danh mục <span style="color:#d70018;">*</span></label>
        <select name="category_id" class="form-control" required>
          <option value="">-- Chọn danh mục --</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category->id; ?>"
              <?php echo (($_POST['category_id'] ?? '') == $category->id) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($category->name,ENT_QUOTES,'UTF-8'); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group">
        <label style="font-size:0.82rem;font-weight:600;color:#555;">Hình ảnh sản phẩm</label>
        <div class="custom-file">
          <input type="file" name="image" class="custom-file-input" id="customFile" accept="image/*">
          <label class="custom-file-label" for="customFile" style="font-size:0.88rem;color:#888;">Chọn ảnh...</label>
        </div>
        <small style="color:#aaa;font-size:0.75rem;">Định dạng: JPG, PNG, GIF. Tối đa 10MB.</small>
      </div>

      <hr style="border-color:#f0f0f0;">
      <div class="text-right">
        <a href="/ChuNguyenGiaBao/Product" class="btn btn-light mr-2" style="font-size:0.88rem;">Hủy</a>
        <button type="submit" class="btn" style="background:#d70018;color:#fff;font-weight:700;font-size:0.88rem;padding:8px 24px;">
          Lưu sản phẩm
        </button>
      </div>
    </form>
  </div>
</div>

<script>
$('.custom-file-input').on('change', function() {
  var fileName = $(this).val().split('\\').pop();
  $(this).next('.custom-file-label').html(fileName || 'Chọn ảnh...');
});
</script>

<?php require_once 'app/views/shares/footer.php'; ?>