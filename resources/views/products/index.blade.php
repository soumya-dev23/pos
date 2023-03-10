@extends('layouts.master')

@section('title', 'Manage Products')

@section('css')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="page-heading">
        <h1 class="page-title">Manage Products</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard')}}"><i class="fa fa-home font-20"></i></a>
            </li>
            <li class="breadcrumb-item">Manage Products</li>
        </ol>
    </div>
    <div class="page-content fade-in-up">
        <div class="ibox">
            <div class="ibox-head">
                <div class="ibox-title">Products</div>
            </div>
            <div class="ibox-body">
                <table class="table table-striped table-bordered table-hover" id="category-table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Code</th>
                        <th>Created At</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr data-index="{{$product['id']}}">
                            <td>{{$product['id'] }}</td>
                            <td><img class="img-fluid img-50" alt="category" src="<?php echo $product['product_image'];?>"></td>
                            <td>{{$product['product_name']}}</td>
                            <td>{{$product['category']}}</td>
                            <td>{{$product['product_code']}}</td>
                            <td>{{$product['created_at']}}</td>
                            <td class="text-center">
                            <a href="{{route('products.stock', $product['id'])}}" class="btn btn-info  btn-xs m-r-5" data-toggle="tooltip" data-original-title="stock"><i class="fa fa-warehousefont-14"></i></a>
                                <a href="{{route('products.show', $product['product_slug'])}}" class="btn btn-info btn-xs m-r-5" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye font-14"></i></a>
                                <a href="{{route('products.edit', $product['id'])}}" class="btn btn-primary btn-xs m-r-5" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil font-14"></i></a>
                                <a href="{{route('products.destroy', $product['id'])}}" class="btn btn-danger delete-product btn-xs m-r-5" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash font-14"></i></a>
                                <div class="switch_box">
                                    <div class="input_wrapper">
                                        <input type="checkbox" data-url="{{route('products.delete', $product['id'])}}" {{$product['deleted_at'] == null ? 'checked' : ''}} class="switch_4 soft-delete-product">
                                        <svg class="is_checked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 426.67 426.67">
                                            <path d="M153.504 366.84c-8.657 0-17.323-3.303-23.927-9.912L9.914 237.265c-13.218-13.218-13.218-34.645 0-47.863 13.218-13.218 34.645-13.218 47.863 0l95.727 95.727 215.39-215.387c13.218-13.214 34.65-13.218 47.86 0 13.22 13.218 13.22 34.65 0 47.863L177.435 356.928c-6.61 6.605-15.27 9.91-23.932 9.91z"/>
                                        </svg>
                                        <svg class="is_unchecked" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 212.982 212.982">
                                            <path d="M131.804 106.49l75.936-75.935c6.99-6.99 6.99-18.323 0-25.312-6.99-6.99-18.322-6.99-25.312 0L106.49 81.18 30.555 5.242c-6.99-6.99-18.322-6.99-25.312 0-6.99 6.99-6.99 18.323 0 25.312L81.18 106.49 5.24 182.427c-6.99 6.99-6.99 18.323 0 25.312 6.99 6.99 18.322 6.99 25.312 0L106.49 131.8l75.938 75.937c6.99 6.99 18.322 6.99 25.312 0 6.99-6.99 6.99-18.323 0-25.313l-75.936-75.936z" fill-rule="evenodd" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        let dataTable = $('#category-table').DataTable({
            pageLength: 10,
            responsive: true
        });

        $(document).on('change', '.soft-delete-product', function (e) {
            let url = $(this).attr('data-url');

            $.get(url, function (response) {
                if (JSON.parse(response).status){
                    showToast('Success', JSON.parse(response).message, 'success');
                }else {
                    showToast('Error', JSON.parse(response).message, 'error');
                }
            })
        });

        $(document).on('click', '.delete-product', function (e) {
            e.preventDefault();
            let isDelete = confirm('Do you really want to permanently delete?');
            if (isDelete){
                let row = $(this).parents('tr');
                let url = $(this).attr('href');
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function (response) {
                        if (JSON.parse(response).status){
                            showToast('Success', JSON.parse(response).message, 'success');
                            dataTable.row(row).remove().draw(false);
                        } else {
                            showToast('Error', JSON.parse(response).message, 'error');
                        }
                    }
                });
            }
        });
    </script>
@endsection