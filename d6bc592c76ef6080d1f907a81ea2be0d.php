<?php $__env->startSection('title', 'Claims'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h1 class="h4 fw-bold mb-0">Claims</h1>
    <small class="text-muted">
      <?php echo e($isStaff ? 'All claims' : 'My claims'); ?>

    </small>
  </div>
  <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-sm btn-outline-secondary">
    <i class="bi bi-arrow-left"></i> Back
  </a>
</div>

  
  
  <form method="GET" action="<?php echo e(route('claims.index')); ?>" class="card shadow-sm mb-3">
    <div class="card-body row g-2 align-items-end">
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <option value="">Any</option>
          <?php $__currentLoopData = ['pending','approved','rejected','cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($s); ?>" <?php if($status === $s): echo 'selected'; endif; ?>>
              <?php echo e(ucfirst($s)); ?>

            </option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-md-8 text-end">
        <button class="btn btn-outline-primary">
          <i class="bi bi-filter"></i> Apply
        </button>
      </div>
    </div>
  </form>

  
  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Report</th>
            <th>Status</th>
            <th>Claimant</th>
            <th>Reviewed</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $claims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
              <td><?php echo e($c->id); ?></td>
              <td>
                <a href="<?php echo e(route('reports.show', $c->report_id)); ?>">
                  #<?php echo e($c->report_id); ?>

                </a>
              </td>
              <td>
                <span class="badge bg-secondary">
                  <?php echo e(ucfirst($c->status)); ?>

                </span>
              </td>
              <td><?php echo e($c->claimant->name ?? '—'); ?></td>
              <td><?php echo e($c->reviewed_at?->format('Y-m-d H:i') ?? '—'); ?></td>
              <td class="text-end">
                <a href="<?php echo e(route('claims.show', $c->id)); ?>" class="btn btn-sm btn-outline-secondary">
                  <i class="bi bi-eye"></i>
                </a>
              </td>
            </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-4">
                No claims found
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="mt-3">
    <?php echo e($claims->links()); ?>

  </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/claims/index.blade.php ENDPATH**/ ?>