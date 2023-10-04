@if($id)
    <div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
        <div hx-get="{{ url("/role/$id") }}" hx-trigger="load" nunjucks-template="role_form" hx-indicator="#role_form_spinner" _="on htmx:load remove @hx-indicator">
            <div id="role_form_spinner" class="flex justify-center">
                <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
            </div>
            <template id="role_form">
@endif
            <form class="flex flex-col m-auto w-full md:w-10/12 lg:w-1/2 max-w-2xl border-2 border-gray-300 border-dashed rounded-lg p-6">
                <fieldset>
                    <legend class="mb-4 flex justify-between items-center w-full">
                        <span class="text-2xl text-gray-500 capitalize">
                            @if($disabled)
                                role information
                            @elseif($id)
                                role editing
                            @else
                                role creating
                            @endif
                        </span>
                        @if($disabled)
                            <span class="flex">
                                @if(in_array('role_update', $permissions, true))
                                    <a href="#role-id-@{{ data.role.code }}-edit" class="mx-2 text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-get="{{ url('/admin/page/role?id=') }}@{{ data.role.code }}" hx-target=".content">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if(in_array('role_delete', $permissions, true))
                                    <a href="#roles" class="mx-2 text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-delete="{{ url('/role') }}/@{{ data.role.code }}" hx-target="closest form" hx-swap="delete" _="on click wait 0.1s htmx.ajax('GET', '{{ url('/admin/page/roles') }}', '.content')">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                            <path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/>
                                        </svg>
                                    </a>
                                @endif
                            </span>
                        @else
                            <div hx-ext="client-side-templates" _="on htmx:error set errors to JSON.parse(event.detail.errorInfo.xhr.response).error.description then for inputName in Object.keys(errors) add .border-red-600 to the <[id=`${inputName}`] /> then add .focus:border-red-600 to the <[id=`${inputName}`] /> then add .text-red-600 to the <[for=`${inputName}`] /> then add .peer-focus:text-red-600 to the <[for=`${inputName}`] /> then remove .hidden from <[id=`${inputName}_error`] /> then put errors[inputName].join('<br/>') into <[id=`${inputName}_error`] > span /> end">
                                <div @if($id) hx-put="{{ url("/role/$id") }}" @else hx-post="{{ url('/role') }}" @endif hx-include="[name]" nunjucks-template="response_message" hx-target=".content">
                                    <div class="text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer">
                                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </legend>
                    <div class="my-4">
                        <div class="relative">
                            <input type="text" name="code" id="code" aria-describedby="code_error" onload="window.roleCode = this.value" onchange="window.roleCode = this.value" class="block px-2.5 pb-1.5 pt-3 w-full text-lg text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @if($id) value="@{{ data.role.code }}" @endif {{ $disabled }} _="on focus add .hidden to the <[id='code_error'] /> then remove .border-red-600 from me then remove .focus:border-red-600 from me then remove .peer-focus:text-red-600 from <[for='code'] /> then remove .text-red-600 from <[for='code'] />"/>
                            <label for="code" class="absolute font-medium text-gray-500 duration-300 transform -translate-y-3 scale-90 top-0 z-10 origin-[0] bg-gray-100 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:-top-0.5 peer-focus:scale-95 left-3 capitalize">code</label>
                        </div>
                        <p id="code_error" class="mt-2 ml-2 text-sm text-red-600 hidden"><span class="font-medium"></span></p>
                    </div>
                    <div class="my-4">
                        <div class="relative">
                            <input type="text" name="label" id="label" aria-describedby="label_error" class="block px-2.5 pb-1.5 pt-3 w-full text-lg text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @if($id) value="@{{ data.role.label }}" @endif {{ $disabled }} _="on focus add .hidden to the <[id='label_error'] /> then remove .border-red-600 from me then remove .focus:border-red-600 from me then remove .peer-focus:text-red-600 from <[for='label'] /> then remove .text-red-600 from <[for='label'] />"/>
                            <label for="label" class="absolute font-medium text-gray-500 duration-300 transform -translate-y-3 scale-90 top-0 z-10 origin-[0] bg-gray-100 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:-top-0.5 peer-focus:scale-95 left-3 capitalize">label</label>
                        </div>
                        <p id="label_error" class="mt-2 ml-2 text-sm text-red-600 hidden"><span class="font-medium"></span></p>
                    </div>
                </fieldset>
                @if(!$disabled)
                    <fieldset>
                        <div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
                            <div hx-get="{{ url('/permissions?limit=99999') }}" hx-trigger="load" nunjucks-template="add_permissions_to_role" hx-indicator="#add_permissions_to_role_spinner">
                                <div id="add_permissions_to_role_spinner" class="flex justify-center">
                                    <img alt="Spinner" class="h-20 w-20" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                @endif
            </form>
@if($id)
            </template>
        </div>
    </div>
@endif

<template id="add_permissions_to_role">
    {% if data.permissions %}
    <legend class="mb-4 w-full text-center">
        <span class="text-lg text-gray-500">Add permissions to role</span>
    </legend>
    <div class="w-full rounded-lg shadow">
        <ul class="p-3 space-y-1 text-sm text-gray-700 flex flex-wrap">
            {% for permission in data.permissions %}
            <li>
                <div class="flex items-center p-2 rounded hover:bg-gray-200">
                    <input name="codes[@{{ loop.index }}]" id="permission-@{{ permission.code }}" type="checkbox" value="@{{ permission.code }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="permission-@{{ permission.code }}" class="w-full ml-2 text-sm font-medium text-gray-900 rounded">@{{ permission.label }}</label>
                </div>
            </li>
            {% endfor %}
        </ul>
    </div>
    {% endif %}
</template>

<template id="response_message">
    <div class="flex justify-center" hx-on::load="window.location.hash=`#role-id-${window.roleCode}-view`; htmx.ajax('GET', `{{ url('/admin/page/role?disabled=true&id=') }}${window.roleCode}`, '.content')">
        <p class="text-gray-500 text-lg">@{{ data.message }}</p>
    </div>
</template>

@if($id && in_array('permission_read', $permissions, true))
    <x-listing.related
            :batch-url='url("/role/$id/permissions")'
            :get-one-url="url('/admin/page/permission?disabled=true&id=') . '@{{ permission.code }}'"
            :get-one-route="'#permission-id-@{{ permission.code }}-view'"
            :permissions="$permissions"
            :update-permission="'role_update'"
            :disabled="$disabled"
            :id="'@{{ permission.code }}'"
            :label="'@{{ permission.label }}'"
            :entities="'data.permissions'"
            :entity="'permission'"
            :headline="'role permissions listing'"
            :checkbox-name="'codes'"
    />
@endif