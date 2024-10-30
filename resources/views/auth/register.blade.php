@extends('front.layouts.app');

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form action="{{ route('account.registration') }}" method="POST" name="registrationForm" id="registrationForm">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <p class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Email*</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email">
                            <p class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            <p class="text-danger"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Please Confirm Password">
                            <p class="text-danger"></p>
                        </div>
                        <button class="btn btn-primary mt-2">Register</button>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a  href="{{ route('account.login') }}" class="cls">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $('#registrationForm').submit(function(e){
       e.preventDefault();

       $.ajax({
            url: '{{ route("account.processRegistration") }}',
            type: 'POST',
            data: $("#registrationForm").serialize(),
            dataType: 'json',
            success: function(response) {
               // Remove previous error states before adding new ones
               $('.is-invalid').removeClass('is-invalid');
               $('.invalid-feedback').html('');

               if(response.status === false) {
                     var errors = response.errors;

                     // Name validation
                     if(errors.name){
                         $("#name").addClass('is-invalid')
                         .siblings('p')
                         .html(errors.name);
                         console.log(errors.name);
                     }

                     // Email validation
                     if(errors.email){
                         $("#email").addClass('is-invalid')
                         .siblings('p')
                         .html(errors.email);
                     }

                     // Password validation
                     if(errors.password){
                         $("#password").addClass('is-invalid')
                         .siblings('p')
                         .html(errors.password);
                     }

                     // Confirm password validation
                     if(errors.confirm_password){
                         $("#confirm_password").addClass('is-invalid')
                         .siblings('p')
                         .html(errors.confirm_password);
                     }

               } else {
                     // Clear all validation errors
                     $("#name").removeClass('is-invalid').siblings('p').html('');
                     $("#email").removeClass('is-invalid').siblings('p').html('');
                     $("#password").removeClass('is-invalid').siblings('p').html('');
                     $("#confirm_password").removeClass('is-invalid').siblings('p').html('');

                     // Redirect on success
                     window.location.href = '{{ route("account.login") }}';
               }
            },
            error: function(xhr, status, error) {
               console.log('An error occurred: ' + error);
            }
        });
    });
   </script>

@endsection
