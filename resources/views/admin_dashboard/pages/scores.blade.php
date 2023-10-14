<div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
    <div hx-get="{{ url("/scores/extended/list?page=$page") }}" hx-trigger="load" nunjucks-template="scores_list" hx-indicator="#scores_list_spinner" _="on htmx:load remove @hx-indicator">
        <div id="scores_list_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="scores_list">
            {% if data %}
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-fixed">
                        <thead class="text-xs text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 uppercase" colspan="4">id</th>
                                <th scope="col" class="px-6 py-3" colspan="7">user</th>
                                <th scope="col" class="px-6 py-3" colspan="7">test</th>
                                <th scope="col" class="px-6 py-3" colspan="7">question</th>
                                <th scope="col" class="px-6 py-3" colspan="7">answer</th>
                                <th scope="col" class="px-6 py-3" colspan="3">scores</th>
                            </tr>
                        </thead>
                        <tbody>
                        {% if data.scores %}
                            <!-- {% for score in data.scores %} -->
                                <tr class="odd:bg-white odd:border-b odd:hover:bg-gray-200 odd:hover:border-gray-200 even:border-b even:bg-gray-50 even:hover:bg-gray-300 even:hover:border-gray-200">
                                    <td class="px-6 py-4" colspan="4">@{{ score.id }}</td>
                                    <td class="px-6 py-4 overflow-hidden whitespace-nowrap text-ellipsis" colspan="7">
                                        <a href="#user-id-@{{ score.user.id }}-view" hx-get="{{ url('/admin/page/user?disabled=true&id=') }}@{{ score.user.id }}" hx-target=".content" class="hover:text-gray-400">
                                            @{{ score.user.firstname }} @{{ score.user.middlename }} @{{ score.user.lastname }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 overflow-hidden whitespace-nowrap text-ellipsis" colspan="7">
                                        <a href="#test-id-@{{ score.test.id }}-view" hx-get="{{ url('/admin/page/test?disabled=true&id=') }}@{{ score.test.id }}" hx-target=".content" class="hover:text-gray-400">
                                            @{{ score.test.label }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 overflow-hidden whitespace-nowrap text-ellipsis" colspan="7">
                                        <a href="#question-id-@{{ score.question.id }}-view" hx-get="{{ url('/admin/page/question?disabled=true&id=') }}@{{ score.question.id }}" hx-target=".content" class="hover:text-gray-400">
                                            @{{ score.question.text }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 overflow-hidden whitespace-nowrap text-ellipsis" colspan="7">
                                        <a href="#answer-id-@{{ score.answer.id }}-view" hx-get="{{ url('/admin/page/answer?disabled=true&id=') }}@{{ score.answer.id }}" hx-target=".content" class="hover:text-gray-400">
                                            @{{ score.answer.text }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4" colspan="3">@{{ score.points }}</td>
                                </tr>
                            <!-- {% endfor %} -->
                        {% endif %}
                        </tbody>
                    </table>
                </div>
                <x-listing.pagination :url="url('/admin/page/scores')" :view="'scores'" />
            {% endif %}
        </template>
    </div>
</div>
