function loadResults() {
$("#results").load("./php/search_results.php");
};

$(document).ready(function(){
	//define JSON ??? 	
	let jsonPostval = '{"postVal":[]}';
		
	//add row to postcode Values
	$(".add-row").on("click", function () {
		debugger;

		var postStartvar = $("#postStart").val();
		var postEndvar = $("#postEnd").val();
		var Ratingvar = $("#Rating").val();

		if ($("#postStart").val() == "")
		{
			alert('Please Enter postStart.');
			return false;
		}

		else if ($("#postEnd").val()=="")
		{
			alert('Please Enter postEnd.');
			return false;
		}
		else if ($("#Rating").val() =="")
		{
			alert('Please Enter Rating');
			return false;
		}

		//parse
		let obj = JSON.parse(jsonPostval);
		//push
		obj['postVal'].push({"postID":postStartvar+""+postEndvar,"postStart":postStartvar,"postEnd":postEndvar,"Rating":Ratingvar});
		//stringify
		jsonPostval = JSON.stringify(obj);
		//print result
		let text = "";
		for (let i in obj.postVal) {
			text += "<tr><td><button class='delete-row' value='"+obj.postVal[i].postID+"'>x</button></td><td>"+ obj.postVal[i].postStart + "</td><td>" + obj.postVal[i].postEnd + "</td><td>" + obj.postVal[i].Rating+"</td></tr>";
			}
		document.getElementById("JSONtest").innerHTML = text;
		
		$(".delete-row").on("click", function (){
		debugger;
			let postIDvar = $(this).attr('value');
			let obj = JSON.parse(jsonPostval);
			let index = obj['postVal'].findIndex(function(item, i){
				return item.postID === postIDvar
				});
			obj['postVal'].splice(index,1);
			
			jsonPostval = JSON.stringify(obj);
			let text = "";
			for (let i in obj.postVal) {
				text += "<tr><td><button class='delete-row' value='"+obj.postVal[i].postID+"'>x</button></td><td>"+ obj.postVal[i].postStart + "</td><td>" + obj.postVal[i].postEnd + "</td><td>" + obj.postVal[i].Rating+"</td></tr>";
			}
			document.getElementById("JSONtest").innerHTML = text;
	
		});
		
	});
	



});