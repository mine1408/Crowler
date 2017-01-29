exports.module = {
	data : [ //array of site
		{
			url : "foot.tv",
			balises : [ //array of balises by sites
				{
					balise : "h1",
					words : [ //array of words
						{
							word : "foot",
							count : 15
						},
						{
							word : "football",
							count : 10
						}
					]
				},
				{
					balise : "title",
					words : [
						{
							word : "foot",
							count : 1
						}
					]
				}
			] //end of balises
		}
	] //array of site
};


//second structure
var test = {
	h1 : {
		balise  :"h1",
		keywords : [
			{
				word : "test",
				count : 1
			}
		]
	},
	h2 : {
		//...
	}
};