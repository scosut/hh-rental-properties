function typeWriter(len, str, speed, el) {
  if (len < 0) {
    setTimeout(typeWriter.bind(this, len + 1, str, speed, el), 1750);
  }
  else {
    if (len < str.length) {
      el.innerHTML += str.charCodeAt(len) === 10 ? "<br>" : str.charAt(len);
      len++;
      setTimeout(typeWriter.bind(this, len, str, speed, el), speed);
    }
  }
}

function timepicker(el, obj) {
  for (var i = obj.min; i <= obj.max; i++) {
    var hour = i > 12 ? i - 12 : i;
    var ampm = i >= 12 ? "pm" : "am";
    var mins, str;

    hour = hour.toString().length < 2 ? "&nbsp;" + hour.toString() : hour.toString();

    for (var j = 0; j < 60; j += obj.step) {
      mins = j % 60;
      mins = mins.toString().length < 2 ? "0" + mins.toString() : mins.toString();
			str = hour + ":" + mins + " " + ampm;      
			el.append("<option value=\"" + str.replace('&nbsp;', '') + "\">" + str + "</option>");

      if (i === obj.max) {
        break;
      }
    }
  }
}

$(function() {
		$('#navbarToggler').click(function(e) {
			e.preventDefault();
			$('#navbarTogglerContent').slideToggle(1000);
		});

		$('#navbarRentDropdown').click(function(e) {
			e.preventDefault();
			$('#navbarAdminDropdownContent').slideUp(500);
			$('#navbarRentDropdownContent').slideToggle(500);
		});

		$('#navbarAdminDropdown').click(function(e) {
			e.preventDefault();
			$('#navbarRentDropdownContent').slideUp(500);
			$('#navbarAdminDropdownContent').slideToggle(500);
		});
	
		$(document).click(function (e) {
			if ($(e.target).closest("#navbarRentDropdownContent").length > 0) {
				location.href = e.target.href;
				return false;
			}
			else {
				$('#navbarRentDropdownContent').slideUp(500);
			}

			if ($(e.target).closest("#navbarAdminDropdownContent").length > 0) {
				location.href = e.target.href;
				return false;
			}
			else {
				$('#navbarAdminDropdownContent').slideUp(500);
			}
		});
	
		var hero_text = document.getElementById("hero-text");
	
		if (hero_text) {
			$("body").css("display", "flex").hide().fadeIn(2000, typeWriter(-1, "Rent your next home\nin beautiful Sioux Falls today!", 100, hero_text));
		}
		else {
			$("body").css("display", "flex").hide().fadeIn(2000);
		}
	
		var links  = $(".page-link");
	
		if (links.length) {
			var toHide = $("[class*='pagenum-']");
			var toShow = $("[class*='pagenum-1']");
			var back   = links[0];
			var first  = links[1];
			var next   = links[links.length-1];
			toHide.hide();
			toShow.show();
			$(back).parent().addClass("disabled");
			$(first).parent().addClass("active");

			$(links).click(function(e) {
				e.preventDefault();
				var page   = $(e.currentTarget).attr("data-page");
				var active = Number($('.page-item.active').children().attr("data-page"));
				page = page === 'next' ? active + 1 : page === 'back' ? active - 1 : page;
				toShow = $("[class*='pagenum-" + page + "']");
				page = Number(page);

				links.parent().removeClass("active disabled");
				$(links[page]).parent().addClass("active");
				toHide.hide();
				toShow.fadeIn(2000);
				
				if (page === 1) {
					$(back).parent().addClass("disabled");
				}
				else if (page === links.length - 2) {
					$(next).parent().addClass("disabled");
				}
			})
		}
	
		$("#date").datepicker({
			minDate: 1, beforeShowDay: function (date) {
				var day = date.getDay();
				return [(day !== 0), ''];
			}
		});
	
		timepicker($("#time").first(), { min: 9, max: 18, step: 60 });
	
		$("[data-inputmask]").inputmask({ "showMaskOnHover": false });
	
		$("[data-toggle='tooltip']").tooltip({ "boundary": "window" });
		
		$("#rentalApp form").each(function(index, el) {
			var arr = $("#rentalApp form");

			$(el).attr({
				"data-prev": index > 0 ? arr[index - 1].id : "",
				"data-next": index < arr.length - 1 ? arr[index + 1].id : ""
			});
			if (index > 0) {
				$(el).hide();
			}		
		});
	
		$(".dashboard-link.delete-property").click(function(e) {
			e.preventDefault();
			var content   = $(e.currentTarget).attr("data-address");
			var property  = $(e.currentTarget).attr("data-property");
			var modal     = $("#deletePropertyModal");
  		var modalBody = $("#deletePropertyModal .modal-body");
			var form      = $("#deletePropertyModal form");

    	form.submit(function(e) {
				e.preventDefault();
				e.target.action = "/properties/delete/" + property;						
				modal.modal("hide");
				window.scrollTo(0, 0);
				$(".loading-overlay").addClass("loading-overlay-on");
				setTimeout(function() {
					$(".loading-overlay").removeClass("loading-overlay-on");
					e.target.submit();
				}, 400);
			});
			
			modalBody.html("<p>You have chosen to delete property " + content + ". Click 'Confirm' to proceed or 'Cancel' to abort.</p>");
    	modal.modal("show");
		});
	
		$(".dashboard-link.delete-applicant").click(function(e) {
			e.preventDefault();
			var content   = $(e.currentTarget).attr("data-name");
			var applicant = $(e.currentTarget).attr("data-applicant");
			var modal     = $("#deleteApplicantModal");
  		var modalBody = $("#deleteApplicantModal .modal-body");
			var form      = $("#deleteApplicantModal form");

    	form.submit(function(e) {
				e.preventDefault();
				e.target.action = "/applicants/delete/" + applicant;
				modal.modal("hide");
				window.scrollTo(0, 0);
				$(".loading-overlay").addClass("loading-overlay-on");
				setTimeout(function() {
					$(".loading-overlay").removeClass("loading-overlay-on");
					e.target.submit();
				}, 400);
			});
			
			modalBody.html("<p>You have chosen to delete applicant " + content + ". Click 'Confirm' to proceed or 'Cancel' to abort.</p>");
    	modal.modal("show");
		});
	
		$(".dashboard-link-email").click(function(e) {
			e.preventDefault();
			var route = $(e.currentTarget).attr("href");
			
			$(".loading-overlay").addClass("loading-overlay-on");
			
			$.get(route)
				.done(function(data) {
					var obj = JSON.parse(data);		
					setTimeout(function() {
						$(".loading-overlay").removeClass("loading-overlay-on");
						location.href = obj.redirect;
					}, 400);
				})
				.fail(function() {
				});
		});
	
		$(".custom-file-input").change(function(e) {
			var str = "";
			
			if (e.target.files.length > 0) {
				str = Array.prototype.slice.call(e.target.files).map(function(file) {
					return file.name;
				}).join("<br>");
			} 
			
			$(e.target).parent().children().last().html(str);
		});
	
		function processForm(url, data, formId) {			
			var files = $("#" + formId + " :input[type='file']");
			var fd = new FormData();
			fd.append('data', data);
			
			files.each(function(index, el) {
				$(el.files).each(function(fileIndex, file) {
					fd.append(el.name, file);
				});
			});
			
			window.scrollTo(0, 0);
			$(".loading-overlay").addClass("loading-overlay-on");
			
			$.ajax({
				method: 'post',
				processData: false,
				contentType: false,
				cache: false,
				data: fd,
				enctype: 'multipart/form-data',
				url: url				
			})
				.done(function(data){
					setTimeout(function() {
						$(".loading-overlay").removeClass("loading-overlay-on");
						
						var obj = JSON.parse(data);
						
						if (obj.succeeded) {
							if (obj.redirect.length > 0) {
								location.href = obj.redirect;
							}
							else {
								clearErrors(formId);											
								$("#" + formId + "Modal").modal("hide");
								$("#" + formId + " :input").val("");
							}
						}
						else {
							showErrors(obj, formId);
						}
					}, 400);
				})
				.fail(function(data){
					$(".loading-overlay").removeClass("loading-overlay-on");
				});
		}
	
		function getFormData(forms, includeEmptyValues) {
			var data = {};
			var hash = {};
						
			$(forms).each(function(index, el) {
				data[$(el).attr("id")] = $(el).serializeArray().filter(function(obj) {
					var bln = includeEmptyValues ? true : obj.value.length > 0;
					
					return obj.name != "hdnFormId" && obj.name != "hdnCoapp" && bln;
				});
			});
									
			Object.keys(data).forEach(function(key) {
				hash[key] = {};
				
				data[key].forEach(function(obj) {
					var name = obj.name.replace(/\[\]/g, '');
					hash[key][name] = hash[key].hasOwnProperty(name) ? hash[key][name] + "," + obj.value : obj.value;
				});
			});
			
			return JSON.stringify(hash);
		}
	
		function clearErrors(id) {
			var label    = $("#" + id + " label");
			var input    = $("#" + id + " :input");
			var feedback = $("#" + id + " .invalid-feedback");
			label.removeClass("form-control is-invalid");
			input.removeClass("is-invalid");
			feedback.html("");
		}
	
		function showErrors(obj, id) {
			clearErrors(id);
			
			Object.keys(obj.errors).forEach(function(key) {
				var el = $(document.forms[id][key]);
				el.next().html(obj.errors[key]);

				if (el.attr("type") == "hidden") {
					el.prev().addClass("form-control is-invalid");
				}
				else {
					el.addClass("is-invalid");	
				}
			});
			if (obj.firstError.length > 0) {
				$(document.forms[id][obj.firstError]).focus();
			}
		}

		$("#property").submit(function(e) {
			e.preventDefault();
			processForm(e.target.action, getFormData("#property", true), e.target.id);
		});
	
		$("#login").submit(function(e) {
			e.preventDefault();
			processForm(e.target.action, getFormData("#login", true), e.target.id);
		});
	
		$("#schedule").submit(function(e) {
			e.preventDefault();
			processForm(e.target.action, getFormData("#schedule", true), e.target.id);
		});
	
		$("#scheduleModal").on("hidden.bs.modal", function() {
			$("#schedule :input").val("");
			clearErrors($("#schedule").attr("id"));
		});
	
		$("#rentalApp .btn-back").click(function(e) {
			$("#rentalApp form").hide();
			var el = $(e.target).closest("form").attr("data-prev");
			$("#" + el).fadeIn(1000);
			window.scrollTo(0, 0);
		});
	
		$("#rentalApp form").submit(function(e) {
			e.preventDefault();
			
			window.scrollTo(0, 0);
			$(".loading-overlay").addClass("loading-overlay-on");
			
			$.post(e.target.action, $(e.target).serialize())
				.done(function(data){
					setTimeout(function() {
						$(".loading-overlay").removeClass("loading-overlay-on");
						
						var obj = JSON.parse(data);
						var el;

						if (obj.succeeded) {						
							clearErrors(e.target.id);

							if (obj.coapp == "yes") {
								$("#infoCoapp").attr("data-next", "empCurrCoapp");
								$("#dependents").attr("data-prev", "creditCoapp");
								$("#additional-signatureCoapp").show();
							}
							else {							
								$("#infoCoapp").attr("data-next", "dependents");
								$("#dependents").attr("data-prev", "infoCoapp");
								$("#additional-signatureCoapp").hide();
							}

							el = $("#" + e.target.id).attr("data-next");

							if (el.length == 0) {					
								processForm("/applicants/complete", getFormData("#rentalApp form", false), e.target.id);
							}
							else {							
								$("#rentalApp form").hide();
								$("#" + el).fadeIn(1000);
								document.forms[el]['hdnCoapp'].value = obj.coapp;
							}						
						}
						else {
							showErrors(obj, e.target.id);
						}
					}, 400);					
				})
				.fail(function(data){
					$(".loading-overlay").removeClass("loading-overlay-on");
				});
		});
	
		function showContent(pref, vals) {
			var opts = [];
			var el   = $("[id^='" + pref + "-']").not("[id$='expanded-content']");
			
			el.click(function(e) {
				el = $("[id='" + pref + "-expanded-content']");
				var bln = false;
				
				if (e.target.type === "radio") {
					opts = [e.target.value];
				}
				else {
					if (e.target.checked) {
						opts.push(e.target.value);
					}
					else {
						opts = opts.filter(function(opt) {
							return opt !== e.target.value;
						});
					}
				}
				
				for (var i=0; i<vals.length; i++) {
					if (opts.indexOf(vals[i]) >= 0) {
						bln = true;
						break;
					}
				}				

				if (bln) {
					el.slideDown(1000);
				}
				else {
					el.slideUp(1000);
				}
			});
		}
	
		function showExplanation(pref, val) {
			var obj = {};
			var el  = $("[id^='" + pref + "-']").not("[id$='expanded-content']");
	
			el.click(function(e) {
				el = $("[id='" + pref + "-expanded-content']");
				obj[e.target.name.replace(/\[\]/g, '')] = e.target.value;

				var count = Object.keys(obj).filter(function(key) {
					return obj[key] === val;
				}).length;

				if (count > 0) {
					el.slideDown('slow');
				}
				else {
					el.slideUp('slow');
				}
			});
		}
	
		function showNumber(el, pref) {
			el = $("#" + el);
			el.change(function(e) {
				var visible = $("[id^='" + pref + "-']:visible");
				var num  = e.target.selectedIndex > 0 ? Number(e.target.value) : -1;
				
				if (num > 0) {
					if (num < visible.length) {
						for (var i=visible.length; i>num; i--) {
							$("#" + pref + "-" + i.toString()).slideUp('slow');
						}
					}
					
					if (num > visible.length) {
						for (var i=1; i<=num; i++) {
							$("#" + pref + "-" + i.toString()).slideDown('slow');
						}
					}
				}
				else {
					visible.slideUp('slow');
				}
			});
		}
	
		$("#termsAgree").click(function() {
			$("#additional-terms").prop("checked", true);
		});
	
		showContent('empCurrApp', ['full time', 'part time']);
		showContent('empPrevApp-employment', ['yes']);
		showExplanation('creditApp', 'yes');
		showContent('infoCoapp', ['yes']);
		showContent('empCurrCoapp', ['full time', 'part time']);		
		showContent('empPrevCoapp-employment', ['yes']);
		showExplanation('creditCoapp', 'yes');
		showNumber('numDependents', 'dependents');
		showNumber('numVehicles', 'vehicles');	
		showContent('prevRes-residence', ['yes']);
});

try {
  lightbox.option({ "wrapAround": true });
}
catch (err) {
}