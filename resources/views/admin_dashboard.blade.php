@extends('layouts.app')

@section('title', 'Admin Panel')

@section('header')
    <div class="flex justify-end">
        <form method="post" action="{{ url('/admin/logout') }}">
            <button type="submit" class="rounded-md bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 text-lg text-end">Logout</button>
        </form>
    </div>
@endsection