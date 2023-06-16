function payment(){
    var total = $('#total').text();
    if(total == '0') alert('Giỏ hàng trống.')
    else{
        if(confirm('Xác nhận thanh toán')){
            $.ajax({
                url: 'http://localhost/customer/ajax/payment.php',
                method: 'POST',
                success: function(response){
                    window.location.href = "./pay_success.php"
                },
                error: function(e){
                    console.log(e.message)
                    throw e
                }
            })
        }
    }
}

function add(id){
    $.ajax({
        url: 'http://localhost/customer/ajax/changeNumBook.php?method=add',
        method: 'POST',
        dataType: "json",
        data: {
            bookId: id
        },
        success: function(response){
            var cssSelector = '#book'+id
            $(cssSelector).text('Số lượng: '+response.quantity)
            
            var total = $('#total').text();
            newTotal = parseInt(total) + parseInt(response.price)
            $('#total').text(newTotal)
        },
        error: function(e){
            console.log(e.message)
            throw e
        }
    })
}

function sub(id){
    $.ajax({
        url: 'http://localhost/customer/ajax/changeNumBook.php?method=sub',
        method: 'POST',
        dataType: "json",
        data: {
            bookId: id
        },
        success: function(response){
            var cssSelector = '#book'+id
            $(cssSelector).text('Số lượng: '+response.quantity)
            
            var total = $('#total').text();
            if(!response.negative) newTotal = parseInt(total) - parseInt(response.price)
            $('#total').text(newTotal)
        },
        error: function(e){
            console.log(e.message)
            throw e
        }
    })
}

function delBook(id){
    $.ajax({
        url: 'http://localhost/customer/ajax/delBook.php',
        method: 'POST',
        data: {
            bookId: id
        },
        success: function(response){
            window.location.reload()
        },
        error: function(e){
            console.log(e.message)
            throw e
        }
    })
}