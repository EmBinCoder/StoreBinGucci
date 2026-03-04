<?php
// Session already started in index.php — no session_start() here
// Handle login / register / logout via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sbg_action'])) {
    if ($_POST['sbg_action'] === 'login') {
        $u = trim($_POST['login_user'] ?? '');
        $p = $_POST['login_pass'] ?? '';
        if ($u !== '' && $p !== '') {
            $_SESSION['sbg_user'] = $u;
            header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
            exit;
        }
    }
    if ($_POST['sbg_action'] === 'register') {
        $u = trim($_POST['reg_user'] ?? '');
        $p = $_POST['reg_pass'] ?? '';
        if ($u !== '' && $p !== '') {
            $_SESSION['sbg_user'] = $u;
            header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
            exit;
        }
    }
    if ($_POST['sbg_action'] === 'logout') {
        unset($_SESSION['sbg_user']);
        header('Location: /ChuNguyenGiaBao/Product/');
        exit;
    }
}

$loggedIn  = isset($_SESSION['sbg_user']);
$username  = $loggedIn ? htmlspecialchars($_SESSION['sbg_user']) : '';
if (!isset($_SESSION['sbg_cart'])) $_SESSION['sbg_cart'] = [];
$cartCount = array_sum(array_column($_SESSION['sbg_cart'], 'qty'));
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoreBinGucci – Mua sắm công nghệ giá tốt</title>
    <meta name="description" content="StoreBinGucci - Cửa hàng công nghệ hàng đầu Việt Nam. Điện thoại, Laptop, Tablet, Phụ kiện giá tốt, chính hãng.">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== RESET ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f5;
            color: #333;
            font-size: 14px;
        }

        /* ===== VARIABLES ===== */
        :root {
            --red:      #d70018;
            --red-dark: #b5000f;
            --yellow:   #FFD600;
            --gray-bg:  #f5f5f5;
            --white:    #ffffff;
            --border:   #e0e0e0;
            --text:     #333333;
            --muted:    #777777;
        }

        a { color: var(--text); text-decoration: none; }
        a:hover { color: var(--red); text-decoration: none; }

        /* ===== TOP-BAR ===== */
        #top-bar {
            background: var(--red);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .tb-wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 12px;
            height: 56px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Logo */
        .tb-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            flex-shrink: 0;
        }
        .tb-logo .logo-box {
            background: #fff;
            border-radius: 6px;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .tb-logo .logo-box svg circle { fill: var(--red); }
        .tb-logo .logo-name {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            line-height: 1.2;
        }
        .tb-logo .logo-sub {
            display: block;
            font-size: 0.62rem;
            font-weight: 400;
            opacity: 0.85;
        }

        /* Search */
        .tb-search {
            flex: 1 1 380px;
            max-width: 520px;
        }
        .tb-search form {
            display: flex;
            background: #fff;
            border-radius: 4px;
            overflow: hidden;
            height: 36px;
        }
        .tb-search input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0 12px;
            font-size: 0.88rem;
            color: #333;
            background: transparent;
        }
        .tb-search input::placeholder { color: #aaa; }
        .tb-search button {
            background: var(--red-dark);
            border: none;
            color: #fff;
            width: 44px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.15s;
        }
        .tb-search button:hover { background: #940012; }

        /* Nav buttons */
        .tb-nav { display: flex; align-items: center; gap: 4px; margin-left: auto; }
        .tb-navbtn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            padding: 4px 10px;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.15s;
            white-space: nowrap;
            font-size: 0.72rem;
            border: none;
            background: transparent;
        }
        .tb-navbtn:hover { background: rgba(255,255,255,0.15); color: #fff; }
        .tb-navbtn svg { width: 20px; height: 20px; }
        .tb-navbtn span { font-size: 0.72rem; }

        /* Cart badge */
        .cart-badge {
            position: relative;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
        }
        .cart-badge .badge-num {
            position: absolute;
            top: -4px;
            right: -8px;
            background: var(--yellow);
            color: #333;
            font-size: 0.6rem;
            font-weight: 700;
            min-width: 16px;
            height: 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
        }

        /* ===== CATEGORY NAV ===== */
        #cat-nav {
            background: #fff;
            border-bottom: 1px solid var(--border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.07);
        }
        .cn-wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 12px;
            display: flex;
            overflow-x: auto;
            scrollbar-width: none;
        }
        .cn-wrap::-webkit-scrollbar { display: none; }
        .cn-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 10px 14px;
            font-size: 0.82rem;
            font-weight: 500;
            color: #444;
            white-space: nowrap;
            border-bottom: 2px solid transparent;
            transition: color 0.15s, border-color 0.15s;
            cursor: pointer;
        }
        .cn-item:hover, .cn-item.active {
            color: var(--red);
            border-bottom-color: var(--red);
        }
        .cn-item svg { opacity: 0.6; width: 14px; height: 14px; }

        /* ===== CART DRAWER ===== */
        #cart-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 2000;
        }
        #cart-overlay.open { display: block; }
        #cart-drawer {
            position: fixed;
            right: -420px; top: 0; bottom: 0;
            width: 400px;
            background: #fff;
            border-left: 1px solid var(--border);
            z-index: 2001;
            display: flex; flex-direction: column;
            transition: right 0.3s ease;
            box-shadow: -4px 0 20px rgba(0,0,0,0.12);
        }
        #cart-drawer.open { right: 0; }
        .cart-hd {
            background: var(--red);
            color: #fff;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 700;
            font-size: 0.95rem;
        }
        .cart-hd button { background: none; border: none; color: #fff; font-size: 1.3rem; cursor: pointer; line-height: 1; }
        .cart-bd { flex: 1; overflow-y: auto; padding: 12px; }
        .cart-empty { text-align: center; padding: 50px 20px; color: #aaa; }
        .cart-empty svg { margin-bottom: 10px; opacity: 0.25; display: block; margin: 0 auto 10px; }
        .c-item {
            display: flex; gap: 10px;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 8px;
            background: #fafafa;
        }
        .c-item img { width: 60px; height: 60px; object-fit: contain; border-radius: 4px; flex-shrink: 0; border: 1px solid #eee; }
        .c-item-info { flex: 1; }
        .c-item-name { font-size: 0.82rem; font-weight: 600; color: #333; margin-bottom: 4px; line-height: 1.3; }
        .c-item-price { font-size: 0.85rem; color: var(--red); font-weight: 700; }
        .c-item-qty { display: flex; align-items: center; gap: 6px; margin-top: 6px; }
        .qty-btn {
            width: 24px; height: 24px; border-radius: 4px;
            border: 1px solid #ddd; background: #fff;
            color: #555; cursor: pointer; font-size: 0.9rem;
            display: flex; align-items: center; justify-content: center;
        }
        .qty-btn:hover { border-color: var(--red); color: var(--red); }
        .qty-val { font-size: 0.85rem; min-width: 20px; text-align: center; font-weight: 600; }
        .c-item-del { color: #bbb; cursor: pointer; font-size: 1rem; align-self: center; margin-left: 4px; }
        .c-item-del:hover { color: var(--red); }
        .cart-ft { border-top: 1px solid var(--border); padding: 14px 16px; background: #fafafa; }
        .cart-total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .cart-total-lbl { color: #555; font-size: 0.85rem; }
        .cart-total-val { font-size: 1.1rem; color: var(--red); font-weight: 700; }
        .btn-checkout {
            width: 100%;
            background: var(--red);
            color: #fff;
            font-weight: 700;
            border: none;
            padding: 11px;
            border-radius: 4px;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-checkout:hover { background: var(--red-dark); }

        /* ===== AUTH MODAL ===== */
        #auth-modal .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        #auth-modal .modal-header {
            background: var(--red);
            color: #fff;
            border-radius: 8px 8px 0 0;
            border-bottom: none;
            padding: 16px 20px;
        }
        #auth-modal .modal-title { font-weight: 700; font-size: 1rem; color: #fff; }
        #auth-modal .close { color: #fff; opacity: 1; text-shadow: none; }
        .auth-tabs { display: flex; border-bottom: 2px solid #eee; margin-bottom: 20px; }
        .auth-tab-btn {
            flex: 1; padding: 10px; text-align: center;
            background: none; border: none;
            color: #888;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: color 0.15s, border-color 0.15s;
        }
        .auth-tab-btn.active { color: var(--red); border-bottom-color: var(--red); }
        .auth-form { display: none; }
        .auth-form.active { display: block; }
        .auth-form .form-group label { font-size: 0.82rem; color: #666; margin-bottom: 4px; font-weight: 500; }
        .auth-form .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.88rem;
            padding: 8px 12px;
            color: #333;
        }
        .auth-form .form-control:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 2px rgba(215,0,24,0.12);
            outline: none;
        }
        .btn-auth {
            width: 100%;
            background: var(--red);
            color: #fff;
            font-weight: 700;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.15s;
            margin-top: 4px;
        }
        .btn-auth:hover { background: var(--red-dark); }
        .auth-divider { text-align: center; color: #aaa; font-size: 0.78rem; margin: 12px 0; }
        .auth-link { color: var(--red); text-decoration: none; font-weight: 600; }
        .auth-link:hover { text-decoration: underline; }

        /* ===== PAGE WRAPPER / BREADCRUMB ===== */
        .page-wrap {
            max-width: 1280px;
            margin: 0 auto;
            padding: 16px 12px;
        }

        /* ===== FORM CONTROLS (used in add/edit pages) ===== */
        .form-control {
            border: 1px solid #ddd;
            color: #333;
            background: #fff;
            border-radius: 4px;
        }
        .form-control:focus {
            border-color: var(--red);
            box-shadow: 0 0 0 2px rgba(215,0,24,0.1);
            color: #333;
        }
        .card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 6px;
        }
        .input-group-text {
            background: var(--red);
            color: #fff;
            border: none;
        }
    </style>
</head>
<body>

<!-- ===================== TOP BAR ===================== -->
<div id="top-bar">
  <div class="tb-wrap">

    <!-- Logo -->
    <a class="tb-logo" href="/ChuNguyenGiaBao/Product/">
      <div class="logo-box">
        <svg width="28" height="28" viewBox="0 0 28 28">
          <circle cx="14" cy="14" r="14"/>
          <text x="14" y="19" text-anchor="middle" fill="#fff" font-size="10" font-weight="700" font-family="Inter,sans-serif">SBG</text>
        </svg>
      </div>
      <div class="logo-name">
        StoreBinGucci
        <span class="logo-sub">.com</span>
      </div>
    </a>

    <!-- Search -->
    <div class="tb-search">
      <form method="GET" action="/ChuNguyenGiaBao/Product/" id="header-search-form">
        <input type="text" name="q" id="header-search-input"
               placeholder="Bạn tìm gì hôm nay?"
               value="<?php echo htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES); ?>"
               autocomplete="off">
        <button type="submit" aria-label="Tìm kiếm">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
        </button>
      </form>
    </div>

    <!-- Nav actions -->
    <div class="tb-nav">
      <?php if ($loggedIn): ?>
        <button class="tb-navbtn" style="cursor:default;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          <span><?php echo $username; ?></span>
        </button>
        <form method="POST" action="" style="margin:0;">
          <input type="hidden" name="sbg_action" value="logout">
          <button type="submit" class="tb-navbtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            <span>Đăng xuất</span>
          </button>
        </form>
      <?php else: ?>
        <button class="tb-navbtn" onclick="openAuthModal('login')" id="login-btn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          <span>Đăng nhập</span>
        </button>
      <?php endif; ?>

      <button class="tb-navbtn" onclick="toggleCart()" id="cart-btn">
        <div class="cart-badge">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
          <span class="badge-num" id="cart-count"><?php echo $cartCount; ?></span>
        </div>
        <span>Giỏ hàng</span>
      </button>

    </div>
  </div>
</div>

<!-- ===================== CATEGORY NAV ===================== -->
<div id="cat-nav">
  <div class="cn-wrap">
    <a class="cn-item active" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
      Điện thoại
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
      Laptop
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
      Phụ kiện
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      Smartwatch
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/></svg>
      Tablet
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/></svg>
      PC &amp; Gaming
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg>
      Máy cũ
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>
      Màn hình
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
      Sim, Thẻ cào
    </a>
    <a class="cn-item" href="/ChuNguyenGiaBao/Product/add">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Nhập kho
    </a>
  </div>
</div>

<!-- ===================== CART DRAWER ===================== -->
<div id="cart-overlay" onclick="toggleCart()"></div>
<div id="cart-drawer">
  <div class="cart-hd">
    <span>
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;vertical-align:middle;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
      Giỏ hàng của tôi
    </span>
    <button onclick="toggleCart()">×</button>
  </div>
  <div class="cart-bd" id="cart-body"></div>
  <div class="cart-ft">
    <div class="cart-total-row">
      <span class="cart-total-lbl">Tổng tiền:</span>
      <span class="cart-total-val" id="cart-total-display">0 ₫</span>
    </div>
    <button class="btn-checkout" onclick="checkout()">Mua ngay</button>
  </div>
</div>

<!-- ===================== AUTH MODAL ===================== -->
<div class="modal fade" id="auth-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tài khoản StoreBinGucci</h5>
        <button type="button" class="close" data-dismiss="modal"><span>×</span></button>
      </div>
      <div class="modal-body" style="padding:24px;">
        <div class="auth-tabs">
          <button class="auth-tab-btn active" id="tab-login-btn" onclick="switchTab('login')">Đăng nhập</button>
          <button class="auth-tab-btn" id="tab-register-btn" onclick="switchTab('register')">Đăng ký</button>
        </div>

        <!-- LOGIN -->
        <form class="auth-form active" id="form-login" method="POST" action="">
          <input type="hidden" name="sbg_action" value="login">
          <div class="form-group">
            <label>Số điện thoại / Email</label>
            <input type="text" class="form-control" name="login_user" placeholder="Nhập số điện thoại hoặc email" required>
          </div>
          <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" class="form-control" name="login_pass" placeholder="Nhập mật khẩu" required>
          </div>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <label style="font-size:0.8rem;color:#666;display:flex;align-items:center;gap:4px;margin:0;">
              <input type="checkbox" style="margin:0;"> Ghi nhớ đăng nhập
            </label>
            <a href="#" class="auth-link" style="font-size:0.8rem;">Quên mật khẩu?</a>
          </div>
          <button type="submit" class="btn-auth">Đăng nhập</button>
          <p style="text-align:center;font-size:0.8rem;color:#888;margin-top:14px;">
            Chưa có tài khoản? <a href="#" class="auth-link" onclick="switchTab('register'); return false;">Đăng ký ngay</a>
          </p>
        </form>

        <!-- REGISTER -->
        <form class="auth-form" id="form-register" method="POST" action="">
          <input type="hidden" name="sbg_action" value="register">
          <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" class="form-control" placeholder="Nhập họ và tên">
          </div>
          <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" class="form-control" name="reg_user" placeholder="Nhập số điện thoại" required>
          </div>
          <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" class="form-control" name="reg_pass" placeholder="Tạo mật khẩu" required>
          </div>
          <div class="form-group">
            <label>Xác nhận mật khẩu</label>
            <input type="password" class="form-control" placeholder="Nhập lại mật khẩu">
          </div>
          <button type="submit" class="btn-auth">Tạo tài khoản</button>
          <p style="text-align:center;font-size:0.8rem;color:#888;margin-top:14px;">
            Đã có tài khoản? <a href="#" class="auth-link" onclick="switchTab('login'); return false;">Đăng nhập</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* ===== Auth ===== */
function openAuthModal(tab) { switchTab(tab); $('#auth-modal').modal('show'); }
function switchTab(tab) {
  ['login','register'].forEach(function(t) {
    document.getElementById('form-' + t).classList.toggle('active', t === tab);
    document.getElementById('tab-' + t + '-btn').classList.toggle('active', t === tab);
  });
}

/* ===== Cart (localStorage) ===== */
var cart = JSON.parse(localStorage.getItem('sbg_cart') || '[]');
function saveCart() { localStorage.setItem('sbg_cart', JSON.stringify(cart)); }
function totalItems() { return cart.reduce(function(s,i){ return s+i.qty; },0); }
function totalPrice() { return cart.reduce(function(s,i){ return s+i.price*i.qty; },0); }
function fmtPrice(p) { return p.toLocaleString('vi-VN') + ' ₫'; }
function updateBadge() {
  var el = document.getElementById('cart-count');
  if (el) el.textContent = totalItems();
}
function renderCart() {
  var body = document.getElementById('cart-body');
  var tot  = document.getElementById('cart-total-display');
  if (!body) return;
  if (!cart.length) {
    body.innerHTML = '<div class="cart-empty">'
      + '<svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>'
      + '<p style="font-size:0.9rem;color:#888;margin-top:10px;">Giỏ hàng của bạn đang trống</p>'
      + '</div>';
  } else {
    body.innerHTML = cart.map(function(item, idx) {
      return '<div class="c-item">'
        + '<img src="' + item.img + '" alt="' + item.name + '" onerror="this.src=\'https://via.placeholder.com/60x60?text=IMG\'">'
        + '<div class="c-item-info">'
        + '<div class="c-item-name">' + item.name + '</div>'
        + '<div class="c-item-price">' + fmtPrice(item.price) + '</div>'
        + '<div class="c-item-qty">'
        + '<button class="qty-btn" onclick="changeQty(' + idx + ',-1)">−</button>'
        + '<span class="qty-val">' + item.qty + '</span>'
        + '<button class="qty-btn" onclick="changeQty(' + idx + ',1)">+</button>'
        + '</div></div>'
        + '<span class="c-item-del" onclick="removeItem(' + idx + ')" title="Xóa">✕</span>'
        + '</div>';
    }).join('');
  }
  if (tot) tot.textContent = fmtPrice(totalPrice());
  updateBadge();
}
function changeQty(idx, d) { cart[idx].qty += d; if (cart[idx].qty <= 0) cart.splice(idx,1); saveCart(); renderCart(); }
function removeItem(idx) { cart.splice(idx,1); saveCart(); renderCart(); }
function addToCart(id, name, price, img) {
  var f = cart.find(function(i){ return i.id == id; });
  if (f) f.qty++; else cart.push({id:id, name:name, price:price, img:img, qty:1});
  saveCart(); renderCart(); openCart();
}
function openCart()  { document.getElementById('cart-overlay').classList.add('open'); document.getElementById('cart-drawer').classList.add('open'); document.body.style.overflow='hidden'; }
function closeCart() { document.getElementById('cart-overlay').classList.remove('open'); document.getElementById('cart-drawer').classList.remove('open'); document.body.style.overflow=''; }
function toggleCart() { document.getElementById('cart-drawer').classList.contains('open') ? closeCart() : (renderCart(), openCart()); }
function checkout() {
  if (!cart.length) { alert('Giỏ hàng đang trống!'); return; }
  <?php if ($loggedIn): ?>
  if (confirm('Xác nhận đặt hàng ' + cart.length + ' sản phẩm với tổng ' + fmtPrice(totalPrice()) + '?')) {
    alert('Đặt hàng thành công! Cảm ơn bạn đã mua sắm tại StoreBinGucci.');
    cart = []; saveCart(); renderCart(); closeCart();
  }
  <?php else: ?>
  closeCart();
  openAuthModal('login');
  <?php endif; ?>
}
document.addEventListener('DOMContentLoaded', function() {
  renderCart();
  var hi = document.getElementById('header-search-input');
  var pi = document.getElementById('searchInput');
  if (hi && pi) {
    hi.addEventListener('input', function() { if(pi.tagName==='INPUT'){pi.value=this.value; pi.dispatchEvent(new Event('input'));} });
  }
});
</script>

<div class="page-wrap">
