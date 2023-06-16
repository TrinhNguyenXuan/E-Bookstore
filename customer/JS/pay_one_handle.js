var num = 1;

function payment(login) {
  if (login == 0) {
    alert("Vui lòng đăng nhập để mua hàng");
    window.location.href = "./login.php";
  } else {
    var total = $("#total").text();
    if (total == "0") {
      alert("Giỏ hàng trống");
      return;
    }
    var confirm = window.confirm("Hãy xác nhận thanh toán");
    if (confirm) {
      window.location.replace("./pay_success.php");
    }
  }
}

function delBook() {
  window.location.href = "http://localhost/customer/pay_one_book.php";
}

function add(price) {
  num += 1;
  $("#quantity").text(num);
  var total = price * num;
  $("#total").text(total);
}

function sub(price) {
  if (num == 1) return;
  num -= 1;
  $("#quantity").text(num);
  var total = price * num;
  $("#total").text(total);
}
