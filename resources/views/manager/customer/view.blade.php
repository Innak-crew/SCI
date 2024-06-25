@extends('layout.manager-app')

@push('style')

@endpush


@section('managerContent')


<div class="row align-items-center">
  <div class="col-sm-8 col-md-6 col-lg-5 mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="mb-3">
            <a href="{{url()->previous()}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg></a>
        Customer Details</h5>
        <form action="" method="post">
            @csrf
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="text" value="{{$pageData->name}}" class="form-control" disabled/>
                <label for="fname"> Name</label>
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <div class="form-floating">
              <input type="text" value="{{$pageData->email}}" class="form-control" disabled/>
                <label for="email"> Email address</label>
              </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-floating">
                <input type="text" value="{{$pageData->phone}}" class="form-control" disabled/>
                    <label for="phone"> Phone no.</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-floating">
                    <textarea type="text" class="form-control h-100" rows="4"  readonly disabled>{{$pageData->address}}</textarea>
                    <label for="address"> Address</label>
                </div>
            </div>

            

            <div class="d-flex justify-content-end mt-3">
            <a href="{{route('manager.customer.edit',['encodedId' => base64_encode($pageData->id)])}}" type="submit" class="btn btn-info font-medium rounded-pill px-4">
              <div class="d-flex align-items-center">
                <i class="ti ti-pencil me-2 fs-4"></i>
                Edit
              </div>
            </a>
          </div>

          </div>

        </form>
      </div>
    </div>
  </div>
</div>


@endsection

@push('script')

@endpush