@extends('layout.manager-app')

@push('style')

@endpush


@section('managerContent')


<div class="row align-items-center">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="mb-3">Basic Details</h5>
        <form action="{{route('admin.add-user.store')}}" method="post">
            @csrf
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter user name here" required/>
                <label for="fname"> Name <span class="text-danger">*</span></label>
                @error('name')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com" required/>
                <label for="email"> Email address <span class="text-danger">*</span></label>
                @error('email')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" name="phone" id="phone" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror"  required/>
                <label for="phone"> Phone Number <span class="text-danger">*</span></label>
                @error('phone')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" name="branch_name" id="branch_name" value="{{old('branch_name')}}" class="form-control @error('branch_name') is-invalid @enderror" placeholder="" required/>
                <label for="branch_name"> Branch Name <span class="text-danger">*</span></label>
                @error('branch_name')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-floating">
                    <textarea  name="address_1" id="address_1" value="{{old('address_1')}}" class="form-control @error('address_1') is-invalid @enderror" placeholder="" required></textarea>
                    <label for="address_1"> Branch Address <span class="text-danger">*</span></label>
                    @error('address_1')
                    <div class="invalid-feedback">
                        <p class="error">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 mb-3">
            <div class="form-floating">
                <input type="text" name="state" id="state" value="{{old('state')}}" class="form-control @error('state') is-invalid @enderror" placeholder="" required/>
                <label for="state"> State </label>
                @error('state')
                <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                </div>
                @enderror
            </div>
            </div>

            <div class="col-md-4 mb-3">
            <div class="form-floating">
                <input type="text" name="city" id="city" value="{{old('city')}}" class="form-control @error('city') is-invalid @enderror" placeholder="" required/>
                <label for="city"> City</label>
                @error('city')
                <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                </div>
                @enderror
            </div>
            </div>

            <div class="col-md-4 mb-3">
            <div class="form-floating">
                <input type="text" name="postal_code" id="postal_code" value="{{old('postal_code')}}" class="form-control @error('postal_code') is-invalid @enderror" placeholder="" required/>
                <label for="postal_code"> Postal Code</label>
                @error('postal_code')
                <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                </div>
                @enderror
            </div>
            </div>

          </div>

          <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-info font-medium rounded-pill px-4">
              <div class="d-flex align-items-center">
                <i class="ti ti-send me-2 fs-4"></i>
                Submit
              </div>
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>


@endsection

@push('script')

@endpush