$(document).ready(function() {
		//default contents
		var startid=1;
		var numberList=10;
		EventList(startid, numberList);
	}
)
function EventList(startid, numberList){
	var contents='<input type="submit" onclick="javascript:EventList('+startid+',10)" value="Show 10">';
	contents +='<input type="submit" onclick="javascript:EventList('+startid+',20)" value="Show 20">';
	contents +='<input type="submit" onclick="javascript:EventList('+startid+',50)" value="Show 50">';
	contents +='<br />';
	var previousid = startid-numberList;
	if(previousid<1)
		previousid=1;
	contents +='<input type="submit" onclick="javascript:EventList('+previousid+','+numberList+')" value="Previous">';
	var nextid=startid+numberList;
	contents +='<div id="listevent"></div>';
	contents +='<input type="submit" onclick="javascript:EventList('+nextid+','+numberList+')" value="Next">';
	$("#viewevent").html(contents);
	showEventList(startid,numberList);
}
function showEventList(startid, numberList){
	//Send AJAX Request
	$.post(
		"http://albertyw.mit.edu/6470/process/eventlist.php",
		{
			startid:startid,
			numberList:numberList
		},
		function(txt){
			$("#listevent").html(txt);
		}
	)

}
