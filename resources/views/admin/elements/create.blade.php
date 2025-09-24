@extends('layouts.master')

@section('content')
    <x-dashboard-layout title="ایجاد - ویرایش ابزار‌ها">
        <form enctype="multipart/form-data"
            action="{{ !empty($id) ? route('elements.update', ['id' => $id]) : route('elements.store') }}"
            method="POST" class="space-y-6">

            @include('partials.errors')
            @csrf
            <div>
                <label for="name" class="block text-base font-medium text-gray-900">نام</label>
                <div class="mt-2">
                    <input id="name" value="{{ !empty($row) ? $row->name : '' }}" type="name" name="name"
                        autocomplete="name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>

            <div>
                <label for="type" class="block text-base font-medium text-gray-900">نوع</label>
                <div class="mt-2">
                    <input id="type" value="{{ !empty($row) ? $row->type : '' }}" type="text" name="type"
                        autocomplete="type"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>

            <div>
                <label for="icon" class="block text-base font-medium text-gray-900">آیکون</label>
                <div class="mt-2">
                    <input id="icon" type="file" name="icon" autocomplete="icon"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>


            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">ثبت
                </button>
            </div>
        </form>
    </x-dashboard-layout>
@endsection
