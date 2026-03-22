<?php $__env->startSection('title', 'Report #<?php echo e($report->id); ?> · NAAP Lost & Found'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-start mb-3">
  <div>
    <h1 class="h4 fw-bold mb-1">Report #<?php echo e($report->id); ?></h1>
    <div class="d-flex gap-2 align-items-center flex-wrap">
      <span class="badge badge-status text-bg-<?php echo e($statusColor ?? 'secondary'); ?>"><?php echo e(strtoupper($report->status)); ?></span>
      <span class="badge text-bg-<?php echo e($report->report_type==='lost'?'warning':'info'); ?>"><?php echo e(strtoupper($report->report_type)); ?></span>
      <span class="text-muted small">System-managed status</span>
    </div>
  </div>

  <div class="d-flex gap-2">
    <?php if($isStaff || $isOwner): ?>
      <a class="btn btn-sm btn-outline-primary" href="<?php echo e(route('reports.edit',$report->id)); ?>">
        <i class="bi bi-pencil"></i> Edit
      </a>
    <?php endif; ?>

    <a class="btn btn-sm btn-outline-secondary" href="<?php echo e(route('reports.index')); ?>">
      <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>
</div>

<div class="row g-3">


<div class="col-lg-7">

  
  <div class="glass-card p-3">
    <div class="section-title"><i class="bi bi-box-seam"></i> Item Details</div>

    <div class="row g-2">
      <div class="col-md-6">
        <div class="meta-label">Item</div>
        <div class="meta-value"><?php echo e($report->item_name ?? '—'); ?></div>
      </div>
      <div class="col-md-6">
        <div class="meta-label">Category</div>
        <div class="meta-value"><?php echo e($report->category?->name ?? '—'); ?></div>
      </div>
      <div class="col-md-6">
        <div class="meta-label">Brand / Model</div>
        <div class="meta-value"><?php echo e($report->brand_model ?? '—'); ?></div>
      </div>
      <div class="col-md-6">
        <div class="meta-label">Color</div>
        <div class="meta-value"><?php echo e($report->color ?? '—'); ?></div>
      </div>
      <div class="col-md-6">
        <div class="meta-label">Incident Date</div>
        <div class="meta-value"><?php echo e($report->incident_date ?? '—'); ?></div>
      </div>
      <div class="col-md-6">
        <div class="meta-label">Location</div>
        <div class="meta-value"><?php echo e($report->location?->name ?? '—'); ?></div>
      </div>
    </div>

    <hr>

    <div class="meta-label">Description</div>
    <div><?php echo e($report->item_description); ?></div>

    <?php if($report->circumstances): ?>
      <div class="meta-label mt-3">Circumstances</div>
      <div><?php echo e($report->circumstances); ?></div>
    <?php endif; ?>

    <?php if($report->contact_override): ?>
      <div class="meta-label mt-3">Contact</div>
      <div><?php echo e($report->contact_override); ?></div>
    <?php endif; ?>
  </div>

  
  <div class="glass-card p-3 mt-3">
    <div class="section-title"><i class="bi bi-images"></i> Photos</div>

    <?php if($report->photos->count()): ?>
      <div class="row g-2">
        <?php $__currentLoopData = $report->photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-6 col-md-3">
<img 
    src="<?php echo e(asset(ltrim(str_replace('/public/', '', $p->photo_url), '/'))); ?>"
    alt="<?php echo e($report->item_name); ?>"
>

          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php else: ?>
      <div class="text-muted">No photos uploaded</div>
    <?php endif; ?>
  </div>

  
  <?php if($isStaff && !empty($report->ai_analysis)): ?>
    <div class="glass-card p-3 mt-3 border-info">
      <div class="section-title text-info"><i class="bi bi-cpu"></i> AI Analysis</div>
      
      <?php $ai = $report->ai_analysis; ?>

      <div class="row g-2">
        <div class="col-md-6">
          <div class="meta-label">Detected Color</div>
          <div class="meta-value"><?php echo e($ai['color'] ?? '—'); ?></div>
        </div>
        <div class="col-md-6">
          <div class="meta-label">Detected Brand</div>
          <div class="meta-value"><?php echo e($ai['brand'] ?? '—'); ?></div>
        </div>
        <div class="col-12">
          <div class="meta-label">Keywords</div>
          <div>
            <?php $__currentLoopData = $ai['keywords'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <span class="badge bg-secondary opacity-75"><?php echo e($k); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
        <?php if(!empty($ai['distinct_features'])): ?>
        <div class="col-12">
          <div class="meta-label">Distinct Features</div>
          <div class="small text-muted"><?php echo e($ai['distinct_features']); ?></div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

</div>


<div class="col-lg-5">

  
  <div class="glass-card p-3">
    <div class="section-title"><i class="bi bi-activity"></i> Status</div>

    <p class="mb-2">
      Status is automatically updated by the system based on
      matching, claims, and verification.
    </p>

    <?php if($isStaff): ?>
      <div class="d-flex gap-2 flex-wrap">

        <?php if($report->status === 'claimed'): ?>
          <form method="POST" action="<?php echo e(route('reports.markReturned',$report->id)); ?>">
            <?php echo csrf_field(); ?>
            <button class="btn btn-sm btn-success">
              <i class="bi bi-check-circle"></i> Mark Returned
            </button>
          </form>
        <?php endif; ?>

        <?php if(in_array($report->status,['claimed','returned'],true)): ?>
          <form method="POST" action="<?php echo e(route('reports.archive',$report->id)); ?>">
            <?php echo csrf_field(); ?>
            <button class="btn btn-sm btn-outline-dark">
              <i class="bi bi-archive"></i> Archive
            </button>
          </form>
        <?php endif; ?>

      </div>
    <?php endif; ?>
  </div>

  
  <?php if($report->report_type === 'found'): ?>
    <div class="glass-card p-3 mt-3">
      <div class="section-title"><i class="bi bi-person-check"></i> Claim Item</div>
      <a class="btn btn-primary w-100" href="<?php echo e(route('claims.create',$report->id)); ?>">
        Submit Claim
      </a>
    </div>
  <?php endif; ?>

  
  <div class="glass-card p-3 mt-3">
    <div class="section-title"><i class="bi bi-link-45deg"></i> Matches</div>

    <?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <?php
        $other = $m->lost_report_id == $report->id ? $m->found_report_id : $m->lost_report_id;
      ?>

      <a
        class="d-flex justify-content-between align-items-center border rounded p-2 mb-2 text-decoration-none"
        href="<?php echo e(route('reports.show',$other)); ?>"
      >
        <div>
          <div class="fw-semibold">Report #<?php echo e($other); ?></div>
          <div class="text-muted small">Score <?php echo e($m->score); ?></div>
        </div>
        <span class="badge text-bg-primary"><?php echo e($m->method); ?></span>
      </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div class="text-muted">No matches yet</div>
    <?php endif; ?>
  </div>

  
  <?php if($claims->count() && ($isStaff || $isOwner)): ?>
  <div class="glass-card p-3 mt-3">
    <div class="section-title"><i class="bi bi-people"></i> Claims History</div>
    <?php $__currentLoopData = $claims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="border rounded p-2 mb-2 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="fw-bold text-dark">Claim #<?php echo e($c->id); ?></span>
            <span class="badge bg-secondary"><?php echo e(ucfirst($c->status)); ?></span>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?php echo e(route('claims.show', $c->id)); ?>" class="small text-decoration-none">View Details</a>
            <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($c->created_at)->diffForHumans()); ?></small>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
  <?php endif; ?>

</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\John Denver\Lost-Found\resources\views/reports/show.blade.php ENDPATH**/ ?>