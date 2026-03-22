<?php $__env->startSection('title', 'Roles · Admin'); ?>

<?php $__env->startSection('content'); ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i> <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle"></i>
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

  
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h5 fw-bold mb-0">Roles</h1>
                <small class="text-muted">System role management</small>
            </div>
            <a href="<?php echo e(route('roles.create')); ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> New Role
            </a>
        </div>

        
        <form class="card mb-3 shadow-sm" method="GET">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input class="form-control"
                               name="q"
                               value="<?php echo e($q ?? ''); ?>"
                               placeholder="Search role name or description">
                    </div>
                    <div class="col-md-6 text-md-end">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-outline-secondary btn-sm">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>

        
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:80px">ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-end" style="width:140px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($row->id); ?></td>
                                <td class="fw-semibold"><?php echo e($row->name); ?></td>
                                <td class="text-muted"><?php echo e($row->description); ?></td>
                                <td class="text-end">
                                    <a href="<?php echo e(route('roles.edit', $row->id)); ?>"
                                       class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST"
                                          action="<?php echo e(route('roles.destroy', $row->id)); ?>"
                                          class="d-inline"
                                          data-confirm="Are you sure you want to delete this role? This action cannot be undone." data-confirm-text="Delete Role" data-confirm-danger="true">
                                        <?php echo csrf_field(); ?>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted p-4">
                                    No roles found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="mt-3">
            <?php echo e($roles->links()); ?>

        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/roles/index.blade.php ENDPATH**/ ?>