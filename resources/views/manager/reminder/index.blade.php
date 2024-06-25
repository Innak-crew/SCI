@extends('layout.manager-app')
@section('managerContent')

@push('style')

@endpush


<div class="row align-items-center">
  <div class="col-sm-8 col-md-8 col-lg-5 mx-auto">
    <div class="card">
      <div class="card-body">
        <h5 class="mb-3">Set Reminder</h5>
        <form action="{{route('reminder.store')}}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="text" name="title" value="{{old('title')}}" id="title" class="form-control h-100 @error('title') is-invalid @enderror" placeholder="Enter reminder title here" required/>
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
                <textarea name="description" value="" id="description" class="form-control @error('description') is-invalid @enderror" placeholder="Enter reminder description (optional)">{{old('description')}}</textarea>
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
                <input type="datetime-local" value="{{old('reminder_time')}}" name="reminder_time" id="reminder_time" class="form-control @error('reminder_time') is-invalid @enderror" required/>
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
                  <option value="3" @if(old('description') == 3) selected @endif>Low</option>
                  <option value="2"  @if(old('description') == 2) selected @endif>Medium</option>
                  <option value="1"  @if(old('description') == 1) selected @endif>High</option>
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
                Set Reminder
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