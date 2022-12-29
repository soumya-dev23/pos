@extends('layouts.master')

@section('title', 'Create Product')

@section('css')
    <link href="{{asset('assets/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/cropper.css')}}" rel="stylesheet" type="text/css">
    <style>
        span.select2-container{
            width: 100% !important;
        }
    </style>
@endsection

@section('content')
    @include('partials._crop-image-modal')

    <div class="page-heading">
        <h1 class="page-title">Manage Stock</h1>
    </div>
<div class="page-content">
    <div class="ibox">
        <div class="ibox-head">
            <div class="ibox-title">Store Management</div>
        </div>
        <table class="table table-striped table-bordered table-hover" id="category-table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Batch No</th>
                        <th>QTY</th>
                        <th>Unit Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product_stocks as $product)
                        <tr data-index="{{ $product->batch_number }}">
                            <td>{{ $product->batch_number }}</td>
                            <td>{{ $product->qty_avbl }}</td>
                            <td>{{ $product->sale_price  }}</td>

                        </tr>
                    @endforeach
                    </tbody>
        </table>
        <div class="ibox-body">
            <div class="row">
                <div class="col-md-8">
                    <form action="{{route('products.stock-save')}}" method="post" novalidate="novalidate" id="productForm" enctype="multipart/form-data">
                        @csrf
                        @if(isset($product))
                            @method('PUT')
                        @endif
                    <div id="dynamic_field">    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label for="batch_number" class="col-sm-3 col-form-label">Batch No:</label>
                                    <div class="col-sm-9">
                                    <input class="form-control  name="batch_number[]"  id="batch_number" type="text" placeholder="Batch No">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required row">
                                    <label for="qty_avbl" class="col-sm-3 col-form-label">QTY:</label>
                                    <div class="col-sm-9">
                                    <input class="form-control  name="qty_avbl[]"  id="qty_avbl" type="text" placeholder="qty_avbl">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group required row">
                                    <label for="sale_price" class="col-sm-3 col-form-label">Unit Price:</label>
                                    <div class="col-sm-9">
                                    <input class="form-control  name="sale_price[]"  id="sale_price" type="text" placeholder="sale_price">
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                        <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary btn-block">{{isset($product) ? 'Update' : 'Create'}} Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('js')
    <script src="{{asset('assets/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/cropper.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/image-cropper-modal.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        let rules = {
            product_name: {
                minlength: 5,
                required: !0
            },
            product_code: {
                minlength: 5,
                required: !0
            },
            category_id: {
                required: !0
            },
            product_slug: {
                minlength: 5,
                required: !0
            },
            sale_price: {
                min: 1,
                required: !0
            },
            product_image: {
                minlength: 10,
                required: !0
            },
        };
    </script>
    <script>
$(document).ready(function(){
var i=1;
$('#add').click(function(){
i++;
alert(i);
$('#dynamic_field').append('<div class="row"><div class="col-md-4"><div class="form-group row"><label for="batch_number" class="col-sm-3 col-form-label">Batch No:</label><div class="col-sm-9"><input class="form-control  name=" batch_number[]"="" id="batch_number" type="text" placeholder="Batch No"></div></div></div><div class="col-md-4"><div class="form-group required row"><label for="qty_avbl" class="col-sm-3 col-form-label">QTY:</label><div class="col-sm-9"><input class="form-control  name=" qty_avbl[]"="" id="qty_avbl" type="text" placeholder="qty_avbl"></div></div></div><div class="col-md-4"><div class="form-group required row"><label for="sale_price" class="col-sm-3 col-form-label">Unit Price:</label><div class="col-sm-9"><input class="form-control  name=" sale_price[]"="" id="sale_price" type="text" placeholder="sale_price"></div></div></div></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
});
	
$(document).on('click', '.btn_remove', function(){
var button_id = $(this).attr("id"); 
$('#row'+button_id+'').remove();
});
});
</script>
    <script src="{{asset('assets/js/products.js')}}" type="text/javascript"></script>
@endsection