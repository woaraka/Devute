@extends('Admin.layouts.app')
@section('titleApp', 'Admin Page Assign')
@section('modal')
    <div id="add_data_Modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Page Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('PageAssignEmp.insert') }}">
                        @csrf
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <select name="employee" class="form-control selectpicker @error('employee') is-invalid @enderror" title="Employee Name" data-live-search="true" required autofocus>
                                    <option value="">Select Employee</option>
                                    @foreach($user as $users)
                                        <option value="{{ $users->id }}" {{ old('employee') == $users->id ? 'selected' : ''}}>{{ $users->name }} - {{ $users->email  }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                            </div>
                            @error('employee')
                            <span class="text-danger">
                            <p id="employee">{{ $message }}</p>
                        </span>
                            @enderror
                        </div>
                        <h5>Select Pages</h5>
                        @error('PageSelect')
                        <span class="text-danger">
                            <p id="PageSelect">{{ $message }}</p>
                        </span>
                        @enderror
                        @foreach($page as $pages)
                            <div class="form-check">
                                <input class="form-check-input" name="PageSelect[]" type="checkbox" id="inlineCheckbox1" value="{{ $pages->id }}">
                                <label class="form-check-label" for="inlineCheckbox1">{{ $pages->name }}</label>
                            </div>
                        @endforeach
                        <br>
                        <input type="submit" name="insert" id="submitForm" value="Submit" class="btn btn-success"/>
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
                    <form method="POST" id="FormUpdate" action="{{ route('PageAssignEmp.update') }}">
                        @csrf
                        <input type="hidden" name="hiddenEmpID" id="hiddenID" />
                        <div class="form-group has-feedback">
                            <div class="input-group">
                                <input type="text" id="txtEditEmp" name="UpdateEmp" value="{{ old('UpdateEmp') }}" class="form-control @error('UpdateEmp') is-invalid @enderror" placeholder="Employee Name" title="Employee Name" disabled/>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                        <h5>Select Pages</h5>
                        @foreach($page as $pages)
                            <div class="form-check">
                                <input class="form-check-input" name="pageCheck[]" type="checkbox" id="inlineCheckbox" value="{{ $pages->id }}">
                                <label class="form-check-label" for="inlineCheckbox">{{ $pages->name }}</label>
                            </div>
                        @endforeach
                        <br>
                        <input type="submit" name="insert" id="submitForm" value="Submit" class="btn btn-success"/>
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
                            <table class="table table-bordered table-sm" id="tblEmpPage">
                                <thead class="table-active">
                                <tr>
                                    <th>SL</th>
                                    <th>Employee</th>
                                    <th>Pages</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($user as $role)
                                    @if($role->page_permission->isNotEmpty())
                                        @php $tempArray = array() @endphp
                                        @php $pages = \App\User::find($role->id) @endphp
                                        <tr>
                                            <td></td>
                                            <td>{{ $pages->name}}</td>
                                            <td>
                                                @foreach ($pages->page_permission as $roles)
                                                    {{ $roles->name }} |
                                                    @php array_push($tempArray, $roles->id); @endphp
                                                @endforeach
                                            </td>

                                            <td title="Update" style="vertical-align: middle;"><button type="button" class="btn btn-info btnUpdatePermission" data-toggle="modal" data-target="#Edit_data_Modal" data-PageID="{{ implode("|", $tempArray) }}" data-name="{{ $pages->name }}" data-empID=" {{$pages->id}} "><i class="ti-pencil"></i></button>
                                            </td>
                                        </tr>
                                    @endif
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
                @if($errors->has('employee') || $errors->has('PageSelect'))
                $('#add_data_Modal').modal('show');
                @elseif($errors->has('pageCheck'))
                $('#Edit_data_Modal').modal('show');
                @endif
            });
        </script>
    @endif

    <script>
        $('#Edit_data_Modal').on('show.bs.modal', function (e) {
            var button = $(e.relatedTarget); // Button that triggered the modal
            var name = button.attr('data-name');
            var ID = button.attr('data-empID');
            var page = button.attr('data-PageID');

            var modal = $(this);
            modal.find($('#txtEditEmp')).val(name);
            modal.find($('#hiddenID')).val(ID);
            if(page)
            {
                var arr = page.split("|");
                var chk_arr =  document.getElementsByName("pageCheck[]");
                for(i=0;i< chk_arr.length;i++)
                {
                    for(j=0; j<arr.length; j++)
                    {
                        if(chk_arr[i].value == arr[j])
                        {
                            chk_arr[i].checked = true;
                            break;
                        }
                        else
                            chk_arr[i].checked = false;
                    }
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            var t = $('#tblEmpPage').DataTable({
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
