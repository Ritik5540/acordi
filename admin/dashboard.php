<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<style>
    .data-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .data-table thead {
        background-color: #f8f9fa;
    }

    .data-table th {
        padding: 12px 16px;
        text-align: left;
        font-weight: 600;
        color: #555;
        border-bottom: 2px solid #dee2e6;
    }

    .data-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #dee2e6;
    }

    .data-table tbody tr:hover {
        background-color: #f8f9fa;
    }
</style>
<!-- Main Content -->
<main class="main-content">
    <!-- Quick Actions -->
    <div class="quick-actions">

        <a href="./donation-category-add.php" class="action-btn primary">
            <div class="action-icon"><i class="fas fa-hand-holding-heart"></i></div>
            <div class="action-title">New Campaign</div>
            <div class="action-desc">Create donation</div>
        </a>

        <a href="./donations.php" class="action-btn success">
            <div class="action-icon"><i class="fas fa-donate"></i></div>
            <div class="action-title">View Donations</div>
            <div class="action-desc">Donation records</div>
        </a>

        <a href="./gallery.php" class="action-btn warning">
            <div class="action-icon"><i class="fas fa-images"></i></div>
            <div class="action-title">Manage Gallery</div>
            <div class="action-desc">Upload images</div>
        </a>

        <a href="./documents.php" class="action-btn purple">
            <div class="action-icon"><i class="fas fa-file-alt"></i></div>
            <div class="action-title">Documents</div>
            <div class="action-desc">Upload documents</div>
        </a>

    </div>



    <!-- Stats Grid -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-donate"></i>
            </div>
            <div class="stat-details">
                <div class="stat-title">Total Donations</div>
                <div class="stat-value"><?= $postCount ?></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <div class="stat-title">Total Donors</div>
                <div class="stat-value"><?= $donorCount ?></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div class="stat-details">
                <div class="stat-title">Campaigns</div>
                <div class="stat-value"><?= $campaignCount ?></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-images"></i>
            </div>
            <div class="stat-details">
                <div class="stat-title">Gallery</div>
                <div class="stat-value"><?= $galleryCount ?></div>
            </div>
        </div>

    </div>
    <?php
    // Get posts with pagination
    $sql = "SELECT p.*, 
                u.name as author_name,
                GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') as categories,
                GROUP_CONCAT(DISTINCT pc.category_id) as category_ids
            FROM posts p
            LEFT JOIN users u ON p.user_id = u.id
            LEFT JOIN post_categories pc ON p.id = pc.post_id
            LEFT JOIN categories c ON pc.category_id = c.id
            GROUP BY p.id
            ORDER BY p.created_at DESC
            LIMIT 4";

    $result = $conn->query($sql);
    ?>
    <!-- Recent Blog Posts -->
    <div class="content-section">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-newspaper"></i> Recent Blog Posts
            </h3>
            <div class="section-actions">
                <a href="./blog-list.php" class="btn btn-secondary">
                    <i class="fas fa-list"></i> All Blogs
                </a>
                <a href="./post-blog.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Post
                </a>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>

                <?php if ($result->num_rows): ?>

                    <?php while ($row = $result->fetch_assoc()):
                        // Allowed status classes
                        $allowedStatus = ['published', 'draft', 'pending'];
                        $status = in_array($row['status'], $allowedStatus) ? $row['status'] : 'draft';
                    ?>

                        <tr>
                            <td><strong><?= htmlspecialchars($row['title']) ?></strong></td>
                            <td><?= htmlspecialchars($row['categories']) ?></td>
                            <td><?= htmlspecialchars($row['author_name']) ?></td>

                            <td>
                                <span class="table-badge <?= $status ?>">
                                    <?= ucfirst($status) ?>
                                </span>
                            </td>

                            <td><?= date('M d, Y', strtotime($row['created_at'])) ?></td>
                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="5" class="text-center">No posts found.</td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>
    </div>
</main>
<?php include 'layout/footer.php'; ?>
</body>

</html>