@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- centered -->
            <div class="col-md-12">
              @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(Session::has('msg'))
<div class="alert alert-danger" role="alert">

{{ Session::get('msg') }}
</div>
@endif
              <!-- general form elements -->
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Get historical data by submitting Company Symbol</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form  id="form" method="POST" action="{{route('historical.quotes')}}">
                  @csrf
                  <div class="card-body">

                    <div class="row">

                   <!-- left column -->
 
                    <div class="col-md-6">

                      <div class="form-group">
                        <label>Company Symbol</label>
                        <select class="form-control  form-control-lg select2bs4" style="width: 100%;" name="symbol" required>
                        </select>
                      </div>


                        <!-- Date  From-->
                        <div class="form-group">
                            <label>Start Date:</label>
                              <div class="input-group date" id="startDate" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" data-target="#startDate" name="start_date" required data-date-format="YYYY-mm-dd"/>
                                  <div class="input-group-append" data-target="#startDate" data-toggle="datetimepicker">
                                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                  </div>
                              </div>
                          </div>
                        <!--/ Date  From-->


                    </div>
                    <!--/ left column -->

                     <!-- right column -->
                     <div class="col-md-6">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email"  name="email" required>
                      </div>

                  <!-- Date  to-->
                  <div class="form-group">
                     <label>End Date:</label>
                       <div class="input-group date" id="endDate" data-target-input="nearest">
                           <input type="text" class="form-control datetimepicker-input" name="end_date" data-target="#endDate" data-date-format="YYYY-mm-dd"/ required>
                           <div class="input-group-append" data-target="#endDate" data-toggle="datetimepicker">
                               <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                           </div>
                       </div>
                     </div>
                         <!--/ Date  to-->
                  <!-- /.right column -->

                </div>
                <!-- /.row -->
                     </div>
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" value="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
  
            </div>
            <!--/.col (centered) -->

          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
    <!-- /.content -->
@endsection

@section('scripts')

<script>

    $(function () {
     
    $('.select2bs4').select2({
      theme: 'bootstrap4',
    placeholder: 'Select a Symbol',
    selectOnClose: false,
    tokenSeparators: [',', ' '],
   // delay: 250,
    cache: true,
    ajax: {
        dataType : "json",
        url      : "{{url("/test-json-file")}}",

        //url      : "/companies_symbols.json",

        data: function (params) {
      var query = {
        q: params.term,
        page: params.page || 1
      }     
      return query;
    }
    },
    });


    //     //Date picker
    $('#startDate').datetimepicker({
        minView: 2,
        format: 'YYYY-MM-DD',
        dateonly: true
    });

    $('#endDate').datetimepicker({
        minView: 2,
        format: 'YYYY-MM-DD',
        dateonly: true
    });


    })

     </script> 
@endsection