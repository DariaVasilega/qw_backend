<div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
    <div hx-get="{{ url("/users?page=$page") }}" hx-trigger="load" nunjucks-template="users_list" hx-indicator="#users_list_spinner" _="on htmx:load remove @hx-indicator">
        <div id="users_list_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="users_list">
            {% if data %}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 uppercase">id</th>
                                <th scope="col" class="px-6 py-3">first name</th>
                                <th scope="col" class="px-6 py-3">middle name</th>
                                <th scope="col" class="px-6 py-3">last name</th>
                                <th scope="col" class="px-6 py-3">date of birth</th>
                                <th scope="col" class="px-6 py-3"></th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            {% if data.users %}
                                <!-- {% for user in data.users %} -->
                                    <tr class="odd:bg-white odd:border-b odd:hover:bg-gray-200 odd:hover:border-gray-200 even:border-b even:bg-gray-50 even:hover:bg-gray-300 even:hover:border-gray-200">
                                        <td class="px-6 py-4">@{{ user.id }}</td>
                                        <td class="px-6 py-4">@{{ user.firstname }}</td>
                                        <td class="px-6 py-4">@{{ user.middlename }}</td>
                                        <td class="px-6 py-4">@{{ user.lastname }}</td>
                                        <td class="px-6 py-4">@{{ user.dob }}</td>
                                        {{-- TODO: edit entry --}}
                                        <td class="px-6 py-4 text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z"/>
                                            </svg>
                                        </td>
                                        <td class="px-6 py-4 text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-delete="{{ url('/user') }}/@{{ user.id }}" hx-target="closest tr" hx-swap="delete" _="on click wait 0.5s htmx.ajax('GET', '{{ url('/admin/page/users') . "?page=$page" }}', '.content')">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                                <path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/>
                                            </svg>
                                        </td>
                                    </tr>
                               <!-- {% endfor %} -->
                            {% endif %}
                        </tbody>
                    </table>
                </div>
                <x-listing.pagination :url="url('/admin/page/users')" />
            {% endif %}
        </template>
    </div>
</div>
