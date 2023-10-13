<div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext from me" class="mb-4 bg-gray-50 p-4 border-2 border-gray-300 border-dashed rounded-lg">
    <div hx-get="{{ url('/position-histories?order_by=id,desc&includes=position,user') }}" hx-trigger="load" nunjucks-template="user_changes" hx-indicator="#user_changes_spinner" _="on htmx:load remove @hx-indicator from me" class="overflow-x-auto">
        <div id="user_changes_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="user_changes">
            <!-- {% if data.histories %} -->
                <table class="w-full text-sm text-left text-gray-500">
                    <tbody class="border-1 border-solid border-gray-300 rounded-lg">
                        <!-- {% for history in data.histories %} -->
                            <tr class="odd:bg-white odd:border-b odd:hover:bg-gray-200 odd:hover:border-gray-200 even:border-b even:bg-gray-50 even:hover:bg-gray-300 even:hover:border-gray-200">
                                <th scope="row" class="px-6 py-4 text-gray-700 dark:text-white font-bold capitalize">
                                    user
                                </th>
                                <td class="px-6 py-4">
                                    <a href="#user-id-@{{ history.user.id }}-view" hx-get="{{ url('admin/page/user?disabled=true&id=') }}@{{ history.user.id }}" hx-target=".content" class="hover:text-gray-400">
                                        @{{ history.user.firstname }} @{{ history.user.middlename }} @{{ history.user.lastname }}
                                    </a>
                                </td>
                                <th scope="row" class="px-6 py-4 text-gray-700 dark:text-white font-bold">
                                    got position
                                </th>
                                <td class="px-6 py-4">
                                    <a href="#position-id-@{{ history.position.code }}-view" hx-get="{{ url('admin/page/position?disabled=true&id=') }}@{{ history.position.label }}" hx-target=".content" class="hover:text-gray-400">
                                        @{{ history.position.label }}
                                    </a>
                                </td>
                                <th scope="row" class="px-6 py-4 text-gray-700 dark:text-white font-bold">
                                    with salary
                                </th>
                                <td class="px-6 py-4">
                                    @{{ history.salary | round(1, "floor") }} ₴
                                </td>
                                <th scope="row" class="px-6 py-4 text-gray-700 dark:text-white font-bold">
                                    from
                                </th>
                                <td class="px-6 py-4">
                                    @{{ history.from_date.split(' ')[0] }}
                                </td>
                            </tr>
                        <!-- {% endfor %} -->
                    </tbody>
                </table>
            <!-- {% endif %} -->
        </template>
    </div>
</div>