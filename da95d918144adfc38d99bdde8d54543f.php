<?php $__env->startSection('title', 'Users'); ?>

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
      <?php
  $roleFilter = $role ?? '';
  $activeFilter = $active ?? '';
?>

  
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h1 class="h4 fw-bold mb-0">Users</h1>
    <div class="text-muted small">Manage accounts</div>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-sm btn-primary" href="<?php echo e(route('users.create')); ?>"><i class="bi bi-plus-circle"></i> New</a>
  </div>
</div>

<form class="card shadow-sm mb-3" method="GET" action="<?php echo e(route('users.index')); ?>">
  <div class="card-body">
    <div class="row g-2 align-items-end">
      <div class="col-12 col-md-4">
        <label class="form-label mb-1">Search (email or name)</label>
        <input class="form-control" name="q" value="<?php echo e($q ?? ''); ?>" />
      </div>
      <div class="col-12 col-md-3">
        <label class="form-label mb-1">Role</label>
        <select class="form-select" name="role">
          <option value="">Any</option>
          <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($r->name); ?>" <?php if($roleFilter===$r->name): echo 'selected'; endif; ?>><?php echo e($r->name); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="col-12 col-md-3">
        <label class="form-label mb-1">Active</label>
        <select class="form-select" name="active">
          <option value="">Any</option>
          <option value="1" <?php if((string)$activeFilter==='1'): echo 'selected'; endif; ?>>Active</option>
          <option value="0" <?php if((string)$activeFilter==='0'): echo 'selected'; endif; ?>>Disabled</option>
        </select>
      </div>
      <div class="col-12 col-md-2 text-md-end">
        <button class="btn btn-outline-primary w-100" type="submit"><i class="bi bi-search"></i> Filter</button>
      </div>
    </div>
  </div>
</form>

<div class="card shadow-sm">
  <div class="table-responsive">
    <table class="table table-striped align-middle mb-0">
      <thead>
        <tr>
          <th>Avatar</th>
          <th>ID</th>
          <th>Email</th>
          <th>Name</th>
          <th>Roles</th>
          <th>Status</th>
          <th class="text-end">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td>
              <?php if(!empty($u->profile?->avatar_url)): ?>
                <img src="<?php echo e(asset($u->profile->avatar_url)); ?>" alt="Avatar"
                     class="rounded-circle" style="width:36px;height:36px;object-fit:cover">
              <?php else: ?>
                <?php $initial = strtoupper(substr($u->email,0,1)); ?>
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                     style="width:36px;height:36px;background:#e0e7ff;color:#2563eb;font-weight:700">
                  <?php echo e($initial); ?>

                </div>
              <?php endif; ?>
            </td>
            <td><?php echo e($u->id); ?></td>
            <td><?php echo e($u->email); ?></td>
            <td><?php echo e($u->profile?->full_name ?? '—'); ?></td>
            <td>
              <?php $names = $u->roles->pluck('name')->values(); ?>
              <?php if($names->count()): ?>
                <?php $__currentLoopData = $names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <span class="badge text-bg-secondary"><?php echo e($n); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
                <span class="text-muted">—</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if((int)$u->is_active===1): ?>
                <span class="badge text-bg-success">Active</span>
              <?php else: ?>
                <span class="badge text-bg-danger">Disabled</span>
              <?php endif; ?>
            </td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('users.show', $u->id)); ?>"><i class="bi bi-eye"></i></a>
              <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('users.edit', $u->id)); ?>"><i class="bi bi-pencil"></i></a>
              <form class="d-inline" method="POST" action="<?php echo e(route('users.destroy', $u->id)); ?>">
                <?php echo csrf_field(); ?>
                <button 
                  class="btn btn-sm btn-outline-danger" 
                  type="submit"
                  data-confirm="Are you sure you want to delete this user? This action cannot be undone."
                  data-confirm-text="Delete User"
                  data-confirm-danger="true"
                >
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="6" class="text-center text-muted p-4">No users</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="mt-3">
  <?php echo e($users->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/users/index.blade.php ENDPATH**/ ?>