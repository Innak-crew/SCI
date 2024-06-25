@extends('layout.admin-app')
@section('adminContent')


@push('style')

@endpush


<div class="row align-items-center">
  <div class="col-sm-8 col-md-8 col-lg-5 mx-auto">
    <div class="card">
      <div class="card-body">
      <h5 class="mb-3">
            <a href="{{url()->previous()}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg></a>
        View Reminder</h5>
        <form action="#" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="text" name="title" id="title" value="{{$pageData->title}}" class="form-control h-100" placeholder="Enter reminder title here" disabled/>
                <label for="title">Title*</label>
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <textarea name="description" id="description" value="" class="form-control" placeholder="Enter reminder description (optional)" disabled>{{$pageData->description}}</textarea>
                <label for="description">Description</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="datetime-local" name="reminder_time" value="{{$pageData->reminder_time}}" id="reminder_time" class="form-control" disabled/>
                <label for="reminder_time">Reminder Time*</label>
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <select class="form-control " name="priority" id="priority" disabled>
                  <option value="">-- Select Priority --</option>
                  <option value="low" @if($pageData->priority == 3) selected @endif>Low</option>
                  <option value="medium" @if($pageData->priority == 2) selected @endif>Medium</option>
                  <option value="high" @if($pageData->priority == 1) selected @endif>High</option>
                </select>
                <label for="priority">Priority*</label>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
            <a href="{{route('admin.reminder.edit',['encodedId' => base64_encode($pageData->id)])}}" type="submit" class="btn btn-info font-medium rounded-pill px-4">
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