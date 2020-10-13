jQuery(document).ready(function(){

	var __slice = [].slice;

	(function($, window) {
	    var Starrr;

	    Starrr = (function() {
	        Starrr.prototype.defaults = {
	            rating: void 0,
	            numStars: 5,
	            change: function(e, value) {}
	        };

	        function Starrr($el, options) {
	            var i, _, _ref,
	                _this = this;

	            this.options = $.extend({}, this.defaults, options);
	            this.$el = $el;
	            _ref = this.defaults;
	            for (i in _ref) {
	                _ = _ref[i];
	                if (this.$el.data(i) != null) {
	                    this.options[i] = this.$el.data(i);
	                }
	            }
	            this.createStars();
	            this.syncRating();
	            this.$el.on('mouseover.starrr', 'li', function(e) {
	                return _this.syncRating(_this.$el.find('li').index(e.currentTarget) + 1);
	            });
	            this.$el.on('mouseout.starrr', function() {
	                return _this.syncRating();
	            });
	            this.$el.on('click.starrr', 'li', function(e) {

            	    if ( ! jQuery('body').hasClass('logged-in') ) {
            	    	alert(touchrate.alert_message);
            			return false;
            		}

	            	var element = $(this);
	            	return _this.setRating(_this.$el.find('li').index(e.currentTarget) + 1, element);
	            });
	            this.$el.on('starrr:change', this.options.change);
	        }

	        Starrr.prototype.createStars = function() {
                var _i, _ref, _results;

                _results = [];
                for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
                    _results.push(this.$el.append("<li class='icon-star'></li>"));
                }
                return _results;
            };

	        Starrr.prototype.setRating = function(rating, element) {

	        	if ( ! jQuery('body').hasClass('logged-in') ) {
	        		alert(touchrate.alert_message);
	        		return false;
	        	}

	            if (this.options.rating === rating ) {
	                return false;
	            }

	            var data = {
	            	action    : 'touchrate_set_rating',
	            	rating    : rating,
	            	post_id   : touchrate.post_ID,
	            	security  : touchrate.ajax_nonce,
	            };

	           	var rating_avg = rating;

	           	element.parents('.touchrate-container').addClass('is-loading');

	            $.post(touchrate.ajaxurl, data, function(response) {
	            	if( response.status == '200' ) {
	            		rating_avg = response.rating_avg;
	            		element.parent().next().find('i').html( rating_avg );
	            		element.parents('.touchrate-container').removeClass('is-loading');
	            	}
	            });

	            this.options.rating = rating_avg;
	            this.syncRating();
	            return this.$el.trigger('starrr:change', rating_avg);
	        };

	        Starrr.prototype.syncRating = function(rating) {
	            var i, _i, _j, _ref;

	            // Make sure we make full stars
	            if (rating) {
	            	rating = parseInt(rating);
	            } else{
	            	rating = parseInt(this.options.rating);
	            }

	            if (rating) {
	                for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
	                    this.$el.find('li').eq(i).removeClass('icon-star').addClass('icon-star-full');
	                }
	            }
	            if (rating && rating < 5) {
	                for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
	                    this.$el.find('li').eq(i).removeClass('icon-star-full').addClass('icon-star');
	                }
	            }
	            if (!rating) {
	                return this.$el.find('li').removeClass('icon-star-full').addClass('icon-star');
	            }
	        };

	        return Starrr;

	    })();

	    return $.fn.extend({
	        starrr: function() {
	            var args, option;

	            option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
	            return this.each(function() {
	                var data;

	                data = $(this).data('star-rating');
	                if (!data) {
	                    $(this).data('star-rating', (data = new Starrr($(this), option)));
	                }
	                if (typeof option === 'string') {
	                    return data[option].apply(data, args);
	                }
	            });
	        }
	    });

	})(window.jQuery, window);

	jQuery("ul.touchrate-stars").starrr({
		rating: jQuery(this).attr('data-rating')	
	});

});