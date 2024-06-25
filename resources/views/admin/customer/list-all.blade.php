@extends('layout.admin-app')
@section('adminContent')

@push('style')
<link rel="stylesheet" href="/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
@endpush


<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h5 class="card-title fw-semibold mb-0 lh-sm">{{$title}}</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive rounded-2 py-5 mb-4">
        <table class="table border text-nowrap customize-table mb-0 align-middle @if ($pageData->customers && count($pageData->customers) != 0) datatable-select-inputs @endif">
  <thead class="text-dark fs-4">
    <tr>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Name</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Created By</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Creator Role</h6>
      </th>
      <th>
        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
      </th>
    </tr>
  </thead>
  <tbody>
    @if ($pageData->customers && count($pageData->customers) != 0)
        @for ($i = 0; $i < count($pageData->customers); $i++)
        <tr>
          <td>
            <p class="mb-0 fw-normal fs-4">{{ $pageData->customers[$i]['customer_name']}}</p>
          </td>
          <td>
            <p class="mb-0 fw-normal fs-4">{{ $pageData->customers[$i]['username']  }}</p>
          </td>
          <td>
            <p class="mb-0 fw-normal fs-4">{{ $pageData->customers[$i]['userrole']  }}</p>
          </td>
          <td class="">
            <a href="{{route('admin.customer.all.view',['encodedId' => base64_encode($pageData->customers[$i]["id"])])}}" class="text-success"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-eye"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg></a>
          </td>
        </tr>
        @endfor
        @else
        <tr>
          <td>
            <p class="mb-0 fw-normal fs-4">No customers Found</p>
          </td>
        </tr>
    @endif
  </tbody>
</table>

</div>




@endsection

@push('script')
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this customer?');
    }
</script>

<script src="/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/js/datatable/datatable-api.init.js"></script>


@endpush