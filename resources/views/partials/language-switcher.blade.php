<div class="relative inline-block text-left language-switcher">
    <div x-data="{ open: false }" @click.away="open = false" class="relative">
        <button @click="open = !open" type="button" class="inline-flex items-center justify-center px-3 py-2 text-gray-700 hover:text-blue-600 focus:outline-none">
            <span>{{ __('general.language') }}</span>
            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-100" 
             x-transition:enter-start="transform opacity-0 scale-95" 
             x-transition:enter-end="transform opacity-100 scale-100" 
             x-transition:leave="transition ease-in duration-75" 
             x-transition:leave-start="transform opacity-100 scale-100" 
             x-transition:leave-end="transform opacity-0 scale-95" 
             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
             style="display: none;">
            <div class="py-1">
                <a href="{{ route('language.switch', 'en') }}" class="flex items-center px-4 py-2 text-sm {{ app()->getLocale() == 'en' ? 'bg-gray-100 text-blue-600 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="fi fi-gb mr-2"></span> {{ __('general.english') }}
                </a>
                <a href="{{ route('language.switch', 'vi') }}" class="flex items-center px-4 py-2 text-sm {{ app()->getLocale() == 'vi' ? 'bg-gray-100 text-blue-600 font-medium' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="fi fi-vn mr-2"></span> {{ __('general.vietnamese') }}
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.Alpine = window.Alpine || {
        data: function(initialState) {
            return initialState;
        }
    };
    
    // Simple Alpine.js implementation if not available
    if (typeof window.Alpine.data === 'function' && !window.Alpine.start) {
        let elements = document.querySelectorAll('[x-data]');
        elements.forEach(el => {
            const dataAttribute = el.getAttribute('x-data');
            const data = dataAttribute ? eval(`(${dataAttribute})`) : {};
            
            // Handle x-show
            const handleXShow = (element, dataObj) => {
                const showElements = element.querySelectorAll('[x-show]');
                showElements.forEach(showEl => {
                    const showExpr = showEl.getAttribute('x-show');
                    showEl.style.display = eval(`dataObj.${showExpr}`) ? '' : 'none';
                    
                    // Add click handlers for toggling
                    const clickElements = element.querySelectorAll('[\\@click]');
                    clickElements.forEach(clickEl => {
                        clickEl.addEventListener('click', function() {
                            const clickExpr = clickEl.getAttribute('@click');
                            // Handle toggle expression
                            if (clickExpr.includes('!')) {
                                const varName = clickExpr.split('=')[0].trim();
                                dataObj[varName] = !dataObj[varName];
                                handleXShow(element, dataObj);
                            }
                        });
                    });
                    
                    // Handle click away
                    if (element.hasAttribute('@click.away')) {
                        document.addEventListener('click', function(e) {
                            if (!element.contains(e.target)) {
                                const expr = element.getAttribute('@click.away');
                                const varName = expr.split('=')[0].trim();
                                dataObj[varName] = false;
                                handleXShow(element, dataObj);
                            }
                        });
                    }
                });
            };
            
            handleXShow(el, data);
        });
    }
});
</script>