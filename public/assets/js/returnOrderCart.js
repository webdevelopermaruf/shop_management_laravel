function ReturnQtyIncre(max,barcode){
    let now = $("#Return_"+barcode).val();
    if(now < max){
        now++;
        $("#Return_"+barcode).val(now);
        moneybackforSingle(barcode);
    }
}

function ReturnQtyDecr(barcode){
    let now = $("#Return_"+barcode).val();
    if(now > 1){
        now--;
        $("#Return_"+barcode).val(now);
        moneybackforSingle(barcode);
    }
}

function returnQtyInput(max,barcode){
    let now = $("#Return_"+barcode).val();
    if(now < 1){
        now=1;
        $("#Return_"+barcode).val(now);
        moneybackforSingle(barcode);
        return;
    }
    if(now > max){
        now = max;
        $("#Return_"+barcode).val(now);
        moneybackforSingle(barcode);
        return;
    }
    
}
function moneybackforSingle(barcode){
    let Rqty = $('#Return_'+barcode).val();
    let perPrice = $('#Return_'+barcode).data("singleitemprice");
    let result = Rqty * perPrice;
   $(".mback_"+barcode).html(result);
}

function deleteReturnOrderItem(){
    $('#ReturnOrderTable').on('click', 'button#returndeletetbtn', function(e){
        $(this).closest('tr').remove()
     })
}


$(".exchangeBtnToNewOrder").on('click',function(){
    hideModal('#returnOrderModel');
})
$("#getMoneyBack").on('click',function(){
    let total = 0;
    let qty=0;
    document.querySelectorAll("#returnMoneyTotal").forEach((e)=>{
        let a = parseInt(e.innerHTML);
        total+= a;
    }) 
    document.querySelectorAll(".rp_qtys").forEach((e)=>{
    
        let a = parseInt(e.value);
        qty+= a;
    })
    // console.log(total , qty);
    $(".returnProductItems").html(qty);
    $(".totalReturnedMoney").html(total);
})


function returnProductWithMoney(){
    let cusname = $("#return_cus_name").val();
    let cusphn = $("#return_cus_phn").val();
    let previous_order = $("#hid_pre_order_no").val();
    let tqty = $(".returnProductItems").html();
    let rmoney = $(".totalReturnedMoney").html();
    let all = [];
    if(cusname == '' || cusphn == ''){
        alert('Please Fill Up Customer Name & Phone Number');
        return;
    }
    document.querySelectorAll(".OrderEditReturnTbody tr").forEach((row)=>{
        let item = {};
        item.name= row.querySelector("td").innerHTML;
        item.barcode= row.querySelector("#return_barcodes").innerHTML;
        item.returnQty= row.querySelector(".rp_qtys").value;
        item.moneyBack= row.querySelector("#returnMoneyTotal").innerHTML;
        all.push(item);
    })
    
    axios.put('/quick/return-order/action/return/price/',{
        cusname: cusname,
        cusphn: cusphn,
        pre_order_no: previous_order,
        totalQty: tqty,
        totalReturnMoney: rmoney,
        returnProducts:all
    }).then(function(res){
        console.log(res.data);
        if(res.data == 'done'){
            toastr.success('Order Return Success');
            $(".tableEditOrder").addClass('d-none');
            hideModal('#returnOrderModel');
            $(".returnProductItems").html('0');
            $(".totalReturnedMoney").html('0');
            $(".searchRecentOrdersForm").trigger("reset");
            $(".returnFinalMoneyBack").trigger("reset");
        }
    })
}

function returnProductWithExchange(exchangeOrderId){
    let cusname = $("#return_cus_name").val() ;
    let cusphn = $("#return_cus_phn").val();
    let previous_order = $("#hid_pre_order_no").val();
    let tqty = $(".returnProductItems").html();
    let rmoney = $(".totalReturnedMoney").html();

    let all = [];
    
    document.querySelectorAll(".OrderEditReturnTbody tr").forEach((row)=>{
        let item = {};
        item.name= row.querySelector("td").innerHTML;
        item.barcode= row.querySelector("#return_barcodes").innerHTML;
        item.returnQty= row.querySelector(".rp_qtys").value;
        item.moneyBack= row.querySelector("#returnMoneyTotal").innerHTML;
        all.push(item);
    })
    
    axios.put('/quick/return-order/action/return/product/exchange',{
        pre_order_no: previous_order,
        totalQty: tqty,
        newOrderId:exchangeOrderId,
        totalReturnMoney: rmoney,
        returnProducts:all
    }).then(function(res){
        console.log(res.data);
        if(res.data == 'done'){
            toastr.success('Order Return Success');
            $(".tableEditOrder").addClass('d-none');
            hideModal('#returnOrderModel');
            $(".returnProductItems").html('0');
            $(".totalReturnedMoney").html('0');
            $(".searchRecentOrdersForm").trigger("reset");
            $(".returnFinalMoneyBack").trigger("reset");
        }
    })
}