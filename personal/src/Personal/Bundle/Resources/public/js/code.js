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
	$(".line").after("<button title=\"Delete\" id=\"delete_"+this.id+"\" name=\"delete\" class=\"delete\">Delete Student</button>");
	
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
					var t = (response[k].finished).split(/[- :]/);
					var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
					var day = d.getMonth() + '/' + d.getDate() + '/' + d.getYear();
					var curr_hour = d.getHours();
					if (curr_hour < 12)
					   a_p = "AM";
					else
					   a_p = "PM";
					if (curr_hour == 0)
					   curr_hour = 12;
					if (curr_hour > 12)
					   curr_hour = curr_hour - 12;
					var time = curr_hour + ':' + d.getMinutes();
					$(".placeholder").after("<p class='completed'><span class='title'>"+response[k].title+"</span><br><span class='finished' style=\"font-size:12px;color:#303030\"> Finished on: "+day+" at "+time+"</p>");
				}
			}
		}
	})
})

$("#close2").click(function() {
	$( ".completed" ).remove();
	$( ".delete" ).remove();
	$(".student_progress").hide();
})

$("body").on('click','.delete', function() {
	if(confirm("Are you sure you want to delete this student?\n\nThis will remove all traces of them from the website including all progress and account details.")) 
	{
		$("#loading2").show();
		$(".delete").hide();
		var id = (this.id).substring(7);
		var url = location.origin+'/ajax/delete'
		$.ajax({
			type: "DELETE",
			url: url,
			dataType: 'json',
			data: { id : id},
			success: function(response)
			{
				console.log(response);
				$("#loading2").hide();
				$(".delete").show();
				var json = JSON.stringify(response);
				json = JSON.parse(json);
				if(json.status == 200) {
					$("#"+id).remove();
					$("#result2").html(""+json.message);
				}
				else if(json.status != 200) {
					$("#result2").html(""+json.message);
				}
			}
		})
	}
})

$("#add_problem").click(function(){
    $(".add_problem").toggle();
});

$("#close3").click(function() {
	$(".add_problem").hide();
});

$("#problem").submit(function() {
	
	if($("#Title").val() == '')
		$("#result3").html("Please enter a title.");
	else if($("#Prompt").val() == '')
		$("#result3").html("Please enter a prompt.");
	else if($("#Method").val() == '')
		$("#result3").html("Please enter the method.");
	else if($("#Test").val() == '')
		$("#result3").html("Please enter at least one test.");
	else if($("#Output").val() == '')
		$("#result3").html("Please enter expected output.");
	else {
	
		$("#loading3").show();
		$("#submit3").hide();
	
		var url = location.origin+'/ajax/problem';
	
		$.ajax({
			type: "POST",
			url: url,
			dataType: 'json',
			data: $("#problem").serialize(),
			success: function(response)
			{
				$("#loading3").hide();
				$("#submit3").show();
				var json = JSON.stringify(response);
				json = JSON.parse(json);
				if(json.status == 200) {
					$("#result3").html(""+json.message);
					$("#Title").val('');
					$("#Prompt").val('');
					$("#Method").val('');
					$("#Test").val('');
					$("#Output").val('');
				}
				else if(json.status != 200) {
					$("#result3").html(""+json.message);
				}
			}
		})
	}
	return false;
});

$("#close3").click(function() {
	$(".add_problem").hide();
});