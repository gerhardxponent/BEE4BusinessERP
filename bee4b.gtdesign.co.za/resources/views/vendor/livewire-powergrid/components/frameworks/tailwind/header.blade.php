<div class="md:flex md:flex-row w-full justify-between items-center">

    <div class="md:flex md:flex-row w-full">

        <div>
            <x-livewire-powergrid::actions-header
                :theme="$theme"
                :actions="$this->headers"/>
        </div>

        <div class="flex flex-row justify-center items-center text-sm">
            @if($exportActive)
                <div class="mr-2 mt-2 sm:mt-0 flex flex-row space-x-1">
                    @include(powerGridThemeRoot().'.export')
                    @if(isset($emailFiles))
                        @if($emailFiles)
                        @include(powerGridThemeRoot().'.email-files')
                        @endif
                    @endif
                </div>
            @endif

            @includeIf(powerGridThemeRoot().'.toggle-columns')

        </div>

        <!-- LOADING -->
        @include(powerGridThemeRoot().'.loading')

    </div>

    <div class="flex gap-2 w-full justify-end items-center">
        @include(powerGridThemeRoot(). '.archive')
        <div>
            @include(powerGridThemeRoot().'.search')
        </div>
    </div>

</div>

@include(powerGridThemeRoot().'.batch-exporting')

@include(powerGridThemeRoot().'.enabled-filters')

