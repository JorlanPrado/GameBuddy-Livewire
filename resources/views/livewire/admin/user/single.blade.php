<tr x-data="{ banModalIsOpen: false, unbanModalIsOpen: false }">
    <td class="">{{ $user->name }}</td>
    <td class="">{{ $user->email }}</td>
    <td class="">{{ $user->password }}</td>
    <td class="">{{ $user->status }}</td>
    <td class="">{{ $user->isAdmin }}</td>

    @if(getCrudConfig('User')->Ban or getCrudConfig('User')->update or getCrudConfig('User')->Unban)
        <td>

            @if(getCrudConfig('User')->update && hasPermission(getRouteName().'.user.update', 1, 1, $user))
                <a href="@route(getRouteName().'.user.update', $user->id)" class="btn text-primary mt-1">
                    <i class="icon-pencil"></i>
                </a>
            @endif

            @if(getCrudConfig('User')->Ban && hasPermission(getRouteName().'.user.delete', 1, 1, $user))
                <button @click.prevent="banModalIsOpen = true" class="btn text-danger mt-1">
                <i class="fas fa-ban"></i> Ban
                </button>
                <div x-show="banModalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="banModalIsOpen = false">
                        <h5 class="pb-2 border-bottom">{{ __('BanTitle', ['name' => __('User') ]) }}</h5>
                        <p>{{ __('BanMessage', ['name' => __('User') ]) }}</p>
                        <div class="mt-5 d-flex justify-content-between">
                            <a wire:click.prevent="Ban" class="text-white btn btn-success shadow">{{ __('Yes, Ban it.') }}</a>
                            <a @click.prevent="banModalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it.') }}</a>
                        </div>
                    </div>
                </div>
            @endif

            @if(getCrudConfig('User')->Unban && hasPermission(getRouteName().'.user.unban', 1, 1, $user))
                <button @click.prevent="unbanModalIsOpen = true" class="btn text-success mt-1">
                    <i class="icon-check"></i> Unban
                </button>
                <div x-show="unbanModalIsOpen" class="cs-modal animate__animated animate__fadeIn">
                    <div class="bg-white shadow rounded p-5" @click.away="unbanModalIsOpen = false">
                        <h5 class="pb-2 border-bottom">{{ __('UnBanTitle', ['name' => __('User') ]) }}</h5>
                        <p>{{ __('UnBanMessage', ['name' => __('User') ]) }}</p>
                        <div class="mt-5 d-flex justify-content-between">
                            <a wire:click.prevent="Unban" class="text-white btn btn-success shadow">{{ __('Yes, Unban it.') }}</a>
                            <a @click.prevent="unbanModalIsOpen = false" class="text-white btn btn-danger shadow">{{ __('No, Cancel it.') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </td>
    @endif
</tr>
