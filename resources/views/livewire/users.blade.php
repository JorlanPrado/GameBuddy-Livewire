<div class="max-w-6xl mx-auto my-16 flex flex-col items-center">
    <button id="startMatchingBtn" wire:click="startMatching"
        class="flex items-center justify-center text-5xl font-bold py-3 bg-pink-500 hover:bg-pink-700 text-white rounded-lg shadow-md">
        
        <h3 class="p-3 ml-2 flex items-center">Start M<img src="/img/logo.png" alt="Image" class="button-image" style="width: 25px; margin-top: 10px;">tching</h3>
    </button>

    <div class="user-container flex justify-center py-5" style="width: 250px;">
        <div class="w-full bg-white border border-gray-200 rounded-lg p-5 shadow" id="userDisplay">
            @if ($showUser)
                <div class="flex flex-col items-center pb-10">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($randomUser->name) }}&color=7F9CF5&background=random"
                        class="rounded-full w-20 h-20 mb-2" alt="avatar">
                    <h5 class="mb-1 text-xl font-medium text-gray-900">{{ $randomUser->name }}</h5>
                    <span class="text-sm text-gray-500">{{ $randomUser->email }}</span>
                    <div class="flex mt-4 space-x-3 md:mt-6">
                        {{-- <x-secondary-button class="secondary-button">Add Friend</x-secondary-button> --}}
                        <x-primary-button wire:click="message({{ $randomUser->id }})"
                            class="primary-button bg-pink-500 hover:bg-pink-700">
                            Message
                        </x-primary-button>
                    </div>
                </div>
            @else
                <p class="text-center text-gray-500">No user found</p>
            @endif
        </div>
    </div>

    <div class="max-w-8xl mx-auto my-16" style="width: 950px;">
        <h5 class="text-center text-5xl font-bold py-3">Users</h5>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-2 ">
            @foreach ($users as $key => $user)
                {{-- child --}}
                <div class="w-full bg-white border border-gray-200 rounded-lg p-5 shadow">
                    <div class="flex flex-col items-center pb-10">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=random"
                            class="rounded-full w-20 h-20 mb-2" alt="avatar">
                        <h5 class="mb-1 text-xl font-medium text-gray-900 ">
                            {{ $user->name }}
                        </h5>
                        <span class="text-sm text-gray-500">{{ $user->email }} </span>
                        <div class="flex mt-4 space-x-3 md:mt-6">
                            {{-- <x-secondary-button>
                                Add Friend
                            </x-secondary-button> --}}
                            <x-primary-button wire:click="message({{ $user->id }})"
                                class="primary-button bg-pink-500 hover:bg-pink-700">
                                Message
                            </x-primary-button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.getElementById("startMatchingBtn").addEventListener("click", function() {
            Livewire.emit('startMatching');
        });

        Livewire.on('refreshUserDisplay', function(data) {
            document.getElementById("userDisplay").innerHTML = data;
        });
    </script>
</div>
