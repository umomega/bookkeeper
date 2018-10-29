;(function (window) {
    'use strict';

    function Searcher(el, list) {
        this._init(el, list);
    }

    Searcher.prototype = {
        _init: function (el, list) {
            this.el = el;
            this.list = list;

            this.initSearcher();
        },
        initSearcher: function () {
            this.searchurl = this.el.data('searchurl');

            this.results = this.el.find('ul.searcher__results');
            this.search = this.el.find('input[name="_searcher"]');
            this.exclude = this.el.find('input[name="_exclude"]');
            this.additional = this.el.find('input[name="_additional"]');

            this.searching = false;

            this.itemKeys = [];
            this._extractItems();

            this._initSearcherEvents();
        },
        _extractItems: function () {
            var items = this.exclude.val().trim();

            if (items == '') {
                return;
            }

            this.itemKeys = JSON.parse(items);
        },
        _initSearcherEvents: function () {
            var self = this;

            // Search input
            this.search.on('keydown.searchable', function (e) {
                var q = $(this).val().trim(),
                    input = $(this);

                // Press escape
                if (e.which == 27) {
                    e.stopPropagation();

                    (q === '') ? input.blur() : input.val('');

                    self._clearSearch();

                    return;

                    // Press down
                } else if (e.which == 40) {
                    e.stopPropagation();

                    if (self._hasResults()) {
                        self._focusResult(0);
                    }

                    return;

                    // Press enter
                } else if (e.which == 13) {
                    e.preventDefault();

                    self._searchPressReturn(q);
                }

                if (!self.searching && q.length > 0) {
                    self._search(q);
                }

                if (q == '') {
                    self._clearSearch();
                }
            });

            this.search.on('focus', function () {
                self._showResults();
            });

            // Hiding search
            $('body').click(function () {
                self._hideResults();
            });

            this.el.click(function (e) {
                e.stopPropagation();
            });

            // Toggle between results
            this.results.on('keydown.searchable', 'input.searcher__result-input', function (e) {
                e.stopPropagation();
                e.preventDefault();

                var parent = $(this).closest('li');

                // Press down
                if (e.which == 40) {
                    if (!parent.is(':last-child')) {
                        self._focusResult(parent.index() + 1);
                    }
                    // Press up
                } else if (e.which == 38) {
                    if (parent.is(':first-child')) {
                        self._focusSearch();
                    } else {
                        self._focusResult(parent.index() - 1);
                    }

                    // Press enter
                } else if (e.which == 13) {
                    self._addItem(parent);
                }
            });

            // Add item
            this.results.on('click.searchable', 'li.searcher__result', function () {
                self._addItem($(this));
            });

            // Hover result
            this.results.on('mouseenter.searchable', 'li.searcher__result', function () {
                self._focusResult($(this).index());
            });
        },
        _searchPressReturn: function (q) {
            return;
        },
        _populateResults: function (items) {
            this.results.empty();

            for (var key in items) {
                if (this.itemKeys.indexOf(parseInt(key)) == -1) {
                    var item = this._addResult(key, items[key]);

                    this.results.append(item);
                }
            }
        },
        _hasResults: function () {
            return (this.results.find('li.searcher__result').length > 0);
        },
        _focusResult: function (i) {
            var results = $(this.results).find('li.searcher__result'),
                result = results.eq(i);

            results.removeClass('searcher__result--selected');
            result.addClass('searcher__result--selected');

            result.find('input').focus();
        },
        _focusSearch: function () {
            $(this.results).find('li.searcher__result').removeClass('searcher__result--selected');

            this.search.focus();
        },
        _clearSearch: function () {
            this.results.empty();
            this.search.val('');
        },
        _showResults: function () {
            this.results.removeClass('searcher__results--hidden');
        },
        _hideResults: function () {
            this.results.addClass('searcher__results--hidden');
        },
        _search: function (keywords) {
            var self = this;

            if (!self.searching) {
                axios.post(this.searchurl, {
                    q: keywords,
                    additional: self.additional.val()
                })
                .then(function (response) {
                    self._populateResults(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        _addResult: function (id, data) {
            return $('<li class="searcher__result" data-associateroute="' + data.associate_route + '" data-id="' + data.id + '">' + data.name + '<input class="searcher__result-input" type="text" value="' + data.id + '"></li>');
        },
        _addItem : function (item) {
            var self = this;

            axios.post(item.data('associateroute'), {
                _method: 'put'
            })
            .then(function (response) {
                var data = response.data;

                self.list.find('.subcontents__item--padded').remove();

                var item = $('<div class="subcontents__item"><a href="' + data.edit_route + '">' + data.name + '</a><a class="delete delete-option" href="' + data.dissociate_route + '" data-message="' + data.dissociate_message + '"></a></div>');

                self.list.append(item);

                self.itemKeys.push(data.id);
                console.log(self.itemKeys);

                self._clearSearch();

                self.search.focus();
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    };

    window.Searcher = Searcher;

})(window);
