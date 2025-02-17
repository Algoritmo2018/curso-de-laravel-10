<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users / Edit
            </h2>
            <a href="{{ route('users.index') }}"
                class="inline-flex mt-1 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form
                  action="{{ route('users.update',$user->id) }}"
                    method="post">
                        @csrf
                        <div>
                            <label for="" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input value="{{ old('name',$user->name) }}" name="name" placeholder="Enter Name"
                                    type="text"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                @error('name')
                                    <p class="text-sm text-red-600 space-y-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="" class="text-lg font-medium">Email</label>
                                <div class="my-3">
                                    <input value="{{ old('email',$user->email) }}" name="email" placeholder="Enter email"
                                        type="text"
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                                    @error('email')
                                        <p class="text-sm text-red-600 space-y-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            <div style="display: flexbox; flex-diretion:row;" class="mb-3">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                      <input {{($hasRoles->contains($role->id)) ? 'checked' : ''}} type="checkbox" id="role-{{$role->id}}" class="rounded" name="role[]"
                                                value="{{ $role->name }}">
                                            <label for="role-{{$role->id}}">{{ $role->name }}</label>

                                    @endforeach
                                @endif
                            </div>

                            <button
                                class="inline-flex mt-1 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
