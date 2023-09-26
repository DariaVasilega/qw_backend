@extends('layouts.app')

@section('title', 'Admin Panel')

@section('header')
    <div class="flex w-full justify-end">
        <form method="post" action="{{ url('/admin/logout') }}">
            <button type="submit" class="rounded-md bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 .text-sm text-end">Logout</button>
        </form>
    </div>
@endsection

@section('sidebar')
    @if(in_array('user_read', $permissions, true))
        <li>
            {{-- TODO: link to the page --}}
            <a href="javascript:void(0)" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                    <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                </svg>
                <span class="ml-3">Users</span>
            </a>
        </li>
    @endif
    @if(in_array('role_read', $permissions, true))
        <li>
            {{-- TODO: link to the page --}}
            <a href="javascript:void(0)" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                    <path d="M15.045.007 9.31 0a1.965 1.965 0 0 0-1.4.585L.58 7.979a2 2 0 0 0 0 2.805l6.573 6.631a1.956 1.956 0 0 0 1.4.585 1.965 1.965 0 0 0 1.4-.585l7.409-7.477A2 2 0 0 0 18 8.479v-5.5A2.972 2.972 0 0 0 15.045.007Zm-2.452 6.438a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="ml-3">Roles</span>
            </a>
        </li>
    @endif
    @if(in_array('permission_read', $permissions, true))
        <li>
            {{-- TODO: link to the page --}}
            <a href="javascript:void(0)" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 18">
                    <path d="M8 18A18.55 18.55 0 0 1 0 3l8-3 8 3a18.549 18.549 0 0 1-8 15Z"/>
                </svg>
                <span class="ml-3">Permissions</span>
            </a>
        </li>
    @endif
@endsection

@section('content')
    @if(in_array('latest_lection_statistic', $permissions, true))
        @include('admin_dashboard.latest_lection')
    @endif
@endsection