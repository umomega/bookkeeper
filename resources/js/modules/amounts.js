/**
 * Returns the currency name for account id
 *
 * @param string
 * @return string
 */
function getCurrencyFor(id) {
    for (var key in window.accountCurrencies) {
        if (window.accountCurrencies.hasOwnProperty(key) && key == id) {
            return window.accountCurrencies[key];
        }
    }

    return null;
}

/**
 * Returns the decimal place for currency name
 *
 * @param string
 * @return int
 */
function getDecimalPlaceFor(currency) {
    if (['JPY'].indexOf(currency) > -1) {
        return 0;
    } else if (['CNY'].indexOf(currency) > -1) {
        return 1;
    }

    return 2;
}

;( function(window) {
    'use strict';

    /**
     * Amount constructor
     *
     * @param DOM Object el
     * @param DOM Object follows
     * @param boolean directFollow
     */
    function Amount(el, follows, directFollow) {
        this.el = el;
        this.follows = follows;
        this.directFollow = directFollow;

        this.currencyOutput = this.el.find('span.amount-field__currency');
        this.inputField = this.el.find('input.amount-field__input');
        this.valueField = this.el.find('input.amount-field__value');

        this.decimalPlaces = 0;
        this.currentCurrency = 'EUR';

        this._init();
    }

    // Amount prototype
    Amount.prototype = {
        // Initializes meter
        _init : function() {
            var self = this;

            this._setInitialValues();

            this.valueField.focus(function() {
                self.inputField.addClass('is-focused');
            });
            this.valueField.blur(function() {
                self.inputField.removeClass('is-focused');
            });

            this.valueField.on('keydown', function(e) {
                e.preventDefault();

                // Trim unnecessary 0's
                $(this).val($(this).val().replace(/^0+/g, ''));

                if (e.which >= 48 && e.which <= 57) {
                    var newVal = $(this).val() + String(e.which - 48);
                    // Append the new integer
                    $(this).val(newVal);
                } else if (e.which == 8 || e.which == 46) {
                    var newVal = $(this).val().slice(0, -1);
                    // Remove from last place
                    $(this).val(newVal);
                }

                self._regenerateInputField();
            });

            this.valueField.on('change', function() {
                self._regenerateInputField();
            });

            this.valueField.on('copy paste drag drop', function (e) {
                e.preventDefault();

                return false;
            });

            this.follows.on('change', function() {
                self._setInitialValues();
            });
        },
        _setInitialValues: function() {
            if (this.directFollow) {
                this.currentCurrency = this.follows.val();
            } else {
                var accountID = this.follows.val();
                this.currentCurrency = getCurrencyFor(accountID);
            }

            this.decimalPlaces = getDecimalPlaceFor(this.currentCurrency);

            this.currencyOutput.text(this.currentCurrency);

            this._regenerateInputField();
        },
        _regenerateInputField: function() {
            var val = this.valueField.val();
            var shown = '0';

            if (val == '' || val.match(/^0+/g)) {
                if (this.decimalPlaces == 0) {
                    shown = '0'
                } else if (this.decimalPlaces == 1) {
                    shown = '0.0'
                } else {
                    shown = '0.00'
                }
            } else {
                if (this.decimalPlaces == 0) {
                    shown = val
                } else {
                    var first = val.slice(0, -1 * this.decimalPlaces),
                        second = val.slice(val.length -1 * this.decimalPlaces);

                    // Make first 0 if empty
                    first = first == '' ? '0' : first;

                    if (this.decimalPlaces == 2 && second.length == 1) {
                        second = '0' + second;
                    }

                    shown = first + '.' + second;
                }
            }

            this.inputField.val(shown);
        },
        flush: function() {
            this.valueField.val('');
            this._setInitialValues();
        }
    };

    // Register amount input to window namespace
    window.Amount = Amount;

})(window);
