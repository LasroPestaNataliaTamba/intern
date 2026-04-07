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


<h2 class="text-xl font-bold mb-4">Detail Request</h2>

<div class="mb-4 space-y-2">
    <p><b>Nama:</b> <?php echo e($recordModel->user->name); ?></p>
    <p><b>Email:</b> <?php echo e($recordModel->user->email); ?></p>
    <p><b>Jenis:</b> <?php echo e($recordModel->type); ?></p>
    <p><b>Keperluan:</b> <?php echo e($recordModel->purpose); ?></p>
    <p><b>Tanggal:</b> <?php echo e($recordModel->needed_date); ?></p>

    <a href="<?php echo e(asset('storage/'.$recordModel->attachment)); ?>"
       class="text-blue-600 underline">
        Download Lampiran
    </a>
</div>

<form wire:submit.prevent="submit">

    <input type="file" wire:model="file" class="mb-3">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="text-red-500 text-sm"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="flex gap-3 mt-3">

        <!-- ✅ APPROVE -->
        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Approve
        </button>

        <!-- ❌ REJECT -->
        <button type="button"
            wire:click="reject"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Reject
        </button>

    </div>

</form>

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
<?php /**PATH C:\xampp\htdocs\ags-system\resources\views/filament/pages/process-document-request.blade.php ENDPATH**/ ?>