<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Inter Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400&display=swap" rel="stylesheet">

    <!-- Styles -->
    
    <link rel="stylesheet" href="https://app.bee4business.co.za/public/css/app.css">
    <link rel="stylesheet" href="<?php echo e(URL::asset('css/emailsEditor.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(URL::asset('css/tribute.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/billboard.js/3.5.1/billboard.min.css">

    <?php echo \Livewire\Livewire::styles(); ?>

    <?php echo view('livewire-powergrid::assets.styles')->render(); ?>

    <!-- Scripts -->
    
    <script src="https://app.bee4business.co.za/public/js/app.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="<?php echo e(URL::asset('css/filepond.min.css')); ?>">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 relative">
        <div class="fixed top-20 right-5 space-y-4" style="z-index: 999999">
            <?php if(session()->has('msMessage')): ?>
                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.toast.success','data' => ['message' => ''.e(Session::get('msMessage')).'']]); ?>
<?php $component->withName('toast.success'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['message' => ''.e(Session::get('msMessage')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
            <?php endif; ?>
        </div>

        <div>
            <div class="flex h-screen overflow-y-hidden bg-white" x-data="setup()"
                x-init="$refs.loading.classList.add('hidden')">
                <!-- Loading screen -->
                <div x-ref="loading"
                    class="fixed inset-0 z-50 flex items-center justify-center text-white bg-black bg-opacity-50"
                    style="backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); z-index: 99999999999999">
                    Loading
                </div>

                
                <style>
                    .scrollbar-hide::-webkit-scrollbar {
                        display: none;
                    }

                    .scrollbar-hide {
                        -ms-overflow-style: none;
                        /* IE and Edge */
                        scrollbar-width: none;
                        /* Firefox */
                    }
                </style>

                <div
                    class="scrollbar-hide flex bg-b4bpurple-normal h-screen absolute top-0 left-0 z-[999999] overflow-y-scroll overflow-x-hidden">
                    <aside
                        class="flex flex-col text-gray-300 bg-b4bpurple-normal transition-all duration-300 ease-in-out relative"
                        :class="isSidebarExpanded ? 'w-48' : 'w-20'" x-on:mouseenter="isSidebarExpanded = true"
                        x-on:mouseleave="isSidebarExpanded = false">
                        <nav class="p-4 space-y-2 font-medium">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => []]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
                                <?php if(!auth()->user()->client_id): ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('dashboard')); ?>

                                     <?php $__env->endSlot(); ?>
                                <?php else: ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        javascript:void(0); 
                                     <?php $__env->endSlot(); ?>
                                <?php endif; ?>

                                 <?php $__env->slot('icon', null, []); ?> 
                                    <div>
                                        <div class="w-10 h-10 bg-no-repeat"
                                            style="background-image: url('<?php echo e(asset('/assets/logo/B4B_Favicon.png')); ?>')">
                                        </div>
                                    </div>
                                 <?php $__env->endSlot(); ?>

                                 <?php $__env->slot('name', null, []); ?> 
                                    <div>
                                        <img src="<?php echo e(asset('/assets/logo/B4B_Logo.png')); ?>" alt="BEE4Business Logo">
                                    </div>
                                 <?php $__env->endSlot(); ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>


                            <?php if (! (auth()->user()->client_id)): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('dashboard')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('dashboard')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 flex-shrink-0">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                        </svg>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Dashboard')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <?php
                                $userRole = auth()->user()->roles->pluck('name')->first(); // Get the user's first role name
                            ?>

                            <?php if($userRole === 'Client'): ?>
                                
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('clients')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('clients'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('clients')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.client','data' => []]); ?>
<?php $component->withName('icons.client'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Company')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php elseif(auth()->user()->can('view clients')): ?>
                                
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('clients')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('clients'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('clients')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.client','data' => []]); ?>
<?php $component->withName('icons.client'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Clients')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view clients')): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('procurement.index')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('procurement.index'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('procurement.index')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.article','data' => []]); ?>
<?php $component->withName('icons.article'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Procurement')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>


                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('access management')): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('management')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('management'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('management')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.book','data' => []]); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Management')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view audits')): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('audits')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('audits'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('audits')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.audit','data' => []]); ?>
<?php $component->withName('icons.audit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Audits')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view leads')): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('leads')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('leads'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('leads')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.book','data' => []]); ?>
<?php $component->withName('icons.book'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Leads')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view contacts')): ?>
                                <?php if(!($userRole == 'Client' || $userRole == 'Client Sub User')): ?>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('contacts')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('contacts'))]); ?>
                                         <?php $__env->slot('route', null, []); ?> 
                                            <?php echo e(route('contacts')); ?>

                                         <?php $__env->endSlot(); ?>

                                         <?php $__env->slot('icon', null, []); ?> 
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.contact','data' => []]); ?>
<?php $component->withName('icons.contact'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                         <?php $__env->endSlot(); ?>

                                         <?php $__env->slot('name', null, []); ?> <?php echo e(__('Contacts')); ?> <?php $__env->endSlot(); ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view quotes')): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('quotes')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('quotes'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('quotes')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.quote','data' => []]); ?>
<?php $component->withName('icons.quote'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Quotes')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view services')): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('services')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('services'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('services')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.product','data' => []]); ?>
<?php $component->withName('icons.product'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Services')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view consultations')): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('consultations')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('consultations'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('consultations')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.consultation','data' => []]); ?>
<?php $component->withName('icons.consultation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Consultations')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <!--<?php if (! (auth()->user()->hasRole('Client Sub User') || auth()->user()->client_id)): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('calendar')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('calendar'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('calendar')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.calendar','data' => []]); ?>
<?php $component->withName('icons.calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Calendar')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>-->

                            

                            <?php if (! (auth()->user()->hasAnyRole(['Client', 'Client Sub User']))): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->is('public/users')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->is('public/users'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(url('/users')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 flex-shrink-0">
                                            <path
                                                d="M8 9a3 3 0 100-6 3 3 0 000 6zM2 18a6 6 0 0112 0H2zM14 10a4 4 0 10-8 0 4 4 0 008 0zM2 18a6 6 0 0112 0H2z" />
                                        </svg>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Users')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>

                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('support')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('support'))]); ?>
                                 <?php $__env->slot('route', null, []); ?> 
                                    <?php echo e(route('support')); ?>

                                 <?php $__env->endSlot(); ?>

                                 <?php $__env->slot('icon', null, []); ?> 
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.support','data' => []]); ?>
<?php $component->withName('icons.support'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                 <?php $__env->endSlot(); ?>

                                 <?php $__env->slot('name', null, []); ?> <?php echo e(__('Support')); ?> <?php $__env->endSlot(); ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                            <?php if (! (auth()->user()->hasRole('Client Sub User') || auth()->user()->client_id)): ?>
                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('tasks')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('tasks'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('tasks')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.task','data' => []]); ?>
<?php $component->withName('icons.task'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Tasks')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.nav-link-hover','data' => ['active' => request()->routeIs('resources')]]); ?>
<?php $component->withName('nav-link-hover'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('resources'))]); ?>
                                     <?php $__env->slot('route', null, []); ?> 
                                        <?php echo e(route('resources')); ?>

                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('icon', null, []); ?> 
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.info2','data' => []]); ?>
<?php $component->withName('icons.info2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                     <?php $__env->endSlot(); ?>

                                     <?php $__env->slot('name', null, []); ?> <?php echo e(__('Resources')); ?> <?php $__env->endSlot(); ?>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php endif; ?>
                        </nav>
                    </aside>
                </div>
                

                <div class="flex flex-col flex-1 h-full overflow-hidden pl-20 transition-opacity"
                    :class="{ 'opacity-40' : isSidebarExpanded }">
                    <!-- Navbar -->
                    <header class="flex-shrink-0 border-b border-gray-200">
                        <div class="flex items-center justify-between p-2">
                            <!-- Navbar left -->
                            <div class="flex justify-between items-center space-x-3 w-full">
                                <div>
                                    <?php if(isset($title)): ?>
                                        <div class="flex gap-2 justify-start items-center">
                                            <div class="text-xl font-bold ml-2"><?php echo e($title); ?></div>
                                            <?php if(isset($titleButtonText) || isset($titleButtonIcon)): ?>
                                                <button x-on:click="Livewire.emit('<?php echo e($titleButtonAction); ?>')"
                                                    class="flex items-center">
                                                    <div class="text-gray-500"><?php echo $titleButtonIcon ?? ''; ?></div>
                                                    <div><?php echo e($titleButtonText ?? ''); ?></div>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    <?php elseif(isset($backText)): ?>
                                        <div class="ml-2">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.back','data' => ['link' => ''.e($backLink ?? './').'']]); ?>
<?php $component->withName('back'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['link' => ''.e($backLink ?? './').'']); ?><?php echo e($backText); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                        
                                    <?php endif; ?>
                                </div>

                                <?php if(isset($buttonAction) && isset($buttonText) && isset($buttonPermission)): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($buttonPermission)): ?>
                                        <div class="pr-4 border-r-2 border-gray-200">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.create-button','data' => ['xOn:click' => 'Livewire.emit(\''.e($buttonAction).'\')']]); ?>
<?php $component->withName('create-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['x-on:click' => 'Livewire.emit(\''.e($buttonAction).'\')']); ?>
                                                <?php echo e($buttonText); ?>

                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Mobile search box -->
                            <div x-show.transition="isSearchBoxOpen" class="fixed inset-0 z-10 bg-black bg-opacity-20"
                                style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)">
                                <div @click.away="isSearchBoxOpen = false"
                                    class="absolute inset-x-0 flex items-center justify-between p-2 bg-white shadow-md">
                                    <div class="flex items-center flex-1 px-2 space-x-2">
                                        <!-- search icon -->
                                        <span>
                                            <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </span>
                                        <input type="text" placeholder="Search"
                                            class="w-full px-4 py-3 text-gray-600 rounded-md focus:bg-gray-100 focus:outline-none" />
                                    </div>
                                    <!-- close button -->
                                    <button @click="isSearchBoxOpen = false" class="flex-shrink-0 p-4 rounded-md">
                                        <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Navbar right -->
                            <div class="relative flex items-center space-x-3">
                                <!-- Search button -->
                                <button @click="isSearchBoxOpen = true"
                                    class="p-2 bg-gray-100 rounded-full md:hidden focus:outline-none focus:ring hover:bg-gray-200">
                                    <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>

                                <!-- Shortcut Button -->
                                <button onclick="showShortcutInstructions()"
                                    class="text-sm px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    📌 Shortcut
                                </button>

                                <div class="items-center hidden space-x-3 md:flex">
                                    <!-- Notification Button -->
                                    

                                    <?php
                                        $user = Auth::user();
                                        $isClient = $user->hasRole('Client') || $user->hasRole('Client Sub User');
                                    ?>

                                    <?php if($isClient): ?>
                                        <style>
                                            body>div.min-h-screen.bg-gray-100.relative>div:nth-child(2)>div>div.flex.flex-col.flex-1.h-full.overflow-hidden.pl-20.transition-opacity>header>div>div.relative.flex.items-center.space-x-3>div.items-center.hidden.space-x-3.md\:flex>div {
                                                display: none !important;
                                            }
                                        </style>
                                    <?php endif; ?>

                                    <!-- Options Button -->
                                    <div class="relative" x-data="{ isOpen: false }">
                                        <button @click="isOpen = !isOpen"
                                            class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 focus:outline-none focus:ring">
                                            <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown card -->
                                        <div @click.away="isOpen = false" x-show.transition.opacity="isOpen"
                                            style="z-index: 99999999;"
                                            class="absolute w-40 max-w-sm mt-3 transform bg-white rounded-md shadow-lg -translate-x-3/4 min-w-max">
                                            <ul class="flex flex-col p-2 my-2 space-y-1">
                                                <li>
                                                    <a href="<?php echo e(route('settings')); ?>"
                                                        class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Settings</a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo e(route('users')); ?>"
                                                        class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Users</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                

                                
                                <div class="relative" x-data="{ isOpen: false }">
                                    <button @click="isOpen = !isOpen"
                                        class="p-2 bg-gray-100 text-gray-500 rounded-full hover:bg-gray-200 focus:outline-none focus:ring">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.chain','data' => []]); ?>
<?php $component->withName('icons.chain'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </button>

                                    <!-- Dropdown card -->
                                    <div @click.away="isOpen = false" x-show.transition.opacity="isOpen"
                                        style="z-index: 99999999;"
                                        class="absolute w-40 max-w-sm mt-3 transform bg-white rounded-md shadow-lg -translate-x-3/4 min-w-max">
                                        <div class="p-4 font-medium border-b border-gray-200">
                                            <div class="text-lg">Linked Account</div>
                                            <div class="mt-4">
                                                <?php if(Cookie::get('msEmail')): ?>
                                                    <div class="space-y-4">
                                                        <div class="flex flex-row gap-2">
                                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.icons.microsoft','data' => []]); ?>
<?php $component->withName('icons.microsoft'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                            <div><?php echo e(Cookie::get('msEmail')); ?></div>
                                                        </div>
                                                        <div>
                                                            <a href="<?php echo e(url("signout")); ?>">
                                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['class' => 'w-full text-center','colour' => 'red']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'w-full text-center','colour' => 'red']); ?>Unlink
                                                                    Account <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="space-y-4">
                                                        <div class="text-gray-500">No account linked</div>
                                                        <div>
                                                            <a href="<?php echo e(url("signin")); ?>">
                                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.button','data' => ['class' => 'w-full text-center']]); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['class' => 'w-full text-center']); ?>Link Microsoft
                                                                    Account <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <!-- avatar button -->
                                <div class="relative" x-data="{ isOpen: false }" style="z-index: 99999999;">
                                    <button @click="isOpen = !isOpen"
                                        class="p-1 bg-gray-200 w-10 rounded-full focus:outline-none focus:ring">
                                        <img class="object-cover w-8 h-8 rounded-full"
                                            src="https://img.icons8.com/material-sharp/512/user.png"
                                            alt="User Profile" />
                                    </button>
                                    <!-- green dot -->
                                    <div class="absolute right-0 p-1 bg-green-400 rounded-full bottom-3 animate-ping">
                                    </div>
                                    <div
                                        class="absolute right-0 p-1 bg-green-400 border border-white rounded-full bottom-3">
                                    </div>

                                    <!-- Dropdown card -->
                                    <div @click.away="isOpen = false" x-show.transition.opacity="isOpen"
                                        class="absolute z-50 mt-3 transform -translate-x-full bg-white rounded-md shadow-lg min-w-max">
                                        <div class="flex flex-col p-4 space-y-1 font-medium border-b border-gray-200">
                                            <span class="text-gray-800"><?php echo e(Auth::user()->name); ?></span>
                                            <span class="text-sm text-gray-400"><?php echo e(Auth::user()->email); ?></span>
                                        </div>
                                        <ul class="flex flex-col p-2 my-2 space-y-1">
                                            <li>
                                                <a href="<?php echo e(route('profile.show')); ?>"
                                                    class="block px-2 py-1 transition rounded-md hover:bg-gray-100"><?php echo e(__('Profile')); ?></a>
                                            </li>
                                        </ul>
                                        <div
                                            class="flex items-center justify-center p-4 text-blue-700 underline border-t border-gray-200">
                                            <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                                                <?php echo csrf_field(); ?>
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.responsive-nav-link','data' => ['href' => ''.e(route('logout')).'','@click.prevent' => '$root.submit();']]); ?>
<?php $component->withName('jet-responsive-nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['href' => ''.e(route('logout')).'','@click.prevent' => '$root.submit();']); ?>
                                                    <?php echo e(__('Log Out')); ?>

                                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Main content -->
                    <main class="p-4 flex-1 max-h-full overflow-hidden overflow-y-scroll main-bg">
                        
                        <!-- Main content header -->
                        

                        <!-- Page Content -->
                        <!-- dashboard.blade.php -->
                        <main>
                            <?php echo e($slot); ?>

                        </main>
                    </main>
                </div>

            </div>
            <script>
                const setup = () => {
                    return {
                        loading: true,
                        isSidebarExpanded: false,
                        isSettingsPanelOpen: false,
                        isSearchBoxOpen: false,
                    }
                }
            </script>
        </div>

        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>
    </div>


    

    <?php echo $__env->yieldPushContent('modals'); ?>

    <?php echo \Livewire\Livewire::scripts(); ?>

    <?php echo view('livewire-powergrid::assets.scripts')->render(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script src="<?php echo e(URL::asset('js/filepond.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/emailsEditor.bundle.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/tribute.min.js')); ?>"></script>
    
    <script src="https://d3js.org/d3.v6.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/billboard.js/3.5.1/billboard.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        (() => { function c(n) { n.directive("collapse", e), e.inline = (t, { modifiers: i }) => { !i.includes("min") || (t._x_doShow = () => { }, t._x_doHide = () => { }) }; function e(t, { modifiers: i }) { let r = l(i, "duration", 250) / 1e3, h = l(i, "min", 0), u = !i.includes("min"); t._x_isShown || (t.style.height = `${h}px`), !t._x_isShown && u && (t.hidden = !0), t._x_isShown || (t.style.overflow = "hidden"); let g = (d, s) => { let o = n.setStyles(d, s); return s.height ? () => { } : o }, f = { transitionProperty: "height", transitionDuration: `${r}s`, transitionTimingFunction: "cubic-bezier(0.4, 0.0, 0.2, 1)" }; t._x_transition = { in(d = () => { }, s = () => { }) { u && (t.hidden = !1), u && (t.style.display = null); let o = t.getBoundingClientRect().height; t.style.height = "auto"; let a = t.getBoundingClientRect().height; o === a && (o = h), n.transition(t, n.setStyles, { during: f, start: { height: o + "px" }, end: { height: a + "px" } }, () => t._x_isShown = !0, () => { t.style.height == `${a}px` && (t.style.overflow = null) }) }, out(d = () => { }, s = () => { }) { let o = t.getBoundingClientRect().height; n.transition(t, g, { during: f, start: { height: o + "px" }, end: { height: h + "px" } }, () => t.style.overflow = "hidden", () => { t._x_isShown = !1, t.style.height == `${h}px` && u && (t.style.display = "none", t.hidden = !0) }) } } } } function l(n, e, t) { if (n.indexOf(e) === -1) return t; let i = n[n.indexOf(e) + 1]; if (!i) return t; if (e === "duration") { let r = i.match(/([0-9]+)ms/); if (r) return r[1] } if (e === "min") { let r = i.match(/([0-9]+)px/); if (r) return r[1] } return i } document.addEventListener("alpine:init", () => { window.Alpine.plugin(c) }); })();
    </script>
    <script>
        (() => { var j = ["input", "select", "textarea", "a[href]", "button", "[tabindex]", "audio[controls]", "video[controls]", '[contenteditable]:not([contenteditable="false"])', "details>summary:first-of-type", "details"], _ = j.join(","), A = typeof Element == "undefined" ? function () { } : Element.prototype.matches || Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector, G = function (e, t, a) { var u = Array.prototype.slice.apply(e.querySelectorAll(_)); return t && A.call(e, _) && u.unshift(e), u = u.filter(a), u }, Z = function (e) { return e.contentEditable === "true" }, M = function (e) { var t = parseInt(e.getAttribute("tabindex"), 10); return isNaN(t) ? Z(e) || (e.nodeName === "AUDIO" || e.nodeName === "VIDEO" || e.nodeName === "DETAILS") && e.getAttribute("tabindex") === null ? 0 : e.tabIndex : t }, $ = function (e, t) { return e.tabIndex === t.tabIndex ? e.documentOrder - t.documentOrder : e.tabIndex - t.tabIndex }, C = function (e) { return e.tagName === "INPUT" }, ee = function (e) { return C(e) && e.type === "hidden" }, te = function (e) { var t = e.tagName === "DETAILS" && Array.prototype.slice.apply(e.children).some(function (a) { return a.tagName === "SUMMARY" }); return t }, re = function (e, t) { for (var a = 0; a < e.length; a++)if (e[a].checked && e[a].form === t) return e[a] }, ae = function (e) { if (!e.name) return !0; var t = e.form || e.ownerDocument, a = function (l) { return t.querySelectorAll('input[type="radio"][name="' + l + '"]') }, u; if (typeof window != "undefined" && typeof window.CSS != "undefined" && typeof window.CSS.escape == "function") u = a(window.CSS.escape(e.name)); else try { u = a(e.name) } catch (s) { return console.error("Looks like you have a radio button with a name attribute containing invalid CSS selector characters and need the CSS.escape polyfill: %s", s.message), !1 } var r = re(u, e.form); return !r || r === e }, ne = function (e) { return C(e) && e.type === "radio" }, ie = function (e) { return ne(e) && !ae(e) }, ue = function (e, t) { if (getComputedStyle(e).visibility === "hidden") return !0; var a = A.call(e, "details>summary:first-of-type"), u = a ? e.parentElement : e; if (A.call(u, "details:not([open]) *")) return !0; if (!t || t === "full") for (; e;) { if (getComputedStyle(e).display === "none") return !0; e = e.parentElement } else if (t === "non-zero-area") { var r = e.getBoundingClientRect(), s = r.width, l = r.height; return s === 0 && l === 0 } return !1 }, oe = function (e) { if (C(e) || e.tagName === "SELECT" || e.tagName === "TEXTAREA" || e.tagName === "BUTTON") for (var t = e.parentElement; t;) { if (t.tagName === "FIELDSET" && t.disabled) { for (var a = 0; a < t.children.length; a++) { var u = t.children.item(a); if (u.tagName === "LEGEND") return !u.contains(e) } return !0 } t = t.parentElement } return !1 }, O = function (e, t) { return !(t.disabled || ee(t) || ue(t, e.displayCheck) || te(t) || oe(t)) }, se = function (e, t) { return !(!O(e, t) || ie(t) || M(t) < 0) }, q = function (e, t) { t = t || {}; var a = [], u = [], r = G(e, t.includeContainer, se.bind(null, t)); r.forEach(function (l, h) { var b = M(l); b === 0 ? a.push(l) : u.push({ documentOrder: h, tabIndex: b, node: l }) }); var s = u.sort($).map(function (l) { return l.node }).concat(a); return s }, W = function (e, t) { t = t || {}; var a = G(e, t.includeContainer, O.bind(null, t)); return a }; var ce = j.concat("iframe").join(","), k = function (e, t) { if (t = t || {}, !e) throw new Error("No node provided"); return A.call(e, ce) === !1 ? !1 : O(t, e) }; function B(i, e) { var t = Object.keys(i); if (Object.getOwnPropertySymbols) { var a = Object.getOwnPropertySymbols(i); e && (a = a.filter(function (u) { return Object.getOwnPropertyDescriptor(i, u).enumerable })), t.push.apply(t, a) } return t } function fe(i) { for (var e = 1; e < arguments.length; e++) { var t = arguments[e] != null ? arguments[e] : {}; e % 2 ? B(Object(t), !0).forEach(function (a) { le(i, a, t[a]) }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(i, Object.getOwnPropertyDescriptors(t)) : B(Object(t)).forEach(function (a) { Object.defineProperty(i, a, Object.getOwnPropertyDescriptor(t, a)) }) } return i } function le(i, e, t) { return e in i ? Object.defineProperty(i, e, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : i[e] = t, i } var H = function () { var i = []; return { activateTrap: function (t) { if (i.length > 0) { var a = i[i.length - 1]; a !== t && a.pause() } var u = i.indexOf(t); u === -1 || i.splice(u, 1), i.push(t) }, deactivateTrap: function (t) { var a = i.indexOf(t); a !== -1 && i.splice(a, 1), i.length > 0 && i[i.length - 1].unpause() } } }(), de = function (e) { return e.tagName && e.tagName.toLowerCase() === "input" && typeof e.select == "function" }, be = function (e) { return e.key === "Escape" || e.key === "Esc" || e.keyCode === 27 }, ve = function (e) { return e.key === "Tab" || e.keyCode === 9 }, U = function (e) { return setTimeout(e, 0) }, L = function (e, t) { var a = -1; return e.every(function (u, r) { return t(u) ? (a = r, !1) : !0 }), a }, D = function (e) { for (var t = arguments.length, a = new Array(t > 1 ? t - 1 : 0), u = 1; u < t; u++)a[u - 1] = arguments[u]; return typeof e == "function" ? e.apply(void 0, a) : e }, K = function (e, t) { var a = document, u = fe({ returnFocusOnDeactivate: !0, escapeDeactivates: !0, delayInitialFocus: !0 }, t), r = { containers: [], tabbableGroups: [], nodeFocusedBeforeActivation: null, mostRecentlyFocusedNode: null, active: !1, paused: !1, delayInitialFocusTimer: void 0 }, s, l = function (n, o, c) { return n && n[o] !== void 0 ? n[o] : u[c || o] }, h = function (n) { return r.containers.some(function (o) { return o.contains(n) }) }, b = function (n) { var o = u[n]; if (!o) return null; var c = o; if (typeof o == "string" && (c = a.querySelector(o), !c)) throw new Error("`".concat(n, "` refers to no known node")); if (typeof o == "function" && (c = o(), !c)) throw new Error("`".concat(n, "` did not return a node")); return c }, v = function () { var n; if (l({}, "initialFocus") === !1) return !1; if (b("initialFocus") !== null) n = b("initialFocus"); else if (h(a.activeElement)) n = a.activeElement; else { var o = r.tabbableGroups[0], c = o && o.firstTabbableNode; n = c || b("fallbackFocus") } if (!n) throw new Error("Your focus-trap needs to have at least one focusable element"); return n }, m = function () { if (r.tabbableGroups = r.containers.map(function (n) { var o = q(n); if (o.length > 0) return { container: n, firstTabbableNode: o[0], lastTabbableNode: o[o.length - 1] } }).filter(function (n) { return !!n }), r.tabbableGroups.length <= 0 && !b("fallbackFocus")) throw new Error("Your focus-trap must have at least one container with at least one tabbable node in it at all times") }, p = function f(n) { if (n !== !1 && n !== a.activeElement) { if (!n || !n.focus) { f(v()); return } n.focus({ preventScroll: !!u.preventScroll }), r.mostRecentlyFocusedNode = n, de(n) && n.select() } }, E = function (n) { var o = b("setReturnFocus"); return o || n }, y = function (n) { if (!h(n.target)) { if (D(u.clickOutsideDeactivates, n)) { s.deactivate({ returnFocus: u.returnFocusOnDeactivate && !k(n.target) }); return } D(u.allowOutsideClick, n) || n.preventDefault() } }, w = function (n) { var o = h(n.target); o || n.target instanceof Document ? o && (r.mostRecentlyFocusedNode = n.target) : (n.stopImmediatePropagation(), p(r.mostRecentlyFocusedNode || v())) }, Q = function (n) { m(); var o = null; if (r.tabbableGroups.length > 0) { var c = L(r.tabbableGroups, function (S) { var N = S.container; return N.contains(n.target) }); if (c < 0) n.shiftKey ? o = r.tabbableGroups[r.tabbableGroups.length - 1].lastTabbableNode : o = r.tabbableGroups[0].firstTabbableNode; else if (n.shiftKey) { var d = L(r.tabbableGroups, function (S) { var N = S.firstTabbableNode; return n.target === N }); if (d < 0 && r.tabbableGroups[c].container === n.target && (d = c), d >= 0) { var g = d === 0 ? r.tabbableGroups.length - 1 : d - 1, F = r.tabbableGroups[g]; o = F.lastTabbableNode } } else { var T = L(r.tabbableGroups, function (S) { var N = S.lastTabbableNode; return n.target === N }); if (T < 0 && r.tabbableGroups[c].container === n.target && (T = c), T >= 0) { var X = T === r.tabbableGroups.length - 1 ? 0 : T + 1, J = r.tabbableGroups[X]; o = J.firstTabbableNode } } } else o = b("fallbackFocus"); o && (n.preventDefault(), p(o)) }, R = function (n) { if (be(n) && D(u.escapeDeactivates) !== !1) { n.preventDefault(), s.deactivate(); return } if (ve(n)) { Q(n); return } }, x = function (n) { D(u.clickOutsideDeactivates, n) || h(n.target) || D(u.allowOutsideClick, n) || (n.preventDefault(), n.stopImmediatePropagation()) }, I = function () { if (!!r.active) return H.activateTrap(s), r.delayInitialFocusTimer = u.delayInitialFocus ? U(function () { p(v()) }) : p(v()), a.addEventListener("focusin", w, !0), a.addEventListener("mousedown", y, { capture: !0, passive: !1 }), a.addEventListener("touchstart", y, { capture: !0, passive: !1 }), a.addEventListener("click", x, { capture: !0, passive: !1 }), a.addEventListener("keydown", R, { capture: !0, passive: !1 }), s }, P = function () { if (!!r.active) return a.removeEventListener("focusin", w, !0), a.removeEventListener("mousedown", y, !0), a.removeEventListener("touchstart", y, !0), a.removeEventListener("click", x, !0), a.removeEventListener("keydown", R, !0), s }; return s = { activate: function (n) { if (r.active) return this; var o = l(n, "onActivate"), c = l(n, "onPostActivate"), d = l(n, "checkCanFocusTrap"); d || m(), r.active = !0, r.paused = !1, r.nodeFocusedBeforeActivation = a.activeElement, o && o(); var g = function () { d && m(), I(), c && c() }; return d ? (d(r.containers.concat()).then(g, g), this) : (g(), this) }, deactivate: function (n) { if (!r.active) return this; clearTimeout(r.delayInitialFocusTimer), r.delayInitialFocusTimer = void 0, P(), r.active = !1, r.paused = !1, H.deactivateTrap(s); var o = l(n, "onDeactivate"), c = l(n, "onPostDeactivate"), d = l(n, "checkCanReturnFocus"); o && o(); var g = l(n, "returnFocus", "returnFocusOnDeactivate"), F = function () { U(function () { g && p(E(r.nodeFocusedBeforeActivation)), c && c() }) }; return g && d ? (d(E(r.nodeFocusedBeforeActivation)).then(F, F), this) : (F(), this) }, pause: function () { return r.paused || !r.active ? this : (r.paused = !0, P(), this) }, unpause: function () { return !r.paused || !r.active ? this : (r.paused = !1, m(), I(), this) }, updateContainerElements: function (n) { var o = [].concat(n).filter(Boolean); return r.containers = o.map(function (c) { return typeof c == "string" ? a.querySelector(c) : c }), r.active && m(), this } }, s.updateContainerElements(e), s }; function Y(i) { let e, t; window.addEventListener("focusin", () => { e = t, t = document.activeElement }), i.magic("focus", a => { let u = a; return { __noscroll: !1, __wrapAround: !1, within(r) { return u = r, this }, withoutScrolling() { return this.__noscroll = !0, this }, noscroll() { return this.__noscroll = !0, this }, withWrapAround() { return this.__wrapAround = !0, this }, wrap() { return this.withWrapAround() }, focusable(r) { return k(r) }, previouslyFocused() { return e }, lastFocused() { return e }, focused() { return t }, focusables() { return Array.isArray(u) ? u : W(u, { displayCheck: "none" }) }, all() { return this.focusables() }, isFirst(r) { let s = this.all(); return s[0] && s[0].isSameNode(r) }, isLast(r) { let s = this.all(); return s.length && s.slice(-1)[0].isSameNode(r) }, getFirst() { return this.all()[0] }, getLast() { return this.all().slice(-1)[0] }, getNext() { let r = this.all(), s = document.activeElement; if (r.indexOf(s) !== -1) return this.__wrapAround && r.indexOf(s) === r.length - 1 ? r[0] : r[r.indexOf(s) + 1] }, getPrevious() { let r = this.all(), s = document.activeElement; if (r.indexOf(s) !== -1) return this.__wrapAround && r.indexOf(s) === 0 ? r.slice(-1)[0] : r[r.indexOf(s) - 1] }, first() { this.focus(this.getFirst()) }, last() { this.focus(this.getLast()) }, next() { this.focus(this.getNext()) }, previous() { this.focus(this.getPrevious()) }, prev() { return this.previous() }, focus(r) { !r || setTimeout(() => { r.hasAttribute("tabindex") || r.setAttribute("tabindex", "0"), r.focus({ preventScroll: this._noscroll }) }) } } }), i.directive("trap", i.skipDuringClone((a, { expression: u, modifiers: r }, { effect: s, evaluateLater: l, cleanup: h }) => { let b = l(u), v = !1, m = K(a, { escapeDeactivates: !1, allowOutsideClick: !0, fallbackFocus: () => a, initialFocus: a.querySelector("[autofocus]") }), p = () => { }, E = () => { }, y = () => { p(), p = () => { }, E(), E = () => { }, m.deactivate({ returnFocus: !r.includes("noreturn") }) }; s(() => b(w => { v !== w && (w && !v && setTimeout(() => { r.includes("inert") && (p = V(a)), r.includes("noscroll") && (E = pe()), m.activate() }), !w && v && y(), v = !!w) })), h(y) }, (a, { expression: u, modifiers: r }, { evaluate: s }) => { r.includes("inert") && s(u) && V(a) })) } function V(i) { let e = []; return z(i, t => { let a = t.hasAttribute("aria-hidden"); t.setAttribute("aria-hidden", "true"), e.push(() => a || t.removeAttribute("aria-hidden")) }), () => { for (; e.length;)e.pop()() } } function z(i, e) { i.isSameNode(document.body) || !i.parentNode || Array.from(i.parentNode.children).forEach(t => { t.isSameNode(i) || e(t), z(i.parentNode, e) }) } function pe() { let i = document.documentElement.style.overflow, e = document.documentElement.style.paddingRight, t = window.innerWidth - document.documentElement.clientWidth; return document.documentElement.style.overflow = "hidden", document.documentElement.style.paddingRight = `${t}px`, () => { document.documentElement.style.overflow = i, document.documentElement.style.paddingRight = e } } document.addEventListener("alpine:init", () => { window.Alpine.plugin(Y) }); })();
    </script>

    <div id="shortcutModal"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md text-sm">
            <h2 class="text-lg font-semibold mb-2">Create a Shortcut</h2>
            <p class="mb-2"><strong>📱 On iPhone (Safari):</strong> Tap <span class="font-mono">Share</span> → <span
                    class="font-mono">Add to Home Screen</span></p>
            <p class="mb-2"><strong>📱 On Android (Chrome):</strong> Tap <span class="font-mono">⋮ Menu</span> → <span
                    class="font-mono">Add to Home Screen</span></p>
            <p class="mb-2"><strong>💻 On Desktop (Chrome):</strong> Menu → <span class="font-mono">More Tools</span> →
                <span class="font-mono">Create Shortcut</span>
            </p>
            <div class="mt-4 text-right">
                <button onclick="closeShortcutModal()" class="text-blue-600 hover:underline">Close</button>
            </div>
        </div>
    </div>

    <script>
        function showShortcutInstructions() {
            document.getElementById('shortcutModal').classList.remove('hidden');
        }

        function closeShortcutModal() {
            document.getElementById('shortcutModal').classList.add('hidden');
        }
    </script>

</body>

</html><?php /**PATH /usr/www/users/gtdesneeey/bee4b.gtdesign.co.za/resources/views/layouts/app2.blade.php ENDPATH**/ ?>