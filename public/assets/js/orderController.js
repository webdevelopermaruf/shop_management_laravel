function reWriterForCartItem(cart) {
    var cartNewAricle = '';
    if (cart.length == 0) {
        $(".cashNowBtn").css('display', 'none');
    } else {
        $(".cashNowBtn").css('display', 'block');
        for (const item in cart) {
            cartNewAricle += ` <tr>
            <td>${cart[item].name} <span class="text-danger" style="font-weight: 700">[${cart[item].attributes.stock}]</span></td>
            <td class="d-none">${cart[item].attributes.stock}</td>
            <td>
                <div class="input-group input-group-sm"><span class="input-group-btn">
                        <button onclick="decrement_qty(${cart[item].id})" type="button" class="btn btn-default btn-flat"><i class="ti-minus text-danger"></i>
                        </button>
                    </span>
                    <input type="number" value="${cart[item].quantity}" id='qty-item-${cart[item].id}'
                        class="form-control no-padding text-center min_width outindecator" oninput="input_u_qty(${cart[item].id})" onchange="oninput_qty(${cart[item].id})" data-stock='${cart[item].attributes.stock}'>
                    <span class="input-group-btn">
                        <button onclick="increment_qty(${cart[item].id})" type="button" class="btn btn-default btn-flat">
                            <i class="ti-plus text-success"></i>
                        </button>
                    </span>
                </div>
            </td>
            <td style='cursor:help' id='price-${cart[item].id}' title='${cart[item].attributes.factory}'>${cart[item].price}</td>
            <td><input onchange='setdiscount(${cart[item].id}, ${cart[item].price})' id="dis-${cart[item].id}" type="number" 
            value="${cart[item].discount}" class="outindecator sub-discount" style="width:75px"></td>
            <td><span class='subtotal-sum' id="subtotal-${cart[item].id}">${(cart[item].price * cart[item].quantity) - cart[item].discount}</span></td>
            <td><i onclick="delitem(${cart[item].id})" class="ti-trash btn btn-sm btn-danger"></i></td>
        </tr>`;
        }
    }

    document.querySelector('#cartTbody').innerHTML = cartNewAricle;
}
function addrow(id, qty = null) {
    var stock = qty;
    var nowval = $("#qty-item-" + id).val();
    if (nowval == stock || stock == 0) {
        toastr.error('Product Not Available!', { timeout: 30 });
        $(".autocomplete").html('');
        warningsound();
        return;
    }
    insertsuccess();
    $(".autocomplete").html('');
    $("#itemorbarcode").val('');
    axios.post('/add/to/cart', {
        id: id
    }).then(function (res) {
        if (res.data == null) {
            return;
        } else {
            reWriterForCartItem(res.data);
        }
    })
}

function tbody() {
    axios.get('/carts').then(function (cart) {
        reWriterForCartItem(cart.data);
    });
}
tbody();

function onsuggest(item) {
    if (item.checked == false) {
        $(".autocomplete").html('');
        $("#itemorbarcode").attr('onkeyup', '')
    } else {
        $(".autocomplete").html('');
        $("#itemorbarcode").attr('onkeyup', 'keyupSuggestion(this)')
    }
}
function keyupSuggestion(content) {
    if (content.value != '') {
        var optionBody = '<ul class="auto-complete-input-menu">';
        axios.post('/barcode/get', {
            keyword: content.value,
        }).then(function (res) {
            for (let item of res.data) {
                optionBody += `<li onclick='addrow(${item.product_id}, ${item.product_qty})'
                 data-productid='${item.product_id}'>${item.product_name}</li>`
            }
            optionBody += `</ul>`;
            $(".autocomplete").html(optionBody);
        })
    } else {
        $(".autocomplete").html('');
    }
}

function barcodeReader(item) {
    if (item.value.length >= 9) {
        axios.post('/barcode/put', {
            barcode: item.value,
        }).then(function (res) {
            if (res.data == '') {
                return;
            } else if (res.data == 'empty') {
                warningsound();
                toastr.error('Product Not Available')
                $("#itemorbarcode").val('');
                $(".autocomplete").css('display', 'none');
            } else {
                reWriterForCartItem(res.data);
                $("#itemorbarcode").val('');
                $(".autocomplete").css('display', 'none');
            }

        })
    }
}

function decrement_qty(id) {
    var nowval = $('#qty-item-' + id).val();
    if (nowval == 1) {
        return;
    } else {
        // clickedsound();
        $('#qty-item-' + id).val(nowval - 1);
        $('#subtotal-' + id).html((nowval - 1) * $('#price-' + id).text() - $('#dis-' + id).val());

        axios.get('/update/qty/cart/' + id + '/' + (nowval - 1))
            .then(function (res) {
            });
    }
}
function increment_qty(id) {
    var stock = $('#qty-item-' + id).data('stock');
    var nowval = $('#qty-item-' + id).val();

    if (nowval < stock) {
        // clickedsound();
        var x = parseInt(nowval) + 1;
        $('#qty-item-' + id).val(x);
        $('#subtotal-' + id).html(x * $('#price-' + id).text() - $('#dis-' + id).val());
        axios.get('/update/qty/cart/' + id + '/' + x)
            .then(function (res) {
            });
    } else {
        return;
    }
}

function clearAll() {
    axios.get('/deleteall/to/cart').then(function (res) {
        if (res.data == 'done') {
            document.querySelector('#cartTbody').innerHTML = '';
        }
    });
    $(".cashNowBtn").css('display', 'none');
}
function oninput_qty(id) {
    var stock = $('#qty-item-' + id).data('stock');
    var nowval = $('#qty-item-' + id).val();
    if (nowval > 0) {
        $('#subtotal-' + id).html(nowval * $('#price-' + id).text() - $('#dis-' + id).val());
    }

    if (nowval == '' || nowval < 1) {
        $('#qty-item-' + id).val(1);
        $('#subtotal-' + id).html($('#price-' + id).text() - $('#dis-' + id).val());
        axios.get('/update/qty/cart/' + id + '/' + 1)
            .then(function (res) {
            });
    }
    if (nowval > stock) {
        // insertsuccess();
        $('#qty-item-' + id).val(stock);
        $('#subtotal-' + id).html(stock * $('#price-' + id).text() - $('#dis-' + id).val());
        axios.get('/update/qty/cart/' + id + '/' + stock)
            .then(function (res) {
            });
    }

}
function setdiscount(id, maxprice = null) {

    if ($('#dis-' + id).val() == '' || $('#dis-' + id).val() < 0) {
        $('#dis-' + id).val(0)
    }
    if (maxprice * $('#qty-item-' + id).val() < $('#dis-' + id).val()) {
        $('#dis-' + id).val(0);
    }
    var nowval = $('#dis-' + id).val();
    $('#subtotal-' + id).html($('#qty-item-' + id).val() * $('#price-' + id).text() - $('#dis-' + id).val());
    axios.get('/barcode/put/discount/' + id + "/" + nowval).then(function (res) {
    })

}
function input_u_qty(id) {
    var nowval = $('#qty-item-' + id).val();
    axios.get('/update/qty/cart/' + id + '/' + nowval)
        .then(function (res) {
        });

}
function delitem(id) {
    axios.get('/delete/qty/cart/' + id)
        .then(function (res) {
            reWriterForCartItem(res.data);
        });
}
function readyInvoice() {
    var subtotal = 0;
    var subdis = 0;
    document.querySelectorAll('.subtotal-sum').forEach(element => {
        subtotal += parseInt(element.innerText);
    });
    document.querySelectorAll('.sub-discount').forEach(element => {
        subdis += parseInt(element.value);
    });
    let returnMoney = $(".totalReturnedMoney").html();

    $(".mtprice").html(subdis + subtotal);
    $(".mtdiscount").html(subdis);
    $(".mtpayable").html(subtotal - returnMoney);

}
$("#payingId").on('input', function () {
    var price = $(".mtpayable").text();
    var getreturn = this.value - price;
    $(".returnable").html(getreturn);

})


function PaymentClearence(button) {
    button.disabled = true;
    var price = parseInt($(".mtpayable").text());
    var paying = $("#payingId").val();

    if (paying >= price) {
        axios.post('order/addto/invoice', {
            customer: $(".customerSelect").val(),
            total: $('.mtprice').text(),
            discount: $('.mtdiscount').text(),
            payable: $('.mtprice').text() - $('.mtdiscount').text(),
        }).then(function (res) {
            hideModal('#payModal');
            reWriterForCartItem(res.data);
            toastr.info('Order Payment Successfully');
            $('#select').val('guest').trigger('change');
            button.disabled = false;
        })
    } else {
        button.disabled = false;
        $("#payingId").focus();
    }

}

function clickedsound() {
    var clickedsound = new Audio('assets/sound/clickedsound.mp3');
    clickedsound.play();
}

function insertsuccess() {
    var insertSuccess = new Audio('assets/sound/insertsound.wav');
    insertSuccess.play();
}

function warningsound() {
    var warningsound = new Audio('assets/sound/failed.mp3');
    warningsound.play();
}
//modal autofocus 
$('#editModal').on('shown.bs.modal', function () {
    $('#val-customerName').focus()
})

$('#payModal').on('shown.bs.modal', function () {
    $('#payingId').val('');
    $('.returnable').html('');
    $('#payingId').focus();
})

//invoice settings

function updateInvoice(id) {
    var invoicetable = '';
    axios.get('/get/invoice/' + id).then(function (res) {
        for (let invoice of res.data) {
            invoicetable += `<tr>
            <td style='text-transform:capitalize;'>${invoice.invoice_product}</td>
            <td class="action-td secr-td">${invoice.invoice_factory}</td>
            <td class="action-td">${invoice.invoice_sell}</td>
            <td class="action-td">${invoice.invoice_qty}</td>
            <td class="action-td">${invoice.invoice_discount}</td>
            <td class="action-td">${invoice.invoice_paid}</td>
         </tr>`;
        }
        $('#invoiceTbody').html(invoicetable);
    });
    axios.get('/get/sell/' + id).then(function (res) {
        var order = res.data;
        $("#invoice_customer").html(order.orders_holder + "<br/>" + (order.orders_holder_phone == 'guest' ? '' : order.orders_holder_phone));
        $("#invoice_order_time").html(order.orders_creation);
        $("#paidPriceInvoice").html(order.orders_grand_price);
        $(".printingInv").attr('onclick', 'print_invoice(' + order.orders_id + ')');
    });
}

//order return section 

function orderReturnSearch(){
    var mobile = $("#return_mobile_search");
    var invoice = $("#return_invoice_search");
    var orderdate = $("#return_orderdate_search");
    axios.put('/quick-order/select/orders/items',{
        phone: mobile.val(),
        invoice: invoice.val(),
        orderDate: orderdate.val(),
    }).then(function(res){
        $(".tableEditOrder").addClass('d-none');
        $(".OrderEditReturnTbody").html('');
        if(res.data.length == 0){
            $(".searchOrderTable").removeClass('d-none');
            $("#SearchedOrdersTbody").html('<tr><td colspan="5" style="color:red;font-size:20px;text-align:center">No Data Found</td></tr>');
        }else{
            $(".searchOrderTable").removeClass('d-none');
            let content = '';
            for (let item of res.data) {
                content += `<tr>
                <td>${item.orders_holder}</td>
                <td>${item.orders_holder_phone}</td>
                <td>${item.orders_grand_price}</td>
                <td>${item.orders_creation}</td>
                <td><button onclick="returnProductOptionOpening(${item.orders_id})" class="btn btn-danger"><i class="ti-search"></i></button></td></tr>`
            }
            $("#SearchedOrdersTbody").html(content);
        }
    });
}

function returnProductOptionOpening(orderID){
    $(".searchOrderTable").addClass('d-none');
    $(".tableEditOrder").removeClass('d-none');
    let Id = orderID;
    let content = '';
    axios.get("/quick-order/select/products/"+Id)
    .then(function(res){
      if(res.data.length!=0){
        for(let item of res.data){
            content += `
            <tr>
            <td>${item.invoice_product}</td>
            <td id='return_barcodes'>${item.invoice_barcode}</td>
            <td>${item.invoice_qty}</td>
            <td>
                <div class="input-group input-group-sm"><span class="input-group-btn">
                        <button onclick='ReturnQtyDecr(${item.invoice_barcode})' type="button" class="btn btn-default btn-flat">
                        <i class="ti-minus text-danger"></i>
                        </button>
                    </span>
                    <input type="number" value="1" id="Return_${item.invoice_barcode}" 
                    class="form-control no-padding text-center min_width outindecator rp_qtys" onchange="returnQtyInput(${item.invoice_qty},${item.invoice_barcode})" data-singleitemprice='${item.invoice_paid / item.invoice_qty}' />
                    <span class="input-group-btn">
                        <button onclick='ReturnQtyIncre(${item.invoice_qty},${item.invoice_barcode})' type="button" class="btn btn-default btn-flat">
                            <i class="ti-plus text-success"></i>
                        </button>
                    </span>
                </div>
            </td>
            <td class="return_paid_${item.invoice_barcode}">${item.invoice_paid}</td>
            <td id='returnMoneyTotal' class='mback_${item.invoice_barcode}'> ${item.invoice_paid / item.invoice_qty} </td>
            <td><button id='returndeletetbtn' onclick="deleteReturnOrderItem()" class="btn btn-danger"><i class="ti-trash"></i></button></td>
            </tr>
            `;
        }
        $(".OrderEditReturnTbody").html(content);
        $("#hid_pre_order_no").val(Id);
        $(".boxbuttonReturn").removeClass('d-none');
      }
      
      if(res.data == 'returned'){
        $(".boxbuttonReturn").addClass('d-none');
        $("#hid_pre_order_no").val(Id);
        $(".OrderEditReturnTbody").html('<tr><td class="text-center text-danger" colspan="7"><b>Already Returned</b></td></tr>');
      }
    });
}

document.querySelector('#ReturnSearchQueryBtn').addEventListener('click',orderReturnSearch);

// print invoice 

function print_invoice(id) {
    window.open('/generate/invoice/' + id, "_blank", "scrollbars=1,resizable=1,height=500,width=500");
}