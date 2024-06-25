@extends('layout.admin-app')
@section('adminContent')


@push('style')
<style>
    .app-calendar .fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-frame {
        background-color: #d7dfff;
        border-radius: 8px;
    }
</style>
@endpush


<div class="card">
    <div class="row gx-0">
        <div class="col-lg-12">
            <div class="px-4 calender-sidebar app-calendar">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN MODAL -->
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scheduleModalLabel">Add / Edit Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('schedule.store')}}" method="post" id="myForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Schedule Title<span class="text-danger">*</span></label>
                            <input id="schedule-title" type="text" name="title" class="form-control" required />
                        </div>
                        <div class="col-md-12 mt-4">
                            <label class="form-label">Schedule Description<span class="text-danger">*</span></label>
                            <textarea id="schedule-description" name="description" class="form-control"
                                required></textarea>
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label">Schedule Start Date<span class="text-danger">*</span></label>
                            <input id="schedule-start-date" name="start" type="datetime-local" class="form-control"
                                required />
                        </div>
                        <div class="col-md-6 mt-4">
                            <label class="form-label">Schedule End Date</label>
                            <input id="schedule-end-date" name="end" type="datetime-local" class="form-control" />
                        </div>
                        <div class="col-md-6 mt-4"  id="visibilitySelection">
                            <label class="form-label">Schedule Visibility<span class="text-danger">*</span></label>
                            <select id="schedule-visibility" class="form-control" name="visibility">
                                <option value="private">Private</option>
                                <option value="public">Public</option>
                                <option value="admin">For Admins</option>
                                <option value="manager">For Managers</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-4" id="visibilityInput" style="display:none">
                        <label class="form-label">Schedule Visibility</label>
                            <input id="schedule-visibility-input" class="form-control" disabled/>
                        </div>

                        <div class="col-md-6 mt-4">
                            <div class="form-check form-check-primary form-check-inline">
                                <input class="form-check-input" type="checkbox" name="is_editable" id="foreditable">

                                <label class="form-check-label" for="foreditable">Editable</label>
                            </div>
                        </div>


                        <div class="col-md-12 mt-4">
                            <div><label class="form-label">Schedule Color</label></div>
                            <div class="d-flex">
                                <div class="n-chk">
                                    <div class="form-check form-check-primary form-check-inline">
                                        <input class="form-check-input" type="radio" name="schedule_level"
                                            value="Danger" id="modalDanger" />
                                        <label class="form-check-label" for="modalDanger">Danger</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-warning form-check-inline">
                                        <input class="form-check-input" type="radio" name="schedule_level"
                                            value="Success" id="modalSuccess" />
                                        <label class="form-check-label" for="modalSuccess">Success</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-success form-check-inline">
                                        <input class="form-check-input" type="radio" name="schedule_level"
                                            value="Primary" id="modalPrimary" />
                                        <label class="form-check-label" for="modalPrimary">Primary</label>
                                    </div>
                                </div>
                                <div class="n-chk">
                                    <div class="form-check form-check-danger form-check-inline">
                                        <input class="form-check-input" type="radio" name="schedule_level"
                                            value="Warning" id="modalWarning" />
                                        <label class="form-check-label" for="modalWarning">Warning</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-update-event" data-fc-event-public-id="">Update
                            changes</button>
                        <button type="submit" class="btn btn-primary btn-add-event">Add Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('script')
<script src="/libs/fullcalendar/index.global.min.js"></script>
<script>
    var schedulesData = {!! json_encode($pageData -> Schedules -> map(function ($schedule) {
        return [
            'id' => $schedule -> id,
            'is_mine' => Auth::user()->id === $schedule->user_id,
            'title' => $schedule -> title,
            'description' => $schedule -> description,
            'start' => str_replace(' ', 'T', $schedule -> start),
            'start_time' => $schedule -> start,
            'end' => $schedule -> end !== null ? str_replace(' ', 'T', $schedule -> end) : null,
            'end_time' => $schedule -> end !== null ? $schedule -> end : null,
            'foreditable' => $schedule -> is_editable,
          'visibility' => $schedule -> visibility,
            'extendedProps' => ['calendar' => $schedule -> level]
        ];
    }))!!};

var storeURL = "{{route('schedule.store')}}";
    
</script>

<script src="{{ asset('js/apps/calendar-init.js') }}"></script>
@endpush