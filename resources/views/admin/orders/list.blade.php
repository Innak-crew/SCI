
@extends('layout.admin-app')
@section('adminContent')

@push('style')
<link rel="stylesheet" href="/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

@endpush




<div class="card w-100 position-relative overflow-hidden">
<div class="px-4 py-3 border-bottom d-flex justify-content-between align-items-center">
  <a href="{{url()->previous()}}"><span class="th-arrow-left"></span></a>
  <h5 class="card-title fw-semibold mb-0 lh-sm">{{$title}}</h5>
  <a href="{{route('admin.new.order')}}" class="btn btn-success font-medium rounded-pill px-4">Add new</a>
</div>
    <div class="card-body p-4">
        <div class="table-responsive rounded-2 py-5 mb-4">
        <table class="table border text-nowrap customize-table mb-0 align-middle @if ($pageData->Orders && count($pageData->Orders) != 0) datatable-select-inputs @endif">
  <thead class="text-dark fs-4">
    <tr>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">#</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Order ID</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Name</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Created By</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Order Status</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Payment Status</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Created At</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
      </th>
    </tr>
  </thead>
  <tbody>
    @if ($pageData->Orders && count($pageData->Orders) != 0)
        @for ($i = 0; $i < count($pageData->Orders); $i++)
        <tr>
          <td>
            <p class="mb-0 fw-normal fs-4">{{$i + 1}}</p>
          </td>
          <td>
            <p class="mb-0 fw-normal fs-4">#ODR-{{ str_pad($pageData->Orders[$i]->id ,5,'0',STR_PAD_LEFT) }}</p>
          </td>
          <td>
            <p class="mb-0 fw-normal fs-4">{{ $pageData->Orders[$i]->name }}</p>
          </td>
          <td>
            <p class="mb-0 fw-normal fs-4">@if ($pageData->Orders[$i]->user_id == $userId) You @else {{ $pageData->Orders[$i]->user()->first()->name }}@endif </p>
          </td>
          <td>
            <p class="mb-0 fw-normal fs-4">
                @php
                    $statusClasses = [
                        'ongoing' => 'bg-light-primary text-primary',
                        'cancelled' => 'bg-light-danger text-danger',
                        'follow-up' => 'bg-light-info text-info',
                        'completed' => 'bg-light-success text-success',
                    ];
                    $statusClass = $statusClasses[$pageData->Orders[$i]->status] ?? 'bg-light-success text-success';
                @endphp

                <span class="mb-1 badge font-medium {{ $statusClass }}"> {{ ucfirst($pageData->Orders[$i]->status) }}</span>
            </p>
          </td>
          <td>
            <p class="mb-0 fw-normal fs-4">
                @php
                    $paymentStatusClasses = [
                        'pending' => 'bg-light-warning text-warning',
                        'paid' => 'bg-light-success text-success',
                        'partially_paid' => 'bg-light-info text-info',
                        'late' => 'bg-light-warning text-warning',
                        'overdue' => 'bg-light-danger text-danger',
                    ];
                    $paymentStatus = $pageData->Orders[$i]->invoice()->first()->payment_status;
                    $paymentStatusClass = $paymentStatusClasses[$paymentStatus] ?? 'bg-light-warning text-warning';
                @endphp
                <span class="mb-1 badge font-medium {{ $paymentStatusClass }}"> {{ ucfirst($paymentStatus) }}</span>
            </p>
          </td>
          <td>
            <p class="mb-0 fw-normal fs-4">{{ \Carbon\Carbon::parse($pageData->Orders[$i]->created_at)->format('jS F Y')}}</p>
          </td>
          <td class="">
            <a href="{{route('admin.view.order',['encodedId' => base64_encode($pageData->Orders[$i]->id)])}}" class="text-success"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></a>
            <a href="{{route('admin.edit.order',['encodedId' => base64_encode($pageData->Orders[$i]->id)])}}" class="text-primary mx-2"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg></a>
            <form action="{{route('order.destroy', ['encodedId' => base64_encode($pageData->Orders[$i]->id)]) }}"
                                    method="post" class="delete-form" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" onclick="return confirmDelete()"
                    style="background:none; border:none; padding:0; margin:0; color:red; cursor:pointer;">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                </button>
            </form>
          </td>
        </tr>
        @endfor
        @else
        <tr>
          <td>
            <p class="mb-0 fw-normal fs-4">No Orders Found</p>
          </td>
        </tr>
    @endif
  </tbody>
        </table>

        </div>
    </div>




@endsection

@push('script')
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this order?');
    }
</script>

<script src="/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/js/datatable/datatable-api.init.js"></script>


@endpush
