@extends('layouts.master')

@section('content')
    <x-dashboard-layout title="ایجاد - ویرایش ابزار‌ها">
        <form enctype="multipart/form-data"
            action="{{ !empty($id) ? route('integrations.update', ['id' => $id]) : route('integrations.store') }}"
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
                <label for="description" class="block text-base font-medium text-gray-900">توضیحات</label>
                <div class="mt-2">
                    <input id="description" value="{{ !empty($row) ? $row->description : '' }}" type="text"
                        name="description" autocomplete="description"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>

            <div>
                <label for="slug" class="block text-base font-medium text-gray-900">شناسه یکتا</label>
                <div class="mt-2">
                    <input id="slug" value="{{ !empty($row) ? $row->slug : '' }}" type="text" name="slug"
                        autocomplete="slug"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>

            <div>
                <label for="background" class="block text-base font-medium text-gray-900">رنگ پس‌زمینه</label>
                <div class="mt-2">
                    <input id="background" value="{{ !empty($row) ? $row->background : '' }}" type="text"
                        name="background" autocomplete="background"
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
                <label for="parent_id" class="block text-base font-medium text-gray-900">والد</label>
                <div class="mt-2">
                    <select id="parent_id" type="text" name="parent_id" autocomplete="parent_id"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option value="0">ندارد</option>
                        @if (!empty($integrations))
                            @foreach ($integrations as $integration)
                                <option @if (!empty($row) && $row->parent_id == $integration->id) selected @endif value="{{ $integration->id }}">
                                    {{ $integration->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div>
                <label for="type" class="block text-base font-medium text-gray-900">نوع</label>
                <div class="mt-2">
                    <select id="type" type="text" name="type" autocomplete="type"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option @if (!empty($row) && $row->type == 'core') selected @endif value="core">اصلی</option>
                        <option @if (!empty($row) && $row->type == 'tools') selected @endif value="tools">ابزار</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="is_mcp_server" class="block text-base font-medium text-gray-900">MCP</label>
                <div class="mt-2">
                    <select id="is_mcp_server" is_mcp_server="text" name="is_mcp_server" autocomplete="is_mcp_server"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        <option @if (!empty($row) && $row->is_mcp_server) selected @endif value="1">بله</option>
                        <option @if (!empty($row) && !$row->is_mcp_server) selected @endif value="0">خیر</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="orders" class="block text-base font-medium text-gray-900">ترتیب نمایش</label>
                <div class="mt-2">
                    <input id="orders" type="text" name="orders" value="{{ !empty($row) ? $row->orders : 0 }}"
                        autocomplete="orders"
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
