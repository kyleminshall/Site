$(".like").click(function(e) {
    if ($(this).innerHTML() == "Like") {
        $(this).innerHTML("Unlike");
    }
    else {
        $(this).innerHTML("Like");
    }
    return false;
});​