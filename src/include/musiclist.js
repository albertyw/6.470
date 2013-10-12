$(document).ready(function() {
		//default contents
		var startid=1;
		var numberList=10;
		MusicList(startid, numberList);
	}
)
function MusicList(startid, numberList){
	var contents='<input type="submit" onclick="javascript:MusicList('+startid+',10)" value="Show 10">';
	contents +='<input type="submit" onclick="javascript:MusicList('+startid+',20)" value="Show 20">';
	contents +='<input type="submit" onclick="javascript:MusicList('+startid+',50)" value="Show 50">';
	contents +='<br />';
	var previousid = startid-numberList;
	if(previousid<1)
		previousid=1;
	contents +='<input type="submit" onclick="javascript:MusicList('+previousid+','+numberList+')" value="Previous">';
	var nextid=startid+numberList;
	contents +='<div id="listmusic"></div>';
	contents +='<input type="submit" onclick="javascript:MusicList('+nextid+','+numberList+')" value="Next">';
	$("#viewmusic").html(contents);
	showMusicList(startid,numberList);
}
function showMusicList(startid, numberList){
	//Send AJAX Request
	$.post(
		"http://albertyw.mit.edu/6470/process/musiclist.php",
		{
			startid:startid,
			numberList:numberList
		},
		function(txt){
			$("#listmusic").html(txt);
		}
	)

}
