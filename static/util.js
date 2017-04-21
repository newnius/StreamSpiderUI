function formatDate(date, fmt)
{
	function pad(value) {
		return (value.toString().length < 2) ? '0' + value : value;
	}
	return fmt.replace(/%([a-zA-Z])/g, function (_, fmtCode) {
		switch (fmtCode) {
			case 'Y':
				return date.getUTCFullYear();
			case 'M':
				return pad(date.getUTCMonth() + 1);
			case 'n':
				return date.getUTCMonth() + 1;
			case 'd':
				return pad(date.getUTCDate());
			case 'H':
				return pad(date.getUTCHours());
			case 'm':
				return pad(date.getUTCMinutes());
			case 's':
				return pad(date.getUTCSeconds());
			default:
				throw new Error('Unsupported format code: ' + fmtCode);
		}
	});
}


function long2ip(ip)
{
	//  discuss at: http://locutus.io/php/long2ip/
	// original by: Waldo Malqui Silva (http://waldo.malqui.info)
	if (!isFinite(ip)) {
		return false
	}
	return [ip >>> 24, ip >>> 16 & 0xFF, ip >>> 8 & 0xFF, ip & 0xFF].join('.')
}

//http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
function getParameterByName(name, url)
{
	if (!url) {
		url = window.location.href;
	}
	name = name.replace(/[\[\]]/g, "\\$&");
	var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
	results = regex.exec(url);
	if (!results) return null;
	if (!results[2]) return '';
	return decodeURIComponent(results[2].replace(/\+/g, " "));
}


function timeFormatter(unixTimestamp)
{
	unixTimestamp = parseInt(unixTimestamp);
  var d = new Date(unixTimestamp);
  d.setTime( d.getTime() - d.getTimezoneOffset()*60*1000 );
  return formatDate(d, '%Y-%M-%d %H:%m');
}
