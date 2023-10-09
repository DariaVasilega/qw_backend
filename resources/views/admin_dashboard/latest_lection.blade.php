<div class="flex items-center justify-center mb-4 bg-gray-50 p-4 border-2 border-gray-300 border-dashed rounded-lg" hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
    <div class="flex flex-col w-full" hx-get="{{ url('/lection/last/statistic') }}" hx-trigger="load" nunjucks-template="last_lection_statistic" hx-indicator="#last_lection_statistic_spinner" _="on htmx:load remove @hx-indicator">
        <div id="last_lection_statistic_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="last_lection_statistic">
            <div class="flex justify-center mb-4">
                {% if label %}
                    <p class="text-2xl text-gray-500">Statistic for Lection Test: "<span hx-get="{{ url('/admin/page/test?disabled=true&id=') }}@{{ test }}" hx-target=".content" class="text-gray-400 hover:text-gray-300 hover:cursor-pointer underline">@{{ label }}</span>"</p>
                {% else %}
                    <p class="text-2xl text-gray-500">This lection has not tests</p>
                {% endif %}
            </div>
            <div class="relative w-50 h-50 -mt-5">
                <div class="flex flex-nowrap">
                    <div class="w-full flex justify-around my-12">
                        <div class="w-1/3">
                            <div class="max-w-[250px] max-h-[250px]">
                                {{-- Circle --}}
                                <p class="-mt-10 mb-8 text-gray-500">Indicator of Completing:</p>
                                <svg viewBox="0 0 36 36" class="block stroke-gray-500 hover:scale-110 hover:cursor-pointer">
                                    <path stroke-width="3.8" class="fill-none stroke-[#eee]"
                                          d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                    />
                                    <path class="fill-none "
                                          stroke-width="3.8"
                                          stroke-linecap="round"
                                          stroke-dasharray="@{{ percentage }}, 100"
                                          d="M18 2.0845
                                              a 15.9155 15.9155 0 0 1 0 31.831
                                              a 15.9155 15.9155 0 0 1 0 -31.831"
                                    />
                                    <text x="9" y="21" font-size="10px" font-stretch="extra-expanded" font-weight="lighter">@{{ percentage }}%</text>
                                </svg>
                                {{-- Circle --}}
                            </div>
                        </div>
                        <div class="w-1/3 max-h-[250px] overflow-scroll text-gray-500">
                            <p class="mb-6">Users, not finished the test yet:</p>
                            <ul>
                                {% if users %}
                                    {% for user in users %}
                                        <li class="hover:text-gray-400 hover:cursor-pointer" hx-get="{{ url('/admin/page/user?id=') }}@{{ user.id }}&disabled=true" hx-target=".content">
                                            <a href="#user-id-@{{ user.id }}-view">@{{ user.firstname }} @{{ user.lastname }}</a>
                                        </li>
                                    {% endfor %}
                                {% endif %}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>