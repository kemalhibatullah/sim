@extends('layouts.app')
@section('content')
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">History User</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="{{route('history.index')}}">History</a></li>
            <li class="active">History User</li>
        </ul>
    </div>
</div>
<!-- Content area -->
<div class="content">
    <!-- User thumbnail -->
    <div class="thumbnail">
        @if($data->picture == 'avatar.png')
        <img class="img-circle" src="{{asset('img/avatar.png')}}" alt="Avatar" title="Change the avatar" width="100" height="50" style="padding-top:15px;">
        @else
        <img class="img-circle" src="{{route('user.picture',$data->id)}}" alt="Avatar" title="Change the avatar" width="100" height="50" style="padding-top:15px;">
        @endif
        <div class="caption text-center">
            <h6 class="text-semibold no-margin">{{$data->name}} <small class="display-block">{{ucfirst($data->roles[0]['name'])}}</small></h6>
        </div>
    </div>
    <!-- /user thumbnail -->

    <div class="thumbnail">
        <h6 class="panel-title" style="margin-left: 10px; margin-top: 20px;">Chart filter</h6>
        <div class="btn-group" style="margin-left: 10px;">
            <select name="category" class="form-control">
                <option>-- Quiz Category --</option>
                @foreach ($dataj as $category)
                <option class="tt" value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>
        </div>
        <div class="btn-group" style="margin-left: 10px;">
            <select name="quiz-type" class="form-control">
                <option>-- Quiz Type --</option>
            </select>
        </div>
        <div class="btn-group" style="margin-left: 20px; margin-top: 20px; margin-bottom: 20px;">
            <select id="aba" name="category-quiz" class="form-control">
                <option>-- Quiz --</option>
            </select>
        </div>
        <div class="btn-group" style="margin-left: 20px; margin-top: 20px; margin-bottom: 20px;">
            <button class="btn btn-primary" id="semua" name="semua">Lihat Semua</button>
        </div>

        <!-- Chained -->

    </div>

    <div class="panel panel-flat">
        <div class="panel-heading">
            <h6 class="panel-title">Basic line chart</h6>
            <div class="heading-elements">
                <ul class="icons-list">
                    <li><a data-action="collapse"></a></li>
                    <li><a data-action="reload"></a></li>
                    <li><a data-action="close"></a></li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="chart-container">
                <div class="chart" id="c3-line-regions-chart"></div>
            </div>
        </div>
    </div>


    <div class="panel panel-flat">
        <div style="padding:20px">
            <table class="table" id="table-history-user" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Title Quiz</th>
                        <th>Date</th>
                        <th>Score</th>
                        <th class="col-md-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
@push('after_script')
<script type="text/javascript" src="{{asset('js/plugins/visualization/d3/d3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/visualization/c3/c3.min.js')}}"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

<script>

</script>
<script>
    var history_user;

    $(document).ready(function() {

        $('select[name="category"]').on('change', function() {
            var categoryId = this.value;
            if (categoryId) {
                $.ajax({
                    url: '/select/data-quiz-type/' + categoryId,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function() {
                        $('#loader').css("visibility", "visible");
                    },

                    success: function(data) {

                        $('select[name="quiz-type"]').empty();
                        $('select[name="quiz-type"]').append('<option>' + "-- Quiz Type --" + '</option>');

                        $.each(data, function(key, value) {


                            $('select[name="quiz-type"]').append('<option value="' + value['id'] + '">' + value['Name'] + '</option>');
                        });
                    },
                    complete: function() {
                        $('#loader').css("visibility", "visible");
                    }
                });
            } else {
                $('select[name="quiz-type"]').empty();
            }
            console.log(categoryId);

        });

        $('select[name="quiz-type"]').on('change', function() {
            var categoryTypeId = this.value;
            if (categoryTypeId) {
                $.ajax({
                    url: '/select/data-quiz/' + categoryTypeId,
                    type: "GET",
                    dataType: "json",
                    beforeSend: function() {
                        $('#loader').css("visibility", "visible");
                    },

                    success: function(data) {

                        $('select[name="category-quiz"]').empty();
                        $('select[name="category-quiz"]').append('<option>' + "-- Quiz --" + '</option>');

                        $.each(data, function(key, value) {

                            $('select[name="category-quiz"]').append('<option value="' + value['id'] + '">' + value['text'] + '</option>');
                        });
                    },
                    complete: function() {
                        $('#loader').css("visibility", "visible");
                    }
                });
            } else {
                $('select[name="category-quiz"]').empty();
            }
            console.log(categoryTypeId);

        });

        $("#aba").on('change', function() {
            x = this.value;

            $.ajax({
                type: 'GET',
                url: "{{ url('table/data-history-chart-id') }}" + "/" + "{{$data->id}}" + "/" + x,
                success: function(data) {
                    //alert(data.success);
                    var chart_line_regions = c3.generate({
                        bindto: '#c3-line-regions-chart',
                        size: {
                            height: 500
                        },
                        point: {
                            r: 4
                        },
                        data: {
                            // x: 'x',
                            columns: data,
                        },
                        grid: {
                            y: {
                                show: true
                            }
                        },
                        axis: {
                            x: {
                                label: 'Quiz ke-',
                                start: 1
                            },
                            y: {
                                label: 'Total score'
                            },
                        }
                    });
                }
            });

        });

        $("button").click(function(e) {
            $.ajax({
                type: 'GET',
                url: "{{ url('table/data-history-chart') }}" + "/" + "{{$data->id}}",
                success: function(data) {
                    //alert(data.success);
                    var chart_line_regions = c3.generate({
                        bindto: '#c3-line-regions-chart',
                        size: {
                            height: 500
                        },
                        point: {
                            r: 4
                        },
                        data: {
                            // x: 'x',
                            columns: data,
                        },
                        grid: {
                            y: {
                                show: true
                            }
                        },
                        axis: {
                            x: {
                                label: 'Quiz ke-',
                                start: 1
                            },
                            y: {
                                label: 'Total score'
                            },
                        }
                    });
                }
            });
        });


        history_user = $('#table-history-user').DataTable({

            order: [
                [4, "desc"]
            ],
            processing: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records"
            },
            // dom 		: "<fl<t>ip>",
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ url('table/data-history-user') }}" + "/" + "{{$data->id}}",
                type: "GET",
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    visible: false
                },
                {
                    data: 'name',
                    name: 'name',
                    visible: true
                },
                {
                    data: 'category',
                    name: 'category',
                    visible: true
                },
                {
                    data: 'type',
                    name: 'type',
                    visible: true
                },
                {
                    data: 'title',
                    name: 'title',
                    visible: true
                },
                {
                    data: 'date',
                    name: 'date',
                    visible: true
                },
                {
                    data: 'score',
                    name: 'score',
                    visible: true
                },
                {
                    data: 'action',
                    name: 'action',
                    visible: true
                },
            ],


            dom: 'lBfrtip',
            buttons: [
                {
                    "extend": 'excel',
                    "text": 'Export Data',
                    "className": 'btn btn-primary'
                }
            ],
            select: true
        });


    });
</script>
@endpush