@props([
    'link' => './',
    'title' => '',
])

{{-- <div> --}}
    <div class="sential w-full h-1 opacity-0"></div>

    <div class="back-header mb-6 bg-white sticky top-0 left-0 z-[999999] p-4 shadow-md transition-all">
        <div style="width: max-content;">
            <a href="{{ $link }}">
                <div class="flex flex-row space-x-2 text-indigo-600 hover:underline cursor-pointer items-center">
                    <x-icons.left-arrow />
                    <span class="font-bold text-lg">Back to {{ $slot }}</span>
                </div>
            </a>
        </div>
    </div>

    <script>
        const headerEl = document.querySelector('.back-header');
        const sentialEl = document.querySelector('.sential');

        const handler = (entries) => {
            if (!entries[0].isIntersecting) {
                headerEl.classList.add('bg-white', 'shadow-md');
            } else {
                headerEl.classList.remove('bg-white', 'shadow-md');
            }
        }

        const observer = new window.IntersectionObserver(handler);
        observer.observe(sentialEl);
    </script>
{{-- </div> --}}