<div class="container">
    <section>
        <header>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Interest') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Tell us about your interests! Click the boxes below to let us know which activities you\'re passionate about.') }}
            </p>
        </header>
        <div class="card-body">
            <form id="interestForm" method="post" action="{{ route('interest.edit', ['userId' => Auth::user()->id]) }}" class="space-y-190" enctype="multipart/form-data">
                @csrf
                @method('put')

                <label for="interest" class="form-label">{{ __('Games') }}</label>
                <div class="btn-group m-auto d-flex flex-wrap" role="group" aria-label="Basic checkbox toggle button group">
                    <!-- Add the 'flex-wrap' class to allow items to wrap to the next line on small screens -->

                    <!-- Your existing checkbox code -->
                    <input type="checkbox" class="custom-checkbox" id="btncheck1" name="interests[0][id]" name="interests[1][game]" value="1" autocomplete="off">
                    <label class="custom-label mb-2 btn-square" for="btncheck1" style="width: 170px; border-radius: 10px;">League of Legends</label>

                    <input type="checkbox" class="custom-checkbox" id="btncheck2" name="interests[1][id]" value="2" autocomplete="off">
                    <label class="custom-label mb-2 btn-square" for="btncheck2" style="width: 170px; border-radius: 10px;">Valorant</label>

                    <input type="checkbox" class="custom-checkbox" id="btncheck3" name="interests[2][id]" name="interests[2][game]" value="3" autocomplete="off">
                    <label class="custom-label mb-2 btn-square" for="btncheck3" style="width: 170px; border-radius: 10px;">Genshin Impact</label>

                    <input type="checkbox" class="custom-checkbox" id="btncheck4" name="interests[3][id]" name="interests[3][game]" value="4" autocomplete="off">
                    <label class="custom-label mb-2 btn-square" for="btncheck4" style="width: 170px; border-radius: 10px;">Mobile Legends</label>

                    <input type="checkbox" class="custom-checkbox" id="btncheck5" name="interests[4][id]" name="interests[4][game]" value="5" autocomplete="off">
                    <label class="custom-label mb-2 btn-square" for="btncheck5" style="width: 170px; border-radius: 10px;">Call of duty Mobile</label>

                    <!-- Add other checkboxes as needed -->

                </div>

                <div class="flex items-center gap-4 mt-3">
                    <x-primary-button style="background-color: #C850C0; color: white;">{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'Interest-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>

<style>
    .btn-group {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        margin-bottom: 30px;
    }

    .btn-square {
        margin-right: 8px;
    }

    .btn-primary {
        margin-top: 40px;
    }

    .custom-checkbox {
        display: none;
    }

    .custom-label {
        display: inline-block;
        width: 170px;
        border: 1px solid #C850C0;
        border-radius: 10px;
        padding: 6px 12px;
        cursor: pointer;
        text-align: center;
        color: #C850C0;
        transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
    }

    .custom-checkbox:checked+.custom-label {
        color: white;
        background-color: #A75EF8;
        border-color: #A75EF8;
    }

    .custom-label:hover {
        color: white;
        background-color: #A75EF8;
        border-color: #A75EF8;
    }

    @media (max-width: 576px) {

        .btn-group {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-square {
            width: 100%;
            margin-right: 0;
            margin-bottom: 8px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let checkboxes = document.querySelectorAll('.custom-checkbox');

        // Initialize checkboxes based on stored data
        checkboxes.forEach(function(checkbox) {
            let storedState = localStorage.getItem(checkbox.id);
            if (storedState === 'checked') {
                checkbox.checked = true;
                checkbox.nextElementSibling.classList.add('active');
            }
        });

        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    this.nextElementSibling.classList.add('active');
                } else {
                    this.nextElementSibling.classList.remove('active');
                }
                // Store the state of the checkbox
                localStorage.setItem(this.id, this.checked ? 'checked' : '');
            });
        });

        let saveButton = document.querySelector('.btn-primary');
        saveButton.addEventListener('click', function() {
            let savedMessage = document.getElementById('savedMessage');
            savedMessage.style.display = 'block';
        });
    });
</script>