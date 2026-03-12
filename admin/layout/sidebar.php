    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);

    function isActive($page)
    {
        global $currentPage;
        return ($currentPage == $page) ? 'active' : '';
    }
    ?>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-layer-group"></i> CMS Panel</h2>
            <p>Content Management System</p>
        </div>
        <nav class="sidebar-menu">
            <!-- Dashboard Section -->
            <div class="menu-section">
                <div class="menu-section-title">Main</div>
                <a href="./dashboard.php" class="menu-item <?= isActive('dashboard.php'); ?>">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <?php
            // ===== BLOG COUNTS =====

            // TOTAL BLOG POSTS
            $postCount = $conn->query("SELECT COUNT(*) as total FROM donations")->fetch_assoc()['total'];
            $donorCount = $conn->query("SELECT COUNT(*) as total FROM donors")->fetch_assoc()['total'];
            $campaignCount = $conn->query("SELECT COUNT(*) as total FROM donation_categories")->fetch_assoc()['total'];
            $galleryCount = $conn->query("SELECT COUNT(*) as total FROM galleries")->fetch_assoc()['total'];

            // BLOG CATEGORIES COUNT
            $blogCatSql = "SELECT COUNT(*) as total FROM categories";
            $blogCatRes = $conn->query($blogCatSql);
            $blogCatCount = $blogCatRes->fetch_assoc()['total'];

            ?>
            
            <!-- ================= DOCUMENT SECTION ================= -->
            <div class="menu-section">
                <div class="menu-section-title">Document Management</div>

                <a href="./documents.php" class="menu-item <?= isActive('documents.php'); ?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Documents</span>
                </a>
            </div>
            
            <!-- ================= Gallery SECTION ================= -->
            <div class="menu-section">
                <div class="menu-section-title">Gallery Management</div>

                <a href="./gallery.php" class="menu-item <?= isActive('gallery.php'); ?>">
                    <i class="fas fa-images"></i>
                    <span>Gallery</span>
                </a>
            </div>

            <!-- ================= DONATION SECTION ================= -->
            <div class="menu-section">
                <div class="menu-section-title">Donation Management</div>

                <a href="./donations.php" class="menu-item <?= isActive('donations.php'); ?>">
                    <i class="fas fa-donate"></i>
                    <span>Donations</span>
                    <span class="menu-badge"><?= $postCount; ?></span>
                </a>

                <a href="./donors.php" class="menu-item <?= isActive('donors.php'); ?>">
                    <i class="fas fa-users"></i>
                    <span>Donors</span>
                    <span class="menu-badge"><?= $donorCount; ?></span>
                </a>

                <a href="./donation-category-add.php" class="menu-item <?= isActive('donation-category-add.php'); ?>">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span>Donation Campaigns</span>
                    <span class="menu-badge"><?= $campaignCount; ?></span>
                </a>
            </div>

            
            <!-- ================= BLOG SECTION ================= -->
            <div class="menu-section">
                <div class="menu-section-title">Blog Management</div>

                <a href="./blog-list.php" class="menu-item <?= isActive('blog-list.php'); ?>">
                    <i class="fas fa-newspaper"></i>
                    <span>All Posts</span>
                    <span class="menu-badge"><?= $postCount; ?></span>
                </a>

                <a href="./post-blog.php" class="menu-item <?= isActive('post-blog.php'); ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span>New Post</span>
                </a>

                <a href="./categories.php" class="menu-item <?= isActive('categories.php'); ?>">
                    <i class="fas fa-folder"></i>
                    <span>Categories</span>
                    <span class="menu-badge success"><?= $blogCatCount; ?></span>
                </a>

            </div>

            <!-- Settings Section -->
            <div class="menu-section">
                <div class="menu-section-title">System</div>
                <a href="./users.php" class="menu-item <?= isActive('users.php'); ?>">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </div>
        </nav>
    </aside>