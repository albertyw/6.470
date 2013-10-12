function findValue(li) {
	if( li == null ) return alert("No match!");
	// if coming from an AJAX call, let\'s use the CityId as the value
	if( !!li.extra ) var sValue = li.extra[0];
	// otherwise, let\'s just display the value in the text box
	else var sValue = li.selectValue;
	//alert("The value you selected was: " + sValue);
}
function selectItem(li) {
	findValue(li);
}
function formatItem(row) {
	return row[0];
}
function lookupAjax(){
	var oSuggest = $("#collegename")[0].autocompleter;
	oSuggest.findValue();
	return false;
}

$(document).ready(function() {
	$("#collegename").autocomplete(
		"http://albertyw.mit.edu/6470/process/autocomplete_college.php",
		{
			delay:10,
			minChars:2,
			matchSubset:0,
			matchContains:0,
			cacheLength:1,
			onItemSelect:selectItem,
			onFindValue:findValue,
			formatItem:formatItem,
			autoFill:true,
			maxItemsToShow:5
		}
	)
})
