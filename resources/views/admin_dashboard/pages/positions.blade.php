<div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
    <div hx-get="{{ url("/positions?page=$page") }}" hx-trigger="load" nunjucks-template="positions_list" hx-indicator="#positions_list_spinner" _="on htmx:load remove @hx-indicator">
        <div id="positions_list_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="positions_list">
            {% if data %}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">code</th>
                                <th scope="col" class="px-6 py-3">label</th>
                                @if(in_array('position_update', $permissions, true))
                                    <th scope="col" class="px-6 py-3"></th>
                                @endif
                                @if(in_array('position_delete', $permissions, true))
                                    <th scope="col" class="px-6 py-3"></th>
                                @endif
                                @if(in_array('position_create', $permissions, true))
                                    <th scope="col" class="px-6 py-3 text-center">
                                        <a href="#position" class="text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-get="{{ url('/admin/page/position') }}" hx-target=".content">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.546.5a9.5 9.5 0 1 0 9.5 9.5 9.51 9.51 0 0 0-9.5-9.5ZM13.788 11h-3.242v3.242a1 1 0 1 1-2 0V11H5.304a1 1 0 0 1 0-2h3.242V5.758a1 1 0 0 1 2 0V9h3.242a1 1 0 1 1 0 2Z"/>
                                            </svg>
                                        </a>
                                    </th>
                                @else
                                    <th scope="col" class="px-6 py-3"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {% if data.positions %}
                                <!-- {% for position in data.positions %} -->
                                    <tr class="odd:bg-white odd:border-b odd:hover:bg-gray-200 odd:hover:border-gray-200 even:border-b even:bg-gray-50 even:hover:bg-gray-300 even:hover:border-gray-200">
                                        <td class="px-6 py-4">@{{ position.code }}</td>
                                        <td class="px-6 py-4">@{{ position.label }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="#position-id-@{{ position.code }}-view" class="text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-get="{{ url('/admin/page/position?id=') }}@{{ position.code }}&disabled=true" hx-target=".content">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                                                    <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                                                </svg>
                                            </a>
                                        </td>
                                        @if(in_array('position_update', $permissions, true))
                                            <td class="px-6 py-4 text-center">
                                                <a href="#position-id-@{{ position.code }}-edit" class="text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-get="{{ url('/admin/page/position?id=') }}@{{ position.code }}" hx-target=".content">
                                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        @endif
                                        @if(in_array('position_delete', $permissions, true))
                                            <td class="px-6 py-4 text-center">
                                                <a href="#positions-p{{ $page }}" class="text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-delete="{{ url('/position') }}/@{{ position.code }}" hx-target="closest tr" hx-swap="delete" _="on click wait 0.5s htmx.ajax('GET', '{{ url('/admin/page/positions') . "?page=$page" }}', '.content')">
                                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                                        <path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                               <!-- {% endfor %} -->
                            {% endif %}
                        </tbody>
                    </table>
                </div>
                <x-listing.pagination :url="url('/admin/page/positions')" :view="'positions'" />
            {% endif %}
        </template>
    </div>
</div>
