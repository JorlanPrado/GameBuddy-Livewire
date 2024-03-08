<div class="container d-flex justify-content-center align-items-center">
    <section class="space-y-6" style="max-width: 900px;">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Delete Account') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
            </p>
        </header>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
            {{ __('Delete Account') }}
        </button>

        <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                                {{ __('Are you sure you want to delete your account?') }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <p class="text-sm text-gray-600">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </p>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{ __('Password') }}">
                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
