@extends('layouts.app')
@section('titleApp', 'Purchase')
@section('modal')
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Purchase</h4>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-icon-text btn-rounded">
                            <i class="ti-clipboard btn-icon-prepend"></i>Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card border-bottom-0">
                    <div class="card-body pb-0">
                        <p class="card-title">Purchases</p>
                        <p class="text-muted font-weight-light">The argument in favor of using filler text goes something like this: If you use real content in the design process, anytime you reach a review</p>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="mr-5 mt-3">
                                <p class="text-muted">Status</p>
                                <h3>362</h3>
                            </div>
                            <div class="mr-5 mt-3">
                                <p class="text-muted">New users</p>
                                <h3>187</h3>
                            </div>
                            <div class="mr-5 mt-3">
                                <p class="text-muted">Chats</p>
                                <h3>524</h3>
                            </div>
                            <div class="mt-3">
                                <p class="text-muted">Feedbacks</p>
                                <h3>509</h3>
                            </div>
                        </div>
                    </div>
                    <canvas id="order-chart" class="w-100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
@endsection

@section('script')
    <!-- Plugin js for this page-->
    <script src="{{ asset('include_admin/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page-->
    <!-- Custom js for this page-->
    <script src="{{ asset('include_admin/js/dashboard.js') }}"></script>
    <!-- End custom js for this page-->
@endsection
