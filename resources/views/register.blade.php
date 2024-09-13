@extends('layout')
@section('content')
<section class="" style="background-color: #eee;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                  @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                  @endif
                  <form method="post" action="{{ url('save-user') }}" class="mx-1 mx-md-4" enctype="multipart/form-data" >
                    @csrf
                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="text" name="name" id="name" class="form-control" placeholder="enter your name" value="{{ old('name') }}" />
                        <label class="form-label" for="name">Your Name</label>
                        @if ($errors->has('name'))
                            <div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
                        @endif
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="email" name="email" id="email" class="form-control" placeholder="enter your email" value="{{ old('email') }}" />
                        <label class="form-label" for="email">Your Email</label>
                        @error('email')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" />
                        <label class="form-label" for="password">Password</label>
                        @error('password')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="{{ old('confirm_password') }}" />
                        <label class="form-label" for="confirm_password">Repeat your password</label>
                        @error('confirm_password')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}" />
                          <label class="form-label" for="confirm_password">Date or Birth</label>
                          @error('dob')
                              <div class="alert alert-danger" role="alert">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>


                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-people fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="file" name="photo" id="photo" class="form-control" />
                          <label class="form-label" for="photo">Photo</label>
                          @error('photo')
                              <div class="alert alert-danger" role="alert">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-people fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="radio" name="gender" id="gender" value="Male" /> Male
                          <input type="radio" name="gender" id="gender"  value="Female" /> Female
                          <label class="form-label" for="gender">Gender</label>
                          @error('gender')
                              <div class="alert alert-danger" role="alert">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-people fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <textarea name="address" id="address" class="form-control" ></textarea>
                            <label class="form-label" for="address">Address</label>
                            @error('address')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>


                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <label class="form-label" for="">Country</label>
                          <select id="country-list" name="country" class="form-control" >
                            <option value="">Select Country</option>
                            @foreach ($countries as $country )
                                <option value="{{ $country->country_id }}">{{ $country->country_name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <label class="form-label" for="">State</label>
                          <select id="states-list" name="state" class="form-control" >
                            <option value="">Select State</option>
                          </select>
                        </div>
                      </div>

                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <label class="form-label" for="">City</label>
                          <select id="city-list" name="city" class="form-control" >
                            <option value="">Select City</option>
                          </select>
                        </div>
                      </div>

                      <!-- <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <label class="form-label" for="">Captcha</label>
                          <div class="captcha">
                            <span>{!! captcha_img() !!}</span>
                          </div>
                        </div>
                      </div> -->

                      <div class="captcha">
                        <span>{!! captcha_img() !!}</span>
                        <button type="button" class="btn btn-success btn-refresh"><i class="fa fa-sync"></i></button>
                        </div>
                        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                        @error('captcha')
                            <div class="alert alert-danger" role="alert">{{ $message }}</div>
                        @enderror

                      


                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <input type="submit" class="btn btn-primary btn-lg" name="submit" value="Submit" />
                    </div>

                  </form>

                </div>
                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                    class="img-fluid" alt="Sample image">

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="clear:both;"></div>
  </section>



  <script>
    $(document).ready(function() {
        //alert('hello');
        $('#country-list').on('change',function() {
            //alert('country seleted');
            var IdCountry = this.value;
            $('#states-list').html("");
            $.ajax({
                url:"{{ url('get-states') }}",
                type:"POST",
                data:{
                    country_id:IdCountry,
                    _token:'{{ csrf_token() }}'
                },
                dataType:'json',
                success: function (retrunresult) {
                    $('#states-list').html('<option value="">Select State</option>');
                    $.each(retrunresult.states, function(key,value){
                        $('#states-list').append('<option value="'+ value.state_id +'">'+ value.state_name +'</option>');
                    });
                }
            });
        });


        $('#states-list').on('change',function() {
            //alert('country seleted');
            var IdState = this.value;
            $('#city-list').html("");
            $.ajax({
                url:"{{ url('get-cities') }}",
                type:"POST",
                data:{
                    state_id:IdState,
                    _token:'{{ csrf_token() }}'
                },
                dataType:'json',
                success: function (retrunstateresult) {
                    $('#city-list').html('<option value="">Select City</option>');
                    $.each(retrunstateresult.cities, function(key,value){
                        $('#city-list').append('<option value="'+ value.city_id +'">'+ value.city_name +'</option>');
                    });
                }
            });
        });

        $('.btn-refresh').on('click',function() {
            //alert('captcha refresh');
            $.ajax({
                url:"{{ url('refresh-captcha') }}",
                type:"GET",
                data:{
                    _token:'{{ csrf_token() }}'
                },
                dataType:'json',
                success: function (retrunCaptchaResult) {
                    $('.captcha span').html(retrunCaptchaResult.captcha);
                }
            });
        });

    });
  </script>

@endsection
