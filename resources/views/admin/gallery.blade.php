@extends('layout.admin-app')
@section('adminContent')


@push('style')
<link rel="stylesheet" href="/libs/magnific-popup/dist/magnific-popup.css">

@endpush


<div class="nav nav-pills p-3 mb-3 gap-3 rounded align-items-center card flex-row">
  <div class="nav-item">
    <label for="type">Type</label>
    <select name="" class="btn btn-light-primary border d-flex align-items-center" id="type">
      <option value="all">All</option>
      <option value="Interior">Interior</option>
      <option value="Exterior">Exterior</option>
    </select>
  </div>

  <div class="nav-item">
    <label for="image-category">Category</label>
    <select name="" class="btn btn-light-primary border d-flex align-items-center" id="image-category">
        <option value="all">All</option>
        @php
            $addedCategories = [];
        @endphp
        @foreach ($pageData as $design)
            @php
                $parentCategory = $design->category->parentCategory;
                $categoryName = $parentCategory->name;
                $categoryType = $parentCategory->type != 'Both' ? $parentCategory->type : 'Interior Exterior';
            @endphp
            @if (!in_array($categoryName, $addedCategories))
                <option value="{{ $categoryName }}" data-category-type="{{ $categoryType }}">{{ $categoryName }}</option>
                @php
                    $addedCategories[] = $categoryName;
                @endphp
            @endif
        @endforeach
    </select>
</div>


  <div class="nav-item ">
    <label for="sub-category">Sub Category</label>
    <select name="" class="btn btn-light-primary d-flex align-items-center" id="sub-category">
      <option value="all">All</option>
      @php
            $addedSubCategories = [];
        @endphp
        @foreach ($pageData as $design)
            @php
                $parentCategory = $design->category->parentCategory;
                $categoryName = $design->category->name;
            @endphp
            @if (!in_array($categoryName, $addedSubCategories))
                <option value="{{ $categoryName }}" data-subcategory-type="{{ $parentCategory->name }}">{{ $categoryName }}</option>
                @php
                    $addedSubCategories[] = $categoryName;
                @endphp
            @endif
        @endforeach

    </select>
  </div>
</div>

<!-- 

for (let i = 0; i < length; i += 4) {
}

for (let i = 1; i < length; i += 4) {
}

for (let i = 2; i < length; i += 4) {
}

for (let i = 3; i < length; i += 4) {
}

 -->


<!-- Gallery -->
<div class="row el-element-overlay">

    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
        @for ($i = 0; $i < $pageData->count() ; $i += 4)
            @php
            $itemType = $pageData[$i]->category->parentCategory->type;
            $itemCategory = $pageData[$i]->category->parentCategory->name;
            $itemSubCategory = $pageData[$i]->category->name;
            @endphp
            <div class="overflow-hidden  w-100 shadow-1-strong rounded mb-4 gallery-image " data-type="{{ $itemType }}" data-category="{{ $itemCategory }}" data-subcategory="{{ $itemSubCategory }}">
                <div class="el-card-item">
                    <div class=" el-card-avatar el-overlay-1 w-100 overflow-hidden position-relative  text-center">
                        <a class="image-popup-vertical-fit"  href="{{ $pageData[$i]->image_url }}">
                            <img src="{{ $pageData[$i]->image_url }}" class="w-100" alt="Boat on Calm Water" loading="lazy" />
                            <div class="el-overlay w-100 overflow-hidden">
                                <ul class="list-style-none el-info text-white  d-inline-block p-0 ">
                                <li class="el-item d-inline-block my-0 mx-1">{{ $pageData[$i]->name }}</li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
        @for ($i = 1; $i < $pageData->count() ; $i += 4)
            @php
            $itemType = $pageData[$i]->category->parentCategory->type;
            $itemCategory = $pageData[$i]->category->parentCategory->name;
            $itemSubCategory = $pageData[$i]->category->name;
            @endphp
            <div class="overflow-hidden  w-100 shadow-1-strong rounded mb-4 gallery-image " data-type="{{ $itemType }}" data-category="{{ $itemCategory }}" data-subcategory="{{ $itemSubCategory }}">
                <div class="el-card-item">
                    <div class=" el-card-avatar el-overlay-1 w-100 overflow-hidden position-relative  text-center">
                        <a class="image-popup-vertical-fit"  href="{{ $pageData[$i]->image_url }}">
                            <img src="{{ $pageData[$i]->image_url }}" class="w-100" alt="Boat on Calm Water" loading="lazy" />
                            <div class="el-overlay w-100 overflow-hidden">
                                <ul class="list-style-none el-info text-white  d-inline-block p-0 ">
                                <li class="el-item d-inline-block my-0 mx-1">{{ $pageData[$i]->name }}</li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
        @for ($i = 2; $i < $pageData->count() ; $i += 4)
            @php
            $itemType = $pageData[$i]->category->parentCategory->type;
            $itemCategory = $pageData[$i]->category->parentCategory->name;
            $itemSubCategory = $pageData[$i]->category->name;
            @endphp
            <div class="overflow-hidden  w-100 shadow-1-strong rounded mb-4 gallery-image " data-type="{{ $itemType }}" data-category="{{ $itemCategory }}" data-subcategory="{{ $itemSubCategory }}">
                <div class="el-card-item">
                    <div class=" el-card-avatar el-overlay-1 w-100 overflow-hidden position-relative  text-center">
                        <a class="image-popup-vertical-fit"  href="{{ $pageData[$i]->image_url }}">
                            <img src="{{ $pageData[$i]->image_url }}" class="w-100" alt="Boat on Calm Water" loading="lazy" />
                            <div class="el-overlay w-100 overflow-hidden">
                                <ul class="list-style-none el-info text-white  d-inline-block p-0 ">
                                <li class="el-item d-inline-block my-0 mx-1">{{ $pageData[$i]->name }}</li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endfor
    </div>

    <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
        @for ($i = 3; $i < $pageData->count() ; $i += 4)
            @php
            $itemType =  $pageData[$i]->category->parentCategory->type;
            $itemCategory = $pageData[$i]->category->parentCategory->name;
            $itemSubCategory = $pageData[$i]->category->name;
            @endphp
            <div class="overflow-hidden  w-100 shadow-1-strong rounded mb-4 gallery-image " data-type="{{ $itemType }}" data-category="{{ $itemCategory }}" data-subcategory="{{ $itemSubCategory }}">
                <div class="el-card-item">
                    <div class=" el-card-avatar el-overlay-1 w-100 overflow-hidden position-relative  text-center">
                        <a class="image-popup-vertical-fit"  href="{{ $pageData[$i]->image_url }}">
                            <img src="{{ $pageData[$i]->image_url }}" class="w-100" alt="Boat on Calm Water" />
                            <div class="el-overlay w-100 overflow-hidden">
                                <ul class="list-style-none el-info text-white d-inline-block p-0 ">
                                <li class="el-item d-inline-block my-0 mx-1">{{ $pageData[$i]->name }}</li>
                                </ul>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endfor
    </div>
  
</div>
<!-- Gallery -->


@endsection

@push('script')
<script src="/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="/js/plugins/meg.init.js"></script>


<script>




  document.addEventListener('DOMContentLoaded', function() {
    var typeSelect = document.getElementById('type');
    var categorySelect = document.getElementById('image-category');
    var subCategorySelect = document.getElementById('sub-category');

    function filterCategories() {
      var selectedType = typeSelect.value;
      var categoryOptions = categorySelect.querySelectorAll('option');

      categoryOptions.forEach(function(option) {
        var categoryType = option.getAttribute('data-category-type');
        if (selectedType === 'all' || (categoryType && categoryType.includes(selectedType))) {
          option.style.display = 'block';
        } else {
          option.style.display = 'none';
        }
      });

      categorySelect.value = 'all';
      filterSubCategories();
    }

    function filterSubCategories() {
      var selectedCategory = categorySelect.value;
      var subCategoryOptions = subCategorySelect.querySelectorAll('option');

      subCategoryOptions.forEach(function(option) {
        if (selectedCategory === 'all' || option.getAttribute('data-subcategory-type') === selectedCategory) {
          option.style.display = 'block';
        } else {
          option.style.display = 'none';
        }
      });

      subCategorySelect.value = 'all';
      filterGallery();
    }

    function filterGallery() {
      var selectedType = typeSelect.value;
      var selectedCategory = categorySelect.value;
      var selectedSubCategory = subCategorySelect.value;
      var galleryItems = document.querySelectorAll('.gallery-image');

      galleryItems.forEach(function(item) {
        var itemType = item.getAttribute('data-type');
        var itemCategory = item.getAttribute('data-category');
        var itemSubCategory = item.getAttribute('data-subcategory');

        if ((selectedType === 'all' || itemType === selectedType) &&
            (selectedCategory === 'all' || itemCategory === selectedCategory) &&
            (selectedSubCategory === 'all' || itemSubCategory === selectedSubCategory)) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    }

    typeSelect.addEventListener('change', filterCategories);
    categorySelect.addEventListener('change', filterSubCategories);
    subCategorySelect.addEventListener('change', filterGallery);

    filterCategories();
  });
</script>
@endpush