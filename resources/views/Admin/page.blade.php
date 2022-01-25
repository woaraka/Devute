@extends('Admin.layouts.app')
@section('titleApp', 'Admin Page')
@section('modal')
    <div id="add_data_Modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new page</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('page.insert') }}">
                        @csrf
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" placeholder="name" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                                </div>
                            </div>
                            @error('name')
                            <span class="text-danger">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <input type="text" class="form-control" name="route" placeholder="route" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-route"></i></span>
                                </div>
                            </div>
                            @error('route')
                            <span class="text-danger">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <input type="submit" name="insert" value="Submit" class="btn btn-success"/>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Edit_data_Modal">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Page Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="FormUpdate" action="{{ route('page.update','id') }}">
                        @csrf
                        @method('put')
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <input type="text" class="form-control" id="txtName" name="update_name" placeholder="name" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-pen"></i></span>
                                </div>
                            </div>
                            @error('update_name')
                            <span class="text-danger">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <input type="text" class="form-control" id="txtRoute" name="update_route" placeholder="route" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-route"></i></span>
                                </div>
                            </div>
                            @error('update_route')
                            <span class="text-danger">
                                <p>{{ $message }}</p>
                            </span>
                            @enderror
                        </div>
                        <input type="submit" name="insert" value="Submit" class="btn btn-success"/>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold mb-0">Page</h4>
                    </div>
{{--                    <div>--}}
{{--                        <button type="button" class="btn btn-primary btn-icon-text btn-rounded">--}}
{{--                            <i class="ti-clipboard btn-icon-prepend"></i>Report--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
        @if (session()->has('notification'))
            <div class="alert alert-light alert-dismissible text-center">
                {!! session('notification') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <br>
        @endif
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Page
                            <button title="Click to add blog"
                                    style="border: none;background-color: inherit; outline-style: none;" data-toggle="modal"
                                    data-target="#add_data_Modal"><i style="font-size: 15px; font-weight: bold; border: solid; color: #ff001d;"
                                                                         class="ti-plus"></i></button>
                        </h4>
                        <div class="table-responsive pt-3">
                            <table class="table table-sm table-bordered table-striped" id="tblPage">
                                <thead class="thead-dark">
                                <tr>
                                    <th>SL</th>
                                    <th>Pages Name</th>
                                    <th>Route</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($pages as $page)
                                    <tr>
                                        <td>{{ $page->id }}</td>
                                        <td>{{ $page->name }}</td>
                                        <td>{{ $page->route }}</td>
                                        <td title="Update" style="vertical-align: middle;"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#Edit_data_Modal" data-ID="{{ $page->id}}" data-name="{{ $page->name}}" data-route=" {{$page->route}}"><i class="ti-pencil"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
@endsection
@section('script')
    <!--Employee Modal Show error-->
    @if (count($errors) > 0)
        <script>
            $( document ).ready(function() {
                @if($errors->has('name') || $errors->has('route'))
                $('#add_data_Modal').modal('show');
                @elseif($errors->has('update_name') || $errors->has('update_route'))
                $('#Edit_data_Modal').modal('show');
                @endif
            });
        </script>
    @endif

    <script>
        $('#Edit_data_Modal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget); // Button that triggered the modal
            var modal = $(this);

            var id = button.attr('data-ID');
            var url = '{{ route('page.update', ':id') }}';
            url = url.replace(':id',id);
            $('#FormUpdate').attr('action',url);

            modal.find($('#txtName')).val(button.attr('data-name'));
            modal.find($('#txtRoute')).val(button.attr('data-route'));
        });
    </script>
    <script>
        $(document).ready(function() {
            var t = $('#tblPage').DataTable({
                "pagingType":"full_numbers",
                "order": [],
                "lengthMenu":[
                    [10,25,50,-1],
                    [10,25,50,"All"]
                ],
                'columnDefs': [ {
                    'targets': [3], // column index (start from 0)
                    'orderable': false, // set orderable false for selected columns
                }],
                response: true,
                language:{
                    search: "_INPUT_",
                    searchPlaceholder: "Search",
                }
            });
            t.on( 'order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();
        });

    </script>
@endsection
