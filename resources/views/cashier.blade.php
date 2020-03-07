@extends('layouts.admin_layout')
@section('custom_css')

@endsection
@section('page_content')
    <!-- Page -->
    <div class="page animsition" style="margin-left: 0; height: 100%; background-color: white">
        <div class="page-content  padding-0 container-fluid" style="background-color: white">
            <div class="col-sm-6 col-xs-6">
                <div class="row">
                    <div class="example">
                        <select class="show-menu-arrow col-sm-12 col-xs-12" data-plugin="selectpicker" id="id_slt_table_name">
                            <option value="" data-content="">Select Table Name</option>
                            @foreach($tables as $item)
                                <option value="{{$item->table_id}}" data-content="{{$item->table_name}}">{{$item->table_name}}</option>
                            @endforeach
                        </select>

                        <div class=" col-sm-12 col-xs-12">
                            <table class="table table-hover dataTable table-striped" id="orders">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>ShopID</th>
                                    <th class="hide">Date</th>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>ShopID</th>
                                    <th class="hide">Date</th>

                                </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
            <!-- End Panel Basic -->

            <div class="col-sm-6  col-xs-6">
                <div class="row">
                    <div class="example">
                        <select class="show-menu-arrow col-sm-7 col-xs-7" data-plugin="selectpicker" id="id_category">
                            <option value="">Select Category</option>
                            @foreach($categories as $item)
                                <option value="{{$item->id}}" data-id="{{$item->category_name}}">{{$item->category_name}}</option>
                            @endforeach
                        </select>

                        <a href="javascript:" class="btn btn-primary btn-sm pull-right margin-right-15" id="id_bill">Bill</a>

                    </div>


                    <div class="example padding-left-15 products-container"></div>


                </div>
            </div>
        </div>
    </div>
    <!-- End Page -->


    <!-- Modal -->
    <div class="modal fade modal-fill-in" id="modeal_submit" aria-hidden="false" aria-labelledby="exampleFillIn"
         role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content col-xs-12 col-sm-12">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="exampleFillInModalTitle">Ordering</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4">
                                <div class="example">
                                    <img class="img-rounded img-bordered img-bordered-green" width="150" height="150"
                                         src="{{asset('public/images/foods/food.png')}}" alt="...">
                                </div>
                            </div>
                            <div class="col-xs-8 col-sm-8">
                                <div class=" col-sm-6 col-xs-6 form-group">
                                    <input type="text" class="form-control" disabled name="tbName" placeholder="Table Name" style="background: white">
                                </div>

                                <div class="col-sm-6 col-xs-6 form-group">
                                    <input type="text" class="form-control" name="ctName" placeholder="Category Name" disabled  style="background: white">
                                </div>

                                <div class="col-sm-6 col-xs-6 form-group">
                                    <input type="text" class="form-control" name="fdName" placeholder="Food Name"  style="background: white" disabled>
                                </div>

                                <div class="col-sm-6 col-xs-6 form-group">
                                    <input type="text" class="form-control" name="fdPrice" placeholder="Price" id="id_price"  style="background: white" disabled>
                                </div>


                                <div class="col-sm-12 col-xs-12 form-group">
                                    <textarea class="form-control" id="description" rows="3" placeholder="Type Description..." disabled  style="background: white"></textarea>
                                </div>

                                <div class="col-sm-12 col-xs-12 form-group">
                                    <input type="button" class="btn btn-success btn-sm btn-block" value="Submit">

                                </div>

                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->



    <!-- Modal -->
    <div class="modal fade modal-fill-in" id="modal_bill" aria-hidden="false" aria-labelledby="exampleFillIn"
         role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content col-xs-6 col-sm-6">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <!-- Widget -->
                        <div class="widget margin-bottom-0">
                            <div class="widget-content padding-30 bg-green-600 height-200">
                                <div class="counter counter-lg counter-inverse">
                                    <div class="counter-label">
                                        <h1 class="text-center white" id="id_bill_table_name">#001</h1>
                                    </div>
                                    <div class="counter-number-group text-center" style="width:100%;position:absolute;bottom:30px;left:0;">
                                        <span class="counter-number" id="id_bill_price">356</span>
                                        <span class="counter-number-related font-size-30">$</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Widget -->


                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->



@endsection


@section('custom_scripts')

    <script>

        var orderTable;

        var slt_category = $('#id_category');
        var productsContainer = $('.products-container');
        var modeal_submit = $('#modeal_submit');
        var tbName = $('input[name="tbName"]');
        var ctName = $('input[name="ctName"]');
        var fdName = $('input[name="fdName"]');
        var btnSubmit = $("input[type='button']");
        var modalBill = $('#modal_bill');
        var btnBill = $('#id_bill');
        var billTabelName = $('#id_bill_table_name');
        var billPrice = $('#id_bill_price');


        var products = [];
        var tableName = '';
        var categoryName = '';
        var productName = '';
        var tableId = 0;
        var categoryId = 0;
        var productId = 0;



        btnBill.click(function () {

            if(tableName === ""){
                App.showMessage("No Bill");
                return;
            }

            //App.showLoading('');
            $.ajax({
                type: "get",
                url: '{{url('getBillPrice')}}',
                data: {
                    _token : '{{csrf_token()}}',
                    tableId: tableId,
                },
                dataType: 'json',
                success: function (data) {
                    //App.hideLoading();
                    billTabelName.text(tableName);
                    billPrice.text(data.results);
                    modalBill.modal();
                },
                error: function () {
                    //App.hideLoading();
                }
            });


        });




        $('#id_slt_table_name').change(function () {
            tableId = this.value;
            tableName = $(this).children("option:selected").data('content');
            orderTable.draw();

        });


        jQuery(document).ready(function () {

            orderTable = $('#orders').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "paging":   true,
                "ordering": true,
                "info":     true,
                "bLengthChange" : false,
                "searching": false,

                language: {
                    "sSearchPlaceholder": "Search..",
                    "lengthMenu": "_MENU_",
                    "search": "_INPUT_",
                    "paginate": {
                        "previous": '<i class="icon md-chevron-left"></i>',
                        "next": '<i class="icon md-chevron-right"></i>'
                    },


                },
                "ajax": {
                    "url": "{{url('getOrders')}}",
                    "type": "get",
                    "data": function(d) {
                        d._token = "{{csrf_token()}}";
                        d.tableId = tableId;
                    }
                },
                "pageLength": 5,

                "order": [[3, "desc"]],
                "columnDefs": [
                    {
                        "targets": [3],
                        "visible": false
                    },
                    // {
                    //     "targets": "_all",
                    //     "searchable": false
                    // }
                ],
                "columns": [
                    {
                        "data": "product_name",
                    },
                    {
                        "data": "status",
                        "render": function (data, item, row) {
                            var out = '';

                            switch (data) {
                                case "In Progress":
                                    out = '<span class="label label-outline label-warning">'+ data +'</span>'
                                    break;
                                case "Served":
                                    out = '<span class="label label-outline label-success">'+ data +'</span>'
                                    break;
                                case "Cancel":
                                    out = '<span class="label label-outline label-warning">'+ data +'</span>'
                                    break;
                                default:

                            }

                            return out;

                        }
                    },
                    {
                        "data": "shop_id",
                    },

                    {
                        "data": "date_transaction",

                    },

                ]
            });


            slt_category.change(function () {
                categoryId = this.value;
                categoryName = $(this).children("option:selected").data('id');
                getProducts(this.value);
            });




            function getProducts(category_id) {
                $.ajax({
                    type: "get",
                    url: '{{url('getProducts')}}',
                    data: {
                        _token : '{{csrf_token()}}',
                        category_id: category_id
                    },
                    dataType: 'json',
                    success: function (data) {
                        productsContainer.empty();
                        data.results.map((item) => {
                            var out = '<a href="javascript:" class="btn-product btn btn-sm margin-left-10 margin-bottom-5" style="color: white ;background-color: '+ getRandomColor() +'" data-id="'+ item.product_id +'" data-content="'+ item.product_name +'" data-description="'+ item.product_description +'" data-price="'+ item.price +'" data-taxCode="taxcode" data-photo="photo"  data-shopid="shopId">'+ item.product_name +'</a>';
                            $(out).css("background-color", getRandomColor());
                            productsContainer.append(out).children("a").click(function () {
                                if (tableName === ""){
                                    App.showMessage("Please Select Table Name")
                                    return;
                                }

                                var description = $(this).data('description');
                                $('#description').text(description);

                                var taxcode = $(this).data('taxcode');
                                console.log(taxcode);

                                var photo = $(this).data('photo');
                                console.log(photo);

                                var shopid = $(this).data('shopid');
                                console.log(shopid);

                                var price = $(this).data('price');
                                $('#id_price').val(price + " $");

                                productName = $(this).data('content');
                                productId = $(this).data('id');
                                tbName.val(tableName);
                                ctName.val(categoryName);
                                fdName.val(productName);
                                modeal_submit.modal();
                                return;
                            });
                        });
                    },
                    error: function () {}
                });
            }



            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }




            btnSubmit.click(function () {
                App.showLoading('');
                $.ajax({
                    type: "get",
                    url: '{{url('submit')}}',
                    data: {
                        _token : '{{csrf_token()}}',
                        tableId: tableId,
                        productId: productId,
                        unitPrice: 89,
                        shopId: 90,
                    },
                    dataType: 'json',
                    success: function (data) {
                        App.hideLoading();
                        if (data.results){
                            orderTable.draw();

                            modeal_submit.modal('hide');
                        } else {
                            App.showFailedMessage("Fail")
                        }
                    },
                    error: function () {
                        App.hideLoading();
                    }
                });


            });



        });




    </script>


@endsection


