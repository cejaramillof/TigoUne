$('tbody tr td').each(

	function () {
		var score = $(this).text().replace(",", ".").replace("%", "");

		if (score >= 95) {
			$(this).addClass('vcien');
		} else if (score < 95 && score >= 84) {
			$(this).addClass('vnoventa');
		} else if (score < 84 && score >= 75) {
			$(this).addClass('vsetenta');
		} else if (score < 75 && score >= 63) {
			$(this).addClass('asesenta');
		} else if (score < 63 && score >= 49) {
			$(this).addClass('acincuenta');
		} else if (score < 49 && score >= 20) {
			$(this).addClass('rcuarenta');
		} else if (score < 20 && score >= 0 && score.charCodeAt(0) != 160) {
			$(this).addClass('rvente');
		}
	});
