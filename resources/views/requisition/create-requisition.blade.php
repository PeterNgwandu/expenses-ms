<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\Budgets\BudgetsController;
use App\Http\Controllers\Requisitions\RequisitionsController;

// foreach ($data as $data) :

?>

@extends('layout.app')

@section('content')

<style type="text/css">
   /* .requisition div {
        padding: 0px; margin-left: 0px; width: 150px;
    }
    .requisition div input {
        margin: 0px; padding: 0px; width: 100%
    }
    .requisition i:hover {
        color: #fff !important; background: purple
     }*/
     .reqiuisition-container {
        max-width: 96% !important;
     }
     .mydata {
        display: none;
    }
    .preload {
        margin: 0px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
        margin-top: 10px;
        background: #ffffff;
    }
    .img {
        background: #ffffff;
    }
    #myProgress {
  width: 100%;
  background-color: #ddd;
}

#myBar {
  width: 1%;
  height: 30px;
  background-color: #03AA6B;
}
#budget {
  margin-top: -120px;
  margin-bottom: 10px;
  background: #E5E8E8;
}
#item_name {
  margin-left: -140px;
}
input,
input::-webkit-input-placeholder {
    font-size: 12px;
    line-height: 3;
}
select,option {
   font-size: 13px;
}
/*#line_description {
  margin-top: -120px;
  margin-bottom: 10px;
  margin-left: 30px;
  background: #ffffff;
  width: 500px;
}*/
</style>
<div class="preload">
    <img class="img" src="{{url('assets/images/giphy.gif')}}">
</div>
<div class="mdk-drawer-layout js-mdk-drawer-layout mydata" data-fullbleed data-push data-has-scrolling-region>
    <div class="mdk-drawer-layout__content mdk-header-layout__content--scrollable">

        <div class="container reqiuisition-container">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-earnings">
                        <div class="card-header bg-faded">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <h4 class="card-title">Create Requisition</h4>
                                    <span class="float-right">
                                        <p class="lead" style="color: #35A45A;">
                                            {{RequisitionsController::getTheLatestRequisitionNumber()}}
                                        </p>
                                    </span>

                                    <a href="{{url('create-requisition')}}" data-value="{{Auth::user()->id}}" class="btn btn-sm btn-twitter refresh float-right" style="margin-top: -2px; margin-right:25px; border-radius:0px !important">Refresh</a>

                                    <button class="btn btn-sm btn-twitter float-right" style="margin-top: -2px; margin-right:25px; width: 160px; border-radius:0px !important">
                                        <input disabled type="" id="total_amount" value="" class="form-control float-right" name="">
                                    </button>
                                    <p class="float-right font-weight-bold mr-2 mt-2">Total Budget Available</p>

                                </div>
                            </div>
                        </div>

                        <div id="czContainer" class="card-group">
                            <div class="card card-body bg-light ">
                              <div class="form-inline">

                                    <form class="form-inline data requisition-form" id="data">
                                        @csrf
                                        <input type="hidden" name="req_no" value="{{RequisitionsController::getTheLatestRequisitionNumber()}}">
                                        <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                                        <select style="width: 140px;background: #ffffff;border: 1px solid #E5E8E8" id="budget" name="budget_id" class="form-control budget-restrict" data-toogle="tooltip" data-placement="top" title="Select Budget">
                                             <option value="Select Budget" selected disabled>
                                                 Budget
                                             </option>
                                             <option value="0">No Budget</option>
                                             @foreach($budgets as $budget)
                                                 <option value="{{ $budget->id }}" @if (old('budget_id') == $budget->id) selected="selected" @endif>{{ $budget->title }}</option>
                                             @endforeach
                                        </select>
                                        <select id="item_name" style="width: 130px;background: #ffffff;border: 1px solid #566573" name="item_id" class="form-control item" data-toogle="tooltip" data-placement="top" title="Select Budget Line">
                                             <option value="Select Budget" selected disabled>
                                                 Budget Line
                                             </option>
                                             @foreach($items as $item)
                                                <option value="{{$item->id}}">{{$item->item_name}}</option>
                                             @endforeach
                                        </select>
                                        <input disabled id="line_description" type="text" style="width: 360px;margin-right: 50px;" value="" disabled class="form-control" placeholder="Budget Line Description" data-toogle="tooltip" data-placement="top" title="Budget Line Description">

                                        <input id="activity_name" style="width: 185px; margin-right: 10px; margin-left: -55px;" type="text" name="activity_name" class="form-control activity_name" placeholder="Activity Name" data-toogle="tooltip" data-placement="top" title="Activity Name" value="<?php isset($activity) ? $activity->activity_name : ''; ?>">

                                        <input id="item_name2" style="width: 150px;" type="text" name="item_name" class="form-control item_name" placeholder="Item" data-toogle="tooltip" data-placement="top" title="Item To Purchase" value="">
                                        <input id="unit_measure" style="width: 70px;" type="text" name="unit_measure" class="form-control unit_measure" placeholder="UoM" data-toogle="tooltip" data-placement="top" title="Unit of Measure" value="">
                                        <input id="quantity" style="width: 60px;" type="text" name="quantity" class="form-control quantity" placeholder="Qty" data-toogle="tooltip" data-placement="top" title="Quantity" value="">
                                        <input id="unit_price" style="width: 120px;" type="number" name="unit_price" class="form-control unit_price" placeholder="Price" data-toogle="tooltip" data-placement="top" title="Unit Price" value="">
                                        <select style="width: 170px;" name="vat" value="" class="form-control vat" data-toogle="tooltip" data-placement="top" title="Select VAT Options">
                                            <option value="VAT_Options" selected disabled>VAT Options</option>
                                            <option value="VAT Exclusive">Exclusive</option>
                                            <option value="VAT Inclusive">Inclusive</option>
                                            <option value="Non VAT">Non VAT</option>
                                        </select>
                                        <select id="account" style="width: 190px;" name="account_id" class="form-control accounts" data-toogle="tooltip" data-placement="top" title="Select Account">
                                            <option value="VAT Options" selected disabled>Account</option>
                                            @foreach($accounts as $account)
                                                <option value="{{$account->id}}">{{$account->account_name}}</option>
                                            @endforeach
                                        </select>
                                        <input id="description" style="width: 280px;" type="text" name="description" class="form-control description" data-toogle="tooltip" data-placement="top" title="Description of Item to Purchase" placeholder="Description">
                                        &nbsp;
                                        <button style="height:35px;" class="btn  btn-sm btn-twitter submit-requisition">
                                            <span>
                                                <i style="cursor: pointer;" class="material-icons submit-requisition md-10 align-middle mb-1 text-white">add_circle</i>
                                                Add Line
                                                <!-- <i style="cursor: pointer;" class="material-icons delete-row md-10 align-middle mb-1 text-primary">remove_circle</i> -->
                                             </span>
                                        </button>

                                        <!-- <button type="submit" class="btn float-right btn-outline-primary mt-3 ml-1">Retire</button> -->
                                        <br>
                                        <hr><hr>
                                    </form>


                                    </div>

                                <table class="table table-sm mb-0 mt-3">
                                      <thead class="thead-dark">
                                          <tr>
                                              <!-- <th scope="col" class="text-center">Select</th> -->
                                              <th scope="col" class="text-center">Budget</th>
                                              <th scope="col" class="text-center">Budget Line</th>
                                              <th scope="col" class="text-center">Requisition No.</th>
                                              <th scope="col" class="text-center">Item Name</th>
                                              <th scope="col" class="text-center">Unit Measure</th>
                                              <th scope="col" class="text-center">Qty</th>
                                              <th scope="col" class="text-center">Unit Price</th>
                                              <th scope="col" class="text-center">VAT</th>
                                              <th scope="col" class="text-center">Account</th>
                                              <th scope="col" class="text-center">Description</th>
                                              <th scope="col" class="text-center">Action</th>
                                          </tr>
                                      </thead>
                                      <tbody class="render-requisition">

                                      </tbody>

                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection
<script type="text/javascript" src="{{url('assets/js/jquery.js')}}"></script>
<script type="text/javascript">


        $(document).on('change', '#budget', function() {
            var budget_id = $(this).val();
            if(budget_id) {
                $(".item").show();
                $("#line_description").show();
                $( ".item" ).prop( "disabled", false );
                $( "#line_description" ).prop( "disabled", false );
                $('option', this).not(':eq(0), :selected').remove();

                var url = '/get-items-list/'+budget_id;
                $.get(url, function(data) {
                    if(data){
                        $('.item').empty();
                        $('.item').focus;
                        $('.item').append('<option value="">-- Select Item --</option>');
                        $.each(data, function(key, value){
                        $('select[name="item_id"]').append('<option value="'+ value.id +'">' + value.item_name+ '</option>');
                        $('.item').css({'border' : '1px solid #CD5C5C'});
                    });
                  }else{
                      $('.item').empty();
                    }
                });
            }
            if(budget_id == 0){
                $(".item").hide();
                $("#line_description").hide();
                $( ".item" ).prop( "disabled", true );
                $( "#line_description" ).prop( "disabled", true );
            }
        });

        $(document).on('change', '.budget-restrict', function(e) {
            e.preventDefault();
            var budget_id = $(this).val();
            var url = 'budget-restrict/'+ budget_id;

            $.get(url, function(data) {
                console.log(data.result);
                if(data.result != 'undefined'){
                    swal("Warning!", "Make sure you do not use a different budget, otherwise your requisition will not be created.", "warning");
                }else{
                    swal("Opps!", "Cannot submit.", "error");
                }

                // window.location = "create-requisition";
            });
        });

        // $(document).on('click', '.new-row', function(){
        //     var url = '/add-new-form';
        //     $.get(url, function(data){
        //         $('.render-requisition-row').html(data.result);
        //     });
        // });

        // $(document).on('change', '.accounts', function(e){
        //     var budget = $('.budget').val();
        //     var item = e.target.value;
        //     var accounts = e.target.value;
        //     var url = '/submit-single-row/'+budget+'/'+item+'/'+accounts;
        //     $.get(url, function(data){
        //         console.log(data.result);
        //         $('.render-requisition-row').html(data.result);
        //     });
        // });

        $(document).on('change', '#budget', function(e) {
            e.preventDefault();
            var budget_id = $(this).val();
            var url = '/get_total_budget_amount/' + budget_id;
            $.get(url, function(data) {
                console.log(data.result);
                if(data.result <= 0)
                {
                    swal('Oops','Budget is insufficient','info');
                }
                $('#total_amount').val(data.result);
                $('#total_amount').prop('disabled', true);
            });
        });

        $(document).on('change', '.item', function(e) {
            var itemId = $(this).val();
            var url = '/get-item-description/'+itemId;
            $.get(url, function(data) {
                console.log(data.result.description);
                $('#line_description').val(data.result.description);
                $('#line_description').prop('disabled', true);
            })
        });

        $(document).ready(function() {
          var activity_name = $("#activity_name");
          var activity_name_value = $(".activity_name").val();
          activity_name.on('mouseover',function(){
            if(activity_name_value != 'null'){
              console.log(activity_name_value);
            }else{
              // swal('Alert', 'Please use only one activity name for one requisition', 'warning');
            }
          });
        });




        $(document).on('change', '#item', function(e) {
            var item_id = $(this).val();
            var url = 'create-requisition/'+item_id;
            $.get(url, function(data) {
                console.log(data.result);
            });
        });

        $(document).on('click', '.submit-requisition', function(e) {
            e.preventDefault();


            localStorage.setItem("budget_id", $(this).closest('form').find('select[name=budget_id]').val());
            if (localStorage.getItem("budget_id")) {
              $(this).closest('form').find('select[name=budget_id]').val(localStorage.getItem("budget_id"));
              $("#budget").val(localStorage.getItem("budget_id"));
              console.log(localStorage.getItem("budget_id"));
            }

            var budget_id = $(this).closest('form').find('select[name=budget_id]').val();
            var item_id = $(this).closest('form').find('select[name=item_id]').val();
            var req_no = $(this).closest('form').find('input[name=req_no]').val();
            var activity_name = $(this).closest('form').find('input[name=activity_name]').val();

            var item_name2 = $(this).closest('form').find('input[name=item_name]').val();
            var unit_measure = $(this).closest('form').find('input[name=unit_measure]').val();
            var unit_price = $(this).closest('form').find('input[name=unit_price]').val();
            var quantity = $(this).closest('form').find('input[name=quantity]').val();
            var vat = $(this).closest('form').find('select[name=vat]').val();
            var account_id = $(this).closest('form').find('select[name=account_id]').val();
            var description = $(this).closest('form').find('input[name=description]').val();
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
                type: "POST",
                url: '/submit-single-requisition-row',
                data: $('.requisition-form').serialize()+"&"+$.param({'req_no':req_no,'budget_id':budget_id,'item_id':item_id,'activity_name':activity_name,'item_name2':item_name2, 'unit_measure':unit_measure,'unit_price':unit_price,'quantity':quantity,'vat':vat,'description':description,'account_id':account_id}),
                dataType: "json",
                success: function(data) {
                    console.log(data.result);
                    $('.render-requisition').html(data.result);
                    swal("Good Job", "Requisition line created successfuly.", "success");
                    if (budget_id == localStorage.getItem("budget_id")) {
                        $(this).closest('form').find('select[name=budget_id]').attr('selected', true);
                    }
                    if($("#data").find("#activity_name").val() != null){
                        var activity_name = $("#activity_name");
                        activity_name.on('mouseover',function(){
                          if($("#data").find("#activity_name").val() != null){
                            // swal('Alert', 'Please do not change activity name', 'warning');
                            alert('Please do not change activity name', 'warning');
                          }
                        });
                    }

                    $("#data").find("#item_name2").val('');
                    $("#data").find("#unit_measure").val('');
                    $("#data").find("#quantity").val('');
                    $("#data").find("#unit_price").val('');
                    $("#data").find("#description").val('');
                },
                error: function(){
                    //alert('opps error occured');
                }
            });

        });

        $(document).on('click', '.refresh', function(e) {
            var user_id = $(this).attr("data-value");
            var url = '/truncate-requisitions-line/' + user_id;
            $.get(url, function(data) {
                console.log(data.result);
                window.location('create-requisition');
            });
        });

        $(document).on('click', '.permanent-requisition', function(e) {
            var req_no = $(this).attr('req-no');
            var url = '/permanent-requisition/'+req_no;
            $.get(url, function(data) {
                console.log(data.result);
                window.location = "submitted-requisitions";
            });
        });

        $(document).on('click', '.add-row', function(e) {
            // $("#data").find('select').each(function(data){


        });

        $(document).on('click', '.delete-row', function(e) {
            e.preventDefault();
            var req_no = attr('data-req').val();
            var req_id = attr('data-id').val();
            alert(req_no);
            // $("table tbody").find('input[name="record"]').each(function(){
            //     if($(this).is(":checked")){
            //       id[i] = $(this).val();
            //     }
            // });
            // $("table tbody tr td").find('.delete-requisition-line').remove();

        });

        $(document).on('click', '.delete-requisition-line', function(e) {
            e.preventDefault();
            var currentRow = $(this);
        	var req_id = $(this).attr('id');
            var url = 'delete-requisition/'+req_id;
            // swal({
            //     title: "Delete",
            //     text: "Are you sure you want to delete this?",
            //     type: "error",
            //     showCancelButton: true,
            //     confirmButtonClass: 'btn-danger waves-effect waves-light',
            //     confirmButtonText: "Delete",
            //     cancelButtonText: "Cancel",
            //     closeOnConfirm: true,
            //     closeOnCancel: true,
            //   }),

              $.get(url, function(data) {
                  console.log(data.result);
                  currentRow.parent().parent().remove();
                  swal("Deleted!", "Your line has been deleted successfuly.", "success");
              });

        });

        $(document).ready(function() {
            $('.preload').fadeOut('3000', function() {
                $('.mydata').fadeIn('2000');
            });
        });

</script>
