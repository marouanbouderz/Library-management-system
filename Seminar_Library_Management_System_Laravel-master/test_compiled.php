<?php $__env->startSection('title', 'Notifications'); ?>
<?php $__env->startSection('content'); ?>


<div class="mb-8">
    <div class="flex items-center gap-3 mb-1">
        <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
            <i class="fas fa-bell text-amber-600 text-sm"></i>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Notifications</h2>
    </div>
    <p class="text-sm text-slate-500 ml-11">Alerts about overdue or expiring books</p>
</div>

<?php
    date_default_timezone_set("Asia/Dhaka");
    $today = strtotime(date("d-m-Y"));
    $overdueCount = 0;
    $warningCount = 0;
    foreach ($records as $row) {
        $exp = strtotime($row->Expired_Date);
        if ($today >= $exp) $overdueCount++;
        elseif (($exp - $today) <= (3 * 86400)) $warningCount++;
    }
    $totalAlerts = $overdueCount + $warningCount;
?>


<?php if($totalAlerts > 0): ?>
<div class="mb-6 flex items-center gap-4 p-4 bg-red-50 border border-red-200 rounded-2xl">
    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
        <i class="fas fa-triangle-exclamation text-red-600"></i>
    </div>
    <div class="flex-1">
        <p class="text-sm font-bold text-red-800">
            <?php echo e($totalAlerts); ?> <?php echo e(Str::plural('alert', $totalAlerts)); ?> require your attention
        </p>
        <p class="text-xs text-red-600 mt-0.5">
            <?php if($overdueCount > 0): ?><?php echo e($overdueCount); ?> overdue@endif
            <?php if($overdueCount > 0 && $warningCount > 0): ?> · <?php endif; ?>
            <?php if($warningCount > 0): ?><?php echo e($warningCount); ?> expiring soon@endif
        </p>
    </div>
</div>
<?php endif; ?>


<?php if($totalAlerts > 0): ?>
<div class="space-y-4">
    <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $exp = strtotime($row->Expired_Date);
        $isOverdue = $today >= $exp;
        $daysLeft = (int)(($exp - $today) / 86400);
        $expiringSoon = !$isOverdue && $daysLeft <= 3;
        $book = DB::table('books')->where('Book_ID', $row->Book_ID)->first();
    ?>

    <?php if($isOverdue): ?>
    
    <div class="group bg-white border border-red-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-red-200 transition-colors">
                <i class="fas fa-clock text-red-600 text-lg"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-bold text-slate-800">
                            Book Overdue — Return Required
                        </p>
                        <p class="text-xs text-slate-500 mt-1">
                            <span class="font-mono font-semibold text-slate-700"><?php echo e($row->Book_ID); ?></span>
                            <?php if($book): ?> <span class="text-slate-400">·</span> <?php echo e($book->Book_Name); ?><?php endif; ?>
                        </p>
                    </div>
                    <span class="flex-shrink-0 inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-bold px-3 py-1.5 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                        Overdue
                    </span>
                </div>
                <div class="mt-3 flex items-center gap-4">
                    <div class="flex items-center gap-1.5 text-xs text-red-600 font-medium">
                        <i class="fas fa-calendar-xmark text-[10px]"></i>
                        Expired on <?php echo e($row->Expired_Date); ?>

                    </div>
                    <div class="h-3 w-px bg-slate-200"></div>
                    <p class="text-xs text-slate-400">Please return this book to the library immediately to avoid penalties.</p>
                </div>
            </div>
        </div>
    </div>

    <?php elseif($expiringSoon): ?>
    
    <div class="group bg-white border border-amber-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-amber-200 transition-colors">
                <i class="fas fa-hourglass-half text-amber-600 text-lg"></i>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-bold text-slate-800">Expiring Soon — Plan Your Return</p>
                        <p class="text-xs text-slate-500 mt-1">
                            <span class="font-mono font-semibold text-slate-700"><?php echo e($row->Book_ID); ?></span>
                            <?php if($book): ?> <span class="text-slate-400">·</span> <?php echo e($book->Book_Name); ?><?php endif; ?>
                        </p>
                    </div>
                    <span class="flex-shrink-0 inline-flex items-center gap-1.5 bg-amber-100 text-amber-700 text-xs font-bold px-3 py-1.5 rounded-full">
                        <i class="fas fa-exclamation text-[9px]"></i>
                        <?php echo e($daysLeft); ?> <?php echo e(Str::plural('day', $daysLeft)); ?> left
                    </span>
                </div>
                <div class="mt-3 flex items-center gap-1.5 text-xs text-amber-600 font-medium">
                    <i class="fas fa-calendar-days text-[10px]"></i>
                    Due on <?php echo e($row->Expired_Date); ?>

                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php else: ?>

<div class="bg-white rounded-2xl shadow-md px-6 py-24 flex flex-col items-center gap-5">
    <div class="relative">
        <div class="w-20 h-20 bg-emerald-50 rounded-2xl flex items-center justify-center">
            <i class="fas fa-bell text-emerald-400 text-3xl"></i>
        </div>
        <div class="absolute -top-1 -right-1 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center shadow-sm">
            <i class="fas fa-check text-white text-[10px]"></i>
        </div>
    </div>
    <div class="text-center max-w-sm">
        <p class="text-lg font-bold text-slate-700">You're all caught up!</p>
        <p class="text-sm text-slate-400 mt-2 leading-relaxed">
            No overdue books or upcoming deadlines. Keep up the good work and return books before they expire.
        </p>
    </div>
    <a href="<?php echo e(url('student/my-collection')); ?>"
       class="inline-flex items-center gap-2 text-white text-sm font-bold px-5 py-2.5 rounded-xl transition-all duration-200 shadow-sm mt-2"
       style="background:#2E9E6B;"
       onmouseover="this.style.background='#1d7a53';" onmouseout="this.style.background='#2E9E6B';">
        <i class="fas fa-bookmark text-xs"></i> View My Collection
    </a>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.student_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>