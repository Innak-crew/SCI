@extends('admin.quantity-units.unit')
@section('quantity-units')
<div class="row align-items-center">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Edit Quantity Units</h5>
                <form action="{{route('quantity-units.update',['encodedId' => base64_encode($pageData->ChangedQuantityUnit->id)])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <div class="form-floating">
                                <input type="text" name="name" id="name"
                                    class="form-control h-100 @error('name') is-invalid @enderror"
                                    placeholder="Enter name here" value="{{old('name',$pageData->ChangedQuantityUnit->name)}}" required />
                                <label for="name">Name *</label>
                                @error('name')
                                <div class="invalid-feedback">
                                    <p class="error">{{ $message }}</p>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-5 mb-3">
                            <div class="form-floating">
                                <input type="text" name="description" id="description"
                                    class="form-control h-100 @error('description') is-invalid @enderror"
                                    placeholder="Enter Description here" value="{{old('description',$pageData->ChangedQuantityUnit->description)}}" />
                                <label for="description">Description </label>
                                @error('description')
                                <div class="invalid-feedback">
                                    <p class="error">{{ $message }}</p>
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-info font-medium rounded-pill px-4">
                                    <div class="d-flex align-items-center">
                                        Update
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>
</div>
@endsection