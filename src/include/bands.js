function bandMakeFavorite(username, bandid, divid){
	if(username!='' && username!=null && bandid!='' && bandid!=null){
		$.post(
			"http://albertyw.mit.edu/6470/process/bandmakefavorite.php",
			{
				username:username,
				bandid:bandid
			},
			function(txt){
				if(txt=='accept'){
					$('#'+divid).text("This band has been added to your favorites list");
				}
			}
		)
	}
}

