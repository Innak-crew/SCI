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
                <img src="{{$pageData->design->image_url}}" class=' img-field w-25 mb-2' alt="">
            </div>

          <div class="col-md-6 mb-3">
                <div class="form-floating">
                        <select class="form-select mr-sm-2" id="type" name="type" disabled>
                            <option value="" disabled selected>Choose...</option>
                            <option value="Interior" @if($pageData->design->type == 'Interior') selected @endif>Interior</option>
                            <option value="Exterior" @if($pageData->design->type == 'Exterior') selected @endif>Exterior</option>
                            <option value="Both" @if($pageData->design->type == 'Both') selected @endif>Both</option>
                        </select>
                    <label for="type">Type *</label>
                </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
              <input type="text" class="form-control " value="{{$pageData->design->name}}" placeholder="Enter category here" disabled  required/>
                <label for="category1">Design name *</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
              <input type="text" name="category" id="category1" class="form-control " value="{{$pageData->design->category->parentCategory->name}}" placeholder="Enter category here" disabled  required/>
                <label for="category1">Design Category *</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
              <input type="text" name="sub_category" id="sub-category1" class="form-control typeahead" placeholder="Enter sub-category here" value="{{$pageData->design->category->name}}" disabled required/>
                <label for="sub-category1">Design Sub Category *</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
              <input type="text"  class="form-control typeahead" placeholder="Enter key here" value="{{$pageData->design->categoryKey->key}}" disabled required/>
                <label for="sub-category1">Common Key *</label>
              </div>
            </div>
 
            <div class="col-md-6 mb-3">
                <div class="form-floating">
                        <select class="form-select mr-sm-2" id="unit_id" name="unit_id"  disabled required>
                            <option value="" disabled selected>Choose...</option>
                            @if (count($pageData->QuantityUnits) != 0)
                                @foreach ( $pageData->QuantityUnits as $QuantityUnit)
                                <option value="{{$QuantityUnit->id}}"   @if ($QuantityUnit->id === $pageData->design->unit_id) selected @endif  >{{$QuantityUnit->name}} @if ( $QuantityUnit->description != null ) ({{$QuantityUnit->description}}) @endif </option>
                                @endforeach
                            @endif
                        </select>
                    <label for="unit_id">Quantity Unit *</label>
                </div>
            </div>

         

           

            <div class="d-flex justify-content-end mt-3">
            <a href="{{route('admin.edit.design',['encodedId' => base64_encode($pageData->design->id)])}}" type="submit" class="btn btn-info font-medium rounded-pill px-4" >
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