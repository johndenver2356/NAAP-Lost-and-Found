<?php $__env->startSection('title', 'Gallery · NAAP Lost & Found'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h1 class="h3 fw-bold mb-1">Lost & Found Gallery</h1>
    <p class="text-muted mb-0">Browse items reported in the campus</p>
  </div>

  <div class="d-flex gap-2">
    <a href="<?php echo e(route('gallery.index')); ?>" class="btn btn-sm <?php echo e(!request('type') ? 'btn-primary' : 'btn-outline-primary'); ?>">All</a>
    <a href="<?php echo e(route('gallery.index', ['type' => 'lost'])); ?>" class="btn btn-sm <?php echo e(request('type') === 'lost' ? 'btn-primary' : 'btn-outline-primary'); ?>">Lost</a>
    <a href="<?php echo e(route('gallery.index', ['type' => 'found'])); ?>" class="btn btn-sm <?php echo e(request('type') === 'found' ? 'btn-primary' : 'btn-outline-primary'); ?>">Found</a>
  </div>
</div>

<div class="row g-4">
  <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="col-6 col-md-4 col-lg-3">
      <div class="card h-100 shadow-sm border-0 overflow-hidden">
        <div class="ratio ratio-1x1 bg-light position-relative">
          <?php
            $firstPhoto = $report->photos->first();
            $imageSrc = null;

            if ($firstPhoto && $firstPhoto->photo_url) {
                $cleanPath = str_replace('/public/', '', $firstPhoto->photo_url);
                $cleanPath = ltrim($cleanPath, '/');
                $imageSrc = asset($cleanPath);
            }
          ?>

          <?php if($imageSrc): ?>
            <img
              src="<?php echo e($imageSrc); ?>"
              class="object-fit-cover w-100 h-100"
              alt="<?php echo e($report->item_name); ?>"
              style="cursor: pointer;"
              onclick="viewImage(this.src)"
            >
          <?php else: ?>
            <div class="d-flex align-items-center justify-content-center text-muted w-100 h-100">
              <i class="bi bi-image fs-1 opacity-25"></i>
            </div>
          <?php endif; ?>

          <div class="position-absolute top-0 end-0 p-2">
            <span class="badge <?php echo e($report->report_type === 'lost' ? 'bg-danger' : 'bg-success'); ?>">
              <?php echo e(ucfirst($report->report_type)); ?>

            </span>
          </div>
        </div>

        <div class="card-body p-3">
          <h5 class="card-title h6 mb-1 text-truncate"><?php echo e($report->item_name ?? 'Unnamed Item'); ?></h5>
          <div class="small text-muted mb-2">
            <i class="bi bi-calendar"></i> <?php echo e($report->created_at->format('M d, Y')); ?>

          </div>

          <?php if($report->report_type === 'found'): ?>
            <a href="<?php echo e(route('claims.create', $report->id)); ?>" class="btn btn-sm btn-outline-primary w-100 mt-2">
              <i class="bi bi-hand-index-thumb"></i> Claim This
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="col-12 text-center py-5">
      <div class="text-muted fs-5">No items found matching your criteria</div>
    </div>
  <?php endif; ?>
</div>

<div class="mt-4">
  <?php echo e($reports->links()); ?>

</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body p-0 text-center position-relative">
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
        <img src="" id="modalImage" class="img-fluid rounded shadow-lg" style="max-height: 85vh;">
      </div>
    </div>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function viewImage(src) {
        document.getElementById('modalImage').src = src;
        new bootstrap.Modal(document.getElementById('imageModal')).show();
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/gallery/index.blade.php ENDPATH**/ ?>