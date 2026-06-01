@extends('client.layout.app')

@section('content')
                <div class="login-register-area pt-100 pb-70">
                    <div class="container">
                                       <div class="row justify-content-center">
                            <!--Register Form Start-->
                            <div class="col-md-6 col-sm-6">
                                <div class="customer-login-register register-pt-0">
                                    <div class="form-register-title">
                                        <h2>Register</h2>
                                    </div>
                                    <div class="register-form">
                                        <form action="#">
                                            <div class="form-fild">
                                                <p><label>Username or email address <span class="required">*</span></label></p>
                                                <input name="username" value="" type="text">
                                            </div>
                                            <div class="form-fild">
                                                <p><label>Password <span class="required">*</span></label></p>
                                                <input name="password" value="" type="password">
                                            </div>
                                            <div class="register-submit">
                                                <button type="submit" class="button-default">Register</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--Register Form End-->

                        </div> 
                    </div>
                </div>
@endsection