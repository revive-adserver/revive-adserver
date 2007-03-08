/* Copyright (c) 2005 Tim Taylor Consulting (see LICENSE.txt) */

function Grid(spacing, length) {
	this.spacing = spacing;
	this.length = length;
}

Grid.prototype.write = function() {
	var html = '';
	for (var i = 1; i <= (this.length / this.spacing); i++) {
		var num = i * this.spacing;
		html += '<span class="verticalgridline" style="left: ' + num + 'px;height: ' + this.length + 'px">' + num + '</span>';
		html += '<span class="horizontalgridline" style="top: ' + num + 'px;width: ' + this.length + 'px">' + num + '</span>';
	}
	document.write(html);
}
