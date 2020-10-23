@extends('admin')

@section('custom_style')
<style>
.container-remove-padding {
    padding-left: 0;
    padding-right: 0;
}

.modal-content {
  top: 30vh;
}


</style>
@endsection

@section('content')
<div class="alert alert-success successText" style="display:none">
    Success
</div>
<div class="container container-remove-padding">
<div style="overflow: auto;">
<div id="date_latest" data-field-id="{{$calendarlatest->from_date}}" ></div>
<table class="table">
  <thead class="thead">
    <tr>
      <th scope="col"></th>
      <th scope="col"><small>Date<i>(mm-dd-yyyy)</i></small></th>
      <th scope="col"><small>Capacity</small></th>
      <th scope="col"><small>Remaining</small></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  @foreach($calendarcaps as $calendarcap)
  <tr>
    <th><a href="calendar_capacity/{{$calendarcap->id}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></th>
      <td><small>{{ \Carbon\Carbon::parse($calendarcap->from_date)->format('m-d-Y') }}</small></td>
      <td>{{$calendarcap->tray_capacity}}</td>
      <td><a href="order_items/{{$calendarcap->to_date}}">{{ $calendarcap->tray_remaining }}</a></td>
      <td><a data-toggle="modal" data-target="#deleteModal{{$calendarcap->id}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
    </tr>
    <div class="modal fade" id="deleteModal{{$calendarcap->id}}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <p style="text-align:center">ARE YOU SURE?</p>
        </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" id="{{$calendarcap->id}}" class="btn btn-danger deleteItem" data-dismiss="modal">Delete</button>
      </div>
      
    </div>
  </div>
  @endforeach
  </tbody>
</table>
</div>
{{ $calendarcaps->links() }}
</div>
<div class="container">
    <div class="row">
        <div class="col-6 offset-3" style="display:grid;">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">CREATE</button>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">ADD NEW</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-12">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Tray Capacity</span>
                        </div>
                        <input type="number" id="traycapacity" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                        <p class="warningText pl-2 mb-0"><small><i><span style="color:red">Required</span></i></small></p>
                      </div>
                      </div>
                      <div class="col-12">
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm">Date</span>
                        </div>
                        <input id="selectedDate" placeholder="Selected date" type="text" class="form-control datepicker" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                      </div>
                      </div>
                    </div>
                  </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
                  <button type="button" id="addCapacity" class="btn btn-primary">ADD</button>
                </div>
              </div>
            </div>
          </div>
</div>
</div>
@endsection

@push('scripts')
<script>
$( document ).ready(function() {
  
    $('.warningText').hide();
    $('.successText').hide();
    let capacity_date = $('#date_latest').data("field-id");

    $(".datepicker").daterangepicker({
        singleDatePicker: true,
        opens: 'center',
        drops: "auto",
        minDate: capacity_date ? moment(capacity_date).add(1, 'days').format("MMMM DD, YYYY") : moment().format("MMMM DD, YYYY"),
        applyButtonClasses: "btn-warning",
        autoApply: true,
        locale: {
            format: "MMMM DD, YYYY",
            applyLabel: "Confirm",
        },
    }, function(start, end, label) {
      $('#selectedDate').val(start.format('YYYY-MM-DD'))
        // console.log("A new date selection was made: "+ label+ ' ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
  $('#selectedDate').val(moment(capacity_date).add(1, 'days').format("YYYY-MM-DD"));

  $('#addCapacity').on('click', function() {
    if($('#traycapacity').val() < 1) {
      $('.warningText').show();
      return false;
    }else {
      $('.warningText').hide();

      $.post( "{{ url('admin/calendar_capacity')}}", { traycap: $('#traycapacity').val(), date: $('#selectedDate').val() })
      .done(function( data ) {
        if(data.status) {
          $('#exampleModal').modal('toggle');
          location.reload();
          $('.successText').show();
          setTimeout(function(){ $('.successText').fadeOut() }, 2000);
        }else {
          alert('Error')
        }
      });

    }
  });

  $('.deleteItem').on('click', function() {
    // console.log("{{ url('admin/calendar_capacity/')}}"+ '/' + this.id,)
    $.ajax( {
            type: "DELETE",
            url: "{{ url('admin/calendar_capacity/')}}"+ '/' + this.id,
            success: function(data) {
                if(data.status) {
                    location.reload();
                    $('.successText').show();
                    setTimeout(function(){ $('.successText').fadeOut() }, 2000);
                }
            }
        });
  })
    
});
</script>
@endpush