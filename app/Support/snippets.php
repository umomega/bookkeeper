<?php

function resource_options_menu($resource, $key, $parent = null)
{
    $routeParams = is_null($parent) ? $key : [$parent, $key];

    return options_menu_open($key) .
        '<a class="dropdown-item" href="' . route('bookkeeper.' . $resource . '.edit', $routeParams) . '">
            <i class="icon fa fa-edit" aria-hidden="true"></i>' . __($resource . '.edit') . '</a>' .
            delete_option(route('bookkeeper.' . $resource . '.destroy', $routeParams), $resource . '.destroy') .
        options_menu_close();
}

function options_menu_open($key)
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
                    <div class="dropdown-head">' . uppercase(__('general.options')) . '</div>';
}

function options_menu_close()
{
    return '</div></div></div></td>';
}

function delete_option($route, $text, $icon = 'trash', $message = null)
{
    return '<a class="dropdown-item delete-option has-text-danger" data-message="' . __($message ?: 'general.confirm_delete') . '" href="' . $route . '">
        <i class="icon fa fa-' . $icon . '" aria-hidden="true"></i>' . __($text) . '</a>';
}

function no_results_row($text)
{
    return '<tr>
        <td colspan="42" class="contents__message has-text-centered">
            <p class="is-size-5">' . __($text) . '</p>
        </td>
    </tr>';
}
