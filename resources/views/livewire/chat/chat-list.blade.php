<div x-data="{ type: 'all', query: @entangle('query'), showReportModal: false, reporterName: '', reason: '' }" x-init="
   setTimeout(() => {
      conversationElement = document.getElementById('conversation-' + query);
      //scroll to the element
      if (conversationElement) {
         conversationElement.scrollIntoView({ 'behavior': 'smooth' });
      }
   }, 200);

   Echo.private('users.{{ Auth()->User()->id }}')
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
            <button @click="showReportModal = true" type="button" class="items-center gap-1 flex mr-15 w-15 px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-pink-300 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100 text-end" style="border-radius: 10px;">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-flag-fill" viewBox="0 0 16 16">
                        <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001" />
                    </svg>
                </span>
                Report
            </button>
        </div>
        <div x-show="showReportModal" class="fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50" x-cloak>
            <div class="flex items-center justify-center h-screen">
                <div class="bg-white w-96 p-4 rounded-md">
                    <h2 class="text-lg font-bold mb-4">Report User</h2>
                    <form @submit.prevent="submitReport">
                        <div class="mb-4">
                            <label for="reporterName" class="block text-sm font-medium text-gray-700">Your Name</label>
                            <input type="text" x-model="reporterName" id="reporterName" name="reporterName" class="mt-1 p-2 w-full border rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Report</label>
                            <textarea x-model="reason" id="reason" name="reason" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="showReportModal = false" class="mr-2 px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:underline">Cancel</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-pink-500 rounded-md hover:bg-pink-400 focus:outline-none focus:ring focus:border-pink-400">Submit Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Filters --}}
        <div class="flex gap-3 items-center p-2 bg-white">
            <button @click="type='all'" :class="{'bg-purple-300 border-0 text-black':type=='all'}" class="inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1  lg:py-2.5 border ">
                All
            </button>
        </div>
    </header>
    <main class=" overflow-y-scroll overflow-hidden grow  h-full relative " style="contain:content">
        {{-- chatlist  --}}
        <ul class="p-2 grid w-full spacey-y-2">
            @if ($conversations)
            @foreach ($conversations as $key => $conversation)
            <li id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}" class="py-3 hover:bg-pink-50 rounded-2xl dark:hover:bg-pink-900/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{ $conversation->id == $selectedConversation?->id ? 'bg-pink-300' : '' }}">
                <a href="#" class="shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($conversation->getReceiver()->name) }}&color=7F9CF5&background=random" class=" rounded-full w-10 h-10" alt="avatar">
                </a>
                <aside class="grid grid-cols-12 w-full">
                    <a href="{{ route('chat',$conversation->id) }}" class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">
                        {{-- name and date  --}}
                        <div class="flex justify-between w-full items-center">
                            <h6 class="truncate font-medium tracking-wider text-gray-900">
                                {{ $conversation->getReceiver()->name }}
                            </h6>
                            <small class="text-gray-700">{{ $conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans() }} </small>
                        </div>
                        {{-- Message body --}}
                        <div class="flex gap-x-2 items-center">
                            @if ($conversation->messages?->last()?->sender_id == auth()->id())
                            @if ($conversation->isLastMessageReadByUser())
                            {{-- double tick  --}}
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                    <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                                    <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                                </svg>
                            </span>
                            @else
                            {{-- single tick  --}}
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                </svg>
                            </span>
                            @endif
                            @endif
                            <p class="grow truncate text-sm font-[100]">
                                {{ $conversation->messages?->last()?->body ?? ' ' }}
                            </p>
                            {{-- unread count --}}
                            @if ($conversation->unreadMessagesCount() > 0)
                            <span class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-pink-500 text-white">
                                {{ $conversation->unreadMessagesCount() }}
                            </span>
                            @endif
                        </div>
                    </a>
                    {{-- Dropdown --}}
                    <div class="col-span-1 flex flex-col text-center my-auto">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical w-7 h-7 text-purple-500" viewBox="0 0 16 16">
                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="w-full p-1">
                                    <button onclick="confirm('Are you sure?')||event.stopImmediatePropagation()" wire:click="deleteByUser('{{ encrypt($conversation->id) }}')" class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-pink-300 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
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
            @else
            @endif
        </ul>
    </main>
</div>


<script>
    function submitReport() {
        const reporterName = this.reporterName;
        const reason = this.reason;

        // Validate the form data (you can add more validation logic as needed)
        if (!reporterName.trim() || !reason.trim()) {
            alert('Please fill out all fields');
            return;
        }

        // Make an AJAX request to send the data to the server
        fetch('/report', { // Replace with the correct endpoint URL
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Include CSRF token
            },
            body: JSON.stringify({
                name: reporterName,
                reason: reason,
            }),
        })
        .then(response => {
            if (response.ok) {
                // Show success modal
                this.showSuccessModal = true;

                // Optionally, you can reset form fields or close the report modal here
                this.reporterName = '';
                this.reason = '';
                this.showReportModal = false;
            } else {
                alert('Failed to submit report. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error submitting report:', error);
            alert('An error occurred. Please try again.');
        });
    }
</script>