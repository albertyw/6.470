$(document).ready(function() {
		//default contents
		var startid=1;
		var numberList=10;
		CollegeList(startid, numberList);
	}
)
function CollegeList(startid, numberList){
	var contents='<input type="submit" onclick="javascript:CollegeList('+startid+',10)" value="Show 10">';
	contents +='<input type="submit" onclick="javascript:CollegeList('+startid+',20)" value="Show 20">';
	contents +='<input type="submit" onclick="javascript:CollegeList('+startid+',50)" value="Show 50">';
	contents +='<br />';
	var previousid = startid-numberList;
	if(previousid<1)
		previousid=1;
	contents +='<input type="submit" onclick="javascript:CollegeList('+previousid+','+numberList+')" value="Previous">';
	var nextid=startid+numberList;
	contents +='<div id="listcollege"></div>';
	contents +='<input type="submit" onclick="javascript:CollegeList('+nextid+','+numberList+')" value="Next">';
	$("#viewcollege").html(contents);
	//Send AJAX Request
	$.post(
		"http://albertyw.mit.edu/6470/process/collegelist.php",
		{
			startid:startid,
			numberList:numberList
		},
		function(txt){
			$("#listcollege").html(txt);
		}
	)
}
