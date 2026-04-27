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


<div class="bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-5">
        Daftar Permintaan Surat
    </h2>

    <table class="w-full border rounded-lg overflow-hidden">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 border text-left">Nama</th>
                <th class="p-3 border text-left">Jenis</th>
                <th class="p-3 border text-left">Keterangan</th>
                <th class="p-3 border text-left">Tanggal</th>
                <th class="p-3 border text-left">Status</th>
                <th class="p-3 border text-left">Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

            <tr class="hover:bg-gray-50">

                <td class="p-3 border">
                    <?php echo e($r->user->name); ?>

                </td>

                <td class="p-3 border">
                    <?php echo e(ucfirst($r->type)); ?>

                </td>

                <td class="p-3 border">
                    <?php echo e($r->purpose); ?>

                </td>

                <td class="p-3 border">
                    <?php echo e($r->needed_date); ?>

                </td>

                <td class="p-3 border">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->status === 'pending'): ?>
                        <span class="text-yellow-600 font-semibold">
                            Menunggu
                        </span>

                    <?php elseif($r->status === 'approved'): ?>
                        <span class="text-green-600 font-semibold">
                            Disetujui
                        </span>

                    <?php else: ?>
                        <span class="text-red-600 font-semibold">
                            Ditolak
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </td>

                <td class="p-3 border">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($r->status === 'pending'): ?>

                        <a href="/admin/process-document-request?record=<?php echo e($r->id); ?>"
                           class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                           Detail
                        </a>

                    <?php else: ?>
                        <span class="text-gray-400">
                            Selesai
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </td>

            </tr>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            <tr>
                <td colspan="6" class="text-center p-5 text-gray-500">
                    Belum ada request
                </td>
            </tr>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </tbody>

    </table>

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
<?php /**PATH C:\xampp\htdocs\ags-system\resources\views/filament/pages/admin-document-request.blade.php ENDPATH**/ ?>