// import {books} from "./data.js"

var bookEl = document.getElementsByClassName("list-book")[0]
var total = document.getElementById("total")
let totalCash = 0

function showCart(){
    for(let i=0; i<books.length; i++){
        var num = sessionStorage.getItem(`${i}`)
        if(num){
            var book = document.createElement("div")
            book.classList.add("book")
            book.innerHTML =`<img src="./assets/Berserk_vol01.jpg" alt="">
            <p class="title">${books[i].title}</p>
            <p class="price">${books[i].price}$</p>
            <p class="quantity">Số lượng: ${num}</p>`

            var addSub = document.createElement("div")
            addSub.classList.add("add-sub")
            var plusBtn = document.createElement("button")
            plusBtn.innerText = "+"
            plusBtn.addEventListener("click",()=>add(i),false)
            var subBtn = document.createElement("button")
            subBtn.innerText = "-"
            subBtn.addEventListener("click",()=>sub(i),false)

            addSub.appendChild(plusBtn)
            addSub.appendChild(subBtn)
            book.appendChild(addSub)
            // <div class="add-plus">
            //     <button>+</button>
            //     <button>-</button>
            // </div>
            var delBtn = document.createElement("button")
            delBtn.classList.add("del-btn")
            delBtn.innerText = "Xóa"
            delBtn.addEventListener("click",()=>deleteBook(i),false)
            // <button class="del-btn"> Xóa </button>
            book.appendChild(delBtn)
            bookEl.appendChild(book)
            totalCash += num*books[i].price
        }
    }
    total.innerText = "Tổng cộng: "+ totalCash +"$"
}

function deleteBook(value){
    sessionStorage.removeItem(`${value}`)
    location.reload()
}

function add(value){
    var num = sessionStorage.getItem(`${value}`)
    num = parseInt(num)+1
    sessionStorage.setItem(`${value}`,num)
    var numProduct = document.getElementsByClassName("quantity")[value]
    numProduct.innerText = "Số lượng: " + num
    totalCash += books[value].price
    total.innerText = "Tổng cộng: "+ totalCash +"$"
}

function sub(value){
    var num = sessionStorage.getItem(`${value}`)
    if(num==1) return
    num = parseInt(num)-1
    sessionStorage.setItem(`${value}`,num)
    var numProduct = document.getElementsByClassName("quantity")[value]
    numProduct.innerText = "Số lượng: " + num
    totalCash -= books[value].price
    total.innerText = "Tổng cộng: "+ totalCash +"$"
}

// showCart()
