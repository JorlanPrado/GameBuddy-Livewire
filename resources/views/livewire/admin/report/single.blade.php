<tr x-data="{ modalIsOpen : false }">
    <td class="">{{ $report->name }}</td>
    <td class="">{{ $report->reason }}</td>
    
    @if(getCrudConfig('Report')->delete or getCrudConfig('Report')->update)
        <td>

            @if(getCrudConfig('Report')->update && hasPermission(getRouteName().'.report.update', 0, 0, $report))
                <a href="@route(getRouteName().'.report.update', $report->id)" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(getCrudConfig('Report')->delete && hasPermission(getRouteName().'.report.delete', 0, 0, $report))
                <button @click.prevent="modalIsOpen = true" class="btn text-danger mt-1">
                    <i class="icon-trash"></i>
                </button>
                <div x-show="modalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="modalIsOpen = false" >
                        <h5 class="pb-2 border-bottom">{{ __('DeleteTitle', ['name' => __('Report') ]) }}</h5>
                        <p>{{ __('DeleteMessage', ['name' => __('Report') ]) }}</p>
                        <div class="mt-5 d-flex justify-content-between">
                            <a wire:click.prevent="delete" class="text-white btn btn-success shadow">{{ __('Yes, Delete it.') }}</a>
                            <a @click.prevent="modalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it.') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </td>
    @endif
</tr>
