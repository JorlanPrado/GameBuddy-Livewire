<div x-data="{ type: 'all', query: @entangle('query') }" x-init="
    setTimeout(() => {
        conversationElement = document.getElementById('conversation-' + query);

        // Scroll to the element
        if (conversationElement) {
            conversationElement.scrollIntoView({ behavior: 'smooth' });
        }
    }, 200);

    Echo.private('users.{{ Auth()->user()->id }}')
    .notification((notification) => {
        if (notification['type'] == 'App\\Notifications\\MessageRead' || notification['type'] == 'App\\Notifications\\MessageSent') {
            window.Livewire.emit('refresh');
        }
    });
" class="flex flex-col transition-all h-full overflow-hidden">

    <header class="px-3 z-10 bg-white sticky top-0 w-full py-2">

        <div class="border-b justify-between flex items-center pb-2">
            <div class="flex items-center gap-2">
                <h5 class="font-extrabold text-2xl">Chats</h5>
            </div>
            <button title="Create Group Chat" @click="showPopup()">
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
            <div id="create-group-chat-popup" class="fixed top-0 left-0 w-screen h-screen z-50 bg-black/75 flex items-center justify-center hidden">
                <div class="bg-white p-6 rounded-md shadow-lg">
                    <h2 class="text-lg font-medium mb-4">Create Group Chat</h2>
                    <form x-data="groupChatForm()" @submit.prevent="createGroupChatForm()">
                        <div class="mb-4">
                            <label for="group-chat-name" class="block text-sm font-medium mb-1">Group Chat Name</label>
                            <input id="group-chat-name" type="text" x-model="name" required class="w-full border rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Create</button>
                        </div>
                    </form>
                    <button @click="closePopup()" class="absolute top-0 right-0 m-4 text-white hover:text-gray-400">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="flex gap-3 items-center p-2 bg-white">
            <button @click="type='all'" :class="{'bg-purple-300 border-0 text-black': type === 'all'}" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
                All
            </button>
            <button @click="type='lobbies'" :class="{'bg-purple-300 border-0 text-black': type === 'lobbies'}" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1 lg:py-2.5 border">
                Lobbies
            </button>
        </div>
    </header>

    <main class="overflow-y-scroll overflow-hidden grow h-full relative" style="contain:content">
        <ul class="p-2 grid w-full spacey-y-2">
            @if ($conversations)
                @foreach ($conversations as $key => $conversation)
                    <li id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}" class="py-3 hover:bg-pink-50 rounded-2xl dark:hover:bg-pink-900/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{ $conversation->id == $selectedConversation?->id ? 'bg-pink-300' : '' }}">
                        <a href="#" class="shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($conversation->getReceiver()->name) }}&color=7F9CF5&background=random" class=" rounded-full w-10 h-10" alt="avatar">
                        </a>
                        <aside class="grid grid-cols-12 w-full">
                            <a href="{{ route('chat', $conversation->id) }}" class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">
                                <div class="flex justify-between w-full items-center">
                                    <h6 class="truncate font-medium tracking-wider text-gray-900">
                                        {{ $conversation->getReceiver()->name }}
                                    </h6>
                                    <small class="text-gray-700">{{ $conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans() }}</small>
                                </div>
                                <div class="flex gap-x-2 items-center">
                                    @if ($conversation->messages?->last()?->sender_id == auth()->id())
                                        @if ($conversation->isLastMessageReadByUser())
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                    <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
                                                    <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
                                                </svg>
                                            </span>
                                        @else
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                                </svg>
                                            </span>
                                        @endif
                                    @endif
                                    <p class="grow truncate text-sm font-[100]">
                                        {{ $conversation->messages?->last()?->body ?? ' ' }}
                                    </p>
                                    @if ($conversation->unreadMessagesCount() > 0)
                                        <span class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-pink-500 text-white">
                                            {{ $conversation->unreadMessagesCount() }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                            <div class="col-span-1 flex flex-col text-center my-auto">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical w-7 h-7 text-purple-500" viewBox="0 0 16 16">
                                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <div class="w-full p-1">
                                            <button class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-pink-300 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                                    </svg>
                                                </span>
                                                View Profile
                                            </button>
                                            <button onclick="confirm('Are you sure?') || event.stopImmediatePropagation()" wire:click="deleteByUser('{{ encrypt($conversation->id) }}')" class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-pink-300 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                                    </svg>
                                                </span>
                                                Delete
                                            </button>
                                        </div>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </aside>
                    </li>
                @endforeach
            @endif
        </ul>
    </main>
</div>

<script>
    const groupChatForm = () => ({
        name: '',
        createGroupChatForm() {
            createGroupChat({ name: this.name });
            closePopup();
        }
    });

    const closePopup = () => {
        const popup = document.getElementById('create-group-chat-popup');
        popup.classList.add('hidden');
        popup.classList.remove('flex');
    };

    const showPopup = () => {
        const popup = document.getElementById('create-group-chat-popup');
        popup.classList.remove('hidden');
        popup.classList.add('flex');
    };

    document.addEventListener('alpine:init', () => {
        Alpine.data('chatList', () => ({
            createGroupChat({ name }) {
                fetch('/api/group-chats', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ name }), // Send the group chat name in the request body
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Group chat created:', data);
                    window.Livewire.emit('refresh');
                })
                .catch(error => console.error('Error creating group chat:', error));
            }
        }));
    });

    const avatars = [
        "avatar1.jpg",
        "avatar2.jpg",
        "avatar3.jpg",
        "avatar4.jpg",
        "avatar5.jpg",
        "avatar6.jpg",
        "avatar7.jpg",
        "avatar8.jpg",
        "avatar9.jpg"
    ];

    const avatarElements = document.querySelectorAll('.avatar');

    avatarElements.forEach((avatarImg) => {
        const randomIndex = Math.floor(Math.random() * avatars.length);
        avatarImg.src = "/img/avatars/" + avatars[randomIndex];
    });
</script>