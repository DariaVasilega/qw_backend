<div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext from me" class="mb-4 bg-gray-50 p-4 border-2 border-gray-300 border-dashed rounded-lg">
    <div hx-get="{{ url('/users/most-perspective') }}" hx-trigger="load" nunjucks-template="most_perspective_users" hx-indicator="#most_perspective_users_spinner" _="on htmx:load remove @hx-indicator from me">
        <div id="most_perspective_users_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="most_perspective_users">
            <div class="text-gray-500 flex flex-col">
                {% if users %}
                    <div class="flex justify-center mb-4">
                        <p class="text-2xl">The most perspective users</p>
                    </div>
                    <div class="flex justify-center">
                        <ul class="w-10/12">
                            <li class="flex justify-around w-full p-2 mb-2 items-center">
                                <div class="w-1/2 flex justify-start">
                                    <p class="capitalize">user name:</p>
                                </div>
                                <div class="w-1/2 flex justify-end">
                                    <p class="capitalize">scores:</p>
                                </div>
                            </li>
                            <!-- {% for user in users %} -->
                                <li class="flex w-full p-2 hover:border-2 hover:border-gray-400 hover:rounded-lg items-center">
                                    <div class="w-1/2 flex justify-start">
                                        <a class="hover:text-gray-400" href="#user-id-@{{ user.id }}-view" hx-get="{{ url('/admin/page/user?disabled=true&id=') }}@{{ user.id }}" hx-target=".content">@{{ user.firstname }} @{{ user.middlename }} @{{ user.lastname }}</a>
                                    </div>
                                    <div class="w-1/2 flex justify-end">
                                        <p>@{{ user.scores | round(1, "floor") }}</p>
                                    </div>
                                </li>
                            <!-- {% endfor %} -->
                        </ul>
                    </div>
                {% endif %}
            </div>
        </template>
    </div>
</div>