@extends('layout.manager-app')
@section('managerContent')


@push('style')
    
@endpush


<div class="card overflow-hidden invoice-application">
    <div class="d-flex align-items-center justify-content-between gap-3 m-3 d-lg-none">
        <button class="btn btn-primary d-flex" type="button" data-bs-toggle="offcanvas" data-bs-target="#chat-sidebar"
            aria-controls="chat-sidebar">
            <i class="ti ti-menu-2 fs-5"></i>
        </button>
        <form class="position-relative w-100">
            <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Contact">
            <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
        </form>
    </div>
    <div class="d-flex">
        <div class="w-25 d-none d-lg-block border-end user-chat-box">
            <div class="p-3 border-bottom">
                <form class="position-relative">
                    <input type="search" class="form-control search-invoice ps-5" id="text-srh"
                        placeholder="Search Invoice" />
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                </form>
            </div>
            <div class="app-invoice">
                <ul class="overflow-auto invoice-users" style="height: calc(100vh - 262px)" data-simplebar>
                    <li>
                        <a href="javascript:void(0)"
                            class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user bg-light"
                            id="invoice-123" data-invoice-id="123">
                            <div
                                class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ti ti-user fs-6"></i>
                            </div>
                            <div class="ms-3 d-inline-block w-75">
                                <h6 class="mb-0 invoice-customer">James Anderson</h6>

                                <span class="fs-3 invoice-id text-truncate text-body-color d-block w-85">Id:
                                    #123</span>
                                <span class="fs-3 invoice-date text-nowrap text-body-color d-block">9
                                    Fab 2020</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="w-75 w-xs-100 chat-container">
            <div class="invoice-inner-part h-100">
                <div class="invoiceing-box">
                    <div class="p-3 " id="custom-invoice">
                        <div class="invoice-123 show" id="printableArea">
                            <div class="invoice-header d-flex align-items-center border-bottom ">
                            <h4 class="font-medium text-uppercase mb-0">Invoice</h4>
                            <div class="ms-auto">
                                <h4 class="invoice-number">#127</h4>
                            </div>
                        </div>
                            <header class="invoice-header pt-3">
                                <div class="row">
                                    <div class="col-md-6 company-details">
                                        <!-- <img src="https://innak-crew.github.io/innak-logo/rec/Innak-Transprent.png" alt="Company Logo" class="img-fluid mb-2" style="max-width: 100px; height: auto;"/> -->
                                        <h6>&nbsp;From,</h6>
                                        <h6 class="fw-bold">&nbsp;ABC Construction Company</h6>
                                        <p class="ms-1">
                                            1108, Clair Street, <br />
                                            Massachusetts, Woods Hole - 02543
                                        </p>
                                    </div>
                                    <div class="col-md-6 invoice-details text-end">
                                        <h6>To,</h6>
                                        <h6 class="fw-bold invoice-customer">
                                            James Anderson,
                                        </h6>
                                        <p class="ms-4">
                                            455, Shobe Lane, <br />
                                            Colorado, Fort Collins - 80524
                                        </p>
                                        <p class="mt-4 mb-1">
                                            <span>Invoice Date :</span>
                                            <i class="ti ti-calendar"></i>
                                            2024-06-08
                                        </p>
                                        <p>
                                            <span>Due Date :</span>
                                            <i class="ti ti-calendar"></i>
                                            2024-06-22 
                                        </p>
                                    </div>
                                </div>
                            </header>
                            <main class="invoice-body">
                                <div class="table-responsive mt-2">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Description</th>
                                                <th class="text-end">Quantity</th>
                                                <th class="text-end">Unit Cost</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center"><b>1</b></td>
                                                <td><b>Interior</b></td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">1.1</td>
                                                <td>Kitchen Remodel</td>
                                                <td class="text-end">1</td>
                                                <td class="text-end">N/A</td>
                                                <td class="text-end">₹1,500,000</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">1.2</td>
                                                <td>Painting (Interior Walls)</td>
                                                <td class="text-end">2,000 sq ft</td>
                                                <td class="text-end">₹200/sq ft</td>
                                                <td class="text-end">₹400,000</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center"><b>2</b></td>
                                                <td><b>Exterior</b></td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                                <td class="text-end"></td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2.1</td>
                                                <td>Roof Replacement (Shingles)</td>
                                                <td class="text-end">2,500 sq ft</td>
                                                <td class="text-end">₹300/sq ft</td>
                                                <td class="text-end">₹750,000</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">2.2</td>
                                                <td>Siding Installation (Vinyl)</td>
                                                <td class="text-end">1,800 sq ft</td>
                                                <td class="text-end">₹400/sq ft</td>
                                                <td class="text-end">₹720,000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6 invoice-summary text-end">
                                        <p>Sub - Total amount: ₹3,370,000</p>
                                        <p>Tax (8%)	 : ₹269,600</p>
                                        <hr />
                                        <h3><b>Total :</b> 	₹3,639,600</h3>
                                    </div>
                                </div>
                            </main>
                            <footer class="invoice-footer">
                                <hr />
                                <div class="row">
                                    <div class="col-md-6 terms-and-conditions">
                                        <h4>Terms & Instructions</h4>
                                        <ul>
                                            <li>Payment is due within 15 days of the invoice date.</li>
                                            <li>Late payments will incur a late fee of 5% per month.</li>
                                            <li>Payments can be made by check or bank transfer.</li>
                                            <li>Please include the invoice number with your payment.</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6"> </div>
                                </div>
                            </footer>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-default print-page" type="button">
                            <span><i class="ti ti-printer fs-5"></i>
                                Print</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start user-chat-box" tabindex="-1" id="chat-sidebar"
        aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                Invoice
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="p-3 border-bottom">
            <form class="position-relative">
                <input type="search" class="form-control search-invoice ps-5" id="text-srh"
                    placeholder="Search Invoice">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
            </form>
        </div>
        <div class="app-invoice overflow-auto">
            <ul class="invoice-users">
                <li>
                    <a href="javascript:void(0)"
                        class="p-3 bg-hover-light-black border-bottom d-flex align-items-start invoice-user listing-user bg-light"
                        id="invoice-123" data-invoice-id="123">
                        <div
                            class="btn btn-primary round rounded-circle d-flex align-items-center justify-content-center">
                            <i class="ti ti-user fs-6"></i>
                        </div>
                        <div class="ms-3 d-inline-block w-75">
                            <h6 class="mb-0 invoice-customer">James Anderson</h6>

                            <span class="fs-3 invoice-id text-truncate text-body-color d-block w-85">Id:
                                #123</span>
                            <span class="fs-3 invoice-date text-nowrap text-body-color d-block">9
                                Fab 2020</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</div>
</div>



@endsection

@push('script')
<script src="/js/apps/jquery.PrintArea.js"></script>

<script>
    $("#custom-invoice > #printableArea:first").show();
// Print
$(".print-page").click(function () {
  var mode = "iframe"; //popup
  var close = mode == "popup";
  var options = {
    mode: mode,
    popClose: close,
  };
  $("div#printableArea:first").printArea(options);
});
</script>
@endpush