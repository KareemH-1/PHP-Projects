<?php
session_start();

if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

$dark_mode = $_SESSION['dark_mode'] ?? 0;
$arabic_mode = $_SESSION['arabic_mode'] ?? 0;

$themeClass = $dark_mode ? 'dark' : 'light';
$direction = $arabic_mode ? 'rtl' : 'ltr';
?>

<!DOCTYPE html>
<html lang="<?= $arabic_mode ? 'ar' : 'en' ?>" dir="<?= $direction ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $arabic_mode ? 'لوحة التحكم' : 'Dashboard' ?></title>
    <link rel="stylesheet" href="styles/main-styling.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="<?= $themeClass ?>">
    
    <header class="header">
        <div class="header-content">
            <h1><?= $arabic_mode ? 'لوحة التحكم' : 'Dashboard' ?></h1>
            
            <div class="header-controls">
                <div class="toggle-container">
                    <span class="toggle-label">
                        <i class="fas fa-sun"></i> <?= $arabic_mode ? 'فاتح' : 'Light' ?>
                    </span>
                    <div class="toggle-switch <?= $dark_mode ? 'active' : '' ?>" onclick="toggleTheme()">
                        <div class="toggle-slider"></div>
                    </div>
                    <span class="toggle-label">
                        <i class="fas fa-moon"></i> <?= $arabic_mode ? 'داكن' : 'Dark' ?>
                    </span>
                </div>
                
                <div class="toggle-container">
                    <span class="toggle-label">EN</span>
                    <div class="toggle-switch <?= $arabic_mode ? 'active' : '' ?>" onclick="toggleLanguage()">
                        <div class="toggle-slider"></div>
                    </div>
                    <span class="toggle-label">AR</span>
                </div>
                
                <form action="logout.php" method="post" style="margin: 0;">
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <?= $arabic_mode ? 'خروج' : 'Logout' ?>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="card">
            <h2>
                <i class="fas fa-tachometer-alt"></i>
                <?= $arabic_mode ? 'مرحباً بك' : 'Welcome' ?>
            </h2>
            <p><?= $arabic_mode ? 'مرحباً بك في لوحة التحكم الخاصة بك.' : 'Welcome to your dashboard.' ?></p>
            <p><?= $arabic_mode ? 'يمكنك تبديل الوضع الداكن/الفاتح ووضع اللغة من الأعلى.' : 'You can toggle dark/light mode and language mode from the top.' ?></p>
        </div>

        <div class="grid">
            <div class="card">
                <h2>
                    <i class="fas fa-chart-bar"></i>
                    <?= $arabic_mode ? 'الإحصائيات' : 'Statistics' ?>
                </h2>
                <p><?= $arabic_mode ? 'عرض الإحصائيات والتقارير.' : 'View statistics and reports.' ?></p>
                <div class="card-actions">
                    <button class="btn">
                        <i class="fas fa-eye"></i>
                        <?= $arabic_mode ? 'عرض التفاصيل' : 'View Details' ?>
                    </button>
                </div>
            </div>

            <div class="card">
                <h2>
                    <i class="fas fa-box"></i>
                    <?= $arabic_mode ? 'المنتجات' : 'Products' ?>
                </h2>
                <p><?= $arabic_mode ? 'إدارة المنتجات والمخزون.' : 'Manage products and stock.' ?></p>
                <div class="card-actions">
                    <button class="btn">
                        <i class="fas fa-plus"></i>
                        <?= $arabic_mode ? 'إضافة منتج' : 'Add Product' ?>
                    </button>
                </div>
            </div>

            <div class="card">
                <h2>
                    <i class="fas fa-dollar-sign"></i>
                    <?= $arabic_mode ? 'المبيعات' : 'Sales' ?>
                </h2>
                <p><?= $arabic_mode ? 'إدارة المبيعات والفواتير.' : 'Manage sales and invoices.' ?></p>
                <div class="card-actions">
                    <button class="btn">
                        <i class="fas fa-plus"></i>
                        <?= $arabic_mode ? 'إضافة بيع' : 'Add Sale' ?>
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-list"></i>
                        <?= $arabic_mode ? 'عرض المبيعات' : 'View Sales' ?>
                    </button>
                </div>
            </div>

            <div class="card">
                <h2>
                    <i class="fas fa-cog"></i>
                    <?= $arabic_mode ? 'الإعدادات' : 'Settings' ?>
                </h2>
                <p><?= $arabic_mode ? 'تكوين إعدادات النظام.' : 'Configure system settings.' ?></p>
                <div class="card-actions">
                    <button class="btn btn-secondary">
                        <i class="fas fa-edit"></i>
                        <?= $arabic_mode ? 'تعديل الإعدادات' : 'Edit Settings' ?>
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleTheme() {
            fetch('toggle_setting.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'setting=dark_mode'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.body.className = data.dark_mode ? 'dark' : 'light';
                    const toggle = document.querySelector('.toggle-switch');
                    if (data.dark_mode) {
                        toggle.classList.add('active');
                    } else {
                        toggle.classList.remove('active');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function toggleLanguage() {
            fetch('toggle_setting.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'setting=arabic_mode'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>

</body>
</html>