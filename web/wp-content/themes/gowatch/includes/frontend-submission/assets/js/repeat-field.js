;(function($) {

    var TSZF_User_Frontend = {

        pass_val : '',
        retype_pass_val : '',

        init: function() {

            // If we already have some values, remove required attr from last input, so the user can submit form without adding anything.
            if( $('.repeat-field-container > div[data-label-index]').length) {

                var self = this;

                $('.repeat-field-container').each(function(){
                    /*
                     * Only change 'data-required' attr if there are more than one inputs. 
                     * This means that something was added and user can submit form.
                     */
                    if( $(this).find('div[data-label-index]').length > 1 ) {

                        self.toggleRequiredAttr( $(this).find('div[data-label-index]').last() );    

                    }

                });
                
            }

            // Clone field on 'Enter' keyup.
            $(document).on('keypress', '.repeatable-input', function(e){

                var key = e.which;

                if( key == 13 ) {

                    e.preventDefault();

                    // Create pills for each sequence separed by comma
                    if( jQuery(this).val().indexOf(',') != -1 ) {

                      TSZF_User_Frontend.cloneMultiple( jQuery(this).parent('div') );

                    } else {
                      // Create one pill, as there was no commas in submitted text..
                      TSZF_User_Frontend.cloneThis( jQuery(this).parent('div') );   

                    }

                    return false;

                }
            });

            $(document).on('click', '.tszf-tabs .ts-item-tab', function(e){
                e.preventDefault();
                TSZF_User_Frontend.updateActiveTab( jQuery( this ) );

            });

            // Remove field on pill click.

            $(document).on('click', '.repeat-pill', function(e){
                TSZF_User_Frontend.removePill( jQuery(this) );
            });

        },

        /**
         * Clone multiple
         * Get a string containg commas, split stirng by commas, create pills for each sequence
         * @param domObject submitetd input parent div
         */

         cloneMultiple( submitted ) {

            var $input = submitted.find('input');
            var sequences = $input.val().split(',');

            var $currentObject = $previousObject = submitted;

            var oldIndex,
                newIndex;

            jQuery.each( sequences, function( index, value ) {

                if( value.trim() == '' ) return;

                if( index > 0 ) {

                  $currentObject = $previousObject.clone();

                }

                oldIndex = $previousObject.attr('data-label-index'),
                newIndex = parseInt( oldIndex ) + 1;

                $previousObject.after( $currentObject );

                $currentObject.hide();
                $currentObject.attr( 'data-label-index', newIndex );
                $currentObject.find( 'input' ).val( value );

                TSZF_User_Frontend.rewriteInputValue( $currentObject );

                TSZF_User_Frontend.createPill( $currentObject );

                $previousObject = $currentObject;

            });    

            var $clone = $previousObject.clone();

            $clone.attr( 'data-label-index', newIndex + 1 );

            TSZF_User_Frontend.toggleRequiredAttr( $clone );

            $previousObject.after( $clone );
            $clone.show();

            $clone.find('input').val('');

            $clone.find(':checked').attr('checked', '');

            $clone.find('input').focus();

         },

        /**
         * Creates and empty field, clone of given domObject.
         * @param DOM Object Given object that must be cloned.
         * $clone is the new, empty input.
         * domObject is input with submitted value.
         */
        cloneThis: function( domObject ) {

            var $clone = domObject.clone();

            var oldIndex = $clone.attr('data-label-index'),
                newIndex = parseInt( oldIndex ) + 1 ;

            $clone.attr('data-label-index', newIndex);
            TSZF_User_Frontend.toggleRequiredAttr( $clone );

            domObject.after( $clone );
            domObject.hide();

            TSZF_User_Frontend.rewriteInputValue( domObject );

            $clone.find('input').val('');
            $clone.find(':checked').attr('checked', '');

            //Focus on this input.
            $clone.find('input').focus();

            // Create the pill for previously populated input.
            TSZF_User_Frontend.createPill( domObject ); 
                        
        },

        /**
         * Rewrite input value. Assign ID and text.
         * @param domObject input
         */

        rewriteInputValue: function( domObject ) {
            var $input = domObject.is('input') ? jQuery(domObject) : domObject.find('input'),
                oldValue = $input.val();

            //Generate a random ID and assign it to previosuly populated input.
            var randID =  new Date().getUTCMilliseconds() +  Math.round( Math.random() * 9999 ).toString() + '{-}' + oldValue;

            $input.val( randID );

        },

        /**
         * If we added at least one value, we need to make all following inputs not required.
         * @param DOM Object  Input to change data-required attr to no
         */

        toggleRequiredAttr: function( domObject ) {

            var $input = domObject.is('input') ? jQuery(domObject) : domObject.find('input');

            if( $input.attr('data-required') == 'yes' ) {
                $input.attr('data-required', 'no');       
                $input.data('required', 'no');
            }

        },

        /*
         * Explode repeat field value to pair ['id'] {-} ['text']
         */

         explodeValue: function( val ){
            var pair  = val.split( '{-}' );
            return pair[1];
         },

        /**
         * Used to create a pill for given value for repeat field.
         * @param DOM Object Repeat field Input.
         */                    
        createPill: function( domObject ) {
            // Get actual input and its value.
            var $input = domObject.is('input') ? jQuery(domObject) : domObject.find('input'),
                value  = $input.val().replace(/(<([^>]+)>)/ig,"");

            //Where pill will be appended.
            var addTo = domObject.parents('.repeat-field-container'),
                pill  = TSZF_User_Frontend.renderPill( value, domObject.attr('data-label-index') );

                pill.appendTo( addTo );
        },

        /**
         * Renders pill output.
         * @param string text Pill text.
         */
        renderPill: function( text, index ) {
            var actualText = TSZF_User_Frontend.explodeValue( text );
            return $( '<div class="repeat-pill" data-label-for="'+ index +'"><span class="value">'+ actualText +'</span> <span class="remove icon-close"></span></div>' );
        },

        /*
         * Delete pill and coresponding input.
         * @param DOM Object pill that was clicked.
         */
        removePill: function( domObject ) {
            var labelIndex = domObject.attr('data-label-for');
            domObject.fadeOut(400).remove();
            jQuery('div[data-label-index="'+ labelIndex +'"]').remove();
        },


        removeField: function() {
            //check if it's the only item
            var $parent = $(this).closest('tr');
            var items = $parent.siblings().andSelf().length;

            if( items > 1 ) {
                $parent.remove();
            }
        },

        updateActiveTab: function( tab ) {

            var selectedTab = tab.attr('data-tabname');
                tab.parents('.tszf-el').find('.tszf-tabs-active-holder').val( selectedTab );


            var id = tab.find('a').attr('href'),
                parent = tab.closest('.tszf-tabs');

            parent.find('.active').removeClass('active');

            tab.addClass('active');

            jQuery(id).addClass('active');

            tab.parents('.tszf-tabs').find('.tszf-tabs-active-holder').attr( 'value', selectedTab );

        },         
    };

    $(function() {
        TSZF_User_Frontend.init();
    });

})(jQuery);

// Fold and ignore.
window.tszf_countries_list = [ 
  {name: 'Afghanistan', code: 'AF'}, 
  {name: 'Åland Islands', code: 'AX'}, 
  {name: 'Albania', code: 'AL'}, 
  {name: 'Algeria', code: 'DZ'}, 
  {name: 'American Samoa', code: 'AS'}, 
  {name: 'AndorrA', code: 'AD'}, 
  {name: 'Angola', code: 'AO'}, 
  {name: 'Anguilla', code: 'AI'}, 
  {name: 'Antarctica', code: 'AQ'}, 
  {name: 'Antigua and Barbuda', code: 'AG'}, 
  {name: 'Argentina', code: 'AR'}, 
  {name: 'Armenia', code: 'AM'}, 
  {name: 'Aruba', code: 'AW'}, 
  {name: 'Australia', code: 'AU'}, 
  {name: 'Austria', code: 'AT'}, 
  {name: 'Azerbaijan', code: 'AZ'}, 
  {name: 'Bahamas', code: 'BS'}, 
  {name: 'Bahrain', code: 'BH'}, 
  {name: 'Bangladesh', code: 'BD'}, 
  {name: 'Barbados', code: 'BB'}, 
  {name: 'Belarus', code: 'BY'}, 
  {name: 'Belgium', code: 'BE'}, 
  {name: 'Belize', code: 'BZ'}, 
  {name: 'Benin', code: 'BJ'}, 
  {name: 'Bermuda', code: 'BM'}, 
  {name: 'Bhutan', code: 'BT'}, 
  {name: 'Bolivia', code: 'BO'}, 
  {name: 'Bosnia and Herzegovina', code: 'BA'}, 
  {name: 'Botswana', code: 'BW'}, 
  {name: 'Bouvet Island', code: 'BV'}, 
  {name: 'Brazil', code: 'BR'}, 
  {name: 'British Indian Ocean Territory', code: 'IO'}, 
  {name: 'Brunei Darussalam', code: 'BN'}, 
  {name: 'Bulgaria', code: 'BG'}, 
  {name: 'Burkina Faso', code: 'BF'}, 
  {name: 'Burundi', code: 'BI'}, 
  {name: 'Cambodia', code: 'KH'}, 
  {name: 'Cameroon', code: 'CM'}, 
  {name: 'Canada', code: 'CA'}, 
  {name: 'Cape Verde', code: 'CV'}, 
  {name: 'Cayman Islands', code: 'KY'}, 
  {name: 'Central African Republic', code: 'CF'}, 
  {name: 'Chad', code: 'TD'}, 
  {name: 'Chile', code: 'CL'}, 
  {name: 'China', code: 'CN'}, 
  {name: 'Christmas Island', code: 'CX'}, 
  {name: 'Cocos (Keeling) Islands', code: 'CC'}, 
  {name: 'Colombia', code: 'CO'}, 
  {name: 'Comoros', code: 'KM'}, 
  {name: 'Congo', code: 'CG'}, 
  {name: 'Congo, The Democratic Republic of the', code: 'CD'}, 
  {name: 'Cook Islands', code: 'CK'}, 
  {name: 'Costa Rica', code: 'CR'}, 
  {name: 'Cote D\'Ivoire', code: 'CI'}, 
  {name: 'Croatia', code: 'HR'}, 
  {name: 'Cuba', code: 'CU'}, 
  {name: 'Cyprus', code: 'CY'}, 
  {name: 'Czech Republic', code: 'CZ'}, 
  {name: 'Denmark', code: 'DK'}, 
  {name: 'Djibouti', code: 'DJ'}, 
  {name: 'Dominica', code: 'DM'}, 
  {name: 'Dominican Republic', code: 'DO'}, 
  {name: 'Ecuador', code: 'EC'}, 
  {name: 'Egypt', code: 'EG'}, 
  {name: 'El Salvador', code: 'SV'}, 
  {name: 'Equatorial Guinea', code: 'GQ'}, 
  {name: 'Eritrea', code: 'ER'}, 
  {name: 'Estonia', code: 'EE'}, 
  {name: 'Ethiopia', code: 'ET'}, 
  {name: 'Falkland Islands (Malvinas)', code: 'FK'}, 
  {name: 'Faroe Islands', code: 'FO'}, 
  {name: 'Fiji', code: 'FJ'}, 
  {name: 'Finland', code: 'FI'}, 
  {name: 'France', code: 'FR'}, 
  {name: 'French Guiana', code: 'GF'}, 
  {name: 'French Polynesia', code: 'PF'}, 
  {name: 'French Southern Territories', code: 'TF'}, 
  {name: 'Gabon', code: 'GA'}, 
  {name: 'Gambia', code: 'GM'}, 
  {name: 'Georgia', code: 'GE'}, 
  {name: 'Germany', code: 'DE'}, 
  {name: 'Ghana', code: 'GH'}, 
  {name: 'Gibraltar', code: 'GI'}, 
  {name: 'Greece', code: 'GR'}, 
  {name: 'Greenland', code: 'GL'}, 
  {name: 'Grenada', code: 'GD'}, 
  {name: 'Guadeloupe', code: 'GP'}, 
  {name: 'Guam', code: 'GU'}, 
  {name: 'Guatemala', code: 'GT'}, 
  {name: 'Guernsey', code: 'GG'}, 
  {name: 'Guinea', code: 'GN'}, 
  {name: 'Guinea-Bissau', code: 'GW'}, 
  {name: 'Guyana', code: 'GY'}, 
  {name: 'Haiti', code: 'HT'}, 
  {name: 'Heard Island and Mcdonald Islands', code: 'HM'}, 
  {name: 'Holy See (Vatican City State)', code: 'VA'}, 
  {name: 'Honduras', code: 'HN'}, 
  {name: 'Hong Kong', code: 'HK'}, 
  {name: 'Hungary', code: 'HU'}, 
  {name: 'Iceland', code: 'IS'}, 
  {name: 'India', code: 'IN'}, 
  {name: 'Indonesia', code: 'ID'}, 
  {name: 'Iran, Islamic Republic Of', code: 'IR'}, 
  {name: 'Iraq', code: 'IQ'}, 
  {name: 'Ireland', code: 'IE'}, 
  {name: 'Isle of Man', code: 'IM'}, 
  {name: 'Israel', code: 'IL'}, 
  {name: 'Italy', code: 'IT'}, 
  {name: 'Jamaica', code: 'JM'}, 
  {name: 'Japan', code: 'JP'}, 
  {name: 'Jersey', code: 'JE'}, 
  {name: 'Jordan', code: 'JO'}, 
  {name: 'Kazakhstan', code: 'KZ'}, 
  {name: 'Kenya', code: 'KE'}, 
  {name: 'Kiribati', code: 'KI'}, 
  {name: 'Korea, Democratic People\'S Republic of', code: 'KP'}, 
  {name: 'Korea, Republic of', code: 'KR'}, 
  {name: 'Kuwait', code: 'KW'}, 
  {name: 'Kyrgyzstan', code: 'KG'}, 
  {name: 'Lao People\'S Democratic Republic', code: 'LA'}, 
  {name: 'Latvia', code: 'LV'}, 
  {name: 'Lebanon', code: 'LB'}, 
  {name: 'Lesotho', code: 'LS'}, 
  {name: 'Liberia', code: 'LR'}, 
  {name: 'Libyan Arab Jamahiriya', code: 'LY'}, 
  {name: 'Liechtenstein', code: 'LI'}, 
  {name: 'Lithuania', code: 'LT'}, 
  {name: 'Luxembourg', code: 'LU'}, 
  {name: 'Macao', code: 'MO'}, 
  {name: 'Macedonia, The Former Yugoslav Republic of', code: 'MK'}, 
  {name: 'Madagascar', code: 'MG'}, 
  {name: 'Malawi', code: 'MW'}, 
  {name: 'Malaysia', code: 'MY'}, 
  {name: 'Maldives', code: 'MV'}, 
  {name: 'Mali', code: 'ML'}, 
  {name: 'Malta', code: 'MT'}, 
  {name: 'Marshall Islands', code: 'MH'}, 
  {name: 'Martinique', code: 'MQ'}, 
  {name: 'Mauritania', code: 'MR'}, 
  {name: 'Mauritius', code: 'MU'}, 
  {name: 'Mayotte', code: 'YT'}, 
  {name: 'Mexico', code: 'MX'}, 
  {name: 'Micronesia, Federated States of', code: 'FM'}, 
  {name: 'Moldova, Republic of', code: 'MD'}, 
  {name: 'Monaco', code: 'MC'}, 
  {name: 'Mongolia', code: 'MN'}, 
  {name: 'Montserrat', code: 'MS'}, 
  {name: 'Morocco', code: 'MA'}, 
  {name: 'Mozambique', code: 'MZ'}, 
  {name: 'Myanmar', code: 'MM'}, 
  {name: 'Namibia', code: 'NA'}, 
  {name: 'Nauru', code: 'NR'}, 
  {name: 'Nepal', code: 'NP'}, 
  {name: 'Netherlands', code: 'NL'}, 
  {name: 'Netherlands Antilles', code: 'AN'}, 
  {name: 'New Caledonia', code: 'NC'}, 
  {name: 'New Zealand', code: 'NZ'}, 
  {name: 'Nicaragua', code: 'NI'}, 
  {name: 'Niger', code: 'NE'}, 
  {name: 'Nigeria', code: 'NG'}, 
  {name: 'Niue', code: 'NU'}, 
  {name: 'Norfolk Island', code: 'NF'}, 
  {name: 'Northern Mariana Islands', code: 'MP'}, 
  {name: 'Norway', code: 'NO'}, 
  {name: 'Oman', code: 'OM'}, 
  {name: 'Pakistan', code: 'PK'}, 
  {name: 'Palau', code: 'PW'}, 
  {name: 'Palestinian Territory, Occupied', code: 'PS'}, 
  {name: 'Panama', code: 'PA'}, 
  {name: 'Papua New Guinea', code: 'PG'}, 
  {name: 'Paraguay', code: 'PY'}, 
  {name: 'Peru', code: 'PE'}, 
  {name: 'Philippines', code: 'PH'}, 
  {name: 'Pitcairn', code: 'PN'}, 
  {name: 'Poland', code: 'PL'}, 
  {name: 'Portugal', code: 'PT'}, 
  {name: 'Puerto Rico', code: 'PR'}, 
  {name: 'Qatar', code: 'QA'}, 
  {name: 'Reunion', code: 'RE'}, 
  {name: 'Romania', code: 'RO'}, 
  {name: 'Russian Federation', code: 'RU'}, 
  {name: 'RWANDA', code: 'RW'}, 
  {name: 'Saint Helena', code: 'SH'}, 
  {name: 'Saint Kitts and Nevis', code: 'KN'}, 
  {name: 'Saint Lucia', code: 'LC'}, 
  {name: 'Saint Pierre and Miquelon', code: 'PM'}, 
  {name: 'Saint Vincent and the Grenadines', code: 'VC'}, 
  {name: 'Samoa', code: 'WS'}, 
  {name: 'San Marino', code: 'SM'}, 
  {name: 'Sao Tome and Principe', code: 'ST'}, 
  {name: 'Saudi Arabia', code: 'SA'}, 
  {name: 'Senegal', code: 'SN'}, 
  {name: 'Serbia and Montenegro', code: 'CS'}, 
  {name: 'Seychelles', code: 'SC'}, 
  {name: 'Sierra Leone', code: 'SL'}, 
  {name: 'Singapore', code: 'SG'}, 
  {name: 'Slovakia', code: 'SK'}, 
  {name: 'Slovenia', code: 'SI'}, 
  {name: 'Solomon Islands', code: 'SB'}, 
  {name: 'Somalia', code: 'SO'}, 
  {name: 'South Africa', code: 'ZA'}, 
  {name: 'South Georgia and the South Sandwich Islands', code: 'GS'}, 
  {name: 'Spain', code: 'ES'}, 
  {name: 'Sri Lanka', code: 'LK'}, 
  {name: 'Sudan', code: 'SD'}, 
  {name: 'Suriname', code: 'SR'}, 
  {name: 'Svalbard and Jan Mayen', code: 'SJ'}, 
  {name: 'Swaziland', code: 'SZ'}, 
  {name: 'Sweden', code: 'SE'}, 
  {name: 'Switzerland', code: 'CH'}, 
  {name: 'Syrian Arab Republic', code: 'SY'}, 
  {name: 'Taiwan, Province of China', code: 'TW'}, 
  {name: 'Tajikistan', code: 'TJ'}, 
  {name: 'Tanzania, United Republic of', code: 'TZ'}, 
  {name: 'Thailand', code: 'TH'}, 
  {name: 'Timor-Leste', code: 'TL'}, 
  {name: 'Togo', code: 'TG'}, 
  {name: 'Tokelau', code: 'TK'}, 
  {name: 'Tonga', code: 'TO'}, 
  {name: 'Trinidad and Tobago', code: 'TT'}, 
  {name: 'Tunisia', code: 'TN'}, 
  {name: 'Turkey', code: 'TR'}, 
  {name: 'Turkmenistan', code: 'TM'}, 
  {name: 'Turks and Caicos Islands', code: 'TC'}, 
  {name: 'Tuvalu', code: 'TV'}, 
  {name: 'Uganda', code: 'UG'}, 
  {name: 'Ukraine', code: 'UA'}, 
  {name: 'United Arab Emirates', code: 'AE'}, 
  {name: 'United Kingdom', code: 'GB'}, 
  {name: 'United States', code: 'US'}, 
  {name: 'United States Minor Outlying Islands', code: 'UM'}, 
  {name: 'Uruguay', code: 'UY'}, 
  {name: 'Uzbekistan', code: 'UZ'}, 
  {name: 'Vanuatu', code: 'VU'}, 
  {name: 'Venezuela', code: 'VE'}, 
  {name: 'Viet Nam', code: 'VN'}, 
  {name: 'Virgin Islands, British', code: 'VG'}, 
  {name: 'Virgin Islands, U.S.', code: 'VI'}, 
  {name: 'Wallis and Futuna', code: 'WF'}, 
  {name: 'Western Sahara', code: 'EH'}, 
  {name: 'Yemen', code: 'YE'}, 
  {name: 'Zambia', code: 'ZM'}, 
  {name: 'Zimbabwe', code: 'ZW'} 
];