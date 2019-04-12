<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/')}}" aria-expanded="false"><i class="mdi mdi-view-dashboard {{ Request::is('/') ? 'active' : '' }}"></i><span class="hide-menu">Dashboard</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ Request::is('/owners') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Patients </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('owners.create')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">New Owner</span></a></li>
                        <li class="sidebar-item"><a href="{{route('owners.index')}}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> View Owners </span></a></li>
                        <li class="sidebar-item"><a href="{{route('patients.create')}}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">New Patient</span></a></li>
                        <li class="sidebar-item"><a href="{{route('patients.index')}}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> View Patients </span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{route('bills.index')}}" aria-expanded="false"><i class="mdi mdi-relative-scale"></i><span class="hide-menu">Billing</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ Request::is('/appointments') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face "></i><span class="hide-menu">Appointments</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('appointments.create')}}" class="sidebar-link"><i class="mdi mdi-emoticon"></i><span class="hide-menu"> New Appointment</span></a></li>
                        <li class="sidebar-item"><a href="{{route('appointments.index')}}" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> View Appointments </span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-move-resize-variant"></i><span class="hide-menu">Prescription</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('prescriptions.create')}}" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu"> New Prescription</span></a></li>
                        <li class="sidebar-item"><a href="{{route('prescriptions.index')}}" class="sidebar-link"><i class="mdi mdi-multiplication-box"></i><span class="hide-menu">View Prescriptions</span></a></li>
                        <li class="sidebar-item"><a href="{{route('symptoms.index')}}" class="sidebar-link"><i class="mdi mdi-calendar-check"></i><span class="hide-menu"> Symptoms List </span></a></li>
                        <li class="sidebar-item"><a href="{{route('diagnoses.index')}}" class="sidebar-link"><i class="mdi mdi-bulletin-board"></i><span class="hide-menu"> Diagnosis List </span></a></li>
                        <li class="sidebar-item"><a href="{{route('medicines.index')}}" class="sidebar-link"><i class="mdi mdi-message-outline"></i><span class="hide-menu"> Prescription List </span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">Reports </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{url('/reminders')}}" class="sidebar-link"><i class="mdi mdi-all-inclusive"></i><span class="hide-menu"> Reminders </span></a></li>
                        <li class="sidebar-item"><a href="{{url('/notifications')}}" class="sidebar-link"><i class="mdi mdi-all-inclusive"></i><span class="hide-menu"> General Reports </span></a></li>
                    </ul>
                </li>
                @if(Auth::user()->role_id == 1)
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark {{ Request::is('/users') ? 'active' : '' }}" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">Users </span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{url('/users')}}" class="sidebar-link"><i class="mdi mdi-all-inclusive"></i><span class="hide-menu"> View Users </span></a></li>
                            <li class="sidebar-item"><a href="{{url('/users/create')}}" class="sidebar-link"><i class="mdi mdi-all-inclusive"></i><span class="hide-menu"> Add User </span></a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->