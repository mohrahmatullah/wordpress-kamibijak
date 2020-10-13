window.ts_google_fonts = function ($, o) {

var google_fonts = {

	options: {
		fonts: null,
		key: gowatch.google_fonts_key,
		font_name: '0',
		allfonts: $('.ts-all-fonts'),
		subsetsTypes: $('.ts-subset-types'),
		selected_subsets : $('.ts-subset-types').attr('data-subsets'),
		section : $('.ts-all-fonts').attr('data-id')
	},

	init: function (options) {

		var $this = this;
		$.extend(this.options, options);

		$this.options.allfonts.off('change').on("change", function() {
			var selected_font = $(this).val(),
				s;

			$this.options.subsetsTypes.html('');
			s = $(this).find('option[value="' + selected_font + '"]').attr('data-subsets');

			if( typeof(s) !== 'undefined' ){
				$this.subsets(s.split(','));
			}
		});

		if ( $this.options.fonts === null ) {
			$.get(
				"https://www.googleapis.com/webfonts/v1/webfonts?key=" + $this.options.key,
				{},
				function (data) {
					$this.options.fonts = data.items;
					$this.getFontList(data.items);
				}
			);

		} else {
			$this.getFontList($this.options.fonts);
		}

		$this.activatePreview();
	},

	getFontList: function (items) {

		var $this = this;

		$.each(items, function (font_index, font) {

			option = $("<option></option>");
			option.attr("value", font.family).text(font.family);
			option.attr("data-variants", font.variants);
			option.attr("data-subsets", font.subsets);

			if ( font.family === $this.options.font_name ) {
				option.attr("selected", "selected");
				$this.subsets(font.subsets);
			}

			$this.options.allfonts.append(option);
		});
	},

	subsets: function (subsets) {

		var options,
			$this = this;

		$.each(subsets, function(index, subset) {

			options = {
				name  : $this.options.section + '[subsets][]',
				type  : 'checkbox',
				value : subset
			};

			if ( $.inArray(subset, $this.options.selected_subsets) !== -1 ) {
				options.checked = "checked";
			}

			inputCheckbox = $("<input/>").attr(options);

			$this.options.subsetsTypes.append(inputCheckbox);
			$this.options.subsetsTypes.append('<span>' + subset + '</span>');
		});
	},

	activatePreview: function() {

		$this = this;
		var preview = this.options.allfonts.closest('.ts-option-line').find('.ts-font-preview');

		$(preview).click(function(event) {
			event.preventDefault();

			// remove previous font
			$('#googlefont-'+prefix).remove();

			var font = this.options.allfonts.find("option:selected").val(),
				fontSize = this.options.allfonts.closest('.ts-option-line').find('.ts-font-size').val(),
				selectedSubsets = this.options.allfonts.closest('.ts-option-line').find('input:checked'),
				fontWeight = this.options.allfonts.closest('.ts-option-line').find('.ts-font-weight').val(),
				fontStyle = this.options.allfonts.closest('.ts-option-line').find('.ts-font-weight option:selected').val(),
				subsets = [],
				styles = [];

			if ( fontName === '0' ) {
				alert('Please select font name');
				return 0;
			}

			$.each(selectedSubsets, function(index, value) {
				subsets.push( value.val() );
			});

			subsets = '&subset=' + subsets.join(',');

			if ( typeof(fontSize) == 'undefined' || fontSize.length == 0 ) {
				fontSize = 24;
			}

			$('head').append('<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=' + escape(fontName) + ':400,400italic,700' + subsets + '" type="text/css" media="all" />');

			preview.parent().find('.ts-lab-preview').html( $('#' + prefix + '-demo').val() ).removeAttr('style').css({
				'font-family': fontName,
				'font-size': fontSize + 'px',
				'font-weight': fontWeight,
				'font-style': fontStyle,
				color: 'black'
			});
		});
	}
};

return google_fonts.init(o);

};

 ts_google_fonts(jQuery, {});