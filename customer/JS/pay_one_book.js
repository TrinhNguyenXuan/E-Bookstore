import {books} from "./data.js"

var bookEl = document.getElementsByClassName("list-book")[0]
var total = document.getElementById("total")
let totalCash = 0
var num = 1

function showCart(){
    var i = localStorage.getItem("product")
    var book = document.createElement("div")
    book.classList.add("book")
    if(i){
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
        var delBtn = document.createElement("button")
        delBtn.classList.add("del-btn")
        delBtn.innerText = "Xóa"
        delBtn.addEventListener("click",deleteBook)
        // <button class="del-btn"> Xóa </button>
        book.appendChild(delBtn)
        totalCash += num*books[i].price

    }
    bookEl.appendChild(book)
    total.innerText = "Tổng cộng: "+ totalCash +"$"
}

function deleteBook(){
    localStorage.removeItem("product")
    location.reload()
}

function add(value){
    num +=1
    localStorage.setItem("product",num)
    var numProduct = document.getElementsByClassName("quantity")[0]
    numProduct.innerText = "Số lượng: " + num
    totalCash += books[value].price
    total.innerText = "Tổng cộng: "+ totalCash +"$"
}

function sub(value){
    if(num == 1) return
    num-=1
    localStorage.setItem("product",num)
    var numProduct = document.getElementsByClassName("quantity")[0]
    numProduct.innerText = "Số lượng: " + num
    totalCash -= books[value].price
    total.innerText = "Tổng cộng: "+ totalCash +"$"
}


showCart()
