$(document).ready(function(){
    $('textarea').autosize();    
});

$(document).delegate('#textbox', 'keydown', function(e) {
  var keyCode = e.keyCode || e.which;

  if (keyCode == 9) {
    e.preventDefault();
    var start = $(this).get(0).selectionStart;
    var end = $(this).get(0).selectionEnd;

    // set textarea value to: text before caret + tab + text after caret
    $(this).val($(this).val().substring(0, start)
                + "\t"
                + $(this).val().substring(end));

    // put caret at right position again
    $(this).get(0).selectionStart =
    $(this).get(0).selectionEnd = start + 1;
  }
});

$(".add").click(function(){
    $(".add_students").toggle();
});

$(".close").click(function() {
	$(".add_students").hide();
});

$("#enroll").submit(function() {
	
	if($("#Email").val() == '')
		$("#result").html("Please enter an email!");
	else {
		var url = location.origin+'/ajax/enroll';
	
		$("#loading").show();
		$("#submit").hide();
		$("#result").html("");
	
		$.ajax({
			type: "POST",
			url: url,
			dataType: 'json',
			data: $("#enroll").serialize(),
			success: function(response)
			{
				$("#loading").hide();
				$("#submit").show();
				var json = JSON.stringify(response);
				json = JSON.parse(json);
				if(json.status == 200) {
					$("#result").html(""+json.message);
					$("#Email").val('');
				}
				else if(json.status != 200) {
					$("#result").html(""+json.message);
				}
			}
		});
	}
	return false;
})

$(".student").click(function() {
	$(".student_progress").toggle();
	$("#loading2").show();
	
	var url = location.origin+'/ajax/progress';
	
	$.ajax({
		type: "GET",
		url: url,
		dataType: 'json',
		data: { id : this.id },
		success: function(response)
		{
			$("#loading2").hide();
			if(response.length == 0)
				$(".placeholder").after("<p class='completed'> User has not completed any problems. </p>");
			else {
				for(var k in response) {
					$(".placeholder").after("<p class='completed'>"+response[k].title+"</p>");
				}
			}
		}
	})
})

$("#close2").click(function() {
	$( ".completed" ).remove();
	$(".student_progress").hide();
})