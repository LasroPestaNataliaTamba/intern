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


<div class="flex gap-3 mb-6">

<?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'success','type' => 'button','onclick' => 'getLocation()']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'success','type' => 'button','onclick' => 'getLocation()']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

Check In
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'danger','wire:click' => 'checkOut','disabled' => !$today || $today->check_out]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'danger','wire:click' => 'checkOut','disabled' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(!$today || $today->check_out)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

Check Out
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>

</div>



<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($today): ?>

<div class="p-4 border rounded mb-6 bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3">
Today Attendance
</h3>

<div class="grid grid-cols-2 gap-4">

<div>
<p class="text-sm text-gray-500">Jam Masuk</p>
<p class="font-semibold">
<?php echo e(\Carbon\Carbon::parse($today->check_in)->format('H:i')); ?>

</p>
</div>

<div>
<p class="text-sm text-gray-500">Jam Keluar</p>
<p class="font-semibold">
<?php echo e($today->check_out
? \Carbon\Carbon::parse($today->check_out)->format('H:i')
: '-'); ?>

</p>
</div>

</div>

<p class="mt-3">
Status :
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($today->status == 'late'): ?>
<span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold">Late</span>
<?php else: ?>
<span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-semibold">On Time</span>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</p>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($today->latitude): ?>
<p class="mt-3">
Lokasi :
<a
href="https://www.google.com/maps?q=<?php echo e($today->latitude); ?>,<?php echo e($today->longitude); ?>"
target="_blank"
class="text-blue-600 underline">
Lihat di Maps
</a>
</p>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>




<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasAnyRole(['HR','direktur'])): ?>


<div class="p-4 border rounded mb-6 bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3">
Absensi Hari Ini (Semua Karyawan)
</h3>

<div class="overflow-x-auto">
<table class="w-full border border-gray-300 text-sm">

<thead class="bg-gray-100 text-gray-700">
<tr>
<th class="p-3 border">Nama</th>
<th class="p-3 border">Jam Masuk</th>
<th class="p-3 border">Jam Keluar</th>
<th class="p-3 border">Status</th>
</tr>
</thead>

<tbody>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->todayAttendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
<tr class="hover:bg-gray-50">

<td class="p-3 border"><?php echo e($att->user->name); ?></td>

<td class="p-3 border">
<?php echo e(\Carbon\Carbon::parse($att->check_in)->format('H:i')); ?>

</td>

<td class="p-3 border">
<?php echo e($att->check_out
? \Carbon\Carbon::parse($att->check_out)->format('H:i')
: '-'); ?>

</td>

<td class="p-3 border">

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($att->status == 'late'): ?>
<span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold">
Late
</span>
<?php else: ?>
<span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-semibold">
On Time
</span>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</td>

</tr>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
<tr>
<td colspan="4" class="text-center p-3">Belum ada absensi</td>
</tr>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</tbody>

</table>
</div>

</div>



<div class="p-4 border rounded mb-6 bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3 text-red-600">
Belum Absen Hari Ini
</h3>

<div class="grid grid-cols-2 md:grid-cols-3 gap-2">

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->notCheckedIn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
<div class="p-2 bg-red-50 border border-red-200 rounded text-sm">
<?php echo e($user->name); ?>

</div>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
<div class="text-green-600">Semua sudah absen ✅</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>

</div>



<div class="p-4 border rounded mb-6 bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3 text-yellow-600">
Belum Check Out
</h3>

<table class="w-full border text-sm">

<thead class="bg-gray-100">
<tr>
<th class="p-2 border">Nama</th>
<th class="p-2 border">Jam Masuk</th>
</tr>
</thead>

<tbody>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->notCheckedOut; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $att): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
<tr class="hover:bg-gray-50">
<td class="p-2 border"><?php echo e($att->user->name); ?></td>
<td class="p-2 border">
<?php echo e(\Carbon\Carbon::parse($att->check_in)->format('H:i')); ?>

</td>
</tr>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
<tr>
<td colspan="2" class="text-center p-2 text-green-600">
Semua sudah check out ✅
</td>
</tr>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</tbody>

</table>

</div>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>




<div class="p-4 border rounded bg-white shadow-sm">

<h3 class="font-bold text-lg mb-3">
Riwayat Absensi
</h3>

<table class="w-full border text-sm">

<thead class="bg-gray-100">
<tr>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasAnyRole(['HR','direktur'])): ?>
<th class="p-3 border">Nama</th>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<th class="p-3 border">Tanggal</th>
<th class="p-3 border">Masuk</th>
<th class="p-3 border">Keluar</th>
<th class="p-3 border">Status</th>

</tr>
</thead>

<tbody>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>

<tr class="hover:bg-gray-50">

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->hasAnyRole(['HR','direktur'])): ?>
<td class="p-3 border"><?php echo e($h->user->name ?? '-'); ?></td>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<td class="p-3 border">
<?php echo e(\Carbon\Carbon::parse($h->date)->format('d M Y')); ?>

</td>

<td class="p-3 border">
<?php echo e(\Carbon\Carbon::parse($h->check_in)->format('H:i')); ?>

</td>

<td class="p-3 border">
<?php echo e($h->check_out
? \Carbon\Carbon::parse($h->check_out)->format('H:i')
: '-'); ?>

</td>

<td class="p-3 border">

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($h->status == 'late'): ?>
<span class="px-2 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold">
Late
</span>
<?php else: ?>
<span class="px-2 py-1 bg-green-100 text-green-600 rounded text-xs font-semibold">
On Time
</span>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</td>

</tr>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

</tbody>

</table>

</div>



<script>
function getLocation(){
navigator.geolocation.getCurrentPosition(
function(position){
window.Livewire.dispatch('checkInLocation',{
lat: position.coords.latitude,
lng: position.coords.longitude
});
},
function(error){
alert('GPS gagal diambil');
}
);
}
</script>

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
<?php /**PATH C:\xampp\htdocs\ags-system\resources\views/filament/pages/attendance.blade.php ENDPATH**/ ?>