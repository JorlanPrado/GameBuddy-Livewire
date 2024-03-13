<x-guest-layout>
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <section class="section gradient-form py-3" style="width: 600px;">
        <div class="container-fluid">
            <div class="card rounded-3 text-black">
                <div class="card-body p-md-5 mx-md-4 mx-2">
                    <div class="text-center mb-5">
                        <img src="/img/logo.png" style="width: 100px;" alt="logo" class="mx-auto">
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <p>Please sign up for your account</p>
                        <div class="form-outline mb-4 mt-3">
                            <x-input-label for="name" :value="__('Username')" />
                            <x-text-input id="name" class="form-control mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="form-outline mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="form-control mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="form-outline mb-4">
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input id="password" class="form-control mt-1 w-full" type="password" name="password"
                                required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="form-outline mb-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                            <x-text-input id="password_confirmation" class="form-control mt-1 w-full" type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!--gender-->
                        <div class="col-md-6 mb-4 d-flex flex-column">
                            <h6 class="mb-2 pb-1">Gender: </h6>
                          
                            <div class="d-flex">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="maleGender" value="Male" required/>
                                     <label class="form-check-label" for="maleGender">Male</label>
                                     <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>
                          
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="femaleGender" value="Female" required/>
                                <label class="form-check-label" for="femaleGender">Female</label>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                              </div>
                          
                              <div class="form-check form-check-inline ">
                                <input class="form-check-input" type="radio" name="gender" id="otherGender" value="Other" required/>
                                <label class="form-check-label" for="otherGender">Other</label>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                
                              </div>
                            </div>
                          
                        </div>

                          <!--age-->
                        <div class="form-outline mb-4">
                            <h6 class="mb-2 pb-1">Age:</h6>
                            <div class="form-outline" data-mdb-input-init>
                                <input type="number" style="border-radius: 10px;" id="age" name="age" class="form-control" min="18" max="40" pattern="[0-9]{1,2}" required/>
                                <label class="form-label" for="age"></label>
                                <x-input-error :messages="$errors->get('age')" class="mt-2" />
                            </div>
                        </div>

        

                        
                        <div class="form-check mb-4" >
                            <input class="form-check-input" type="checkbox" id="termsCheckbox" name="termsCheckbox" required>
                            <label class="form-check-label" for="termsCheckbox">
                                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" style="color:#4158D0">Terms and Conditions</a>
                            </label>
                            <x-input-error :messages="$errors->get('termsCheckbox')" class="mt-2" />
                        </div>

                        <div class="text-center pt-1 mb-3 pb-1">

                            <button class="btn btn-block fa-lg gradient-custom-3 mb-1 btn-login text-white">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <div class="d-flex align-items-center justify-content-center">
                            <p class="mb-0 me-2">Already have an account?</p>
                            <a href="{{ route('login') }}"><button type="button"
                                    class="btn btn-outline-custom-danger">Log In</button></a>
                        </div>
                    </form>

                    <!-- Modal -->
                    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="termsModalLabel"
                                        style="font-weight: bold; font-size: 23px">Terms and Conditions</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- terms and conditions content -->
                                    <section id="termsAndConditions">

                                        <ol>
                                            <li>
                                                <strong style="font-weight: bold">Eligibility:</strong> By using the
                                                GameBuddy app, you confirm that you are 18 years old or above. Users
                                                below
                                                this age are prohibited from accessing the platform.
                                            </li>

                                            <br>

                                            <li>
                                                <strong style="font-weight: bold">Responsibility for Actions:</strong>
                                                Users are solely responsible for their actions on GameBuddy. The
                                                platform does not assume responsibility for any consequences arising
                                                from user interactions, behavior, or content
                                                shared.
                                            </li>

                                            <br>

                                            <li>
                                                <strong style="font-weight: bold">Content Guidelines:</strong> Users
                                                agree not to share offensive, inappropriate, or illegal content.
                                                GameBuddy reserves the right to remove any content that violates these
                                                guidelines and may take appropriate action
                                                against the user.
                                            </li>

                                            <br>

                                            <li>
                                                <strong style="font-weight: bold">User Conduct:</strong> Users must
                                                conduct themselves in a respectful and lawful manner while using
                                                GameBuddy. Any harassment, abuse, or harmful behavior towards others is
                                                strictly prohibited.
                                            </li>
                                            <br>
                                            <li>
                                                <strong style="font-weight: bold">Account Security:</strong> Users are
                                                responsible for maintaining the security of their accounts. GameBuddy
                                                is not liable for any unauthorized access or use of user accounts.
                                            </li>
                                            <br>
                                        </ol>
                                    </section>

                                    <section id="privacyPolicy">
                                        <strong style="font-weight: bold; font-size:23px;">Privacy Policy</strong>
                                        <br>
                                        <br>
                                        <ol>
                                            <li>
                                                <strong style="font-weight: bold">Age Verification:</strong> GameBuddy
                                                requires users to be 18 years old or above. The app collects and
                                                processes age information to ensure compliance with this policy.
                                            </li>
                                            <br>
                                            <li>
                                                <strong style="font-weight: bold">Personal Information:</strong>
                                                GameBuddy may collect personal information, such as email, and age
                                                to provide the app's services. This information is handled with utmost
                                                confidentiality and is not shared with third
                                                parties without user consent.
                                            </li>
                                            <br>
                                            <li>
                                                <strong style="font-weight: bold">Data Security:</strong> GameBuddy
                                                employs industry-standard security measures to protect user data.
                                                However,
                                                users should be aware of the inherent risks of online communication and
                                                take necessary precautions.
                                            </li>
                                            <br>
                                            <li>
                                                <strong style="font-weight: bold">Third-Party Links:</strong> GameBuddy
                                                may contain links to third-party websites. Users are encouraged to
                                                review the privacy policies of these external sites, as GameBuddy is not
                                                responsible for their practices.
                                            </li>
                                            <br>
                                        </ol>
                                    </section>

                                    <section id="acknowledgment">
                                        <p>
                                            By using GameBuddy, you acknowledge that you have read, understood, and
                                            agreed to these Terms & Conditions and the
                                            Privacy Policy. GameBuddy reserves the right to update these documents
                                            periodically, and users are responsible for
                                            staying informed about any changes.
                                        </p>
                                    </section>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-custom-danger"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
