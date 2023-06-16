function rating(value){
    for(let i=1; i<=5; i++){
        var star = '#rated-star'+i
        if(i<=value){
            if(!$(star).hasClass('checked')) {
                $(star).addClass('checked')
            }
        }
        else
        {
            if($(star).hasClass('checked')) {
                $(star).removeClass('checked')
            }                    
        }
    }
}

function updateComment(data){
    $('.evaluations > div:eq(0)').after(data.element)
    for(let i=1; i<=5; i++){
        var star = '#rated-star'+i
        if($(star).hasClass('checked')) {
            $(star).removeClass('checked')
        }
    }
    $("input:radio").attr("checked", false);
    $('textarea[name="comment"]').val('');
    $(".avg-star").text(data.avgRating);
    $(".avg-star").append('<i class="fa-solid fa-star fa-sm"></i>')

}

