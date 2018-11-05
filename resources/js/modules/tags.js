// INHERITANCE
var inheritsFrom = function (child, parent) {
    child.prototype = Object.create(parent.prototype);
};

;(function (window) {
    'use strict';

    /**
     * Tags constructor
     */
    function Tags(el, list, passive, passiveField) {
        this.el = el;
        this.list = list;
        this.isPassive = passive;
        this.passiveField = passiveField;

        this._init();
    }

    inheritsFrom(Tags, Searcher);

    // Tags prototype
    Tags.prototype._init = function () {
        this.initSearcher();

        if(this.isPassive) {
            this._regenerateValue();
            this.additional = '{"passive": true}';
        }

        this._initEvents();
    }

    Tags.prototype._initEvents = function () {
        var self = this;

        this.list.on('click', '.tag-detach', function (e) {
            e.preventDefault();

            var tag = $(this).closest('.tag-sub'),
                link = $(e.target).attr('href'),
                id = $(this).parent().parent().data('tagid');

            if(tag.hasClass('tag-disabled')) {
                return;
            } else {
                tag.addClass('tag-disabled');
            }

            var i = self.itemKeys.indexOf(id);
            delete self.itemKeys[i];

            if(self.isPassive) {
                tag.remove();

                self._regenerateValue();

                return;
            }

            axios.post(link, {
                _method: 'delete'
            })
            .then(function (response) {
                if(response.data.success) {
                    tag.remove();
                }

                if(self.list.find('.tag-sub.control').length == 0) {
                    self.list.find('.subcontents__item--padded').show();
                }
            })
            .catch(function (error) {
                tag.removeClass('tag-disabled');
                console.log(error);
            });
        });
    }

    Tags.prototype._createItem = function (data) {
        if(this.isPassive) {
            return $('<div class="tag-sub control" data-tagid="' + data.id + '"><div class="tags has-addons"><span class="tag is-medium is-primary">' + data.name + '</span><a class="tag is-delete is-medium tag-detach" href="#"></a></div>');
        } else {
            return $('<div class="tag-sub control" data-tagid="' + data.id + '"><div class="tags has-addons"><a class="tag is-medium is-link" href="' + data.show_route + '">' + data.name + '</a><a class="tag is-delete is-medium tag-detach" href="' + data.dissociate_route + '"></a></div>');
        }
    }

    Tags.prototype._addItem = function (item) {
        var self = this;

        if(self.isPassive) {
            var data = {id: item.data('id'), name: item.text()};

            self.list.find('.subcontents__item--padded').hide();

            var item = self._createItem(data);

            self.list.append(item);

            self.itemKeys.push(data.id);

            self._regenerateValue();

            self._clearSearch();

            self.search.focus();
        } else {
            axios.post(item.data('associateroute'), {
                _method: 'put',
                additional: self.additional
            })
            .then(function (response) {
                var data = response.data;

                self.list.find('.subcontents__item--padded').hide();

                var item = self._createItem(data);

                self.list.append(item);

                self.itemKeys.push(data.id);

                self._clearSearch();

                self.search.focus();
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }

    Tags.prototype._regenerateValue = function () {
        this.passiveField.val(JSON.stringify(this.itemKeys));
    }

    // Register tags to window namespace
    window.Tags = Tags;

})(window);
