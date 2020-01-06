let changeUrl = (value) =>
{
	window.history.replaceState(null,"Weather",weatherUrl+`?search_for=${value}`);
}

let loading = (type) => 
{
	let button = $("#submitButton");
	let loading = $("#loading");
	if(type === "start"){
		button.val("searching...");
		button.attr("disabled","true");
		button.css("cursor","progress");
		loading.show();
	}else{
		button.val("search");
		button.removeAttr("disabled");
		button.css("cursor","pointer");
		loading.hide();
	}
}

let validateForm = (searchField) =>
{
	if(searchField.val().trim().length < 1){
		searchField.addClass("error");
		searchField.attr("placeholder","city name can not be empty");
		return "fail";
	}else{
		searchField.removeClass("error");
		searchField.attr("placeholder","type city name...");
	}
}

$(document).ready(function(){

	$("#searchForm").submit(function(e){
		event.preventDefault();
		let searchField = $("#searchField");
		let status = validateForm(searchField);
		if(status === "fail"){
			return false;
		}

		let formData = $(this).serialize();
		loading("start");

		$.ajax({
			method: "GET",
			url: weatherUrl,
			data:formData

		}).done(function(response){
			changeUrl(searchField.val());

			$("#data").remove();
			let formDiv = $("#formDiv");
			formDiv.after("<div id='data'></div>");
			let dataDiv = $("#data");
			loading("end");
			if(!$.isEmptyObject(response.cityName)){
				dataDiv.append(`<h2> ${response.mainCondition}</h2>`)
				dataDiv.append(`<div id='details'>It is ${response.description}  in  ${response.cityName} , ${response.country}  with <span id='degree'> ${response.degree} </span>c &deg;</div>`)
				dataDiv.append(`<div id='icon'><img id='icon-image' alt='Weather icon' src='http://openweathermap.org/img/wn/${response.icon}@2x.png'></div>`)
			}else{
				dataDiv.append("<h2>No City Found!</h2>")
			}
		}).fail(function(response){
			loading("end");
			changeUrl(searchField.val());
			alert("SomeThing went wrong please try again");
		});
	});


});