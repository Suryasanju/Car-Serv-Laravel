@extends('admin.layoutadmin')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Users</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit User</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    
                    @php
                       //echo "<pre>"; print_r($data); echo "</pre>";
                    @endphp

                       
                                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                      @if (Session::has('success'))
                                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                                      @endif
                                      <form method="post" action="{{ url('admin/update-user') }}" class="mx-1 mx-md-4" enctype="multipart/form-data" >
                                        @csrf
                                        <input type="hidden" name="id" id="id" class="form-control" placeholder="enter your name" value="{{ $data->id }}" />
                                        <div class="d-flex flex-row align-items-center mb-4">
                                          <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                          <div class="form-outline flex-fill mb-0">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="enter your name" value="{{ $data->name }}" />
                                            <label class="form-label" for="name">Your Name</label>
                                            @if ($errors->has('name'))
                                                <div class="alert alert-danger" role="alert">{{ $errors->first('name') }}</div>
                                            @endif
                                          </div>
                                        </div>
                    
                                        <div class="d-flex flex-row align-items-center mb-4">
                                          <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                          <div class="form-outline flex-fill mb-0">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="enter your email" value="{{ $data->email }}" />
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
                    
                    
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                          <input type="submit" class="btn btn-primary btn-lg" name="submit" value="Update User" />
                                        </div>
                    
                                      </form>
                    
                                    </div>
                    
                    




                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->
@endsection
