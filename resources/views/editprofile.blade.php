@extends('layout')
@section('content')
<section class="vh-100" style="background-color: #eee;">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                  <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Edit Profile</p>
                  @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                  @endif
                  <form method="post" action="{{ url('update-user') }}" class="mx-1 mx-md-4" enctype="multipart/form-data" >
                    @csrf
                    <input type="hidden" name="id"  class="form-control"  value="{{ $user->id }}" />
                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <input type="text" name="name" id="name" class="form-control" placeholder="enter your name" value="{{ $user->name }}" />
                        <label class="form-label" for="name">Your Name</label>
                        @if ($errors->has('name'))
                            <div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
                        @endif
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                      <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                      <div class="form-outline flex-fill mb-0">
                        <label class="form-label" for="email">Your Email : {{ $user->email }}</label>
                      </div>
                    </div>

                    <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                          <input type="date" name="dob" id="dob" class="form-control" value="{{ $user->dob }}" />
                          <label class="form-label" for="confirm_password">Date or Birth</label>
                          @error('dob')
                              <div class="alert alert-danger" role="alert">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>


                      <div class="d-flex flex-row align-items-center mb-4">
                        <i class="fas fa-people fa-lg me-3 fa-fw"></i>
                        <div class="form-outline flex-fill mb-0">
                            @php
                                $selected =''; $selected2 ='';
                                if($user->gender=='Male')
                                {
                                    $selected ='checked';
                                } else {
                                    $selected2 ='checked';
                                }
                            @endphp
                          <input type="radio" name="gender" id="gender" {{ $selected }} value="Male" /> Male
                          <input type="radio" name="gender" id="gender" {{ $selected2 }} value="Female" /> Female
                          <label class="form-label" for="gender">Gender</label>
                          @error('gender')
                              <div class="alert alert-danger" role="alert">{{ $message }}</div>
                          @enderror
                        </div>
                      </div>
                      <div class="d-flex flex-row align-items-center mb-4">
                          <i class="fas fa-people fa-lg me-3 fa-fw"></i>
                          <div class="form-outline flex-fill mb-0">
                            <textarea name="address" id="address" class="form-control" >{{ $user->address }}</textarea>
                            <label class="form-label" for="address">Address</label>
                            @error('address')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                            @enderror
                          </div>
                        </div>


                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                      <input type="submit" class="btn btn-primary btn-lg" name="submit" value="Update" />
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
  </section>




@endsection
