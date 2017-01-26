//CODE
var casper = require('casper').create({
    //verbose:true,
	//logLevel:'debug'
});

casper.options.pageSettings.userAgent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)';
//casper.options.pageSettings.userAgent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)';
var conf = require('./conf.json');
var fs = require('fs');

var links = [];

//CMS
var footprintCMS = 'Powered by ';
var footprintComments = {
    'dotclear': '+"Laisser un commentaire"',
    'wordpress': '-"valider votre commentaire"' // Remove captcha securised pages
};

//FUNCTION
/**
 * Format the entire query
 * @param  {Array}  keywords List of keywords
 * @param  {Array}  escapes  List of escaped words
 * @param  {string} cms      The cms you want to target
 * @return {string}          The query with keywords, escaped words and footprint from the cms targetted
 */
 var formatQuery = function(keywords, escapes, cms) {
    var query = '';

    // If we defined a CMS, add some footprints to the query
    if (cms) {
        query += '+"' + footprintCMS + capitalizeFirstLetter(cms) + '"';
        if (footprintComments[cms]) {
            query += ' ' + footprintComments[cms];
        }
    }

    // Adds keywords and escapes the non-wanted words
    query += formatKeywords('+', keywords);
    query += formatKeywords('-', escapes);

    return query;
};

/**
 * Returns the links
 * @return {Array}     A list of links
 */
 var getLinks = function() {
    var links = document.querySelectorAll('h3.r a');
    return Array.prototype.map.call(links, function(e) {
        return e.getAttribute('href');
    });
};

/**
 * Utility : capitalize the first letter of a string
 * @param  {string} string The string to format
 * @return {string}        The capitalized string
 */
 function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function writeResults() {
    //Writing
    var data = {links : casper.links};
    fs.write('result.json', JSON.stringify(data), null);
    this.echo('Writed into result.json');
}

/**
 * Format the search
 * @param  {Array} keywords List of keywords
 * @param  {Array} escapes  List of escaped words
 * @return {string}         The search
 */
 var formatKeywords = function(prefix, keywords) {
    var formatted = '';
    if (Array.isArray(keywords)) {
        keywords.forEach(function(word, key) {
            formatted += ' ' + prefix + '"' + word +'"';
        });
    } else {
        formatted += ' ' + prefix + '"' + keywords +'"';
    }
    return formatted;
};

function parseResults(){


	// casper.capture(links.length + '-google-search.png');
            casper.echo("Screen saved.");


    if (casper.visible(conf.captchaBalise)) {
        casper.echo('Capta here too much request on google');
        casper.capture(conf.captcha);
        return;
    }   

    casper.then(function() {
       
	        // Fetches the link in the page
	        casper.links = casper.links.concat(this.evaluate(getLinks));
            casper.echo('Links saved.');
	        // Fetches the following pages
            //casper.capture(links.length + '-google-search.png');
            //casper.echo("Screen saved.");
            //casper.echo(casper.exists('a.fl[style="text-align:left"]'));

            if(casper.exists('a.fl[style="text-align:left"]') && casper.links.length < conf.nbLinks){
              casper.thenClick('a.fl[style="text-align:left"]');
              casper.echo('Next page.');
              casper.then(parseResults);	
          }
      });	
}

var options = conf.options;
casper.query = formatQuery(options.keywords, options.escapes, options.cms);
casper.links = [];

casper.start(conf.rootPage, function() {
	this.waitForSelector('form[action="/search"]');
	this.fill('form[action="/search"]', { q: casper.query }, true);
});

casper.then(parseResults);  

casper.then(writeResults);

casper.run();

