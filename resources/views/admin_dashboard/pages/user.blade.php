@if($id)
    <div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
        <div hx-get="{{ url("/user/$id") }}" hx-trigger="load" nunjucks-template="user_form" hx-indicator="#user_form_spinner" _="on htmx:load remove @hx-indicator">
            <div id="user_form_spinner" class="flex justify-center">
                <img alt="Spinner" class="h-50 w-50" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif"/>
            </div>
            <template id="user_form">
@endif
            <form class="flex flex-col m-auto w-full md:w-10/12 lg:w-1/2 max-w-2xl border-2 border-gray-300 border-dashed rounded-lg p-6">
                <fieldset>
                    <legend class="mb-4 flex justify-between items-center w-full">
                        <span class="text-2xl text-gray-500 capitalize">
                            @if($disabled)
                                user information
                            @elseif($id)
                                user editing
                            @else
                                user creating
                            @endif
                        </span>
                        @if($disabled)
                            <span class="flex">
                                @if(in_array('user_update', $permissions, true))
                                    <a href="#user-id-@{{ data.user.id }}-edit" class="mx-2 text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-get="{{ url('/admin/page/user?id=') }}@{{ data.user.id }}" hx-target=".content">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="m13.835 7.578-.005.007-7.137 7.137 2.139 2.138 7.143-7.142-2.14-2.14Zm-10.696 3.59 2.139 2.14 7.138-7.137.007-.005-2.141-2.141-7.143 7.143Zm1.433 4.261L2 12.852.051 18.684a1 1 0 0 0 1.265 1.264L7.147 18l-2.575-2.571Zm14.249-14.25a4.03 4.03 0 0 0-5.693 0L11.7 2.611 17.389 8.3l1.432-1.432a4.029 4.029 0 0 0 0-5.689Z"/>
                                        </svg>
                                    </a>
                                @endif
                                @if(in_array('user_delete', $permissions, true))
                                    <a href="#users" class="mx-2 text-gray-400 transition duration-75 hover:text-gray-900 hover:cursor-pointer" hx-delete="{{ url('/user') }}/@{{ data.user.id }}" hx-target="closest form" hx-swap="delete" _="on click wait 0.1s htmx.ajax('GET', '{{ url('/admin/page/users') }}', '.content')">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                            <path d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z"/>
                                        </svg>
                                    </a>
                                @endif
                            </span>
                        @else
                            <div hx-ext="client-side-templates" _="on htmx:error set errors to JSON.parse(event.detail.errorInfo.xhr.response).error.description then for inputName in Object.keys(errors) add .border-red-600 to the <[id=`${inputName}`] /> then add .focus:border-red-600 to the <[id=`${inputName}`] /> then add .text-red-600 to the <[for=`${inputName}`] /> then add .peer-focus:text-red-600 to the <[for=`${inputName}`] /> then remove .hidden from <[id=`${inputName}_error`] /> then put errors[inputName].join('<br/>') into <[id=`${inputName}_error`] > span /> end">
                                <div @if($id) hx-put="{{ url("/user/$id") }}" @else hx-post="{{ url('/user') }}" @endif hx-include="[name]" nunjucks-template="response_message" hx-target=".content">
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
                            <input type="text" name="email" id="email" aria-describedby="email_error" class="block px-2.5 pb-1.5 pt-3 w-full text-lg text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @if($id) value="@{{ data.user.email }}" @endif {{ $disabled }} _="on focus add .hidden to the <[id='email_error'] /> then remove .border-red-600 from me then remove .focus:border-red-600 from me then remove .peer-focus:text-red-600 from <[for='email'] /> then remove .text-red-600 from <[for='email'] />"/>
                            <label for="email" class="absolute font-medium text-gray-500 duration-300 transform -translate-y-3 scale-90 top-0 z-10 origin-[0] bg-gray-100 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:-top-0.5 peer-focus:scale-95 left-3 capitalize">email</label>
                        </div>
                        <p id="email_error" class="mt-2 ml-2 text-sm text-red-600 hidden"><span class="font-medium"></span></p>
                    </div>
                    <div class="my-4">
                        <div class="relative">
                            <input type="text" name="firstname" id="firstname" aria-describedby="firstname_error" class="block px-2.5 pb-1.5 pt-3 w-full text-lg text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @if($id) value="@{{ data.user.firstname }}" @endif {{ $disabled }} _="on focus add .hidden to the <[id='firstname_error'] /> then remove .border-red-600 from me then remove .focus:border-red-600 from me then remove .peer-focus:text-red-600 from <[for='firstname'] /> then remove .text-red-600 from <[for='firstname'] />"/>
                            <label for="firstname" class="absolute font-medium text-gray-500 duration-300 transform -translate-y-3 scale-90 top-0 z-10 origin-[0] bg-gray-100 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:-top-0.5 peer-focus:scale-95 left-3 capitalize">first name</label>
                        </div>
                        <p id="firstname_error" class="mt-2 ml-2 text-sm text-red-600 hidden"><span class="font-medium"></span></p>
                    </div>
                    <div class="my-4">
                        <div class="relative">
                            <input type="text" name="middlename" id="middlename" aria-describedby="middlename_error" class="block px-2.5 pb-1.5 pt-3 w-full text-lg text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @if($id) value="@{{ data.user.middlename }}" @endif {{ $disabled }} _="on focus add .hidden to the <[id='middlename_error'] /> then remove .border-red-600 from me then remove .focus:border-red-600 from me then remove .peer-focus:text-red-600 from <[for='middlename'] /> then remove .text-red-600 from <[for='middlename'] />"/>
                            <label for="middlename" class="absolute font-medium text-gray-500 duration-300 transform -translate-y-3 scale-90 top-0 z-10 origin-[0] bg-gray-100 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:-top-0.5 peer-focus:scale-95 left-3 capitalize">middle name</label>
                        </div>
                        <p id="middlename_error" class="mt-2 ml-2 text-sm text-red-600 hidden"><span class="font-medium"></span></p>
                    </div>
                    <div class="my-4">
                        <div class="relative">
                            <input type="text" name="lastname" id="lastname" aria-describedby="lastname_error" class="block px-2.5 pb-1.5 pt-3 w-full text-lg text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @if($id) value="@{{ data.user.lastname }}" @endif {{ $disabled }} _="on focus add .hidden to the <[id='lastname_error'] /> then remove .border-red-600 from me then remove .focus:border-red-600 from me then remove .peer-focus:text-red-600 from <[for='lastname'] /> then remove .text-red-600 from <[for='lastname'] />"/>
                            <label for="lastname" class="absolute font-medium text-gray-500 duration-300 transform -translate-y-3 scale-90 top-0 z-10 origin-[0] bg-gray-100 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:-top-0.5 peer-focus:scale-95 left-3 capitalize">last name</label>
                        </div>
                        <p id="lastname_error" class="mt-2 ml-2 text-sm text-red-600 hidden"><span class="font-medium"></span></p>
                    </div>
                    <div class="my-4">
                        <div class="relative">
                            <div class="absolute top-1 inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd" datepicker-orientation="bottom" aria-describedby="dob_error" _="on load datepicker.initDatepickers() then on focus add .hidden to the <[id='dob_error'] /> then remove .border-red-600 from me then remove .focus:border-red-600 from me then remove .peer-focus:text-red-600 from <[for='dob'] /> then remove .text-red-600 from <[for='dob'] />" type="text" name="dob" id="dob" class="block px-2.5 pl-10 pb-1.5 pt-3 w-full text-lg text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " @if($id) value="@{{ data.user.dob}}" @endif {{ $disabled }}/>
                            <label for="dob" class="absolute font-medium text-gray-500 duration-300 transform -translate-y-3 scale-90 top-0 z-10 origin-[0] bg-gray-100 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:-top-0.5 peer-focus:scale-95 left-3 capitalize">date of birth</label>
                        </div>
                        <p id="dob_error" class="mt-2 ml-2 text-sm text-red-600 hidden"><span class="font-medium"></span></p>
                    </div>
                    @if(!$disabled)
                        <div class="my-4">
                            <div class="relative">
                                <input type="password" name="password" id="password" aria-describedby="password_error" class="block px-2.5 pb-1.5 pt-3 w-full text-lg text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " _="on focus add .hidden to the <[id='password_error'] /> then remove .border-red-600 from me then remove .focus:border-red-600 from me then remove .peer-focus:text-red-600 from <[for='password'] /> then remove .text-red-600 from <[for='password'] />"/>
                                <label for="password" class="absolute font-medium text-gray-500 duration-300 transform -translate-y-3 scale-90 top-0 z-10 origin-[0] bg-gray-100 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:-top-0.5 peer-focus:scale-95 left-3 capitalize">password</label>
                            </div>
                        </div>
                        <p id="password_error" class="mt-2 ml-2 text-sm text-red-600 hidden"><span class="font-medium"></span></p>
                    @endif
                </fieldset>
                @if(!$disabled)
                    <fieldset>
                        <div hx-ext="client-side-templates" _="on htmx:load remove @hx-ext">
                            <div hx-get="{{ url('/roles?limit=99999') }}" hx-trigger="load" nunjucks-template="add_roles_to_user" hx-indicator="#add_roles_to_user_spinner">
                                <div id="add_roles_to_user_spinner" class="flex justify-center">
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

<template id="add_roles_to_user">
    {% if data.roles %}
        <legend class="mb-4 w-full text-center">
            <span class="text-lg text-gray-500">Add roles to user</span>
        </legend>
        <div class="w-full rounded-lg shadow">
            <ul class="p-3 space-y-1 text-sm text-gray-700 flex flex-wrap">
                {% for role in data.roles %}
                    <li>
                        <div class="flex items-center p-2 rounded hover:bg-gray-200">
                            <input name="codes[@{{ loop.index }}]" id="role-@{{ role.code }}" type="checkbox" value="@{{ role.code }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                            <label for="role-@{{ role.code }}" class="w-full ml-2 text-sm font-medium text-gray-900 rounded">@{{ role.label }}</label>
                        </div>
                    </li>
                {% endfor %}
            </ul>
        </div>
    {% endif %}
</template>

<template id="response_message">
    <?php $userId = ($id ?: '{{ data.user.id }}') ?>
    <?php $newEntityUrl = url('/admin/page/user?disabled=true&id=') . $userId ?>
    <div class="flex justify-center" hx-get="{{ $newEntityUrl }}" hx-trigger="load delay:500ms" hx-target=".content" hx-on::before-request="window.location.hash='#user-id-{{ $userId }}-view'">
        <p class="text-gray-500 text-lg">@{{ data.message }}</p>
    </div>
</template>

@if($id && in_array('role_read', $permissions, true))
    <x-listing.related
            :batch-url='url("/user/{$userManager->getAuthMicroserviceUserIdByNativeUserId((int) $id)}/roles")'
            :get-one-url="url('/admin/page/role?disabled=true&id=') . '@{{ role.code }}'"
            :get-one-route="'#role-id-@{{ role.code }}-view'"
            :permissions="$permissions"
            :update-permission="'user_update'"
            :disabled="$disabled"
            :id="'@{{ role.code }}'"
            :label="'@{{ role.label }}'"
            :entities="'data.roles'"
            :entity="'role'"
            :headline="'user roles listing'"
            :checkbox-name="'codes'"
    />
@endif
