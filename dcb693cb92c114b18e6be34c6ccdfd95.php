<?php $__env->startSection('title', 'Categories'); ?>

<?php $__env->startSection('content'); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success d-flex gap-2">
            <i class="bi bi-check-circle"></i>
            <div><?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle"></i> Please fix the errors below
        </div>
    <?php endif; ?>
  
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 fw-bold mb-0">Categories</h1>
            <div class="text-muted small">Manage categories</div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-sm btn-primary" href="<?php echo e(route('categories.create')); ?>">
                <i class="bi bi-plus-circle"></i> New
            </a>
            <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('dashboard')); ?>">
                <i class="bi bi-house"></i> Dashboard
            </a>
        </div>
    </div>

    
    <form class="card shadow-sm mb-3" method="GET">
        <div class="card-body">
            <div class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label mb-1">Search</label>
                    <input class="form-control" name="q" value="<?php echo e($q ?? ''); ?>" placeholder="Type keyword..." />
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-outline-primary"><i class="bi bi-search"></i> Filter</button>
                    <a class="btn btn-outline-secondary" href="<?php echo e(route('categories.index')); ?>">Reset</a>
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
                    <th>Name</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($row->id); ?></td>
                        <td><?php echo e($row->name); ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('categories.edit', $row->id)); ?>">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form class="d-inline" method="POST"
                                  action="<?php echo e(route('categories.destroy', $row->id)); ?>"
                                  onsubmit="return confirm('Delete this record?');">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="text-center text-muted p-4">No records</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="mt-3">
        <?php echo e($categories->links()); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/categories/index.blade.php ENDPATH**/ ?>