function like_add(post_id){
	$.post('classes/like_add.php', {post_id:post_id}, function(data) {
		if(data == "success") {
			like_get(post_id);
		} else {
			alert(data);
		}
	});
}

function like_get(post_id) {
	$.post('classes/like_get.php', {post_id:post_id}, function(data) {
		$('#post_'+post_id+'_likes').text(data);
	});
}

function like_update(post_id)
{
	$('.like_'+post_id).click(function(e) {
	    if ($(this).html() == 'Like') {
	        $(this).html('Unlike');
	    }
	    else {
	        $(this).html('Like');
	    }
	    return false;
	});
}