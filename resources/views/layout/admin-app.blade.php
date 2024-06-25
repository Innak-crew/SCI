@extends('layout.app')
@section('content')

@push('style')
@if (!$displayReminder->isEmpty())
<link rel="stylesheet" href="/libs/sweetalert2/dist/sweetalert2.min.css">
@endif
@endpush

<div class="page-wrapper" id="main-wrapper" data-theme="blue_theme" data-layout="vertical" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
        <div>
            <div class="brand-logo d-flex align-items-center justify-content-between">
                <a href="/" class="text-nowrap logo-img">
                <img src="{{ asset('images\logo\logo-2.png') }}" class="light-logo"  width="50" alt="" />
                    <!-- <h1>Buildy</h1> -->
                </a>
                <div class="close-btn d-lg-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                    <i class="ti ti-x fs-8 text-muted"></i>
                </div>
            </div>

            <nav class="sidebar-nav scroll-sidebar" data-simplebar>
                <ul id="sidebarnav">

                    <li class="sidebar-item">
                        <a class="sidebar-link @if ($title == 'Index') active @endif" href="{{route('admin.index')}}"
                            aria-expanded="false">
                            <span>
                                <i class="ti ti-aperture"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                            <span class="d-flex">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-rocket"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3 -5a9 9 0 0 0 6 -8a3 3 0 0 0 -3 -3a9 9 0 0 0 -8 6a6 6 0 0 0 -5 3" /><path d="M7 14a6 6 0 0 0 -3 6a6 6 0 0 0 6 -3" /><path d="M15 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                            </span>
                            <span class="hide-menu">Orders</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{route('admin.new.order')}}" class="sidebar-link ">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Add new</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{route('admin.list.order')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">view all</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.report')}}" aria-expanded="false">
                            <span class="ti ti-file fs-5 fw-semibold"></span>
                            <span class="hide-menu">Report</span>
                        </a>
                    </li>

                    

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                            <span class="th-image"></span>
                            <span class="hide-menu">Designs</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{route('admin.new.design')}}" class="sidebar-link ">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Add new</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{route('admin.list.design')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">view all</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.invoice')}}" aria-expanded="false">
                            <span>
                                <i class="ti ti-file-text"></i>
                            </span>
                            <span class="hide-menu">Invoice</span>
                        </a>
                    </li> -->

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-bell"></i>
                            </span>
                            <span class="hide-menu">Reminder</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{route('admin.reminder')}}" class="sidebar-link ">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Set Remainder</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a href="{{route('admin.reminder.list')}}" class="sidebar-link">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">List Remainder</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                            <span class="d-flex">
                                <i class="ti ti-user-plus"></i>
                            </span>
                            <span class="hide-menu">Users</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            <li class="sidebar-item">
                                <a href="{{route('admin.add-user')}}" class="sidebar-link ">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Add User</span>
                                </a>
                            </li>
                            <!-- <li class="sidebar-item">
                                <a href="#" class="sidebar-link">
                                <div class="round-16 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-circle"></i>
                                </div>
                                <span class="hide-menu">List Manager</span>
                                </a>
                            </li> -->
                        </ul>
                    </li>


                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow" href="#" aria-expanded="false">
                        <span class="d-flex">
                            <i class="ti ti-user-plus"></i>
                        </span>
                        <span class="hide-menu">Customer</span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{route('admin.customer.add')}}" class="sidebar-link ">
                            <div class="round-16 d-flex align-items-center justify-content-center">
                                <i class="ti ti-circle"></i>
                            </div>
                            <span class="hide-menu">Add Customer</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.customer.list')}}" class="sidebar-link">
                            <div class="round-16 d-flex align-items-center justify-content-center">
                                <i class="ti ti-circle"></i>
                            </div>
                            <span class="hide-menu">List Customer</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{route('admin.customer.list-all')}}" class="sidebar-link">
                            <div class="round-16 d-flex align-items-center justify-content-center">
                                <i class="ti ti-circle"></i>
                            </div>
                            <span class="hide-menu">List All Customers</span>
                            </a>
                        </li>
                        </ul>
                    </li>
                    
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.quantity-units')}}" aria-expanded="false">
                            <span>
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chart-dots-3"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M16 15m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M18 6m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M6 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M9 17l5 -1.5" /><path d="M6.5 8.5l7.81 5.37" /><path d="M7 7l8 -1" /></svg>
                            </span>
                            <span class="hide-menu">Quantity Units</span>
                        </a>
                    </li>
                    

                    <li class="sidebar-item">
                        <a class="sidebar-link" href="{{route('admin.gallery')}}" aria-expanded="false">
                            <span class="th-gallery fs-5 fw-semibold"></span>
                            <span class="hide-menu">Gallery</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <div class="fixed-profile p-3 mx-4 mb-2 bg-light-info rounded sidebar-ad mt-3">
            <div class="hstack gap-3">
                <div class="john-img">
                <img src="/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40" alt="" />
                </div>
                <div class="john-title">
                <h6 class="mb-0 fs-4 fw-semibold">{{$user->name}}</h6>
                <span class="fs-2">Admin</span>
                </div>
                <form action="{{route('logout')}}" class="ms-auto" method="post">
                    @csrf
                    <button class="border-0 bg-transparent text-primary " type="submit" class="btn btn-outline-primary" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout" >   
                        <i class="ti ti-power fs-6"></i>
                    </button>
                </form>
            </div>
            </div>
        </div>
    </aside>

    <div class="body-wrapper">

        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse"
                            href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>

                <div class="d-block d-lg-none">
                <img src="{{ asset('images\logo\logo-2.png') }}" class="light-logo"  width="50" alt="" />
                    <!-- <h1>Buildy</h1> -->
                </div>

                <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="p-2">
                        <i class="ti ti-dots fs-7"></i>
                    </span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <div class="d-flex align-items-center justify-content-between">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-bell-ringing"></i>
                                        @if (!$displayReminder->isEmpty())
                                        <div class="notification bg-primary rounded-circle"></div>
                                        @endif
                                    <!-- <div class="notification bg-primary rounded-circle"></div> -->
                                </a>
                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                        <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                        <!-- <span class="badge bg-primary rounded-4 px-3 py-1 lh-sm">5 new</span> -->
                                    </div>
                                    <div class="message-body" data-simplebar>

                                    </div>
                                    <div class="py-6 px-7 mb-1">
                                        <button class="btn btn-outline-primary w-100"> See All Notifications </button>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="user-profile-img">
                                            <img src="/images/profile/user-1.jpg" class="rounded-circle" width="35"
                                                height="35" alt="" />
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop1">
                                    <div class="profile-dropdown position-relative" data-simplebar>
                                        <div class="py-3 px-7 pb-0">
                                            <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                        </div>
                                        <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                            <img src="/images/profile/user-1.jpg" class="rounded-circle" width="80"
                                                height="80" alt="" />
                                            <div class="ms-3">
                                                <h5 class="mb-1 fs-3">{{$user->name}}</h5>
                                                <span class="mb-1 d-block text-dark">Admin</span>
                                                <p class="mb-0 d-flex text-dark align-items-center gap-2">
                                                    <i class="ti ti-mail fs-4"></i>{{$user->email}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-grid py-4 px-7 pt-8">
                                            <form action="{{route('logout')}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary">Log Out</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="container-fluid">

            <!-- <div class="card bg-white-info shadow-none position-relative overflow-hidden">
                <div class="row ">
                    <div class="col order-md-1 order-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item text-muted"><a href="#">{{$sectionName}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div> -->

           

            @yield('adminContent')



        </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <div class="dark-transparent sidebartoggler"></div>
</div>

@endsection


@push('script')

  @if (!$displayReminder->isEmpty())
      <?php
          $reminder = $displayReminder[0];
          $reminderTime = strtotime($reminder->reminder_time);
          $currentTime = time();
          $timeDifference = $reminderTime > $currentTime ? $reminderTime - $currentTime : 0;
      ?>
      <script src="/libs/sweetalert2/dist/sweetalert2.min.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', (event) => {
        if ({{ $timeDifference * 1000 }} >= 0) { 
          setTimeout(() => {
            Swal.fire({
              title: '<span class="text-warning">Reminder Alert!</span>',
              html: `
                <h4>{{ htmlspecialchars($reminder->title, ENT_QUOTES, 'UTF-8') }}</h4>
                <p>{!! $reminder->description !!}</p>
              `,
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Mark as Completed",
              cancelButtonText: "Snooze",
              allowOutsideClick: false 
            }).then((result) => {
              if (result.isConfirmed) {
                completeReminder('{{base64_encode($reminder->id)}}');
              }
            }).catch(error => {
              console.error('Error displaying the reminder:', error);
            });
          }, {{ $timeDifference * 1000 }});
        }

      });


       
      function completeReminder(id) {
            fetch('{{route('reminder.is_completed')}}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                    },
                    body: JSON.stringify({ id: id })
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                      Swal.fire({
                        title: 'Completed!',
                        text: 'The reminder has been marked as completed.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ok'
                      }).then((result) => {
                        if (result.isConfirmed) {
                          window.location.reload(); 
                        }
                      });
                    } else {
                        Swal.fire(
                            'Error!',
                            'There was an error marking the reminder as completed.',
                            'error'
                        );
                    }
                }).catch(error => {
                    console.error('Error marking the reminder as completed:', error);
                });
          }
      </script>   
  @endif
@endpush