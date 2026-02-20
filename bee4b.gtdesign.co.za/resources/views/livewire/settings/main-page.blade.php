<div>
    <div class="flex w-full" >
        <div class="w-1/6">
            <livewire:settings.components.sections :currentSection="$currentSection" />
        </div>

        <div class="w-full pl-6">
            @switch($currentSection)
                @case('clients')
                    <livewire:settings.components.clients />
                @break

                @case('projects')
                    <livewire:settings.components.projects />
                @break

                @case('audit Fields')
                    <livewire:audit-management.audit-defaults />
                @break

                @case('audit Templates')
                    <livewire:audit-template-builder />
                @break

                @case('roles and permissions')
                    <livewire:settings.components.roles-and-permissions />
                @break

                 @case('lead email')
                    <livewire:settings.application-form-settings />
                @break

                @default
                    <div></div>
            @endswitch
        </div>
    </div>
</div>
