<?php if (isset($component)) { $__componentOriginald2aa9f7b74553621bdcc3c69267ff328 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald2aa9f7b74553621bdcc3c69267ff328 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\PageComponent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Filament\View\LegacyComponents\PageComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>


<?php
    $user = auth()->user();

    // 🔥 ambil semua role & lowercase (anti typo / case sensitive)
    $roles = $user->getRoleNames()->map(fn($r) => strtolower($r));

    // 🔥 fix approver
    $isApprover =
        $roles->contains('kepala divisi') ||
        $roles->contains('HR') ||
        $roles->contains('direktur');
?>

<div style="max-width:900px;margin:auto">


<div style="
    background:white;
    padding:40px;
    border-radius:12px;
    box-shadow:0 4px 20px rgba(0,0,0,0.08);
    margin-bottom:30px;
">

    <h2 style="font-size:24px;font-weight:bold;margin-bottom:25px">
        Request Cuti
    </h2>

    <form wire:submit.prevent="submit">

        
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

            
            <div>
                <label>Rencana Berangkat</label>
                <input type="date" wire:model="start_date"
                    style="width:100%;margin-top:8px;padding:12px;border-radius:8px;border:1px solid #ddd;">
            </div>

            
            <div>
                <label>Sisa Cuti (hari)</label>
                <input type="number" wire:model="sisa_cuti"
                    style="width:100%;margin-top:8px;padding:12px;border-radius:8px;border:1px solid #ddd;">
            </div>

            
            <div>
                <label>Rencana Kembali</label>
                <input type="date" wire:model="end_date"
                    style="width:100%;margin-top:8px;padding:12px;border-radius:8px;border:1px solid #ddd;">
            </div>

            
            <div>
                <label>Keperluan Cuti</label>
                <textarea wire:model="reason"
                    style="width:100%;margin-top:8px;padding:12px;border-radius:8px;border:1px solid #ddd;height:100px"></textarea>
            </div>

        </div>

        
        <button type="submit"
            style="
                width:100%;
                background:#16a34a;
                color:white;
                padding:14px;
                border-radius:10px;
                font-weight:bold;
                font-size:16px;
            ">
            Submit
        </button>

    </form>

</div>
    
    <div style="
        background:white;
        padding:30px;
        border-radius:12px;
        box-shadow:0 4px 20px rgba(0,0,0,0.08);
    ">

        <h3 style="font-size:20px;font-weight:bold;margin-bottom:15px">
            History Request Cuti
        </h3>

        
        

        <table style="width:100%;border-collapse:collapse">

            <tr style="background:#f3f4f6">
                <th style="padding:10px;border">No</th>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isApprover): ?>
                    <th style="padding:10px;border">Nama</th>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <th style="padding:10px;border">Tanggal</th>
                <th style="padding:10px;border">Alasan</th>
                <th style="padding:10px;border">Status</th>
                <th style="padding:10px;border">Sisa Cuti</th>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isApprover): ?>
                    <th style="padding:10px;border">Aksi</th>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tr>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

            <tr>
                <td style="padding:10px;border">
                    <?php echo e($loop->iteration); ?>

                </td>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isApprover): ?>
                <td style="padding:10px;border">
                    <?php echo e($r->user->name ?? '-'); ?>

                </td>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <td style="padding:10px;border">
                    <?php echo e($r->start_date); ?> - <?php echo e($r->end_date); ?>

                </td>

                <td style="padding:10px;border">
                    <?php echo e($r->reason); ?>

                </td>

                <td style="padding:10px;border">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->final_status == 'approved'): ?>
                        <span style="color:green;font-weight:bold">Approved</span>
                    <?php elseif($r->final_status == 'rejected'): ?>
                        <span style="color:red;font-weight:bold">Rejected</span>
                    <?php else: ?>
                        <span style="color:orange;font-weight:bold">
                            Waiting Approval
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>

                <td style="padding:10px;border">
                    <?php echo e($r->sisa_cuti); ?>

                </td>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isApprover): ?>
                <td style="padding:10px;border">

                    <a href="<?php echo e(url('/admin/leave-approval/id' . $r->id)); ?>"
                    style="
                            background:#3b82f6;
                            color:white;
                            padding:6px 12px;
                            border-radius:6px;
                            text-decoration:none;
                            font-size:12px;
                    ">
                        Lihat Detail
                    </a>

                </td>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tr>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            <tr>
                <td colspan="<?php echo e($isApprover ? 7 : 5); ?>" style="text-align:center;padding:15px">
                    Belum ada data
                </td>
            </tr>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </table>

    </div>

</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald2aa9f7b74553621bdcc3c69267ff328)): ?>
<?php $attributes = $__attributesOriginald2aa9f7b74553621bdcc3c69267ff328; ?>
<?php unset($__attributesOriginald2aa9f7b74553621bdcc3c69267ff328); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald2aa9f7b74553621bdcc3c69267ff328)): ?>
<?php $component = $__componentOriginald2aa9f7b74553621bdcc3c69267ff328; ?>
<?php unset($__componentOriginald2aa9f7b74553621bdcc3c69267ff328); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\ags-system\resources\views/filament/pages/leave-request-form.blade.php ENDPATH**/ ?>