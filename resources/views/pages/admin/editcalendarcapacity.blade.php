@extends('admin')

@section('content')
    <nav aria-label="breadcrumb">   
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/calendar_capacity">Capacity/Inventory</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Capacity/Inventory Update</a></li>
      </ol>
    </nav>
<div class="alert alert-success successText" style="display:none">
    Success
</div>
    <div class="container">
        <div class="row">
        <div id="capacity_date" data-field-id="{{$calendarcap->from_date}}" ></div>
            <div class="col-12">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Tray Capacity</span>
                    </div>
                    <input type="number" id="traycapacity" class="form-control" value="{{$calendarcap->tray_capacity}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Tray Remaining</span>
                    </div>
                    <input type="number" id="trayremaining" class="form-control" value="{{$calendarcap->tray_remaining}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
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
        <a href="/admin/calendar_capacity"><button type="button" class="btn btn-danger" data-dismiss="modal">BACK</button></a>
        <button type="button" id="updateCapacity" class="btn btn-primary">UPDATE</button>
    </div>

@endsection

@push('scripts')
<script>
$( document ).ready(function() {
    $('.successText').hide();
    let capacity_date = $('#capacity_date').data("field-id");

    $(".datepicker").daterangepicker({
        singleDatePicker: true,
        opens: 'center',
        drops: "down",
        minDate: capacity_date ? moment(capacity_date).format("MMMM DD, YYYY") : moment().format("MMMM DD, YYYY"),
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

  

  $('#updateCapacity').on('click', function() {
    $('#selectedDate').val(moment(capacity_date).format("YYYY-MM-DD"));
    capacity_date = moment(capacity_date).format("YYYY-MM-DD");
    if($('#traycapacity').val() && $('#selectedDate').val()) {
        $.ajax( {
            type: "PUT",
            url: "{{ url('admin/calendar_capacity/'.$calendarcap->id)}}",
            data: { traycap: $('#traycapacity').val(), trayremaining: $('#trayremaining').val(), date: $('#selectedDate').val() },
            success: function(data) {
                if(data.status) {
                    location.reload();
                    $('.successText').show();
                    setTimeout(function(){ $('.successText').fadeOut() }, 2000);
                }else if(data.error) {
                    alert(data.error)
                }
            }
        });
    }else {
        alert('Error')
    }
   
   


  })
});
</script>
@endpush