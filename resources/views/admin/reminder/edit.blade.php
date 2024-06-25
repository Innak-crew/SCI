@extends('layout.admin-app')
@section('adminContent')


@push('style')

@endpush


<div class="row align-items-center">
  <div class="col-sm-8 col-md-8 col-lg-5 mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="mb-3">
        <a href="{{route('admin.reminder.list')}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg></a>
            Update Reminder</h5>
        <form action="{{route('reminder.update',['encodedId' => base64_encode($pageData->id)])}}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="text" name="title" value="{{old('title',$pageData->title)}}" id="title" class="form-control h-100 @error('title') is-invalid @enderror" placeholder="Enter reminder title here" required/>
                <label for="title">Title*</label>
                @error('title')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter reminder description (optional)">{{old('description',$pageData->description)}}</textarea>
                <label for="description">Description</label>
                @error('description')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="datetime-local" value="{{old('reminder_time',$pageData->reminder_time)}}" name="reminder_time" id="reminder_time" class="form-control @error('reminder_time') is-invalid @enderror" required/>
                <label for="reminder_time">Reminder Time*</label>
                @error('reminder_time')
                  <div class="invalid-feedback">
                    <p class="error">{{ $message }}</p>
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <select class="form-control @error('priority') is-invalid @enderror" name="priority" id="priority" required>
                  <option value="">-- Select Priority --</option>
                  <option value="3" @if($pageData->priority == 3) selected @endif>Low</option>
                  <option value="2" @if($pageData->priority == 2) selected @endif>Medium</option>
                  <option value="1" @if($pageData->priority == 1) selected @endif>High</option>
                </select>
                <label for="priority">Priority*</label>
                @error('priority')
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
                <i class="ti ti-bell me-2 fs-4"></i>
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