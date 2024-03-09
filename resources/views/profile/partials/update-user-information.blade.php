<div class="container d-flex justify-content-center">
    <section>
        <header>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Interest') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Tell us about your interests! click the boxes below to let us know which activities youre passionate about.') }}
            </p>
        </header>

        <div class="card mt-6" style="width: 900px;">
            <div class="card-body">
                <form method="post" action="{{ route('interest.edit', ['userId' => Auth::user()->id]) }}" class="space-y-190" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                
                    <label for="interest" class="form-label">{{ __('Games') }}</label>
                    <div class="btn-group m-auto" role="group" aria-label="Basic checkbox toggle button group">

                        <input type="checkbox" class="btn-check" id="btncheck1" name="interests[0][id]" name="interests[1][game]" value="1" autocomplete="off">
                        <label class="btn btn-outline-primary mb-2 btn-square" for="btncheck1" style="width: 170px;">League of Legends</label>
                       
                
                        <input type="checkbox" class="btn-check" id="btncheck2" name="interests[1][id]" value="2" autocomplete="off">
                        <label class="btn btn-outline-primary mb-2 btn-square" for="btncheck2" style="width: 170px;">Valorant</label>
                        
                
                        <input type="checkbox" class="btn-check" id="btncheck3" name="interests[2][id]" name="interests[2][game]"value="3" autocomplete="off">
                        <label class="btn btn-outline-primary mb-2 btn-square" for="btncheck3" style="width: 170px;">Genshin Impact</label>
                       
                
                        <input type="checkbox" class="btn-check" id="btncheck4" name="interests[3][id]"name="interests[3][game]" value="4" autocomplete="off">
                        <label class="btn btn-outline-primary mb-2 btn-square" for="btncheck4" style="width: 170px;">Mobile Legends</label>
                        
                
                        <input type="checkbox" class="btn-check" id="btncheck5" name="interests[4][id]"  name="interests[4][game]" value="5" autocomplete="off">
                        <label class="btn btn-outline-primary mb-2 btn-square" for="btncheck5" style="width: 170px;">Call of duty Mobile</label>
                        
                    </div>
                
                    <div class="d-flex align-items-center gap-4">
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                
                        @if (session('status') === 'Interest-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-gray-600"
                            >{{ __('Saved.') }}</p>
                        @endif
                    </div>
                </form>
            </div>

        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</div>

<style>
    .btn-group {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-bottom: 30px; 
        left: -10px;
    }



    .btn-square {
        border-radius: 0;
        margin-right: 8px; /* Adjust the spacing between labels */
        transform: scale(1);
    }
    .btn-primary {
        margin-top: 40px; /* Add margin to the top of the "Save" button */
    }
</style>   
