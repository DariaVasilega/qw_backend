<div hx-ext="client-side-templates">
    <div hx-get="{{ $batchUrl }}" hx-trigger="load" nunjucks-template="related_{{ $entity }}_list" hx-indicator="#related_{{ $entity }}_spinner">
        <div id="related_{{ $entity }}_spinner" class="flex justify-center">
            <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
        </div>
        <template id="related_{{ $entity }}_list">
            {% if {{ $entities }} %}
                <div class="flex justify-center my-6">
                    <p class="text-2xl text-gray-500 capitalize">{{ $headline }}</p>
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-auto my-6 w-full md:w-10/12 lg:w-1/2 max-w-2xl">
                    <table id="related_{{ $entity }}_table" class="text-sm text-left text-gray-500 w-full">
                        <thead class="text-xs text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                @if(! $disabled && in_array($updatePermission, $permissions, true))
                                    <th scope="col" class="px-6 py-3 flex justify-start"></th>
                                @endif
                                <th scope="col" class="px-6 py-3">{{ $entity }}</th>
                                @if(! $disabled && in_array($updatePermission, $permissions, true))
                                    <th scope="col" class="px-6 py-3 flex justify-end">
                                        <a href="javascript:void(0)" class="text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" _="on click set elements to Array.from(document.querySelectorAll('#related_{{ $entity }}_table [name^={{ $checkboxName }}]:checked')) then if elements.length === 0 set values to {'{{ $checkboxName }}[0]': '*'} else set values to {} then put elements as Values into values end then htmx.ajax('DELETE', '{{ $batchUrl }}', {swap: 'none', values: values }) then if values['{{ $checkboxName }}[0]'] === '*' then document.querySelector('tbody').classList.add('hidden') else for checkbox in elements checkbox.closest('tr').classList.add('hidden') end remove elements then remove values end">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                                <path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/>
                                            </svg>
                                        </a>
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        <!-- {% for {{ $entity }} in {{ $entities }} %} -->
                            <tr id="{{ $entity }}-row-@{{ loop.index }}" class="odd:bg-white odd:border-b odd:hover:bg-gray-200 odd:hover:border-gray-200 even:border-b even:bg-gray-50 even:hover:bg-gray-300 even:hover:border-gray-200">
                                @if(! $disabled && in_array($updatePermission, $permissions, true))
                                    <td class="px-6 py-4 flex justify-start">
                                        <label class="hover:cursor-pointer">
                                            <input type="checkbox" name="{{ $checkboxName }}[@{{ loop.index }}]" value="{{ $id }}" class="hover:cursor-pointer w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        </label>
                                    </td>
                                @endif
                                <td class="px-6 py-4">
                                    <a href="{{ $getOneRoute }}" hx-get="{{ $getOneUrl }}" hx-target=".content">{{ $label }}</a>
                                </td>
                                @if(! $disabled && in_array($updatePermission, $permissions, true))
                                    <td class="px-6 py-4 flex justify-end">
                                        <a href="javascript:void(0)" class="text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" _="on click htmx.ajax('DELETE', '{{ $batchUrl }}', { target: '#{{ $entity }}-row-@{{ loop.index }}', swap: 'delete', values: { '{{ $checkboxName }}[0]': document.querySelector('#related_{{ $entity }}_table [name=\'{{ $checkboxName }}[@{{ loop.index }}]\']').value } } )">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                                <path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/>
                                            </svg>
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        <!-- {% endfor %} -->
                        </tbody>
                    </table>
                </div>
            {% endif %}
        </template>
    </div>
</div>