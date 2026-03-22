<?php $__env->startSection('title', 'Create User'); ?>

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
  <h1 class="h4 fw-bold mb-0">Create User</h1>
  <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('users.index')); ?>"><i class="bi bi-arrow-left"></i> Back</a>
</div>

<form method="POST" action="<?php echo e(route('users.store')); ?>" class="card shadow-sm">
  <?php echo csrf_field(); ?>
  <div class="card-body p-4">
    <div class="row g-3">
      <div class="col-12 col-md-6">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="<?php echo e(old('email')); ?>" required />
      </div>

      <div class="col-12 col-md-3">
        <label class="form-label">Active</label>
        <select class="form-select" name="is_active">
          <option value="1" <?php if(old('is_active','1')==='1'): echo 'selected'; endif; ?>>Active</option>
          <option value="0" <?php if(old('is_active')==='0'): echo 'selected'; endif; ?>>Disabled</option>
        </select>
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password" required />
      </div>
      <div class="col-12 col-md-6">
        <label class="form-label">Confirm password</label>
        <input class="form-control" type="password" name="password_confirmation" required />
      </div>

      <hr class="my-2" />

      <div class="col-12 col-md-6">
        <label class="form-label">Full name</label>
        <input class="form-control" name="full_name" value="<?php echo e(old('full_name')); ?>" required />
      </div>

      <div class="col-12 col-md-6">
        <label class="form-label">User type</label>
        <?php $ut = old('user_type', 'student'); ?>
        <select class="form-select" name="user_type" required>
          <option value="student" <?php if($ut==='student'): echo 'selected'; endif; ?>>Student</option>
          <option value="faculty" <?php if($ut==='faculty'): echo 'selected'; endif; ?>>Faculty</option>
          <option value="staff" <?php if($ut==='staff'): echo 'selected'; endif; ?>>Staff</option>
          <option value="visitor" <?php if($ut==='visitor'): echo 'selected'; endif; ?>>Visitor</option>
        </select>
      </div>

      <div class="col-12 col-md-4">
        <label class="form-label">Department ID</label>
        <input class="form-control" type="number" name="department_id" value="<?php echo e(old('department_id')); ?>" />
      </div>

      <div class="col-12 col-md-4">
        <label class="form-label">School ID number</label>
        <input class="form-control" name="school_id_number" value="<?php echo e(old('school_id_number')); ?>" />
      </div>

      <div class="col-12 col-md-4">
        <label class="form-label">Contact no</label>
        <input class="form-control" name="contact_no" value="<?php echo e(old('contact_no')); ?>" />
      </div>

      <div class="col-12">
        <label class="form-label">Roles</label>
        <div class="d-flex flex-wrap gap-2">
          <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="roles[]" value="<?php echo e($r->name); ?>" id="role_<?php echo e($r->id); ?>">
              <label class="form-check-label" for="role_<?php echo e($r->id); ?>"><?php echo e($r->name); ?></label>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>

    <div class="mt-3">
      <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
    </div>
  </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/users/create.blade.php ENDPATH**/ ?>