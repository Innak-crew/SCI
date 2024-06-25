@extends('layout.admin-app')
@section('adminContent')

@push('style')

<style>
    .badge-status {
        padding: 0.5em 1em;
        border-radius: 1em;
        font-weight: bold;
        display: inline-block;
        text-transform: capitalize;
    }

    .badge-status.pending {
        background-color: #e0f7fa;
        color: #00796b;
    }

    .badge-status.cancelled {
        background-color: #ffebee;
        color: #d32f2f;
    }

    .badge-status.paid {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    .badge-status.partially_paid {
        background-color: #fff9c4;
        color: #f57f17;
    }

    .badge-status.late {
        background-color: #fbe9e7;
        color: #d84315;
    }

    .badge-status.overdue {
        background-color: #fbe9e7;
        color: #d84315;
    }

    .invoice-loading-screen {
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

<section class="h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-11 col-xl-10  col-12 gap-2 d-flex align-items-center justify-content-end">
            <button class="btn btn-success gap-2" onclick="downloadInvoice('invocie')"><span class="th-download fs-3 fw-semibold px-2"></span>Invoice</button>
            <button class="btn btn-info" onclick="downloadInvoice('vendor')"><span class="th-download fs-3 fw-semibold px-2"></span>Vendor Invoice</button>
            <a class="btn btn-danger" href="{{route('admin.edit.order',['encodedId' => base64_encode($pageData->id)])}}" ><svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>Edit</a>

        </div>
        <div class="col-lg-11 col-xl-10  col-12">
            <div class="card">
                <div class="card-header px-lg-4 pb-3 invoice-header">
                    <div class="d-flex justify-content-center pt-2">
                        <h5
                            class="mb-1 badge @if($pageData->status == 'ongoing') bg-light-info text-info @elseif($pageData->status == 'cancelled') bg-light-danger text-danger @elseif($pageData->status == 'follow-up') bg-light-warning text-warning @else bg-light-success text-success  @endif">
                            {{ ucfirst($pageData->status) }} Order</h5>
                    </div>
                    <div class="d-flex justify-content-between pt-2">
                        <h5 class=" mb-0">Order Details</h5>
                        <h5 class=" mb-0">#ODR-{{ str_pad($pageData->id ,5,'0',STR_PAD_LEFT) }}</h5>
                    </div>
                </div>
                <div class="card-body invoice-body">
  
                    <div class="row mb-3">
                        <div class="col-6 col-md-6 col-12">
                            <p class="text-muted mb-0">
                                <b class="me-4">Start Date</b>
                                <br>{{ \Carbon\Carbon::parse($pageData->start_date)->format('jS F Y') }}
                            </p>
                        </div>
                        <div class="col-6 col-md-6 col-12 d-flex justify-content-end">
                            <p class="text-muted mb-0">
                                <b class="d-flex justify-content-end">End Date</b>
                                {{ \Carbon\Carbon::parse($pageData->end_date)->format('jS F Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <b>Creator By</b>
                            <p class="text-muted mb-0">Name: {{$pageData->user()->first()->name}}</p>
                            <p class="text-muted mb-0">Role: {{$pageData->user()->first()->role}}</p>
                            <p class="text-muted mb-0">Email: {{$pageData->user()->first()->email}}</p>
                        </div>
                        <div class="col-md-6 col-12 ">
                            <b class="d-flex justify-content-end">Customer Details</b>
                            <p class="text-muted mb-0 d-flex justify-content-end">{{$pageData->Customer()->first()->name
                                }}</p>
                            <p class="text-muted mb-0 d-flex justify-content-end">
                                {{$pageData->Customer()->first()->phone }}</p>
                            <span
                                class="text-muted mb-0 d-flex justify-content-end">{{$pageData->Customer()->first()->address
                                }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5">
                        <p class="lead fw-normal mb-0">Order Items</p>
                        <p class="lead text-muted mb-0">#{{count($pageData->orderItems()->get())}} Item(s)</p>
                    </div>

                    <div class="px-2 py-4">
                        <div class="table-responsive rounded-2">
                            <table class="table border text-nowrap customize-table mb-0 align-middle">
                                <thead class="text-dark">
                                    <tr>
                                        <th>
                                            <p class="lead fw-normal mb-0">Items</p>
                                        </th>
                                        <th>
                                            <p class="lead fw-normal mb-0">Quantity</p>
                                        </th>
                                        <th>
                                            <p class="lead fw-normal mb-0">Rate per Unit</p>
                                        </th>
                                        <th>
                                            <p class="lead fw-normal mb-0">Sub Total</p>
                                        </th>
                                        <th>
                                            <p class="lead fw-normal mb-0">
                                                DISC({{$pageData->invoice()->first()->discount_percentage}}%)</p>
                                        </th>
                                        <th>
                                            <p class="lead fw-normal mb-0">Total</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sub_total = 0; ?>
                                    @if (count($pageData->orderItems()->get()) != 0)
                                    @foreach ($pageData->orderItems()->get() as $orderItem)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{$orderItem->design->image_url}}" class="" alt="..."
                                                    width="56" height="56">
                                                <div class="ms-3">
                                                    <h6 class="lead fw-semibold mb-0 fs-4">
                                                        {{$orderItem->catagories->name}}
                                                        ({{$orderItem->design->type}})
                                                    </h6>
                                                    <p class="text-muted mb-0">
                                                        {{ucwords(strtolower($orderItem->design->name))}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0 fs-4">{{
                                                rtrim(rtrim(number_format($orderItem->quantity, 2), '0'), '.') }}
                                                ({{$orderItem->design->unit()->first()->name}})</p>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0 fs-4">₹ {{
                                                rtrim(rtrim(number_format($orderItem->rate_per, 2), '0'), '.') }} </p>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0 fs-4">₹ {{
                                                rtrim(rtrim(number_format($orderItem->sub_total, 2), '0'), '.')}}</p>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0 fs-4">₹ {{
                                                rtrim(rtrim(number_format($orderItem->sub_total *
                                                ($pageData->invoice()->first()->discount_percentage / 100), 2), '0'),
                                                '.')}}</p>
                                        </td>
                                        <td>
                                            <p class="text-muted mb-0 fs-4">₹ {{
                                                rtrim(rtrim(number_format($orderItem->total, 2), '0'), '.')}}</p>
                                        </td>
                                    </tr>
                                    <?php $sub_total += $orderItem->sub_total; ?>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>
                                            <p class="mb-0 fw-normal fs-4">No Order items Found</p>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-12 col-md-6">
                            <p class="lead fw-semibold">Payment Details</p>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td>₹ {{format_inr(number_format($sub_total))}}</td>
                                    </tr>
                                    <tr>
                                        <td>Discount Percentage</td>
                                        <td>
                                            <?php $discountPercentage = 0; ?>
                                            @if ($pageData->invoice()->first() != null)
                                            <?php $discountPercentage = $pageData->invoice()->first()->discount_percentage; ?>
                                            {{ $discountPercentage }}%
                                            @else
                                            {{$discountPercentage}}%
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Discount Amount</td>
                                        <td>
                                            <?php $discountAmount = 0; ?>
                                            @if ($pageData->invoice()->first() != null)
                                            <?php $discountAmount = $sub_total * ($discountPercentage / 100); ?>
                                            ₹ {{format_inr(number_format($discountAmount, 2))}}
                                            @else
                                            ₹ {{$discountAmount}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Total Amount</td>
                                        <?php $totalAfterDiscount = $sub_total - $discountAmount; ?>
                                        <td>₹ {{ format_inr(number_format($totalAfterDiscount))}}</td>
                                    </tr>
                                    <tr>
                                        <td>Advance Payment</td>
                                        <?php  $advancePayAmount = $pageData->invoice()->first() != null ?  ($pageData->invoice()->first()->advance_pay_amount != null ? $pageData->invoice()->first()->advance_pay_amount : 0 ) : 0; ?>
                                        <td>₹ {{ format_inr(number_format($advancePayAmount)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Paid Amount</td>
                                        <td>₹ {{ format_inr(format_inr($pageData->paymentHistory()->sum('amount'))) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Balance Amount</td>
                                        <?php $balanceAmount = $totalAfterDiscount -  $advancePayAmount?>
                                        <td>₹ {{format_inr(number_format($balanceAmount))}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12 col-md-6 ">
                            <div class="row mb-4">
                                <div class="col-md-12 col-12">
                                    <p class="lead fw-semibold">Payment Status</p>
                                    <p class="badge badge-status {{$pageData->invoice()->first()->payment_status}}">
                                        {{ ucFirst($pageData->invoice()->first()->payment_status) }}
                                    </p>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <p class="lead fw-semibold">Payment History</p>
                                        @if ($pageData->paymentHistory()->count() > 0)
                                        <div id="payment_history">
                                            @foreach ($pageData->paymentHistory as $index => $paymentHistory)
                                            <p class="mb-2">
                                                Paid ₹{{ format_inr(number_format($paymentHistory->amount)) }} via {{
                                                ucwords(str_replace('_', ' ', $paymentHistory->payment_method)) }} on {{
                                                \Carbon\Carbon::parse($paymentHistory->payment_date)->format('F j, Y')
                                                }}.
                                            </p>
                                            @endforeach
                                        </div>
                                        @else
                                        <p>No payment history available.</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <p class="lead fw-semibold">Terms and Conditions</p>
                                        <p id="terms_and_conditions">
                                            {!! nl2br(e($pageData->invoice()->first()->terms_and_conditions)) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card-footer invoice-footer">
                    <h5 class="d-flex align-items-center justify-content-end text-dark text-uppercase mb-0">
                            Balance: <span class="h2 mb-0 ms-2">₹ {{format_inr(number_format($balanceAmount))}}
                            </span></h5>
                    </div>
                </div>
            </div>
        </div>
      </div>
</section>

<!-- Loading -->
<div class="invoice-loading-screen" id="invoice-loading-screen">
  <div class="loader"></div>
</div> 


@endsection

@push('script')

<script>
  function downloadInvoice(mode){
    var downloadUrl = mode == "invocie" ? `{{ route('admin.invoice.download', ['encodeID' => base64_encode($pageData->id)]) }}` :`{{ route('admin.vendor.invoice.download', ['encodeID' => base64_encode($pageData->id)]) }}`;
    var loadingScreen = document.getElementById('invoice-loading-screen');
    loadingScreen.style.display = 'flex';

    fetch(downloadUrl)
      .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.blob();
    })
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = 'invoice-' + '{{ $pageData->invoice()->first()->invoice_number }}' + '.pdf'; // Dynamic file name
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
    })
    .catch(error => {
        console.error('There was an error with the download:', error);
        new Notify({
          status: "error",
          title: "There was an error with the download",
          autoclose: true,
          autotimeout: 5000,
          effect: "slide",
          speed: 300,
          position: "right bottom"
        });
    })
    .finally(() => {
        loadingScreen.style.display = 'none';
    });
  }
</script>

@endpush