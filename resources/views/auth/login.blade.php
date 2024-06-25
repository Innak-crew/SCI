@extends('layout.app')

@section('content')

    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
      <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
          <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
              <div class="card mb-0">
                <div class="card-body">
                  <a href="/" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                  <img src="{{ asset('images\logo\logo-2.png') }}" class="light-logo"  width="100" alt="" />
                    <h1 class="card-title">Smart Construction And Interiors</h1>
                  </a>

                  <form action="{{route('login.post')}}" method="post">
                  @csrf
                    <div class="mb-3">
                      <label for="email" class="form-label">Username</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" value="{{old('email')}}" required>
                        @error('email')
                          <div class="invalid-feedback">
                            <p class="error">{{ $message }}</p>
                          </div>
                        @enderror
                    </div>
                    <div class="mb-4">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" value="{{old('password')}}" required>
                        @error('password')
                          <div class="invalid-feedback">
                            <p class="error">{{ $message }}</p>
                          </div>
                        @enderror 
                      </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary w-50 py-8 mb-4 rounded-2">Sign In</button>
                    </div>
                  </form>
                </div>
                @if (isset($testCookie))
                    <p>{{ $testCookie }}</p>
                @endif
                @if (isset($testSession))
                    <p>Session Value: {{ $testSession }}</p>
                @endif
                @if (isset($cookieValues))
                    @foreach ($cookieValues as $name => $value)
                        <p>{{ ucfirst(str_replace('_', ' ', $name)) }}: {{ $value }}</p>
                    @endforeach
                @endif
                @if (isset($error))
                    <p>Error: {{ $error }}</p>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
