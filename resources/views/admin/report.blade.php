@extends('layout.admin-app')
@section('adminContent')
@use('Carbon\Carbon')

@push('style')
<link rel="stylesheet" href="/libs/magnific-popup/dist/magnific-popup.css">
<style>
.report-loading-screen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

    .loader {
  width: 50px;
  aspect-ratio: 1;
  border-radius: 50%;
  border: 8px solid #0000;
  border-right-color: #ffa50097;
  position: relative;
  animation: l24 1s infinite linear;
}
.loader:before,
.loader:after {
  content: "";
  position: absolute;
  inset: -8px;
  border-radius: 50%;
  border: inherit;
  animation: inherit;
  animation-duration: 2s;
}
.loader:after {
  animation-duration: 4s;
}
@keyframes l24 {
  100% {transform: rotate(1turn)}
}


</style>
@endpush

<form action="{{route('admin.download.report')}}">
<h3>Report</h3>
<div class="nav nav-pills p-3 mb-3 gap-3 rounded align-items-center card flex-row">

    <div class="nav-item">
        <label for="manager_id">User</label>
        <select id="manager_id" name="manager_id" class="btn btn-light-primary border d-flex align-items-center" onchange="fetchData()">
            <option value="">All</option>
            @foreach($pageData->users as $user)
                <option value="{{$user->id}}" @if (old('manager_id')== $user->id) selected @endif>{{ $user->name }} ({{$user->role}})</option>
            @endforeach
        </select>
    </div>

    <div class="nav-item">
        <label for="customer_id">Customer</label>
        <select id="customer_id" name="customer_id" class="btn btn-light-primary border d-flex align-items-center" onchange="fetchData()">
            <option value="">All</option>
            @foreach($pageData->customers as $customer)
                <option value="{{$customer->id}}" @if (old('customer_id')== $customer->id) selected @endif>{{$customer->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="nav-item">
        <label for="status">Status</label>
        <select id="status" name="status" class="btn btn-light-primary border d-flex align-items-center" onchange="fetchData()">
            <option value="" selected>All</option>
            <option value="ongoing" @if (old('status')=='ongoing') selected @endif>Ongoing</option>
            <option value="follow-up" @if (old('status')=='follow-up') selected @endif>Follow Up</option>
            <option value="cancelled" @if (old('status')=='cancelled') selected @endif>Cancelled</option>
            <option value="cancelled" @if (old('status')=='cancelled') selected @endif>Completed</option>
        </select>
    </div>

    <div class="nav-item">
        <label for="type">Type</label>
        <select name="type" class="btn btn-light-primary border d-flex align-items-center" id="type" onchange="fetchData()">
        <option value="">All</option>
        <option value="Interior" @if (old('type')=='Interior') selected @endif>Interior</option>
        <option value="Exterior" @if (old('type')=='Exterior') selected @endif>Exterior</option>
        <option value="Both" @if (old('type')=='Both') selected @endif>Both</option>
        </select>
    </div>
    
    <div class="nav-item">
    

        <label for="date_from">Date From</label>
        <input type="date" value="{{old('date_from')}}" class="btn btn-light-primary border d-flex align-items-center" id="date_from" name="date_from" onchange="fetchData()">
    </div>
    
    <div class="nav-item">
        <label for="date_to">Date To</label>
        <input type="date" value="{{old('date_to')}}"class="btn btn-light-primary border d-flex align-items-center" id="date_to" name="date_to" onchange="fetchData()">
    </div>
    
    <div class="nav-item  ms-auto">
        <button type="submit" class="btn btn-primary border d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download Report"><span class="th-download fs-4 fw-bold px-1"></span> Report</button>
    </div>

</div>
</form>

<div class="row">
    <div class="col-11 mx-auto">
        <div id="reportTable">
            
        </div>
    </div>
</div>                                                                        
                                                                            
<!-- Loading -->
<div class="report-loading-screen" id="report-loading-screen">
  <div class="loader"></div>
</div> 


@endsection

@push('script')


<script>



var loadingScreen = document.getElementById('report-loading-screen');
    
    function fetchData() {
        loadingScreen.style.display = 'flex';
        $.ajax({
            url: `{{route('getReportByFilter')}}??type=${$('#type').val()}&manager_id=${$('#manager_id').val()}&customer_id=${$('#customer_id').val()}&status=${$('#status').val()}&date_from=${$('#date_from').val()}&date_to=${$('#date_to').val()}`,
            type: 'GET',
            data: $('#reportFilterForm').serialize(), 
            success: function(response) {
                $('#reportTable').empty();
                // Generate new table content
                var table = '<table class="table table-sm mb-0">';
                table += `
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order ID</th>
                        <th scope="col">Creator Name</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Order Type</th>
                        <th scope="col">Order status</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                `;
                table += '<tbody>';
                
                $.each(response, function(index, order) {
                    table += '<tr>';
                    table += '<td scope="row">' + (index + 1) + '</td>';
                    table += '<td>' + order.order_id + '</td>';
                    table += '<td>' + order.ceartor_name + '</td>';
                    table += '<td>' + order.customer_name + '</td>';
                    table += '<td>' + order.type + '</td>';
                    table += '<td>' + order.status + '</td>';
                    table += '<td>' + order.created_at + '</td>';
                    table += '</tr>';
                });
                
                table += '</tbody></table>';
                $('#reportTable').append(table);
                loadingScreen.style.display = 'none';
            },
            error: function(xhr, status, error) {
                $('#reportTable').empty();
                $('#reportTable').append(`<div class="alert alert-warning"> ${xhr.responseJSON.message}</div>`);
                loadingScreen.style.display = 'none';
            }
        });
    }

$(document).ready(()=>{
    fetchData();
})
</script>
@endpush