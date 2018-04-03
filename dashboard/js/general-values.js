var arr = [];
var arr2 = [];
var i = 1;
$('#general-matriz tbody tr td').each(
	function() {
		var score = $(this).text().replace("%", "");
		var xd = parseInt(score)
		if (!isNaN(xd)) {
			if (Number.isInteger(xd) && i % 2 != 0) {
				arr.push(xd);

			} else {
				arr2.push(xd);
			}		
		i++;
		}			
	});

var arrd = [];
var arrdi = [];
var j = 1;
$('#general-digital tbody tr td').each(
	function() {
		var scorex = $(this).text().replace("%", "");
		var xddi = parseInt(scorex)
		if (!isNaN(xddi)) {
			if (Number.isInteger(xddi) && j % 2 != 0) {
				arrd.push(xddi);
			} else {
				arrdi.push(xddi);
			}
			j++;
		}			
	});