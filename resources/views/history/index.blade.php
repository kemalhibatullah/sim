@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
  <div class="page-header-content">
    <div class="page-title">
      <h4><i class=""></i> <span class="text-semibold">History</span></h4>
    </div>
  </div>

  <div class="breadcrumb-line breadcrumb-line-component">
    <ul class="breadcrumb">
      <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
      <li class="active">History</li>
    </ul>
  </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- State saving -->
  <div class="panel panel-flat">
    <div style="padding:20px">
      <table name="user" class="table" id="table-history" class="display" style="width:100%">
        <thead>
          <tr>
            <th>Id</th>
            <!-- <th>Check</th> -->
            <th>Name</th>
            <th>Email</th>
            <th class="col-md-2">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $data_history)
          <tr id={{$data_history->id}}>
            <!-- <td><input type="checkbox" name="{{$data_history->id}}" class="kemi"></td> -->
            <td value={{$data_history->id}}>{{$data_history->id}}</td>
            <td>{{$data_history->name}}</td>
            <td>{{$data_history->email}}</td>
            <td><a id="btn-detail" href="/admin/history/{{$data_history->id}}" class="btn border-info btn-xs text-info-600 btn-flat btn-icon"><i class="icon-eye"></i></a></td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
    <div style="margin-left : 10px; margin-bottom : 10px;">
      <a class="btn btn-warning" href="/quiz_categorys/export_excel">Export Data</a>
    </div>
  </div>
  <!-- /state saving -->
</div>
<!-- /content area -->
<!-- <script>
 $(document).ready(function() {
    $('input.kemi').click(function(){
      alert(this.name);
    })
    
})
</script> -->
@endsection
@push('after_script')

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
  var history;
  var history_user;
  var user_id = $('table[name="user"]').val();

  $(document).ready(function() {
    // $('input.kemi').click(function(){
    //   alert("1");
    // })
    //   // .change();
    // history = $('#table-history').DataTable({
    //   processing: true,
    //   language: {
    //     search: "_INPUT_",
    //     searchPlaceholder: "Search records"
    //   },
    //   // dom 		: "<fl<t>ip>",
    //   serverSide: true,
    //   stateSave: true,
    //   ajax: {
    //     url: "{{ url('table/data-history') }}",
    //     type: "GET",
    //   },
    //   columns: [{
    //       data: 'id',
    //       name: 'id',
    //       visible: true
    //     },
    //     {
    //       data: 'check',
    //       name: 'check',
    //       visible: true
    //     },
    //     {
    //       data: 'name',
    //       name: 'name',
    //       visible: true
    //     },
    //     {
    //       data: 'email',
    //       name: 'email',
    //       visible: true
    //     },
    //     {
    //       data: 'action',
    //       name: 'action',
    //       visible: true
    //     },
    //   ],
    // });

  });
</script>
@endpush