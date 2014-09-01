function changeText(idElement) {
    var element = document.getElementById(idElement);
    if (element.innerHTML === 'Like')
	{
    	element.innerHTML = 'Unlike';
    } 
    else 
	{
        element.innerHTML = 'Like';
    }
}