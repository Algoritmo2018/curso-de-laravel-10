@if (Session::has('success'))
    <div  x-data="{ show: true }"
    x-show="show"
    x-transition 
    class="text-sm text-gray-600">{{ Session::get('success') }}</div>
@endif
@if (Session::has('error'))
    <div class="text-red-200 border-green-600 p-4 mb-3  rounded-sm shadow-sm">{{ Session::get('error') }}</div>
@endif
