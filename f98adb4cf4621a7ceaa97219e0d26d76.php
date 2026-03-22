<?php $__env->startSection('title', 'Notifications'); ?>

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
    <h1 class="h4 fw-bold mb-0">Notifications</h1>
    <div class="text-muted small">Your inbox</div>
  </div>
  <div class="d-flex gap-2">
    <form method="POST" action="<?php echo e(route('notifications.read_all')); ?>">
      <?php echo csrf_field(); ?>
      <button class="btn btn-sm btn-outline-primary" type="submit"><i class="bi bi-check2-all"></i> Mark all read</button>
    </form>
  </div>
</div>

<form class="card shadow-sm mb-3" method="GET" action="<?php echo e(route('notifications.index')); ?>">
  <div class="card-body">
    <div class="row g-2 align-items-end">
      <div class="col-12 col-md-4">
        <label class="form-label mb-1">Show</label>
        <select class="form-select" name="unread">
          <option value="0" <?php if((int)$onlyUnread===0): echo 'selected'; endif; ?>>All</option>
          <option value="1" <?php if((int)$onlyUnread===1): echo 'selected'; endif; ?>>Unread only</option>
        </select>
      </div>
      <div class="col-12 col-md-8 text-md-end">
        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-filter"></i> Apply</button>
      </div>
    </div>
  </div>
</form>

<div class="card shadow-sm">
  <div class="list-group list-group-flush">
    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <div class="list-group-item">
        <div class="d-flex justify-content-between align-items-start gap-3">
          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2">
              <div class="fw-semibold"><?php echo e($n->title); ?></div>
              <?php if($n->read_at === null): ?>
                <span class="badge text-bg-warning">Unread</span>
              <?php endif; ?>
            </div>
            <div class="text-muted small"><?php echo e($n->notif_type); ?> · <?php echo e($n->created_at); ?></div>
            <div class="mt-2"><?php echo e($n->body); ?></div>
          </div>
          <div class="d-flex flex-column gap-2">
            <form method="POST" action="<?php echo e(route('notifications.read', $n->id)); ?>">
              <?php echo csrf_field(); ?>
              <button class="btn btn-sm btn-outline-primary" type="submit"><i class="bi bi-check2"></i></button>
            </form>
            <form method="POST" action="<?php echo e(route('notifications.destroy', $n->id)); ?>" onsubmit="return confirm('Delete notification?');">
              <?php echo csrf_field(); ?>
              <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="p-4 text-center text-muted">No notifications</div>
    <?php endif; ?>
  </div>
</div>

<div class="mt-3"><?php echo e($notifications->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/notifications/index.blade.php ENDPATH**/ ?>