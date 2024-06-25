@extends('layout.admin-app')
@section('adminContent')

@push('style')

@endpush



<div class="row align-items-center">
  <div class="col-sm-10 col-md-10 col-lg-8 mx-auto">
    <div class="card">
      <div class="card-body">
      <h5 class="mb-3">
            <a href="{{route('admin.list.design')}}">
              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            </a>
        Product Details
      </h5>
        <form action="{{route('design.update',['encodedId' => base64_encode($pageData->design->id)])}}" method="post" enctype="multipart/form-data">
            @csrf
          <div class="row">

          <div class="col-md-12 mb-3 d-flex justify-content-center align-items-center">
                <img src="{{$pageData->design->image_url}}" class=' img-field w-25 mb-2' alt="">
            </div>

          
            
            <div class="col-md-6 mb-3">
                <div class="form-floating">
                        <select class="form-select mr-sm-2" id="type" name="type" required>
                            <option value="" disabled>Choose...</option>
                            <option value="Interior" @if (old('type',$pageData->design->type) == "Interior") selected @endif>Interior</option>
                            <option value="Exterior"  @if (old('type',$pageData->design->type) == "Exterior") selected @endif>Exterior</option>
                            <option value="Both"  @if (old('type',$pageData->design->type) == "Both") selected @endif>Both</option>
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
              <input type="text" name="name" id="name" class="form-control " value="{{old('name',$pageData->design->name)}}" placeholder="Enter category here"  required/>
                <label for="name">Design name *</label>
                @error('name')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
              <input type="text" name="category" id="category1" class="form-control " value="{{$pageData->design->category->parentCategory->name}}" placeholder="Enter category here" required/>
                <label for="category1">Design Category *</label>
                <small id="textHelp" class="form-text text-muted">(e.g., Kitchen)</small>
                
                @error('category')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
              <input type="text" name="sub_category" id="sub-category1" class="form-control typeahead" value="{{$pageData->design->category->name}}" placeholder="Enter sub-category here" required/>
                <label for="sub-category1">Design Sub Category *</label>
                <small id="textHelp" class="form-text text-muted">(e.g., Kitchen Cupboard)</small>
                @error('sub_category')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
              <input type="text" name="category_key" id="category-key" class="form-control typeahead" placeholder="Enter key here" value="{{old('category_key',$pageData->design->categoryKey->key)}}" required/>
                <label for="category_key">Common Key *</label>
                @error('category_key')
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
                        <select class="form-select mr-sm-2" id="unit_id" name="unit_id" required>
                            <option value="" disabled>Choose...</option>
                            @if (count($pageData->QuantityUnits) != 0)
                                @foreach ( $pageData->QuantityUnits as $QuantityUnit)
                                <option value="{{$QuantityUnit->id}}" @if (old('unit_id',$pageData->design->unit_id) == $QuantityUnit->id) selected @endif  >{{$QuantityUnit->name}} @if ( $QuantityUnit->description != null ) ({{$QuantityUnit->description}}) @endif </option>
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

          </div>

          @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

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

<script src="/js/bootstrap3-typeahead.min.js"></script>

<script>
    $(document).ready(function () {

      $('#category1').typeahead({
        hint: true,
        highlight: true,
        minLength: 1,
        source: function (query, process) {
          $.ajax({
            url: `/api/search/{{ base64_encode($userId) }}/categories/${query}`,
            method: 'GET',
            success: function (data) {
              process(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.error('Error fetching categories:', textStatus, errorThrown);
            }
          });
        }
      });

      $('#sub-category1').typeahead({
        hint: true,
        highlight: true,
        minLength: 1,
        source: function (query, process) {
          $.ajax({
            url: `/api/search/{{ base64_encode($userId) }}/subcategories/${query}?`,
            method: 'GET',
            success: function (data) {
              process(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.error('Error fetching subcategories:', textStatus, errorThrown);
            }
          });
        }
      });

      $('#category-key').typeahead({
        source: function(query, process) {
            $.ajax({
                url: `/api/search/{{ base64_encode($userId) }}/categorykey/${encodeURIComponent(query)}`,
                method: 'GET',
                success: function(data) {
                    var items = $.map(data, function(item) {
                        return { id: item.id, name: item.key };
                    });
                    process(data); 
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching category keys:', textStatus, errorThrown);
                }
            });
          },
          showHintOnFocus:true,
          displayText: function(item) {
            return item.key; 
          },
          afterSelect: function(item) {
              $('#category-key').val(item.key); 
          }
      });
    
    });
  </script>

</script>

@endpush