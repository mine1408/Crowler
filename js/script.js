/**
 * Created by Thomas on 01/12/2016.
 */
$(document).ready(function(){
    $('input[name=submit]').click(function(){
        $.ajax(
            'includes/ajax/crawler.php',
            {
            method:'POST',
            data : {
                input : $('input[name=keywords]').val()
						},
							beforeSend : function(){
								addToProgressBar(3);
								$('#casperSuccess').fadeIn();
								$('#casperSuccess').text("Script casper launched");
							},
							error: function(){
								console.error("error");
							},
							success: function(){
								addToProgressBar(7);
								getUrls(showResult);
								$('#casperSuccess').text("Script casper finished");
							}
						})
    });
});

var sites = [];
var progressBarWidth = 0;

addToProgressBar(0);

var showResult = function(){
	$('#casperSuccess').text('Parsing finished');
	console.log(sites);
	addToProgressBar(100);
	$.ajax({
		url : 'includes/saveSearch.php',
		method : 'POST',
		data : {sites : sites,
			input : $('input[name=keywords]').val()},
		success : function(data) {
			$('#casperInfo').fadeIn();
			$('#casperInfo').text('Search saved into ' + data.files);
		}
	})
};

var getUrls = function(callback){
    $.get(
        'includes/ajax/result.json',
        function(urls){
        	$('#casperSuccess').text('Running on websites collected...');
            for (var i = 0; i < urls.links.length; i++) {
                var url = urls.links[i];
                crawlSite(i,url, function (site) {
                	sites.push(site);
									console.log(sites.length,urls.links.length);
									addToProgressBar(1);
                	if (sites.length == urls.links.length) {
                		addToProgressBar(90 - progressBarWidth);
                		callback();
									}
								});
            }

        }
    )
};


var crawlSite = function(index,site, callback){
    var tempSite = {}, tempBalise = {}, tempWords = {};

    if(!site.includes("http://www.google.com") && !site.includes("http://www.google.fr") ) site = "http://www.google.com" + site;
		$.ajax({
			method : "POST",
			url  :'includes/ajax/dlPage.php',
			data : {
				url : site,
				index : index
			} ,
			success :function(wrote) {
				addToProgressBar(1);
				var file = wrote.file;
				var url = wrote.url;
				tempSite = {
					url : url,
					balises : []
				};

				$.ajax({
					url : 'includes/tempFiles/' + file,
					method: 'GET',
					success : function(data){
						var $page = $(data);
						var balise = ['h1','h2','h3','strong','title','meta[name=description]','meta[name=keywords]'];
						for(var i = 0;i<balise.length;i++){
							tempBalise = {
								balise: balise[i],
								words : []
							};
							tempWords = $(balise[i],$page);
							if(tempWords || tempWords.length > 0){
								for (var j = 0; j < tempWords.length; j++) {
									var words = deleteStopWords((tempWords[j].innerText || tempWords[j].textContent).split(" "));

									for (var k = 0; k < words.length; k++) {
										var word = words[k];
										addWords(tempBalise.words,word);
									}
								}
							}
							tempSite.balises.push(tempBalise);
						}
						callback(tempSite);
					},
					complete : function(){
						callback(tempSite);
					}
				});
			},
			error : function(){
				callback({});
			}
		});
};



//function
function deleteStopWords(strings){
	for (var j = 0; j < crawlSite.length; j++) {
		var stringToParse = strings[j];
		if((stringToParse || "").trim() == "") continue;

    for (var i = stopWords.length - 1; i >= 0; i--) {
			if(stringToParse.toLowerCase() == stopWords[i].toLowerCase()){
				strings.splice(j,1);
			}
    }
	}
	return strings;
}

function clone(obj) {
    if (null == obj || "object" != typeof obj) return obj;
    var copy = obj.constructor();
    for (var attr in obj) {
        if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
    }
    return copy;
}

function addWords(array,word){
    var incremented = false;
    for (var i = 0; i < array.length; i++) {
        var wordSaved = array[i];
        if(wordSaved.word.toLowerCase() == word.toLowerCase()) {
            wordSaved.count++;
            incremented = true;
        }
        break;
    }
    if(!incremented)
        array.push({
            word : word.toLowerCase(),
            count : 1
        })
};


function addToProgressBar(value){
	progressBarWidth = progressBarWidth + value;
	var newVal = progressBarWidth <= 100 ? progressBarWidth : 100;
	$('#progressBar').css('width',newVal + '%');
}