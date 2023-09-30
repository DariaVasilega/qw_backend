<!-- {% if data.page and data.page.count > 1 %} -->
    <nav aria-label="Page Navigation" class="my-6 flex justify-center">
        <ul class="flex items-center -space-x-px h-8 text-sm self-end">
            <!-- {% if data.page.current > 1 %} -->
            <li>
                <a hx-get="{{ $url }}?page=@{{ data.page.current - 1 }}" hx-target=".content" href="#{{ $view }}-p@{{ data.page.current - 1 }}" class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Previous</span>
                    <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                </a>
            </li>
            <!-- {% endif %} -->
            <!-- {% for page in range(1, data.page.count + 1) %} -->
            <li>
                {% if page === data.page.current %}
                <a hx-get="{{ $url }}?page=@{{ page }}" hx-target=".content" href="#{{ $view }}-p@{{ page }}" aria-current="page" class="flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white">@{{ page }}</a>
                {% else %}
                <a hx-get="{{ $url }}?page=@{{ page }}" hx-target=".content" href="#{{ $view }}-p@{{ page }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">@{{ page }}</a>
                {% endif %}
            </li>
            <!-- {% endfor %} -->
            <!-- {% if data.page.current < data.page.count %} -->
            <li>
                <a hx-get="{{ $url }}?page=@{{ data.page.current + 1 }}" hx-target=".content" href="#{{ $view }}-p@{{ data.page.current + 1 }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Next</span>
                    <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                </a>
            </li>
            <!-- {% endif %} -->
        </ul>
    </nav>
<!-- {% endif %} -->