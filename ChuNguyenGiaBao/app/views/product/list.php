<?php require_once 'app/views/shares/header.php'; ?>

<!-- Banner / Hero -->
<div style="background: linear-gradient(135deg, #d70018 0%, #ff4560 100%); border-radius:8px; padding:22px 28px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; overflow:hidden; position:relative;">
  <div style="position:absolute;right:-30px;top:-30px;width:180px;height:180px;background:rgba(255,255,255,0.08);border-radius:50%;"></div>
  <div style="position:absolute;right:60px;bottom:-50px;width:130px;height:130px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
  <div>
    <h1 style="color:#fff;font-size:1.5rem;font-weight:700;margin:0 0 4px;">StoreBinGucci</h1>
    <p style="color:rgba(255,255,255,0.85);margin:0;font-size:0.88rem;">Mua sắm công nghệ – Giá tốt – Chính hãng – Giao nhanh toàn quốc</p>
  </div>
  <a href="/ChuNguyenGiaBao/Product/add"
     style="background:#fff;color:#d70018;font-weight:700;font-size:0.85rem;padding:9px 18px;border-radius:4px;text-decoration:none;white-space:nowrap;flex-shrink:0;transition:opacity 0.15s;"
     onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
    + Nhập kho
  </a>
</div>

<!-- Promo strips (TGDĐ-style highlight bar) -->
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
  <div style="flex:1;min-width:160px;background:#fff;border:1px solid #eee;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:10px;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d70018" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
    <div>
      <p style="margin:0;font-weight:700;font-size:0.82rem;color:#333;">Giao hàng nhanh</p>
      <p style="margin:0;font-size:0.75rem;color:#888;">Trong 2 giờ nội thành</p>
    </div>
  </div>
  <div style="flex:1;min-width:160px;background:#fff;border:1px solid #eee;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:10px;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d70018" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
    <div>
      <p style="margin:0;font-weight:700;font-size:0.82rem;color:#333;">Bảo hành chính hãng</p>
      <p style="margin:0;font-size:0.75rem;color:#888;">12–24 tháng tại cửa hàng</p>
    </div>
  </div>
  <div style="flex:1;min-width:160px;background:#fff;border:1px solid #eee;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:10px;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d70018" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
    <div>
      <p style="margin:0;font-weight:700;font-size:0.82rem;color:#333;">Đổi trả dễ dàng</p>
      <p style="margin:0;font-size:0.75rem;color:#888;">Trong 30 ngày sử dụng</p>
    </div>
  </div>
  <div style="flex:1;min-width:160px;background:#fff;border:1px solid #eee;border-radius:6px;padding:10px 14px;display:flex;align-items:center;gap:10px;">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d70018" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
    <div>
      <p style="margin:0;font-weight:700;font-size:0.82rem;color:#333;">Giá tốt nhất</p>
      <p style="margin:0;font-size:0.75rem;color:#888;">Cam kết hoàn tiền chênh lệch</p>
    </div>
  </div>
</div>

<!-- Product list heading + search -->
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px;">
  <h2 style="font-size:1rem;font-weight:700;color:#333;margin:0;display:flex;align-items:center;gap:8px;">
    <span style="display:inline-block;width:4px;height:18px;background:#d70018;border-radius:2px;vertical-align:middle;"></span>
    Tất cả sản phẩm
    <span style="font-size:0.78rem;font-weight:400;color:#888;">
      (<span id="visibleCount">0</span>/<span id="totalCount">0</span>)
    </span>
  </h2>
  <!-- sort placeholder -->
  <select style="border:1px solid #ddd;border-radius:4px;padding:6px 12px;font-size:0.82rem;color:#555;outline:none;background:#fff;">
    <option>Sắp xếp: Phổ biến nhất</option>
    <option>Giá thấp đến cao</option>
    <option>Giá cao đến thấp</option>
    <option>Mới nhất</option>
  </select>
</div>

<!-- Hidden synced search input -->
<input type="hidden" id="searchInput" value="<?php echo htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES); ?>">

<?php if (!empty($products)): ?>
<div class="row" id="productGrid" style="margin:0 -6px;">
  <?php foreach ($products as $product): ?>
    <?php
      $cat   = $product->category_name ?? 'Chưa phân loại';
      $img   = !empty($product->image)
               ? "/ChuNguyenGiaBao/" . $product->image
               : "https://via.placeholder.com/300x200?text=No+Image";
      $name  = $product->name ?? '';
      $desc  = $product->description ?? '';
      $price = is_numeric($product->price ?? null) ? (float)$product->price : 0;
      $oldPrice = $price * 1.08; // demo: fake "original" price
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6 mb-3 product-item"
         style="padding:0 6px;"
         data-search="<?php echo htmlspecialchars(mb_strtolower($name.' '.$desc.' '.$cat,'UTF-8'),ENT_QUOTES,'UTF-8'); ?>">

      <div style="background:#fff;border:1px solid #e0e0e0;border-radius:8px;overflow:hidden;display:flex;flex-direction:column;height:100%;transition:box-shadow 0.2s;"
           onmouseover="this.style.boxShadow='0 4px 18px rgba(0,0,0,0.12)'"
           onmouseout="this.style.boxShadow='none'">

        <!-- Image -->
        <div style="height:180px;overflow:hidden;display:flex;align-items:center;justify-content:center;background:#f9f9f9;position:relative;">
          <img src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($name,ENT_QUOTES,'UTF-8'); ?>"
               style="max-height:160px;max-width:100%;object-fit:contain;padding:8px;" />
          <span style="position:absolute;top:8px;left:8px;background:#d70018;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 6px;border-radius:3px;">-8%</span>
        </div>

        <!-- Info -->
        <div style="padding:10px 12px;flex:1;display:flex;flex-direction:column;">
          <p style="font-size:0.68rem;color:#888;margin:0 0 4px;text-transform:uppercase;letter-spacing:0.3px;">
            <?php echo htmlspecialchars($cat,ENT_QUOTES,'UTF-8'); ?>
          </p>
          <a href="/ChuNguyenGiaBao/Product/show/<?php echo $product->id; ?>"
             style="font-size:0.88rem;font-weight:600;color:#333;margin-bottom:6px;display:block;line-height:1.35;"
             onmouseover="this.style.color='#d70018'" onmouseout="this.style.color='#333'">
            <?php echo htmlspecialchars($name,ENT_QUOTES,'UTF-8'); ?>
          </a>
          <p style="font-size:0.78rem;color:#888;margin:0 0 8px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;flex:1;">
            <?php echo htmlspecialchars($desc,ENT_QUOTES,'UTF-8'); ?>
          </p>
          <!-- Price -->
          <div style="margin-bottom:10px;">
            <span style="font-size:1rem;font-weight:700;color:#d70018;">
              <?php echo number_format($price,0,',','.'); ?>₫
            </span>
            <span style="font-size:0.78rem;color:#bbb;text-decoration:line-through;margin-left:6px;">
              <?php echo number_format($oldPrice,0,',','.'); ?>₫
            </span>
          </div>
          <!-- Add to cart -->
          <button onclick="addToCart('<?php echo $product->id; ?>','<?php echo addslashes(htmlspecialchars($name,ENT_QUOTES)); ?>',<?php echo $price; ?>,'<?php echo $img; ?>')"
                  style="width:100%;background:#d70018;color:#fff;border:none;border-radius:4px;padding:8px;font-weight:700;font-size:0.82rem;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:background 0.15s;margin-bottom:8px;"
                  onmouseover="this.style.background='#b5000f'" onmouseout="this.style.background='#d70018'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            Chọn mua
          </button>
          <!-- Admin actions -->
          <div style="display:flex;gap:6px;">
            <a href="/ChuNguyenGiaBao/Product/edit/<?php echo $product->id; ?>"
               style="flex:1;text-align:center;padding:6px;font-size:0.78rem;border:1px solid #f0a500;color:#f0a500;border-radius:4px;font-weight:600;transition:background 0.15s;"
               onmouseover="this.style.background='#f0a500';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#f0a500'">
              Sửa
            </a>
            <a href="/ChuNguyenGiaBao/Product/delete/<?php echo $product->id; ?>"
               onclick="return confirm('Xóa sản phẩm này?')"
               style="flex:1;text-align:center;padding:6px;font-size:0.78rem;border:1px solid #e74c3c;color:#e74c3c;border-radius:4px;font-weight:600;transition:background 0.15s;"
               onmouseover="this.style.background='#e74c3c';this.style.color='#fff'" onmouseout="this.style.background='transparent';this.style.color='#e74c3c'">
              Xóa
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div id="noResult" style="display:none;text-align:center;padding:40px;background:#fff;border-radius:8px;border:1px solid #eee;">
  <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 10px;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
  <p style="color:#888;margin:0;">Không tìm thấy sản phẩm phù hợp.</p>
</div>

<?php else: ?>
<div style="text-align:center;padding:60px 20px;background:#fff;border-radius:8px;border:1px solid #eee;">
  <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="display:block;margin:0 auto 12px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
  <p style="color:#aaa;font-size:0.9rem;margin:0;">Chưa có sản phẩm nào. <a href="/ChuNguyenGiaBao/Product/add" style="color:#d70018;font-weight:600;">Thêm ngay</a></p>
</div>
<?php endif; ?>

<script>
(function(){
  var items   = Array.prototype.slice.call(document.querySelectorAll('.product-item'));
  var visible = document.getElementById('visibleCount');
  var total   = document.getElementById('totalCount');
  var noRes   = document.getElementById('noResult');
  var hidden  = document.getElementById('searchInput');
  if (!visible || !total) return;
  total.textContent = items.length;
  function norm(s){ return (s||'').toLowerCase().trim(); }
  function filter(q){
    q = norm(q);
    var c = 0;
    items.forEach(function(el){
      var ok = !q || norm(el.getAttribute('data-search')).indexOf(q) !== -1;
      el.style.display = ok ? '' : 'none';
      if(ok) c++;
    });
    visible.textContent = c;
    if(noRes) noRes.style.display = (c===0 && items.length>0) ? '' : 'none';
  }
  var initQ = hidden ? hidden.value : '';
  filter(initQ);
  document.addEventListener('DOMContentLoaded', function(){
    var hi = document.getElementById('header-search-input');
    if(hi){ if(initQ) hi.value=initQ; hi.addEventListener('input', function(){ filter(this.value); }); }
    filter(initQ);
  });
})();
</script>

<?php require_once 'app/views/shares/footer.php'; ?>