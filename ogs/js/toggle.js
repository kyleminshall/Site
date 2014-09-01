function changeText(idElement) {
    var element = document.getElementById('like_'+idElement);
    if (element.innerHTML === 'Like')
	{
    	element.innerHTML = 'Unlike';
    } 
    else 
	{
        element.innerHTML = 'Like';
    }
}