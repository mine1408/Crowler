/**
 * Created by Thomas on 01/12/2016.
 */
$(document).ready(function(){
    $('input[name=submit]').click(function(){
    	resetProgressBar();
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

    $('input[name=keywords]').keyup(function(e){
				if(e.which == 13){
					$('input[name=submit]').click();
				}
		});
});

var sites = [];
var progressBarWidth = 0;

addToProgressBar(0);

var showResult = function(){
	$('#casperSuccess').text('Parsing finished');
	// console.log(sites);
	addToProgressBar(100);
	var sitesFiltered = filterData(sites)
	console.log(sitesFiltered);
	sitesFiltered = findValuableKeywordsInDataset(sitesFiltered);

	//Create bar chart
	computeMorrisBarObjectFromValuableKeywords(sitesFiltered);

	// computeAverageDataTable(sitesFiltered);

	// computeWebSiteDataTable(0, sites[0]);
	// computeWebSiteDataTable(1, sites[1]);
	// computeWebSiteDataTable(3, sites[2]);
	// computeWebSiteDataTable(23, sites[23]);
	// computeWebSiteDataTable(24, sites[24]);
	// computeWebSiteDataTable(25, sites[25]);
	// computeWebSiteDataTable(47, sites[47]);
	// computeWebSiteDataTable(48, sites[48]);
	// computeWebSiteDataTable(49, sites[49]);

	console.log(sitesFiltered);
	$.ajax({
		url : 'includes/saveSearch.php',
		method : 'POST',
		data : {sites : sitesFiltered,
			input : $('input[name=keywords]').val()},
		success : function(data) {
			$('#casperInfo').fadeIn();
			$('#casperInfo').text('Search saved into ' + data.file);
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

var tags = ['h1','h2','h3','strong','title','meta[name=description]','meta[name=keywords]'];
var tagsArray = [];
for (var i = 0; i < tags.length; i++) {
	tagsArray.push({
		balise : tags[i],
		count : 0
	});
}

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

						for(var i = 0;i < tags.length;i++){
							tempBalise = {
								balise: tags[i],
								words : []
							};
							tempWords = $(tags[i],$page);
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
					error : function(){
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
	// console.log(strings);
	for (var j = 0; j < strings.length; j++) {
		var stringToParse = (strings[j] || "").trim().toLowerCase();

		if(stringToParse == ""){
			strings.splice(j,1);
			continue;
		}

    for (var i = stopWords.length - 1; i >= 0; i--) {
			if(stringToParse == stopWords[i].toLowerCase()){
				strings.splice(j,1);
				break;
			}
    }
	}
	// console.log(strings);
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
		word = word.trim().toLowerCase();
    var incremented = false;
    for (var i = 0; i < array.length; i++) {
        var wordSaved = array[i];
        if(wordSaved.word === word) {
            wordSaved.count++;
            incremented = true;
						break;
        }
    }
    if(!incremented)
        array.push({
            word : word,
            count : 1
        })
}

function addToProgressBar(value){
	progressBarWidth = progressBarWidth + value;
	var newVal = progressBarWidth <= 100 ? progressBarWidth : 100;
	$('#progressBar').css('width',newVal + '%');
}

function resetProgressBar(){
	$('#progressBar').css('width','0');
}

function filterData(data){
	var result = [];

	result = _.reduce(data,function(res, site){ //each sites
		var balises = (site.balises || []);

		for(var i = 0; i < balises.length; i++){ // each balises
			var tag = balises[i].balise;

			for (var j = 0; j < balises[i].words.length; j++) {
				var word = balises[i].words[j];
				res = addToKeywords(res,word,tag);
			}
		}

		return res;
	},[]);

	// console.log(result);
	return result;
}

function addToKeywords(array,elem,tag){
	var done = false;
	for (var i = 0; i < array.length; i++) {
		var word = array[i];
		if(word.keyword == elem.word){
			for (var j = 0; j < word.balises.length; j++) {
				var tagObj = word.balises[j];
				if(tagObj.balise == tag){
					done = true;
					tagObj.count += elem.count;
				}
			}
			if(!done){
				done = true;
				word.balises.push({
					balise : tag,
					count : elem.count
				})
			}
			break;
		}
	}

	if(!done){
		array.push({
			keyword : elem.word,
			balises : tagsArray
		});
		array = addToKeywords(array,elem,tag);
	}
	return array;
}

function findValuableKeywordsInDataset(dataset){
	var countByKeywords = [];
	var maxValue = 0;
	//pour les keywords dan le dataset
	for(var k1 = 0; k1 < dataset.length; k1++){
		if(dataset[k1].keyword != ""){
			var totalOccurrences = 0;
			//pour les balises d'un keyword
			for(var b = 0; b < dataset[k1].balises.length; b++){
				totalOccurrences = totalOccurrences + dataset[k1].balises[b].count;
			}
			if(totalOccurrences > maxValue)
				maxValue = totalOccurrences;
			countByKeywords.push({index: k1, occurrences: totalOccurrences});
		}
	}

	var valuableKeywordsTotalOccurences = _.sortBy(countByKeywords, function(value){
		return value.occurrences;
	});

	valuableKeywordsTotalOccurences.reverse();

	valuableKeywordsTotalOccurences = valuableKeywordsTotalOccurences.slice(0,5);

	var valuablesKeywords = [];

	for(var k2 =0; k2 < dataset.length; k2++){
		for(var vk = 0; vk < valuableKeywordsTotalOccurences.length; vk++){
			if(k2 == valuableKeywordsTotalOccurences[vk].index){
				valuablesKeywords.push(dataset[k2]);
				break;
			}
		}
	}

	return valuablesKeywords;
}


function computeMorrisBarObjectFromValuableKeywords(valuableKeywords){

	console.log("Morris generation launched");


	var data = [];
	var ykeys = [];
	var labels = [];

	for(var b = 0; b < tags.length; b++){
		var dataToAdd = {};
		dataToAdd.y = tags[b];
		for(var k = 0; k < valuableKeywords.length; k++){
			for(var kwb = 0; kwb < valuableKeywords[k].balises.length; kwb++){
				if(valuableKeywords[k].balises[kwb].balise == tags[b]){
                    dataToAdd[k] = valuableKeywords[k].balises[kwb].count;
					if(ykeys.indexOf(k) == -1){
						ykeys.push(k);
					}
					if(labels.indexOf(valuableKeywords[k].keyword) != -1){
						labels.push(valuableKeywords[k].keyword);
					}
					break;
				}
			}
		}
		data.push(dataToAdd);
	}

	console.log(data);
	console.log(ykeys);
	console.log(labels);

	Morris.Bar({
		element:"bar",
		barColors:["rgba(0,201,182, 0.8)","rgba(0,227,205, 0.8)","rgba(0,176,159, 0.8)","rgba(0,150,136, 0.8)","rgba(0,125,113, 0.8)","rgba(0,74,67, 0.8)","rgba(0,99,90, 0.8)"],
		data: data,
		xkey: 'y',
		ykeys: ykeys,
		labels: labels
	});
}
/*
function computeWebSiteDataTable(index, website){

	console.log(website);

	var data = [];

	var allWords = [];
	for(var b=0; b < website.balises.length; b++){
		for(var w=0; website.balises[b].words.length; w++){
			console.log((website.balises[b].words[w]));
			if(website.balises[b].words[w] && allWords.indexOf(website.balises[b].words[w].word) == -1){
				allWords.push(website.balises[b].words[w].word);
			}
		}
	}
console.log(allWords);
	for(var aw= 0; aw < allWords.length; aw++){
		var tempData = [];
		tempData.push(allWords[aw]);
		for(var b1=0; b1 < website.balises.length; b1++){
			for(var w1=0; website.balises[b1].words.length; w1++){
				if(website.balises[b1].words[w1].word.indexOf(allWords[aw]) == -1){
					tempData.push(0);
				}
				if(allWords[aw] == website.balises[b1].words[w1].word){
					tempData.push(website.balises[b1].words[w1].count);
				}
			}
		}
		data.push(tempData);
	}

	console.log(data);

$("#website"+ index).text((index+1) + " : <a href=\"" + website.url + "\">"+ website.url +"</a>");

	$('#websitekeywords' + index).DataTable({
		data: data,
		columns: [
			{ title: "Keywords" },
			{ title: tags[0] },
			{ title: tags[1] },
			{ title: tags[2] },
			{ title: tags[3] },
			{ title: tags[4] },
			{ title: tags[5] },
			{ title: tags[6] }
		],
		paging: true,
		searching: false,
		lengthMenu: [3, 5, 10, 15],
		pageLength: 3,
		autoWidth: false
	});
}

function computeAverageDataTable(valuableKeywords) {

	var data = [];

	for(var vk = 0; vk < valuableKeywords.length; vk++){
		var tempData = [];
		tempData.push(valuableKeywords[vk].keyword);
		for(var b = 0; b < valuableKeywords[vk].balises.length; b++){
			tempData.push(valuableKeywords[vk].balises[b].count);
		}
		data.push(tempData);
	}

	console.log(data);

	$('#average').DataTable({
		data: data,
		columns: [
			{ title: "Keywords" },
			{ title: tags[0] },
			{ title: tags[1] },
			{ title: tags[2] },
			{ title: tags[3] },
			{ title: tags[4] },
			{ title: tags[5] },
			{ title: tags[6] }
		],
		paging: true,
		searching: false,
		lengthMenu: [3, 5, 10, 15],
		pageLength: 3,
		autoWidth: false
	});
}
	*/