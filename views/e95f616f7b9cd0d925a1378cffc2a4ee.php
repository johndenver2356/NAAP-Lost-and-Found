<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php
  $roleNames = auth()->check() ? auth()->user()->roles()->pluck('name')->toArray() : [];
  $isStaff = in_array('admin', $roleNames, true) || in_array('osa', $roleNames, true);
  $initial = strtoupper(substr($user->email,0,1));
?>

<!-- Welcome Header -->
<div class="dashboard-header">
  <div class="dashboard-welcome">
    <div class="dashboard-avatar">
      <?php if($user->profile && $user->profile->avatar_url): ?>
        <img src="<?php echo e(asset($user->profile->avatar_url)); ?>" alt="<?php echo e($user->profile->full_name ?? 'User'); ?>">
      <?php else: ?>
        <span class="dashboard-avatar-initial"><?php echo e($initial); ?></span>
      <?php endif; ?>
    </div>
    <div class="dashboard-welcome-text">
      <h1 class="dashboard-title">Welcome back, <?php echo e($user->profile->full_name ?? 'User'); ?></h1>
      <p class="dashboard-subtitle">Here's what's happening with your lost and found items</p>
    </div>
  </div>
  <div class="dashboard-actions">
    <a class="btn btn-primary" href="<?php echo e(route('reports.create')); ?>">
      <i class="bi bi-plus-lg"></i> New Report
    </a>
  </div>
</div>

<!-- Stats Cards -->
<div class="dashboard-stats">
  <div class="stat-card">
    <div class="stat-icon stat-icon-primary">
      <i class="bi bi-file-earmark-text-fill"></i>
    </div>
    <div class="stat-content">
      <div class="stat-label">My Reports</div>
      <div class="stat-value"><?php echo e($stats['my_reports']); ?></div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-icon stat-icon-success">
      <i class="bi bi-person-check-fill"></i>
    </div>
    <div class="stat-content">
      <div class="stat-label">My Claims</div>
      <div class="stat-value"><?php echo e($stats['my_claims']); ?></div>
    </div>
  </div>

  <?php if($isStaff): ?>
    <div class="stat-card">
      <div class="stat-icon stat-icon-warning">
        <i class="bi bi-hourglass-split"></i>
      </div>
      <div class="stat-content">
        <div class="stat-label">Pending Reports</div>
        <div class="stat-value"><?php echo e($stats['pending_reports']); ?></div>
      </div>
    </div>

    <div class="stat-card">
      <div class="stat-icon stat-icon-info">
        <i class="bi bi-diagram-2-fill"></i>
      </div>
      <div class="stat-content">
        <div class="stat-label">Suggested Matches</div>
        <div class="stat-value"><?php echo e($stats['suggested_matches']); ?></div>
      </div>
    </div>
  <?php endif; ?>
</div>

<!-- Quick Actions -->
<div class="dashboard-section">
  <h2 class="section-heading">Quick Actions</h2>
  <div class="quick-actions-grid">
    <a href="<?php echo e(route('reports.create')); ?>" class="quick-action-card">
      <div class="quick-action-icon">
        <i class="bi bi-plus-circle-fill"></i>
      </div>
      <div class="quick-action-title">New Report</div>
      <div class="quick-action-desc">Submit lost/found item</div>
    </a>

    <a href="<?php echo e(route('reports.index')); ?>" class="quick-action-card">
      <div class="quick-action-icon">
        <i class="bi bi-inbox-fill"></i>
      </div>
      <div class="quick-action-title">View Reports</div>
      <div class="quick-action-desc">Browse all reports</div>
    </a>

    <a href="<?php echo e(route('claims.index')); ?>" class="quick-action-card">
      <div class="quick-action-icon">
        <i class="bi bi-person-check-fill"></i>
      </div>
      <div class="quick-action-title">My Claims</div>
      <div class="quick-action-desc">Track your claims</div>
    </a>

    <a href="<?php echo e(route('notifications.index')); ?>" class="quick-action-card">
      <div class="quick-action-icon">
        <i class="bi bi-bell-fill"></i>
      </div>
      <div class="quick-action-title">Notifications</div>
      <div class="quick-action-desc">View updates</div>
    </a>
  </div>
</div>

<!-- Recent Activity Section -->
<div class="dashboard-grid">
  <div class="dashboard-card">
    <div class="dashboard-card-header">
      <h3 class="dashboard-card-title">
        <i class="bi bi-clock-history"></i> My Recent Reports
      </h3>
    </div>
    <div class="dashboard-card-body">
      <?php if($recentReports->isEmpty()): ?>
        <div class="empty-state-simple">
          <i class="bi bi-inbox"></i>
          <p>No reports yet</p>
        </div>
      <?php else: ?>
        <div class="activity-list">
          <?php $__currentLoopData = $recentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('reports.show', $report->id)); ?>" class="activity-list-item">
              <div class="activity-list-content">
                <div class="activity-list-badges">
                  <span class="badge badge-<?php echo e($report->report_type === 'lost' ? 'warning' : 'success'); ?>">
                    <?php echo e(ucfirst($report->report_type)); ?>

                  </span>
                  <span class="badge badge-outline"><?php echo e($report->status); ?></span>
                </div>
                <div class="activity-list-title"><?php echo e(Str::limit($report->item_name, 40)); ?></div>
                <div class="activity-list-meta">
                  <span><i class="bi bi-tag"></i> <?php echo e($report->category->name ?? 'N/A'); ?></span>
                  <span><i class="bi bi-geo-alt"></i> <?php echo e($report->location->name ?? 'N/A'); ?></span>
                </div>
              </div>
              <div class="activity-list-time">
                <?php echo e($report->created_at->diffForHumans()); ?>

              </div>
            </a>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="dashboard-card-footer">
          <a href="<?php echo e(route('reports.index')); ?>" class="btn-link">
            View All Reports <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <?php if($isStaff): ?>
    <div class="dashboard-card">
      <div class="dashboard-card-header">
        <h3 class="dashboard-card-title">
          <i class="bi bi-activity"></i> Recent Activity
        </h3>
      </div>
      <div class="dashboard-card-body">
        <?php if($recentActivity->isEmpty()): ?>
          <div class="empty-state-simple">
            <i class="bi bi-activity"></i>
            <p>No recent activity</p>
          </div>
        <?php else: ?>
          <div class="activity-list">
            <?php $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <a href="<?php echo e(route('reports.show', $activity->id)); ?>" class="activity-list-item">
                <div class="activity-list-content">
                  <div class="activity-list-badges">
                    <span class="badge badge-<?php echo e($activity->report_type === 'lost' ? 'warning' : 'success'); ?>">
                      <?php echo e(ucfirst($activity->report_type)); ?>

                    </span>
                    <span class="badge badge-outline"><?php echo e($activity->status); ?></span>
                  </div>
                  <div class="activity-list-title"><?php echo e(Str::limit($activity->item_name, 35)); ?></div>
                  <div class="activity-list-meta">
                    <span><i class="bi bi-person"></i> <?php echo e($activity->reporter->email ?? 'Unknown'); ?></span>
                  </div>
                </div>
                <div class="activity-list-time">
                  <?php echo e($activity->created_at->diffForHumans()); ?>

                </div>
              </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <div class="dashboard-card-footer">
            <a href="<?php echo e(route('reports.index')); ?>" class="btn-link">
              View All Activity <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php else: ?>
    <div class="dashboard-card">
      <div class="dashboard-card-header">
        <h3 class="dashboard-card-title">
          <i class="bi bi-lightbulb"></i> Getting Started
        </h3>
      </div>
      <div class="dashboard-card-body">
        <div class="guide-steps">
          <div class="guide-step">
            <div class="guide-step-number">1</div>
            <div class="guide-step-content">
              <div class="guide-step-title">Report Lost or Found Items</div>
              <div class="guide-step-desc">Submit a report when you lose or find an item on campus</div>
            </div>
          </div>
          <div class="guide-step">
            <div class="guide-step-number">2</div>
            <div class="guide-step-content">
              <div class="guide-step-title">AI-Powered Matching</div>
              <div class="guide-step-desc">Our system automatically matches lost and found items using AI</div>
            </div>
          </div>
          <div class="guide-step">
            <div class="guide-step-number">3</div>
            <div class="guide-step-content">
              <div class="guide-step-title">Claim Your Items</div>
              <div class="guide-step-desc">Get notified when matches are found and claim your items</div>
            </div>
          </div>
          <div class="guide-step">
            <div class="guide-step-number">4</div>
            <div class="guide-step-content">
              <div class="guide-step-title">Track Progress</div>
              <div class="guide-step-desc">Monitor the status of your reports and claims in real-time</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
 
<?php if($isStaff): ?>
<?php
  $total = (int) ($stats['total_reports'] ?? 0);
  $rs = $stats['report_status'] ?? [];
  $rt = $stats['report_type'] ?? [];
  $ms = $stats['match_status'] ?? [];
  $pct = function ($n, $d) { $d = max(1,(int)$d); return (int) round(($n/$d)*100); };

  $lostCnt = (int) ($rt['lost'] ?? 0);
  $foundCnt = (int) ($rt['found'] ?? 0);
  $sumType = max(1, $lostCnt + $foundCnt);
  $radius = 52;
  $circ = 2 * pi() * $radius;
  $lostLen = (int) round($circ * $lostCnt / $sumType);
  $foundLen = (int) round($circ * $foundCnt / $sumType);

  $sugCnt = (int) ($ms['suggested'] ?? 0);
  $conCnt = (int) ($ms['confirmed'] ?? 0);
  $rejCnt = (int) ($ms['rejected'] ?? 0);
  $sumMatch = max(1, $sugCnt + $conCnt + $rejCnt);
  $sugLen = (int) round($circ * $sugCnt / $sumMatch);
  $conLen = (int) round($circ * $conCnt / $sumMatch);
  $rejLen = (int) round($circ * $rejCnt / $sumMatch);

  $maxStatus = max(1, (int) max($rs['pending'] ?? 0, $rs['matched'] ?? 0, $rs['claimed'] ?? 0, $rs['returned'] ?? 0, $rs['archived'] ?? 0));
  $barMax = 240;
?>

<div class="glass-card p-3 p-md-4 mt-4">
  <div class="section-title text-center mb-4">
    <i class="bi bi-graph-up"></i> Analytics Overview
  </div>

  <div class="row g-3">
    <div class="col-12 col-lg-3">
      <div class="card">
        <div class="card-body text-center">
          <div class="mini">Total Users</div>
          <div class="h3 fw-bold mb-2"><?php echo e($stats['total_users'] ?? 0); ?></div>
          <span class="chip chip-primary"><i class="bi bi-people"></i> Users</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-3">
      <div class="card">
        <div class="card-body text-center">
          <div class="mini">Total Reports</div>
          <div class="h3 fw-bold mb-2"><?php echo e($total); ?></div>
          <span class="chip chip-primary"><i class="bi bi-files"></i> Reports</span>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="mini mb-2">Reports by Type</div>
          <div class="d-flex align-items-center justify-content-center gap-3">
            <svg width="140" height="140" viewBox="0 0 120 120">
              <g transform="rotate(-90 60 60)">
                <circle cx="60" cy="60" r="<?php echo e($radius); ?>" fill="none" stroke="#f5f5f5" stroke-width="18"></circle>
                <circle cx="60" cy="60" r="<?php echo e($radius); ?>" fill="none" stroke="#f59e0b" stroke-width="18"
                        stroke-dasharray="<?php echo e($lostLen); ?> <?php echo e($circ - $lostLen); ?>" stroke-dashoffset="0"
                        stroke-linecap="round"></circle>
                <circle cx="60" cy="60" r="<?php echo e($radius); ?>" fill="none" stroke="#10b981" stroke-width="18"
                        stroke-dasharray="<?php echo e($foundLen); ?> <?php echo e($circ - $foundLen); ?>" stroke-dashoffset="-<?php echo e($lostLen); ?>"
                        stroke-linecap="round"></circle>
              </g>
              <text x="60" y="64" text-anchor="middle" font-size="14" fill="#737373">Total</text>
              <text x="60" y="84" text-anchor="middle" font-size="18" font-weight="700" fill="#000000"><?php echo e($sumType); ?></text>
            </svg>
            <div class="d-flex flex-column gap-2">
              <span class="chip chip-warning"><i class="bi bi-exclamation-circle"></i> Lost: <?php echo e($lostCnt); ?></span>
              <span class="chip chip-success"><i class="bi bi-check-circle"></i> Found: <?php echo e($foundCnt); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="mini mb-2">Reports by Status</div>
          <svg width="100%" height="140" viewBox="0 0 300 140">
            <?php
              $labels = ['pending','matched','claimed','returned','archived'];
              $y = 18;
            ?>
            <?php $__currentLoopData = $labels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php
                $count = (int) ($rs[$s] ?? 0);
                $wpx = (int) round($barMax * $count / $maxStatus);
              ?>
              <text x="0" y="<?php echo e($y-6); ?>" fill="#737373" font-size="10" style="text-transform:uppercase"><?php echo e($s); ?></text>
              <rect x="90" y="<?php echo e($y-14); ?>" width="<?php echo e($barMax); ?>" height="12" rx="6" fill="#f5f5f5"></rect>
              <rect x="90" y="<?php echo e($y-14); ?>" width="<?php echo e($wpx); ?>" height="12" rx="6" fill="#000000"></rect>
              <text x="<?php echo e(90 + $barMax + 8); ?>" y="<?php echo e($y-3); ?>" fill="#737373" font-size="11"><?php echo e($count); ?></text>
              <?php $y += 26; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </svg>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="mini mb-2">Matches</div>
          <div class="d-flex align-items-center justify-content-center gap-3">
            <svg width="140" height="140" viewBox="0 0 120 120">
              <g transform="rotate(-90 60 60)">
                <circle cx="60" cy="60" r="<?php echo e($radius); ?>" fill="none" stroke="#f5f5f5" stroke-width="18"></circle>
                <circle cx="60" cy="60" r="<?php echo e($radius); ?>" fill="none" stroke="#f59e0b" stroke-width="18"
                        stroke-dasharray="<?php echo e($sugLen); ?> <?php echo e($circ - $sugLen); ?>" stroke-dashoffset="0" stroke-linecap="round"></circle>
                <circle cx="60" cy="60" r="<?php echo e($radius); ?>" fill="none" stroke="#10b981" stroke-width="18"
                        stroke-dasharray="<?php echo e($conLen); ?> <?php echo e($circ - $conLen); ?>" stroke-dashoffset="-<?php echo e($sugLen); ?>" stroke-linecap="round"></circle>
                <circle cx="60" cy="60" r="<?php echo e($radius); ?>" fill="none" stroke="#ef4444" stroke-width="18"
                        stroke-dasharray="<?php echo e($rejLen); ?> <?php echo e($circ - $rejLen); ?>" stroke-dashoffset="-<?php echo e($sugLen + $conLen); ?>" stroke-linecap="round"></circle>
              </g>
              <text x="60" y="64" text-anchor="middle" font-size="14" fill="#737373">Total</text>
              <text x="60" y="84" text-anchor="middle" font-size="18" font-weight="700" fill="#000000"><?php echo e($sumMatch); ?></text>
            </svg>
            <div class="d-flex flex-column gap-2">
              <span class="chip chip-warning"><i class="bi bi-lightbulb"></i> Suggested: <?php echo e($sugCnt); ?></span>
              <span class="chip chip-success"><i class="bi bi-check2-circle"></i> Confirmed: <?php echo e($conCnt); ?></span>
              <span class="chip chip-danger"><i class="bi bi-x-circle"></i> Rejected: <?php echo e($rejCnt); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('styles'); ?>
<style>
/* ============================================
   MODERN DASHBOARD STYLES
   ============================================ */

/* Dashboard Header */
.dashboard-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: var(--space-xl);
  margin-bottom: var(--space-2xl);
  flex-wrap: wrap;
}

.dashboard-welcome {
  display: flex;
  align-items: center;
  gap: var(--space-lg);
}

.dashboard-avatar {
  width: 64px;
  height: 64px;
  border-radius: var(--radius-lg);
  background: #0041C7;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: var(--text-2xl);
  font-weight: 700;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(0, 65, 199, 0.2);
  overflow: hidden;
}

.dashboard-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.dashboard-avatar-initial {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
}

.dashboard-welcome-text {
  flex: 1;
}

.dashboard-title {
  font-size: var(--text-2xl);
  font-weight: 700;
  color: var(--text-primary);
  margin: 0 0 var(--space-xs) 0;
  line-height: 1.2;
}

.dashboard-subtitle {
  font-size: var(--text-base);
  color: var(--text-secondary);
  margin: 0;
}

.dashboard-actions {
  display: flex;
  gap: var(--space-sm);
}

/* Stats Cards */
.dashboard-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: var(--space-lg);
  margin-bottom: var(--space-2xl);
}

.stat-card {
  background: white;
  border: 1px solid var(--border-default);
  border-radius: var(--radius-lg);
  padding: var(--space-xl);
  display: flex;
  align-items: center;
  gap: var(--space-lg);
  transition: all var(--transition-fast);
}

.stat-card:hover {
  border-color: var(--border-strong);
  box-shadow: var(--shadow-md);
  transform: translateY(-2px);
}

.stat-icon {
  width: 56px;
  height: 56px;
  border-radius: var(--radius-md);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  flex-shrink: 0;
}

.stat-icon-primary {
  background: linear-gradient(135deg, rgba(58, 203, 235, 0.1) 0%, rgba(0, 65, 199, 0.1) 100%);
  color: #0041C7;
}

.stat-icon-success {
  background: rgba(16, 185, 129, 0.1);
  color: var(--success);
}

.stat-icon-warning {
  background: rgba(245, 158, 11, 0.1);
  color: var(--warning);
}

.stat-icon-info {
  background: rgba(13, 133, 216, 0.1);
  color: var(--info);
}

.stat-content {
  flex: 1;
}

.stat-label {
  font-size: var(--text-sm);
  color: var(--text-muted);
  margin-bottom: var(--space-xs);
}

.stat-value {
  font-size: var(--text-4xl);
  font-weight: 700;
  color: var(--text-primary);
  line-height: 1;
}

/* Dashboard Sections */
.dashboard-section {
  margin-bottom: var(--space-3xl);
}

.section-heading {
  font-size: var(--text-xl);
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: var(--space-lg);
  display: flex;
  align-items: center;
  gap: var(--space-sm);
}

/* Quick Actions Grid */
.quick-actions-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: var(--space-lg);
}

.quick-action-card {
  background: white;
  border: 1px solid var(--border-default);
  border-radius: var(--radius-lg);
  padding: var(--space-xl);
  text-align: center;
  text-decoration: none;
  transition: all var(--transition-fast);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--space-md);
}

.quick-action-card:hover {
  border-color: #0041C7;
  box-shadow: 0 8px 24px rgba(0, 65, 199, 0.15);
  transform: translateY(-4px);
}

.quick-action-icon {
  width: 64px;
  height: 64px;
  border-radius: var(--radius-md);
  background: linear-gradient(135deg, rgba(58, 203, 235, 0.1) 0%, rgba(0, 65, 199, 0.1) 100%);
  color: #0041C7;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.75rem;
  transition: all var(--transition-fast);
}

.quick-action-card:hover .quick-action-icon {
  background: #0041C7;
  color: white;
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(0, 65, 199, 0.3);
}

.quick-action-title {
  font-size: var(--text-base);
  font-weight: 600;
  color: var(--text-primary);
}

.quick-action-desc {
  font-size: var(--text-sm);
  color: var(--text-muted);
}

/* Dashboard Grid */
.dashboard-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: var(--space-lg);
}

/* Dashboard Cards */
.dashboard-card {
  background: white;
  border: 1px solid var(--border-default);
  border-radius: var(--radius-lg);
  overflow: hidden;
}

.dashboard-card-header {
  padding: var(--space-lg) var(--space-xl);
  border-bottom: 1px solid var(--border-default);
  background: var(--bg-secondary);
}

.dashboard-card-title {
  font-size: var(--text-lg);
  font-weight: 600;
  color: var(--text-primary);
  margin: 0;
  display: flex;
  align-items: center;
  gap: var(--space-sm);
}

.dashboard-card-title i {
  color: var(--text-secondary);
}

.dashboard-card-body {
  padding: var(--space-xl);
}

.dashboard-card-footer {
  padding: var(--space-lg) var(--space-xl);
  border-top: 1px solid var(--border-default);
  text-align: center;
}

/* Activity List */
.activity-list {
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
}

.activity-list-item {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: var(--space-lg);
  padding: var(--space-md);
  border-radius: var(--radius-md);
  text-decoration: none;
  transition: all var(--transition-fast);
  border: 1px solid transparent;
}

.activity-list-item:hover {
  background: var(--bg-hover);
  border-color: var(--border-default);
}

.activity-list-content {
  flex: 1;
}

.activity-list-badges {
  display: flex;
  align-items: center;
  gap: var(--space-sm);
  margin-bottom: var(--space-sm);
}

.activity-list-title {
  font-size: var(--text-base);
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: var(--space-xs);
}

.activity-list-meta {
  font-size: var(--text-sm);
  color: var(--text-muted);
  display: flex;
  align-items: center;
  gap: var(--space-md);
  flex-wrap: wrap;
}

.activity-list-meta i {
  margin-right: 0.25rem;
}

.activity-list-time {
  font-size: var(--text-sm);
  color: var(--text-muted);
  white-space: nowrap;
}

/* Empty State */
.empty-state-simple {
  text-align: center;
  padding: var(--space-3xl) var(--space-xl);
}

.empty-state-simple i {
  font-size: 3rem;
  color: var(--text-muted);
  opacity: 0.3;
  margin-bottom: var(--space-lg);
  display: block;
}

.empty-state-simple .btn i {
  font-size: 1.125rem;
}

.empty-state-simple p {
  font-size: var(--text-base);
  color: var(--text-muted);
  margin-bottom: var(--space-lg);
}

/* Guide Steps */
.guide-steps {
  display: flex;
  flex-direction: column;
  gap: var(--space-xl);
}

.guide-step {
  display: flex;
  align-items: flex-start;
  gap: var(--space-lg);
}

.guide-step-number {
  width: 44px;
  height: 44px;
  border-radius: var(--radius-md);
  border: 2px solid #0041C7;
  background: transparent;
  color: #0041C7;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: var(--text-lg);
  font-weight: 700;
  flex-shrink: 0;
}

.guide-step-content {
  flex: 1;
}

.guide-step-title {
  font-size: var(--text-base);
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: var(--space-xs);
}

.guide-step-desc {
  font-size: var(--text-sm);
  color: var(--text-secondary);
}

/* Analytics Grid */
.analytics-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: var(--space-lg);
}

.analytics-card {
  background: white;
  border: 1px solid var(--border-default);
  border-radius: var(--radius-lg);
  overflow: hidden;
}

.analytics-card-wide {
  grid-column: span 2;
}

.analytics-card-body {
  padding: var(--space-xl);
}

.analytics-label {
  font-size: var(--text-sm);
  color: var(--text-muted);
  margin-bottom: var(--space-md);
  font-weight: 600;
}

.analytics-value {
  font-size: var(--text-4xl);
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: var(--space-md);
  line-height: 1;
}

.chart-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: var(--space-xl);
}

.chart-legend {
  display: flex;
  flex-direction: column;
  gap: var(--space-sm);
}

/* Badge Styles */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 0.375rem;
  padding: 0.375rem 0.75rem;
  border-radius: var(--radius-full);
  font-size: var(--text-xs);
  font-weight: 600;
  line-height: 1;
}

.badge-primary {
  background: linear-gradient(135deg, rgba(58, 203, 235, 0.15) 0%, rgba(0, 65, 199, 0.15) 100%);
  color: #0041C7;
}

.badge-success {
  background: rgba(16, 185, 129, 0.1);
  color: var(--success);
}

.badge-warning {
  background: rgba(245, 158, 11, 0.1);
  color: var(--warning);
}

.badge-danger {
  background: rgba(239, 68, 68, 0.1);
  color: var(--danger);
}

.badge-outline {
  background: transparent;
  border: 1px solid var(--border-default);
  color: var(--text-secondary);
}

/* Link Button */
.btn-link {
  display: inline-flex;
  align-items: center;
  gap: var(--space-xs);
  color: #0041C7;
  text-decoration: none;
  font-size: var(--text-sm);
  font-weight: 600;
  transition: all var(--transition-fast);
}

.btn-link:hover {
  color: #0160C9;
  gap: var(--space-sm);
}

/* Responsive */
@media (max-width: 768px) {
  .dashboard-header {
    flex-direction: column;
    align-items: flex-start;
  }

  .dashboard-welcome {
    width: 100%;
  }

  .dashboard-actions {
    width: 100%;
  }

  .dashboard-actions .btn {
    flex: 1;
  }

  .dashboard-grid {
    grid-template-columns: 1fr;
  }

  .analytics-card-wide {
    grid-column: span 1;
  }

  .quick-actions-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .chart-container {
    flex-direction: column;
  }
}

@media (max-width: 480px) {
  .quick-actions-grid {
    grid-template-columns: 1fr;
  }

  .dashboard-stats {
    grid-template-columns: 1fr;
  }
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/dashboard.blade.php ENDPATH**/ ?>