@extends('layout.admin-app')
@section('adminContent')

@push('style')

@endpush



<div class="row align-items-center">
  <div class="col-sm-12 col-md-8 mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="mb-3">
            <a href="{{url()->previous()}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg></a>
        Product Details</h5>
        <form action="" method="post">
            @csrf
            
          <div class="row">

          <div class="col-md-12 mb-3 d-flex justify-content-center align-items-center">
                <img src="{{$pageData->image_url}}" class=' img-field w-25 mb-2' alt="">
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" name="name" id="name" value="{{$pageData->name}}" class="form-control" placeholder="Enter user name here" disabled/>
                <label for="fname"> Name *</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="email" name="description" id="description" value="{{$pageData->description}}" class="form-control " placeholder="name@example.com" disabled/>
                <label for="description"> Description</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" name="dimensions" id="dimensions" value="{{$pageData->dimensions}}" class="form-control" placeholder="Enter dimensions Value" disabled/>
                    <label for="dimensions"> Dimensions</label>
                </div>
            </div>

            
            <div class="col-md-6 mb-3">
                <div class="form-floating">
                <input type="text" name="dimensions" id="unit_id" value="{{ $pageData->unit()->name}} ({{$pageData->unit()->description}})" class="form-control" placeholder="Enter dimensions Value" disabled/>
                    <label for="unit_id">Quantity Unit *</label>
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-floating">
                <input type="number" step="0.01" id="rate_per" name="rate_per" value="{{ $pageData->rate_per }}" class="form-control " placeholder="Enter Rate Per Value" disabled>
                <label for="rate_per">Rate Per Value *</label>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
            <a href="{{route('admin.edit.product',['encodedId' => base64_encode($pageData->id)])}}" type="submit" class="btn btn-info font-medium rounded-pill px-4" >
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