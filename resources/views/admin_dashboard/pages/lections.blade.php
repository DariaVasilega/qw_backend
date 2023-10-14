<div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext" class="flex flex-col">
    @if(in_array('lection_create', $permissions, true))
        <div class="flex justify-end">
            <a href="#lection" class="text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer my-6 mx-2 md:mx-6" hx-get="{{ url('/admin/page/lection') }}" hx-target=".content">
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.546.5a9.5 9.5 0 1 0 9.5 9.5 9.51 9.51 0 0 0-9.5-9.5ZM13.788 11h-3.242v3.242a1 1 0 1 1-2 0V11H5.304a1 1 0 0 1 0-2h3.242V5.758a1 1 0 0 1 2 0V9h3.242a1 1 0 1 1 0 2Z"/>
                </svg>
            </a>
        </div>
    @endif
    <div hx-get="{{ url("/lections?page=$page") }}" hx-trigger="load" nunjucks-template="lections_list" hx-indicator="#lections_list_spinner" _="on htmx:load remove @hx-indicator">
        <div id="lections_list_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="lections_list">
            {% if data %}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-fixed">
                        <thead class="text-xs text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 uppercase" colspan="2">id</th>
                            <th scope="col" class="px-6 py-3" colspan="30">text</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% if data.lections %}
                            <!-- {% for lection in data.lections %} -->
                                <tr class="odd:bg-white odd:border-b odd:hover:bg-gray-200 odd:hover:border-gray-200 even:border-b even:bg-gray-50 even:hover:bg-gray-300 even:hover:border-gray-200">
                                    <td class="px-6 py-4" colspan="2">@{{ lection.id }}</td>
                                    <td class="px-6 py-4 overflow-hidden whitespace-nowrap text-ellipsis" colspan="30">
                                        <a class="hover:text-gray-400" href="#lection-id-@{{ lection.id }}-view" hx-get="{{ url('/admin/page/lection?disabled=true&id=') }}@{{ lection.id }}" hx-target=".content">@{{ lection.text }}</a>
                                    </td>
                                </tr>
                            <!-- {% endfor %} -->
                        {% endif %}
                        </tbody>
                    </table>
                </div>
                <x-listing.pagination :url="url('/admin/page/lections')" :view="'lections'" />
            {% endif %}
        </template>
    </div>
</div>
