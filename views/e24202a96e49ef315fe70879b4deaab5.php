<?php $__env->startSection('title', 'Matches'); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
  <div class="alert alert-success d-flex align-items-start gap-2" role="alert">
    <i class="bi bi-check-circle"></i>
    <div><?php echo e(session('success')); ?></div>
  </div>
<?php endif; ?>

<?php if($errors->any()): ?>
  <div class="alert alert-danger" role="alert">
    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle"></i> Please fix the errors below</div>
    <ul class="mb-0">
      <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($e); ?></li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>
<?php endif; ?>

  
      <div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h1 class="h4 fw-bold mb-0">Matches</h1>
    <div class="text-muted small">Suggested / Confirmed / Rejected</div>
  </div>
  <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('dashboard')); ?>"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<form class="card shadow-sm mb-3" method="GET" action="<?php echo e(route('matches.index')); ?>">
  <div class="card-body">
    <div class="row g-2 align-items-end">
      <div class="col-12 col-md-4">
        <label class="form-label mb-1">Status</label>
        <select class="form-select" name="status">
          <option value="suggested" <?php if(($status ?? '')==='suggested'): echo 'selected'; endif; ?>>Suggested</option>
          <option value="confirmed" <?php if(($status ?? '')==='confirmed'): echo 'selected'; endif; ?>>Confirmed</option>
          <option value="rejected" <?php if(($status ?? '')==='rejected'): echo 'selected'; endif; ?>>Rejected</option>
        </select>
      </div>
      <div class="col-12 col-md-8 text-md-end">
        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-filter"></i> Apply</button>
      </div>
    </div>
  </div>
</form>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-striped align-middle mb-0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Lost</th>
          <th>Found</th>
          <th>Score</th>
          <th>Method</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><?php echo e($m->id); ?></td>
            <td><a href="<?php echo e(route('reports.show', $m->lost_report_id)); ?>">#<?php echo e($m->lost_report_id); ?></a></td>
            <td><a href="<?php echo e(route('reports.show', $m->found_report_id)); ?>">#<?php echo e($m->found_report_id); ?></a></td>
            <td><span class="badge text-bg-primary"><?php echo e($m->score); ?></span></td>
            <td><?php echo e($m->method); ?></td>
            <td><span class="badge text-bg-secondary"><?php echo e($m->status); ?></span></td>
            <td class="text-end">
              <?php if(($status ?? '')==='suggested'): ?>
                <form class="d-inline" method="POST" action="<?php echo e(route('matches.confirm', $m->id)); ?>" onsubmit="return confirm('Confirm this match?');">
                  <?php echo csrf_field(); ?>
                  <button class="btn btn-sm btn-outline-success" type="submit"><i class="bi bi-check2"></i></button>
                </form>

                <form class="d-inline" method="POST" action="<?php echo e(route('matches.reject', $m->id)); ?>" onsubmit="return confirm('Reject this match?');">
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="note" value="" />
                  <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-x-lg"></i></button>
                </form>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="7" class="text-center text-muted p-4">No matches</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3"><?php echo e($matches->links()); ?></div>

<div class="card shadow-sm mt-4">
  <div class="card-body">
    <h2 class="h6 fw-bold">Manual Match (Suggested)</h2>
    <form method="POST" action="<?php echo e(route('matches.manual')); ?>" class="row g-2 align-items-end">
      <?php echo csrf_field(); ?>
      <div class="col-12 col-md-3">
        <label class="form-label mb-1">Lost report id</label>
        <input class="form-control" type="number" name="lost_report_id" required />
      </div>
      <div class="col-12 col-md-3">
        <label class="form-label mb-1">Found report id</label>
        <input class="form-control" type="number" name="found_report_id" required />
      </div>
      <div class="col-12 col-md-2">
        <label class="form-label mb-1">Score</label>
        <input class="form-control" type="number" step="0.01" name="score" required />
      </div>
      <div class="col-12 col-md-2">
        <label class="form-label mb-1">Method</label>
        <select class="form-select" name="method" required>
          <option value="manual">manual</option>
          <option value="keyword">keyword</option>
          <option value="nlp">nlp</option>
        </select>
      </div>
      <div class="col-12 col-md-2">
        <button class="btn btn-outline-primary w-100" type="submit"><i class="bi bi-plus-circle"></i> Save</button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/matches/index.blade.php ENDPATH**/ ?>