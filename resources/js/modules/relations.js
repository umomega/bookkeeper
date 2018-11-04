// INHERITANCE
var inheritsFrom = function (child, parent) {
    child.prototype = Object.create(parent.prototype);
};

;(function (window) {
    'use strict';

    /**
     * Relation constructor
     */
    function Relation(el) {
        this.el = el;
        this.list = el.find('.subcontents').first();
        this.input = el.find('input.relation-input').first();

        this._init();
    }

    inheritsFrom(Relation, Searcher);

    // Tags prototype
    Relation.prototype._init = function () {
        this.initSearcher();

        this._initEvents();
    }

    Relation.prototype._initEvents = function () {
        var self = this;

        this.list.on('click', '.relation-detach', function (e) {
            e.preventDefault();

            var relation = $(this).closest('.subcontents__item');
            relation.remove();

            self.itemKeys = [];

            self.input.val('');
        });
    }

    Relation.prototype._extractItems = function () {
        var value = this.input.val().trim();

        if (value == '') {
            return;
        }

        this.itemKeys.push(value);
    }

    Relation.prototype._addResult = function (id, data) {
        return $('<li class="searcher__result searcher__result--compact" data-id="' + data.id + '">' + data.name + '<input class="searcher__result-input" type="text" value="' + data.id + '"></li>');
    }

    Relation.prototype._addItem = function (item) {
        var id = item.data('id'),
            name = item.text();

        this.itemKeys = [id];

        this.input.val(id);

        var item = this._createItem({id: id, name: name});

        this.list.empty();

        this.list.append(item);

        this._clearSearch();

        this.search.focus();
    }

    Relation.prototype._createItem = function (data) {
        return $('<div class="subcontents__item subcontents__item--form">' + data.name + '<a href="#" class="delete relation-detach"></a></div>');
    }

    // Register tags to window namespace
    window.Relation = Relation;

})(window);
