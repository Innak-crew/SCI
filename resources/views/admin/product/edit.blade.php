@extends('layout.admin-app')
@section('adminContent')

@push('style')

@endpush



<div class="row align-items-center">
  <div class="col-sm-10 col-md-10 col-lg-8 mx-auto">
    <div class="card">
      <div class="card-body">
      <h5 class="mb-3">
            <a href="{{route('admin.list.product')}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg></a>
        Product Details</h5>
        <form action="{{route('product.update',['encodedId' => base64_encode($pageData->product->id)])}}" method="post" enctype="multipart/form-data">
            @csrf
          <div class="row">

          <div class="col-md-12 mb-3 d-flex justify-content-center align-items-center">
                <img src="{{$pageData->product->image_url}}" class=' img-field w-25 mb-2' alt="">
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="text" name="name" id="name" value="{{old('name',$pageData->product->name)}}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter user name here" required/>
                <label for="fname"> Name *</label>
                <small id="textHelp" class="form-text text-muted">Product Name (e.g., CENTURY MDF SHEET)</small>
                
                @error('name')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="email" name="description" id="description" value="{{old('description',$pageData->product->description)}}" class="form-control @error('description') is-invalid @enderror" placeholder="name@example.com" />
                <label for="description"> Description</label>
                @error('description')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input class="form-control" type="file" id="image" name="image">
                    <label for="image"> Image </label>
                    @error('image')
                    <div class="invalid-feedback">
                        <p class="error">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                    <input type="text" name="dimensions" id="dimensions" value="{{old('dimensions',$pageData->product->dimensions)}}" class="form-control @error('dimensions') is-invalid @enderror" placeholder="Enter dimensions Value" data-bs-toggle="tooltip" data-bs-placement="top" title="Enter dimensions in a format like width x height or diameter."/>
                    <label for="dimensions"> Dimensions</label>
                    <!-- <small id="textHelp" class="form-text text-muted">Enter dimensions in a format like width x height or diameter.</small> -->
                    @error('dimensions')
                    <div class="invalid-feedback">
                        <p class="error">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-floating">
                        <select class="form-select mr-sm-2" id="type" name="type" required>
                            <option value="" >Choose...</option>
                            <option value="Interior" @if (old('type',$pageData->product->type) == "Interior") selected @endif>Interior</option>
                            <option value="Exterior"  @if (old('type',$pageData->product->type) == "Exterior") selected @endif>Exterior</option>
                            <option value="Both"  @if (old('type',$pageData->product->type) == "Both") selected @endif>Both</option>
                        </select>
                    <label for="type">Type *</label>

                    @error('type')
                    <div class="invalid-feedback">
                        <p class="error">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-floating">
                        <select class="form-select mr-sm-2" id="unit_id" name="unit_id" required>
                            <option value="" disabled>Choose...</option>
                            @if (count($pageData->QuantityUnits) != 0)
                                @foreach ( $pageData->QuantityUnits as $QuantityUnit)
                                <option value="{{$QuantityUnit->id}}" @if (old('unit_id',$pageData->product->unit_id) == $QuantityUnit->id) selected @endif  >{{$QuantityUnit->name}} @if ( $QuantityUnit->description != null ) ({{$QuantityUnit->description}}) @endif </option>
                                @endforeach
                            @endif
                        </select>
                    <label for="unit_id">Quantity Unit *</label>
                    <small class="textHelp"><a href="{{ route('admin.quantity-units.add') }}" >Create New Quantity Unit</a></small>
            
                    @error('unit_id')
                    <div class="invalid-feedback">
                        <p class="error">{{ $message }}</p>
                    </div>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6 mb-3">
                <div class="form-floating">
                <input type="number" step="0.01" id="rate_per" name="rate_per" value="{{ old('rate_per',$pageData->product->rate_per) }}" class="form-control @error('rate_per') is-invalid @enderror" placeholder="Enter Rate Per Value">
                <label for="rate_per">Rate Per Value *</label>
                    @error('rate_per')
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
                Update
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