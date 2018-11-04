// INHERITANCE
var inheritsFrom = function (child, parent) {
    child.prototype = Object.create(parent.prototype);
};

;(function (window) {
    'use strict';

    /**
     * Tags constructor
     */
    function Tags(el, list) {
        this.el = el;
        this.list = list;

        this._init();
    }

    inheritsFrom(Tags, Searcher);

    // Tags prototype
    Tags.prototype._init = function () {
        this.initSearcher();

        this._initEvents();
    }

    Tags.prototype._initEvents = function () {
        var self = this;

        this.list.on('click', '.tag-detach', function (e) {
            e.preventDefault();

            var tag = $(this).closest('.tag-sub'),
                link = $(e.target).attr('href');

            if(tag.hasClass('tag-disabled')) {
                return;
            } else {
                tag.addClass('tag-disabled');
            }

            axios.post(link, {
                _method: 'delete',
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
        return $('<div class="tag-sub control" data-tagid="' + data.id + '"><div class="tags has-addons"><a class="tag is-medium is-link" href="' + data.show_route + '">' + data.name + '</a><a class="tag is-delete is-medium tag-detach" href="' + data.dissociate_route + '"></a></div>');
    }

    // Register tags to window namespace
    window.Tags = Tags;

})(window);
