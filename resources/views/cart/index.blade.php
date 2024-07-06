@extends('layouts.admin')

@section('title', 'Open POS')
@section('collapse', 'sidebar-collapse')
@section('css')
<style>
    .swal2-html-container {
        overflow: hidden !important;
        font-size: 15px !important;
    }
</style>
@endsection
@section('content')
<div id="cart"></div>
@endsection
@section('js')
<script>
    function paymentMethod() {
        var tDetails = document.getElementById("t_details");
        var method = document.getElementById("paymentMethod").value;
        var label = document.getElementById("label");
        if (method === "Cash") {
            tDetails.classList.add("d-none");
        } else {
            tDetails.classList.remove("d-none");
        }
    }

    function calculate() {
        let discount = parseFloat($("#discount").val());
        let amount = parseFloat($("#amount").val());

        let newAmount = Math.max(amount - discount, 0);

        newAmount = Math.round(newAmount * 100) / 100;

        $("#amount").val(newAmount.toFixed(2));
    }
</script>
@endsection