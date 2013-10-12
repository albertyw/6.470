$(document).ready(function() {
		//default contents
		var startid=1;
		var numberList=10;
		BandList(startid, numberList);
	}
)
function BandList(startid, numberList){
	var contents='<input type="submit" onclick="javascript:BandList('+startid+',10)" value="Show 10">';
	contents +='<input type="submit" onclick="javascript:BandList('+startid+',20)" value="Show 20">';
	contents +='<input type="submit" onclick="javascript:BandList('+startid+',50)" value="Show 50">';
	contents +='<br />';
	var previousid = startid-numberList;
	if(previousid<1)
		previousid=1;
	contents +='<input type="submit" onclick="javascript:BandList('+previousid+','+numberList+')" value="Previous">';
	var nextid=startid+numberList;
	contents +='<div id="listbands"></div>';
	contents +='<input type="submit" onclick="javascript:BandList('+nextid+','+numberList+')" value="Next">';
	$("#viewbands").html(contents);
	showBandList(startid,numberList);
}
function showBandList(startid, numberList){
	//Send AJAX Request
	$.post(
		"http://albertyw.mit.edu/6470/process/bandlist.php",
		{
			startid:startid,
			numberList:numberList
		},
		function(txt){
			$("#listbands").html(txt);
		}
	)

}
