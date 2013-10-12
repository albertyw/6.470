function eventMakeFavorite(username, eventid, divid){
	if(username!='' && username!=null && eventid!='' && eventid!=null){
		$.post(
			"http://albertyw.mit.edu/6470/process/eventmakefavorite.php",
			{
				username:username,
				eventid:eventid
			},
			function(txt){
				if(txt=='accept'){
					$('#'+divid).text("You have RSVPed to this event");
				}
			}
		)
	}
}
