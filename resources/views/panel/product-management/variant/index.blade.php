@extends('master') @section('content')
<link href="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<div class="container-fluid">
    <div class="animate fadeIn">
        <div class="row">
            <div class="col-sm-6">
                <p>
                    <button type="button" class="btn btn-primary" onclick="refresh()">
                        <i class="fa fa-refresh"></i>
                    </button>
                    <a class="btn btn-primary" href="{{route('variant.create')}}">
                        <i class="fa fa-plus"></i>&nbsp; New Variant
                    </a>
                    <!-- <a class="btn btn-primary" href="{{url('variant/reorder')}}">
                        <i class="fa fa-random"></i>&nbsp; Reorder Variants
                    </a> -->
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Variants Table
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered table-striped table-sm datatable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Type</th>
                                    <th>Option</th>
                                    <th>Date registered</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <i class="fa fa-gear fa-spin"></i>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </div>
</div>
@endsection
<!-- /.container-fluid -->

@section('myscript')
<script src="{{ asset('fiture-style/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('fiture-style/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    //DATATABLES
    $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{route("variant.index")}}/list-data',
        columns: [
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'slug',
                name: 'slug'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'option[,].text',
                name: 'option[,].text'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '20%'
            }
        ],
        "columnDefs": [{
            "targets": 4,
            "className": "text-center"
        }],
        "order": [
            [4, 'desc']
        ]
    });
    $('.datatable').attr('style', 'border-collapse: collapse !important');
</script>
@endsection