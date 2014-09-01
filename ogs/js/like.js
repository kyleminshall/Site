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
    if (element.innerHTML != 'Unlike')
	{
    	element.innerHTML = 'Unlike';
    } 
    else 
	{
        element.innerHTML = 'Like';
    }
}

function initialize(idElement, wch)
{
	document.getElementById('like_'+idElement).innerHTML=(wch?'Like':'Unlike');
}