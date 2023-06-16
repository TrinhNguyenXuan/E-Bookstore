function selectPhoto(value){
    var id = "#prod-img"+value;
    $(id).css('border','3px solid grey')

    if(value==1){
        $("#prod-img2, #prod-img3").css('border','none')
    }
    else if(value==2){
        $("#prod-img1, #prod-img3").css('border','none')
    }
    else{
        $("#prod-img1, #prod-img2").css('border','none')
    }

    let src = $(id).attr('src')
    $('#main-pic').attr('src',src)
}


let slideIndex = 0;
$('.prod-img-plus').click(function(){
    $('.bg-slide').css('display', 'flex')
    $('body').css('overflow', 'hidden')
    $('.slide:eq(0)').css('display', 'block')
    $('.left-slide>i').css('color', 'black')
    $('.right-slide').addClass('enable-hover')

})

$('.right-slide:first').click(function(){
    showSlide(1)
})
$('.left-slide:first').click(function(){
    showSlide(-1)
})

function showSlide(value){
    let curSlide = '.slide:eq(' + slideIndex + ')'
    let temp = slideIndex+1
    let nextSlide = '.slide:eq(' + temp + ')'
    temp = slideIndex-1
    let prevSlide = '.slide:eq(' + temp + ')'
    temp = slideIndex+1+value
    let rightEnable = '.slide:eq(' + temp + ')'
    console.log(rightEnable)

    if(value == 1 && $(nextSlide).length){
        $(curSlide).css('display', 'none')
        $(nextSlide).css('display', 'block')
        slideIndex++;
    }
    else if(value == -1 && $(prevSlide).length && slideIndex>0){
        $(curSlide).css('display', 'none')
        $(prevSlide).css('display', 'block')
        slideIndex--;
    }

    if(slideIndex>0 && !$('.left-slide.enable-hover').length){
        $('.left-slide').addClass('enable-hover')
        $('.left-slide>i').css('color', 'white')
    }
    if(slideIndex==0 && $('.left-slide.enable-hover').length){
        $('.left-slide').removeClass('enable-hover')
        $('.left-slide>i').css('color', 'black')
    }

    if($(rightEnable).length && !$('.right-slide.enable-hover').length)
    {
        $('.right-slide').addClass('enable-hover')
        $('.right-slide>i').css('color', 'white')
    }
    if(!$(rightEnable).length && $('.right-slide.enable-hover').length)
    {
        $('.right-slide').removeClass('enable-hover')
        $('.right-slide>i').css('color', 'black')
    }

}

$('.cancel-slide:first').click(function(){
    $('.bg-slide').css('display', 'none')
    $('body').css('overflow', 'scroll')
    let curSlide = '.slide:eq(' + slideIndex + ')'
    $(curSlide).css('display', 'none')
    $('.left-slide>i').css('color', 'black')
    $('.right-slide>i').css('color', 'white')
    if($('.right-slide.enable-hover').length){
        $('.right-slide.enable-hover').removeClass('enable-hover')
    }
    if($('.left-slide.enable-hover').length){
        $('.left-slide.enable-hover').removeClass('enable-hover')
    }
    slideIndex = 0;
})

selectPhoto(1);