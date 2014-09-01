function like_add(post_id){
	$.post('classes/like_add.php', {post_id:post_id}, function(data) {
		like_get(post_id);
	}).done(function() {
		changeText(post_id);
	});
}

function like_get(post_id) {
	$.post('classes/like_get.php', {post_id:post_id}, function(data) {
		$('#post_'+post_id+'_likes').text(data);
	});
}

function changeText(idElement) {
    var element = document.getElementById('like_'+idElement);
	document.writeln(divid)
    if (element.innerHTML === 'Like')
	{
    	element.innerHTML = 'Unlike';
    } 
    else 
	{
        element.innerHTML = 'Like';
    }
}