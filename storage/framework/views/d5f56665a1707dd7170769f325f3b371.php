<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Members Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Jumuiya Members Report</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Jumuiya</th>
                <th>Joined Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($member->user->name); ?></td>
                    <td><?php echo e($member->user->email); ?></td>
                    <td><?php echo e($member->phone); ?></td>
                    <td><?php echo e($member->jumuiya->name); ?></td>
                    <td><?php echo e($member->created_at->format('Y-m-d')); ?></td>
                    <td><?php echo e($member->status); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\jumuiyakiganjani\resources\views/chairperson/reports/members_pdf.blade.php ENDPATH**/ ?>