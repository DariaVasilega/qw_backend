<div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
    <div hx-get="{{ url("/position-histories?includes=user&page=$page") }}" hx-trigger="load" nunjucks-template="history_list" hx-indicator="#history_list_spinner" _="on htmx:load remove @hx-indicator">
        <div id="history_list_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="history_list">
            {% if data %}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 uppercase">id</th>
                            <th scope="col" class="px-6 py-3">user</th>
                            <th scope="col" class="px-6 py-3">salary</th>
                            <th scope="col" class="px-6 py-3">position</th>
                            <th scope="col" class="px-6 py-3">from date</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% if data.histories %}
                            <!-- {% for history in data.histories %} -->
                                <tr class="odd:bg-white odd:border-b odd:hover:bg-gray-200 odd:hover:border-gray-200 even:border-b even:bg-gray-50 even:hover:bg-gray-300 even:hover:border-gray-200">
                                    <td class="px-6 py-4">@{{ history.id }}</td>
                                    <td class="px-6 py-4">
                                        <a href="#user-id-@{{ history.user_id }}-view" hx-get="{{ url('/admin/page/user?disabled=true&id=') }}@{{ history.user_id }}" hx-target=".content" class="hover:text-gray-400">
                                            @{{ history.user.firstname }} @{{ history.user.middlename }} @{{ history.user.lastname }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">@{{ history.salary }} ₴</td>
                                    <td class="px-6 py-4">
                                        <a href="#position-id-@{{ history.position.code }}-view" hx-get="{{ url('/admin/page/position?disabled=true&id=') }}@{{ history.position.code}}" hx-target=".content" class="hover:text-gray-400">
                                            @{{ history.position.label }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">@{{ history.from_date.split(' ')[0] }}</td>
                                </tr>
                            <!-- {% endfor %} -->
                        {% endif %}
                        </tbody>
                    </table>
                </div>
                <x-listing.pagination :url="url('/admin/page/history')" :view="'history'" />
            {% endif %}
        </template>
    </div>
</div>
