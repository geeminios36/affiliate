<div class="header-login-register-wrapper modal fade" id="login_register_modal"
    tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-box-wrapper">
                <div class="helendo-tabs">
                    <ul class="nav" role="tablist">
                        <li class="tab__item nav-item active">
                            <a class="nav-link active" data-bs-toggle="tab"
                                href="#tab_list_06" role="tab">Login</a>
                        </li>
                        <li class="tab__item nav-item">
                            <a class="nav-link" data-bs-toggle="tab"
                                href="#tab_list_07" role="tab">Our
                                Register</a>
                        </li>

                    </ul>
                </div>
                <div class="tab-content content-modal-box">
                    <div class="tab-pane fade show active" id="tab_list_06"
                        role="tabpanel">
                        <form autocomplete="on" class="account-form-box">
                            <h6>Login your account</h6>
                            <div class="form_group">
                                <div class="single-input">
                                    <input type="text" id="email_or_phone"
                                        placeholder="Enter email or phone">

                                </div>
                                <div class="single-input">
                                    <input type="password" id="password"
                                        placeholder="Password">

                                </div>
                                <div class="checkbox-wrap mt-10">
                                    <label
                                        class="label-for-checkbox inline mt-15">
                                        <input class="input-checkbox"
                                            name="remember" type="checkbox"
                                            id="remember" value="forever">
                                        <span>Remember me</span>
                                    </label>
                                    <a href="#" class=" mt-10">Lost your
                                        password?</a>
                                </div>
                            </div>
                            <div class="button-box mt-25">
                                <button type="button" onclick="home_login()"
                                    class="btn btn--full btn--black">Log
                                    in</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="tab_list_07" role="tabpanel">

                        <form autocomplete="on" id="registration_form"
                            class="account-form-box">
                            <h6>Register An Account</h6>
                            <div class="single-input">
                                <input type="text" id="username"
                                    placeholder="Username">
                            </div>
                            <div class="single-input">
                                <input type="email"
                                    placeholder="Email address" id="email">
                            </div>
                            <div class="single-input">
                                <input type="password" id="password"
                                    placeholder="Password">
                            </div>
                            <p class="mt-15">Your personal data will be used to
                                support your experience throughout this
                                website, to manage access to your account, and
                                for other purposes described in our <a
                                    href="#" class="privacy-policy-link"
                                    target="_blank">privacy policy</a>.</p>
                            <div class="button-box mt-25">
                                <button type="button" onclick="home_register()"
                                    class="btn btn--full btn--black">Register</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
