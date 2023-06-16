function buyNow(value){
    window.location.href = "./pay_one_book.php?bookId=" +value
}

function addBook(value){
    $.ajax(
        {
            url: 'http://localhost/customer/ajax/addBook.php',
            method: 'POST',
            data: {
                bookId: value
            },
            success: function(response){
                if(response == "no login")
                {
                    alert('Vui lòng đăng nhập để mua hàng')
                    window.location.href = './login.php'
                }
                else{
                    if(response == 'new-book'){
                        var num_item = parseInt($('#item-cart').text())
                        num_item+=1;
                        $('#item-cart').text(num_item);
                    }
                    notify()
                }
            },
            error: function (e){
                console.log(e.message);
                throw e
            }
        }
    )
}

function notify(){
    var noti = document.getElementsByClassName("alert")[0]
    noti.style.display = "block"
    noti.style.position = "fixed"
    setTimeout(()=>{
        noti.style.display = "none"
    },3000)
}