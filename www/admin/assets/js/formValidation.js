/**
 * A JavaScript function to set the validation requirements for a form element.
 *
 * @param {String} obj The name of the HTML form element.
 * @param {String} descr A textual description of the HTML form element.
 * @param {Boolean} req If the HTML form element must be filled in (true), or
 *                      if it may be left empty (false).
 * @param {String} check What kind of validation needs to be performed on the
 *                       HTML form data. Possible values are:
 *                       - url:              Ensure the element is a valid URL.
 *                       - email:            Ensure the element is a valid email
 *                                           address.
 *                       - number:           Ensure the element is a non-negative
 *                                           integer.
 *                       - number+{String}:  Ensure that the element is a non-
 *                                           negative integer, which is greater
 *                                           than integer {String}.
 *                       - formattedNumber:  Ensure the element is a valid,
 *                                           non-negative formatted integer.
 *                       - float:            Ensure the element is a non-negative
 *                                           float.
 *                       - float+{String}:   Ensure that the element is a non-
 *                                           negative float, which is greater
 *                                           than float {String}.
 *                       - formattedFloat:   Ensure the element is a valid,
 *                                           non-negative formatted float.
 *                       - compare:{String}: Ensure the element is identical to
 *                                           the form element {String}.
 *                       - string+{Length}:  Ensure the element is a string, at
 *                                           least {Length} characters.
 *                       The parameter can also be left null, in which case no
 *                       validation needs to be performed (i.e. all that is
 *                       required is that the element needs to be filled in, if
 *                       req = true).
 */
function max_formSetRequirements(obj, descr, req, check)
{
    if (typeof(check) == 'undefined') {
        check = 'present';
    }
    // Ensure number+, float+ and compare: checks are valid
    if (check.substr(0,7) == 'number+') {
        if (check.length == 7) {
            return;
        }
    }
    if (check.substr(0,6) == 'float+') {
        if (check.length == 6) {
            return;
        }
    }
	if (check.substr(0,8) == 'compare:') {
		if (check.length == 8) {
			return;
		}
	}
	if (check.substr(0,7) == 'string:') {
		if (check.length == 7) {
			return;
		}
	}
    // Find the object to set properties on
	obj = findObj(obj);
	// Set properties
	if (obj) {
		obj.validateReq = req;
		obj.validateCheck = check;
		obj.validateDescr = descr;
	}
}

/**
 * A JavaScript function to set a unique validation requirement for a form element.
 *
 * @param {String} obj The name of the HTML form element.
 * @param {String} unique A pipe ("|") separated list of values that represent
 *                        all of the existing values that already in use, and
 *                        thus, the values which this HTML form element cannot
 *                        be equal to.
 */
function max_formSetUnique(obj, unique)
{
	obj = findObj(obj);
	// Set properties
	if (obj) {
		obj.validateUnique = unique;
	}
}

/**
 * A JavaScript function to set a length constraints for a form element.
 *
 * @param {Object} length set the minimum and maximum length for the field.
 *                       Pass object with properties: min, max.
 *                       Either min and max can be set.
 *                       Negative values and 0 (zero) for min are ignored.
 *                       Examples: {max: 10}, {min: 2, max: 10}, {min: 5}
 */
function max_formSetLength(obj, length)
{
  obj = findObj(obj);
  // Set properties
  if (obj) {
    if (length && length.min && length.min > 0) {
      obj.minLength = length.min;
    }
    if (length && length.max) {
      obj.maxLength = length.max;
    }
  }
}


/**
 * A JavaScript function to add JS condition which if present should be evaluated before field is validated
 *
 * @param {String} obj The name of the HTML form element.
 * @param JS condition (code for eval)
 */
function max_formSetConditionalValidate(obj, condition)
{
  obj = findObj(obj);
  // Set properties
  if (obj) {
    obj.valCondition = condition;
  }
}

/**
 * A JavaScript function to validate the set requirements/uniqueness of a form
 * element.
 *
 * If a form element is set to be a formattedNumber or formattedFloat value,
 * then this function sets the value of the element to be the NON formatted
 * value of the number, if it has been correctly validated.
 *
 * @param {Object} obj An HTML form element.
 * @return {Boolean} Returns the error status of the element: True when there
 *                   is an error (i.e. the form element data is not valid),
 *                   false when there is no error in the form element data.
 */
function max_formValidateElement(obj)
{
    // Delimiter to use
    var tdelimiter = validatorPreferences.thousandsSeperator;

  //skip validation in condition not met
  if (obj.valCondition && !eval(obj.valCondition)) {
    return false;
  }

	if (obj.validateCheck || obj.validateReq) {
		err = false;
		val = obj.value;
		// Test some simple cases where input is required, but not supplied
		if (obj.validateReq == true && (val == '' || val == '-' || val == 'http://') && !obj.disabled) {
			err = true;
		}
		// If the form element needs to be have the data checked, and there is
		// not an error already...
		if (obj.validateCheck && (err == false) && val != '') {
            // Check URL data
			if ((obj.validateCheck == 'url') && (val.substr(0,7) != 'http://') && (val.substr(0,8) != 'https://')) {
				err = true;
		    }
		    // Check email address data
			if ((obj.validateCheck == 'email') && ((val.indexOf('@') < 1) || (val.indexOf('@') == (val.length - 1)))) {
				err = true;
			}
			// Check number* data
			if ((obj.validateCheck == 'number*') && ((isNaN(val) && (val != '*')) || (parseInt(val) < 0))) {
				err = true;
			}
			// Check number data
			if ((obj.validateCheck == 'number') && ((isNaN(val)) || (parseInt(val) < 0))) {
				err = true;
			}
			// Check whole number data
			if ((obj.validateCheck == 'wholeNumber') && ((isNaN(val)) || (parseInt(val) < 0) || (val.indexOf('.') != -1))) {
				err = true;
			}
			// Check whole number data and if the value is a dash '-' replace it with 0 value
			if (obj.validateCheck == 'wholeNumber-') {
				var valString = val.toString();
				if (valString == '-') {
					valString = 0;
                }
                else if (isNaN(val) || (parseInt(val) < 0) || (val.indexOf('.') != -1)) {
				    err = true;
			    }
			}
			// Check number+ data
			if (obj.validateCheck.substr(0,7) == 'number+') {
				min = obj.validateCheck.substr(7,obj.validateCheck.length - 7);
				if ((min == 0) && (val == '-')) {
				    val = 0;
				}
				if (isNaN(val) || (parseInt(val) < parseInt(min))) {
					err = true;
				}
			}
			// Check formattedNumber data
			if (obj.validateCheck == 'formattedNumber') {
                var valString = val.toString();
                // Remove thousands delimiters
                if (valString.indexOf(tdelimiter) != -1) {
                    var array = valString.split(tdelimiter);
                    valString = array.join('');
                }
                if (valString == '-') {
                    valString = 0;
                }
			    if ((isNaN(valString) && (valString != '*')) || (parseInt(valString) < 0)) {
				    err = true;
			    }
			    if (!err && !isNaN(valString)) {
                    // Set the element value to be non-formatted
                    obj.value = valString;
			    }
            }
			// Check float and float+ data
			if ((obj.validateCheck == 'float*') && ((isNaN(val) && (val != '*')) || (parseFloat(val) < 0))) {
				err = true;
			}
			// Check float+ data
			if (obj.validateCheck.substr(0,6) == 'float+') {
    			min = obj.validateCheck.substr(6,obj.validateCheck.length - 6);
				if ((min == 0) && (val == '-')) {
				    val = 0;
				}
				if (isNaN(val) || (parseFloat(val) < parseFloat(min))) {
					err = true;
				}
			}
			// Check formattedFloat data
			if (obj.validateCheck == 'formattedFloat') {
                var valString = val.toString();
                // While thousands delimiters exist, replace them with nothing
                while (valString.indexOf(tdelimiter) != -1) {
                    var array = valString.split(tdelimiter);
                    valString = array.join('');
                }
                if (valString == '-') {
                    valString = 0;
                }
			    if ((isNaN(valString) && (valString != '*')) || (parseFloat(valString) < 0)) {
				    err = true;
			    }
			    if (!err && !isNaN(valString)) {
                    // Set the element value to be non-formatted
                    obj.value = valString;
			    }
            }
			// Check compare element is identical to the specified element
			if (obj.validateCheck.substr(0,8) == 'compare:') {
				compare = obj.validateCheck.substr(8,obj.validateCheck.length - 8);
				compareobj = findObj(compare);
				if (val != compareobj.value) {
					err = true;
				}
			}
			// Check string length
			if (obj.validateCheck.substr(0,7) == 'string+') {
				var valString = val.toString();
				var len = parseInt(obj.validateCheck.substr(7,obj.validateCheck.length - 7));

				if (valString.length < len) {
					err = true;
				}
			}
			// Check that element is "unique"
			if (obj.validateCheck == 'unique') {
				needle = obj.value.toLowerCase();
				haystack = obj.validateUnique.toLowerCase();
				if (haystack.indexOf('|'+needle+'|') > -1) {
					err = true;
				}
			}
		}

	    if (obj.minLength && obj.value.length < obj.minLength) {
	        err = true;
	    }

	    if (obj.maxLength && obj.maxLength > 0 && obj.value.length > obj.maxLength) { //this is unlikely since browser should contrain that
	        err = true;
	    }

		// Change class
		if (err) {
			$(obj).addClass('error');
		} else {
			$(obj).removeClass('error');
		}
		return err;
	}
}

/**
 * A JavaScript function to validate the set requirements/uniqueness of a form.
 * Displays a pop up warning when there are errors in the form data.
 *
 * @param {Object} obj An HTML form.
 * @return {Boolean} Returns it the form is valid or not: True when there
 *                   are no errors (i.e. the form element data is valid),
 *                   false when there is an error.
 */
function max_formValidate(f)
{
	var noerrors = true;
	var first	 = false;
	var fields   = new Array();
	// Check for errors
	for (var i = 0; i < f.elements.length; i++) {
		if (f.elements[i].validateCheck || f.elements[i].validateReq) {
			err = max_formValidateElement(obj = f.elements[i]);
			if (err) {
				if (first == false) {
				    first = i;
				}
				fields.push(f.elements[i].validateDescr);
				noerrors = false;
			}
		}
	}
	if (noerrors == false) {
		alert (validatorPreferences.strFieldContainsErrors +
			   '                     \n\n- ' +
			   fields.join('\n- ') +
			   '\n\n' +
			   validatorPreferences.strFieldFixBeforeContinue1 +
			   '\n' +
			   validatorPreferences.strFieldFixBeforeContinue2 +
			   '\n');

		// Select field with first error
    if (f.elements[first].nodeName.toLowerCase() != "select") { //selects don't have text to select
      f.elements[first].select();
    }
		f.elements[first].focus();
	}

    return (noerrors);
}

/**
 * A JavaScript function to validate the HTML contents of a form.
 *
 * @param {String} name The id of an HTML element. Example use: var x = new getObj('objectid'); You then must refer to any style attributes as x.style, and any object attributes as x.obj.
 */
function getObj(name)
{
  if (document.getElementById)
  {
  	this.obj = document.getElementById(name);
   if (this.obj)
   {
	   this.style = document.getElementById(name).style;
   }
  }
  else if (document.all)
  {
	 this.obj = document.all[name];
    if (this.obj) {
   	this.style = document.all[name].style;
    }
  }
  else if (document.layers)
  {
    this.obj = document.layers[name];
    this.style = document.layers[name];
  }
}

/**
 * A JavaScript function to validate the HTML contents of a form.
 *
 * @param {String} obj The name of the HTML form element.
 * @return {Boolean} Returns if the form is valid or not: True when there
 *                   are no errors (i.e. the form element data is valid),
 *                   false when there is an error.
 */
function max_formValidateHtml(obj)
{
	var htmlCode = obj.value;

	var openTags;
	var closeTags;
	openTags = 0;
	closeTags = 0;

	pattern = /<!--/;
	pattern2 = /-->/;
	htmlCodes = htmlCode.split(pattern);
	for(i=0;i<htmlCodes.length;i++) {
		var code = htmlCodes[i];
		splitCode = code.split(pattern2);
		if (splitCode) {
			if (splitCode.length>1) {
				for(n=1;n<splitCode.length;n++) {
					var newCode = splitCode[n];
					openTag = /</g;
					openTagsArr = newCode.match(openTag);
					if (openTagsArr) {
						openTags = openTags + openTagsArr.length;
					}
					closeTag = />/g;
					closeTagArr = newCode.match(closeTag);
					if (closeTagArr) {
						closeTags = closeTags + closeTagArr.length;
					}
				}
			} else {
				for(n=0;n<splitCode.length;n++) {
					var newCode = splitCode[n];
					openTag = /</g;
					openTagsArr = newCode.match(openTag);
					if (openTagsArr) {
						openTags = openTags + openTagsArr.length;
					}
					closeTag = />/g;
					closeTagArr = newCode.match(closeTag);
					if (closeTagArr) {
						closeTags = closeTags + closeTagArr.length;
					}
				}
			}
		}
	}

	if(openTags != closeTags) {
        if(openTags > closeTags) {
            var difference = openTags - closeTags;
            var errorMsg  = validatorPreferences.strWarningMissing + difference + validatorPreferences.strWarningMissingClosing;
        }
        else {
            var difference = closeTags - openTags;
            var errorMsg  = validatorPreferences.strWarningMissing + difference + validatorPreferences.strWarningMissingOpening;
        }

		var ignore = confirm (errorMsg + ' \n ' + validatorPreferences.strSubmitAnyway)
		if (!ignore)
			return false;
    }

	return true;
}
