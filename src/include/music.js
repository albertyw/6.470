function musicMakeFavorite(username, musicid, divid){
	if(username!='' && username!=null && musicid!='' && musicid!=null){
		$.post(
			"http://albertyw.mit.edu/6470/process/musicmakefavorite.php",
			{
				username:username,
				musicid:musicid
			},
			function(txt){
				if(txt=='accept'){
					$('#'+divid).text("This music has been added to your favorites list");
				}
			}
		)
	}
}
