@extends('layouts.master')

@section('content')
    <x-dashboard-layout title="ابزار‌ها" link="/admin/integrations/create">

         <form enctype="multipart/form-data"  class="space-y-6 mb-10">
            <div>
                <label for="name" class="block text-base font-medium text-gray-900">نام</label>
                <div class="mt-2">
                    <input id="name"  type="name" name="name"
                        autocomplete="name"
                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-600 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
                </div>
            </div>
         </form>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-base text-gray-700 uppercase bg-gray-200 ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            نام
                        </th>
                        <th scope="col" class="px-6 py-3">
                            شناسه یکتا
                        </th>
                        <th scope="col" class="px-6 py-3">
                            آیکون
                        </th>
                        <th scope="col" class="px-6 py-3">
                            MCP
                        </th>
                        <th scope="col" class="px-6 py-3">
                            والد
                        </th>
                           <th scope="col" class="px-6 py-3">
                            نوع
                        </th>
                        <th scope="col" class="px-6 py-3">
                            عملیات
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (!empty($rows))
                        @foreach ($rows as $row)
                            <tr class="bg-white border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $row->name }}
                                </th>
                                 <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $row->slug ?? "-" }}
                                </th>
                               
                                <td class="px-6 py-4">
                                    <img class="w-10" src="/uploads/{{ $row->icon }}" />
                                </td>
                                <td class="px-6 py-4">
                                    @if ($row->is_mcp_server)
                                        <div class=" flex items-center justify-center pt-1"
                                            style="background: {{ $row->colors[$row->background][100] }}; color:{{ $row->colors[$row->background][500] }}">MCP
                                        </div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 font-bold text-black py-4">
                                    {{ $row->parent ? $row->parent->name : '-' }}
                                </td>
                                     <td class="px-6 py-4">
                                    {{ $row->type == "core" ? "اصلی" : "ابزار" }}
                                </td>
                                <td class="px-6 py-4 flex gap-x-1">
                                    <a href="{{ route('integrations.show', ['id' => $row->id]) }}"
                                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">ویرایش</a>
                                    <a href="{{ route('integrations.remove', ['id' => $row->id]) }}"
                                        class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">حذف</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
            {{ $rows->links() }}
        </div>

    </x-dashboard-layout>
@endsection
