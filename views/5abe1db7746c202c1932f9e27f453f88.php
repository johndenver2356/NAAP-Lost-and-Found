<!doctype html>
<html lang="en">
<head>
  <title><?php echo $__env->yieldContent('title', 'NAAP Lost & Found'); ?></title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="<?php echo e(asset('css/white-black-theme.css')); ?>" rel="stylesheet" />
  
<!-- Favicon -->
<link rel="icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="<?php echo e(asset('images/naap-logo.ico')); ?>" sizes="180x180" />
<meta name="theme-color" content="#0041C7" />
  
  <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="has-navbar">

<?php if(auth()->guard()->check()): ?>
  <?php echo $__env->make('components.layout.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php echo $__env->make('components.layout.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<!-- Confirmation Modal -->
<?php echo $__env->make('components.confirmation-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<main class="content-wrap">
  <div class="container py-4">
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

    <?php echo $__env->yieldContent('content'); ?>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/layouts/app.blade.php ENDPATH**/ ?>