<?php

function resource_options_menu($resource, $key)
{
    return '<td class="is-narrow">
        <div class="dropdown is-right is-hoverable">
            <div class="dropdown-trigger">
                <button class="button" aria-haspopup="true" aria-controls="dropdown-menu-' . $key . '">
                    <span class="icon is-small"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="dropdown-menu" id="dropdown-menu-' . $key . '" role="menu">
                <div class="dropdown-content">
                    <div class="dropdown-head">' . uppercase(__('general.options')) . '</div>
                    <a class="dropdown-item" href="' . route('bookkeeper.' . $resource . '.edit', $key) . '">
                        <i class="icon fa fa-edit" aria-hidden="true"></i>' . __($resource . '.edit') . '</a>
                    <a class="dropdown-item delete-option has-text-danger" href="' . route('bookkeeper.' . $resource . '.destroy', $key) . '">
                        <i class="icon fa fa-trash" aria-hidden="true"></i>' . __($resource . '.destroy') . '</a>
                </div>
            </div>
        </div>
    </td>';
}
