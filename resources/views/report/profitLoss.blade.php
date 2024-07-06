@extends('layouts.admin')

@section('title', 'Reports')
@section('content-header', 'Profit & Loss Report')

@section('content')
<div class="content-wrapper mx-4" style="min-height: 1378px;">
    <section class="content">
        <div class="row">
            <div class="row mb-3">
                <div class="px-4">
                    <form action="{{route('report.profitLoss')}}">
                        <div class="row">
                            <div class="px-3">
                                <input type="date" name="start_date" class="form-control" value="" />
                            </div>
                            <div class="col-md-5">
                                <input type="date" name="end_date" class="form-control" value="" />
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="box bg-white p-4 mb-4 ">
                    <div class="box-header pb-3">
                        <div class="btn-group pull-right" title="View Account">
                            <button class="btn btn-primary btn-o dropdown-toggle" onclick="htmlTableToExcel('xlsx')" data-toggle="dropdown" href="#">
                                <i class="fa fa-fw fa-bars"></i> Export
                            </button>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover " id="tblToExcl">
                            <!-- Total Gross Profit -->
                            <tbody>
                                <tr>
                                    <td>Gross Income</td>
                                    <td class="text-right text-bold gross_profit">{{ number_format($totalSalePrice, 2) }}</td>
                                </tr>
                                <!-- Total Net Profit -->
                                <tr>
                                    <td>Net Income</td>
                                    <td class="text-right text-bold gross_profit">{{ number_format($netProfit, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
                <div class="box bg-white">
                    <div class="box-header p-3">

                        <div class="btn-group pull-right" title="View Account">
                            <button class="btn btn-primary btn-o dropdown-toggle" onclick="salesReport('xlsx')" data-toggle="dropdown" href="#">
                                <i class="fa fa-fw fa-bars"></i> Export
                            </button>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table bg-white table-hover " id="salesReport">
                            <tbody>

                                <tr>
                                    <td colspan="2" class="text-bold font-italic text-primary">Sales</td>
                                </tr>
                                <!-- Total Sales -->
                                <tr>
                                    <td>Sales</td>
                                    <td class="text-right text-bold sal_total">{{$sales->sum('amount')}}</td>
                                </tr>
                                <tr>
                                    <td>Total Discount on Sales</td>
                                    <td class="text-right text-bold sales_discount_amt">{{$sales->sum('discount')}}</td>
                                </tr>
                                <tr>
                                    <td>Total Sales</td>
                                    <td class="text-right text-bold text-primary net_sales">{{$totalSalePrice}}</td>
                                </tr>
                                <!-- Total Sales Paid Amount -->
                                <tr>
                                    <td>Paid Payment</td>
                                    <td class="text-right text-bold text-success sales_paid_amount">{{$sales->sum('amount')}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box bg-white p-3">
                    <div class="box-header pb-3">
                        <div class="btn-group pull-right" title="View Account">
                            <a class="btn btn-primary btn-o dropdown-toggle" onclick="purchaseReport('xlsx')" data-toggle="dropdown" href="#">
                                <i class="fa fa-fw fa-bars"></i> Export </span>
                            </a>

                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover " id="purchaseReport">
                            <!-- Total Opening Stock -->
                            <tbody>
                                <tr>
                                    <td>Opening Stock</td>
                                   <td class="text-right text-bold opening_stock_price" id="balance">0.000</td>
                                </tr>
                                <script>
                                    let totalAmount = parseFloat(localStorage.getItem('amount'));
                                    console.log(totalAmount);
                                        document.getElementById('balance').innerText="Rs "+totalAmount;
                                </script>
                                <tr>
                                    <td colspan="2" class="text-bold font-italic text-primary">Purchase</td>
                                </tr>
                                <!-- Total Purchase -->
                                <tr>
                                    <td>Total Purchase</td>
                                    <td class="text-right text-bold pur_total">{{$allPurchase}}</td>
                                </tr>
                                <!-- Total Purchase Tax -->
                                <tr>
                                    <td>Total Purchase Expanses</td>
                                    <td class="text-right text-bold purchase_tax_amt">{{$products->sum('tax')}}</td>
                                </tr>
                                <!-- Total Purchase Doscount -->
                                <tr>
                                    <td>Total Discount on Purchase</td>
                                    <td class="text-right text-bold purchase_discount_amt">{{$purchase->sum('discount')}}</td>
                                </tr>
                                <!-- Total Purchase Paid Amount -->
                                <tr>
                                    <td>Paid Payment</td>
                                    <td class="text-right text-bold text-success purchase_paid_amount">{{$purchase->sum('paidAmount')}}</td>
                                </tr>
                                <!-- Total Purchase Due -->
                                <tr>
                                    <td>Purchase Due</td>
                                    <td class="text-right text-bold text-danger purchase_due_total">{{$purchase->sum('dues')}}</td>
                                </tr>

                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-hover my-3" id="expensesReport">
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-bold font-italic text-primary">
                                        <div class="box-header pb-3">
                                            <div class="btn-group pull-right" title="View Account">
                                                <a class="btn btn-primary btn-o dropdown-toggle" onclick="expensesReport('xlsx')" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-fw fa-bars"></i> Export
                                                </a>

                                            </div>
                                        </div>
                                        Expenses' Report
                                    </td>
                                </tr>
                                <!-- Total Purchase Return -->
                                <tr>
                                    <td>
                                        Totla Expanses
                                    </td>
                                    <td class="text-right text-bold pur_return_total">{{$expenses->sum('amount')}}</td>
                                </tr>
                                <!-- Total Purchase return Tax -->
                                <tr>
                                    <td>Expesnses Dues</td>
                                    <td class="text-right text-bold purchase_return_tax_amt">0.000</td>
                                </tr>
                                <!-- Total Purchase return Other Charges -->
                                <tr>
                                    <td>Total Other Expense Charges</td>
                                    <td class="text-right text-bold pur_return_other_charges_amt">0.000</td>
                                </tr>

                                <tr>
                                    <td>Paid Payment</td>
                                    <td class="text-right text-bold text-success purchase_return_paid_amount">{{$expenses->sum('amount')}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>

            <!-- right column -->

        </div>
</div>
</section>
</div>
@section('js')
<script>
    function htmlTableToExcel(type) {
        var data = document.getElementById('tblToExcl');
        var excelFile = XLSX.utils.table_to_book(data, {
            sheet: "sheet1"
        });
        XLSX.write(excelFile, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        });
        XLSX.writeFile(excelFile, 'ExportedFile:Report.' + type);
    }

    function expensesReport(type) {
        var data = document.getElementById('expensesReport');
        var excelFile = XLSX.utils.table_to_book(data, {
            sheet: "sheet1"
        });
        XLSX.write(excelFile, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        });
        XLSX.writeFile(excelFile, 'ExportedFile:ExpensesReport.' + type);
    }

    function salesReport(type) {
        var data = document.getElementById('salesReport');
        var excelFile = XLSX.utils.table_to_book(data, {
            sheet: "sheet1"
        });
        XLSX.write(excelFile, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        });
        XLSX.writeFile(excelFile, 'ExportedFile:salesReport.' + type);
    }

    function purchaseReport(type) {
        var data = document.getElementById('purchaseReport');
        var excelFile = XLSX.utils.table_to_book(data, {
            sheet: "sheet1"
        });
        XLSX.write(excelFile, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        });
        XLSX.writeFile(excelFile, 'ExportedFile:purchaseReport.' + type);
    }
</script>

@endsection
@endsection