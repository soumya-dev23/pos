@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div>
    <section id="act-container-landscape">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-content bg-light p-3 mt-2">
                            <div class="row">
                                <div class="col-12">
                                    <h2></h2>
                                </div>
                                <?php $i = 1; ?>
                                @foreach($products as $product)
                                    <div class="col-md-4">
                                    <form name="orderForm"  id="orderForm">
                                       @csrf
                                            <div class="act-portrait-wd">
                                                <div class="border">
                                                    <img src="<?php echo $product['product_image'];?>"
                                                        alt="">
                                                        <p>
                                                        {{$product['product_name']}}
                                                        </p>
                                                        <div class="form-group qty d-flex align-items-center justify-content-center">
                                                            <label class="pl-0">Qty:</label> 
                                                            <input type="hidden" name="product_code" value="{{$product['product_code']}}" id="product_id">
                                                            <input min="1" class="form-control" placeholder="Quantity"  name="quantity" id="quantity" type="number" value="1">
                                                            <button type="button" id="place_order"> Order </button>
                                                        </div>
                                                </div>
                                         </form>   
                                            </div>
                                    </div>
                                    <?php if ($i % 3 == 0) {
                                        echo '<div style="height:30px"></div>';
                                       
                                    }
                                    $i++;
                                    ?>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
<script> 
$(document).ready(function () {
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
$("#place_order").click(function() {
    //alert(total_amount);
             var form = $('#orderForm');
      
                        $.ajax({
                            type: "POST",
                            url: "{{ route('products.order-save') }}",
                            dataType: "JSON",
                            data: form.serialize(),
                            success: function (data) {
                                alert(data.message);
                                window.location.reload();
                            },
                            error: function (jqXHR, exception) {
                                $('#loading').hide();
                                var msg = '';
                                if (jqXHR.status === 0) {
                                    msg = 'Not connect.\n Verify Network.';
                                } else if (jqXHR.status == 404) {
                                    msg = 'Requested page not found. [404]';
                                } else if (jqXHR.status == 500) {
                                    msg = 'Internal Server Error [500].';
                                } else if (exception === 'parsererror') {
                                    msg = 'Requested JSON parse failed.';
                                } else if (exception === 'timeout') {
                                    msg = 'Time out error.';
                                } else if (exception === 'abort') {
                                    msg = 'Ajax request aborted.';
                                } else {
                                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                }
                                $('#errorMessage').html(msg);
                                $('#ErrorModal').modal('show');
                            },
                        });
                
          
    });
});
</script>
    <script src="{{asset('assets/js/Chart.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/dashboard_1_demo.js')}}" type="text/javascript"></script>
@endsection