<?php

namespace Bookkeeper\Html;

use Spatie\Html\Html;
use Illuminate\Support\ViewErrorBag;

class FormBuilder {

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var Html
     */
    protected $htmlBuilder = null;

    /**
     * @var ViewErrorBag
     */
    protected $errors = null;

    /**
     * @var \ArrayAccess|array
     */
    protected $model;

    /**
     * Constructor
     *
     * @param Html $fields
     */
    public function __construct(Html $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
    }

    /**
     * Setter for fields
     *
     * @param array $fields
     * @return self
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Setter for Model
     *
     * @param $model
     * @return self
     */
    public function setModel($model)
    {
        $this->htmlBuilder->model($model);
        $this->model = $model;

        return $this;
    }

    /**
     * Configures the form builder
     *
     * @param ViewErrorBag $errors
     * @param string $form
     * @param $model
     * @return self
     */
    public function configure(ViewErrorBag $errors, $form, $model = null)
    {
        $this->setErrors($errors)->setFields(config('forms.' . $form, []));

        if(!is_null($model))
        {
            $this->setModel($model);
        }

        return $this;
    }

    /**
     * Setter for field configuration
     *
     * @param string $key
     * @param mixed $value
     * @param return self
     */
    public function setFieldConfiguration($key, $value)
    {
        array_set($this->fields, $key, $value);

        return $this;
    }

    /**
     * Setter for errors
     *
     * @param ViewErrorBag $errors
     * @return self
     */
    public function setErrors(ViewErrorBag $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Builds the form fields
     *
     * @return string
     */
    public function build()
    {
        $html = '';

        foreach($this->fields as $name => $field)
        {
            $html .= ($field['type'] == 'separator' ?
                $this->buildSeparator($name, $field) :
                $this->buildField($name));
        }

        return $html;
    }

    /**
     * Builds a field seperator
     *
     * @param string $name
     * @param array $field
     * @return string
     */
    public function buildSeparator($name, array $field)
    {
        return '<h3 class="form-separator"><span class="form-separator__inner">' . $this->translateLabel($name, $field) . '</span></h3>';
    }

    /**
     * Builds a field with given configuration
     *
     * @param string $name
     * @return string
     */
    public function buildField($name)
    {
        $field = $this->fields[$name];

        // Hidden fields
        if($field['type'] == 'hidden')
        {
            return $this->htmlBuilder->hidden($name);
        }

        return $this->buildFieldStart($name, $field) . $this->buildFieldInput($name, $field) . $this->buildFieldEnd($name, $field);
    }

    /**
     * Builds the start of a field
     *
     * @param string $name
     * @param array $field
     * @return string
     */
    public function buildFieldStart($name, array $field)
    {
        $label = $this->translateLabel($name, $field);

        return '<div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label" for="' . $name . '">' . $label . '</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control' .
                    (array_key_exists('icon', $field) ? ' has-icons-left' : '') .
                    (($field['type'] == 'password' && array_key_exists('meter', $field) && $field['meter']) ? ' control--password' : '') .
                    '">';
    }

    /**
     * Builds the input of a field
     *
     * @param string $name
     * @param array $field
     * @return string
     */
    public function buildFieldInput($name, array $field)
    {
        $builder = $this->htmlBuilder;
        $value = isset($field['default']) ? $field['default'] : null;

        switch ($field['type']) {
            case 'select':
                $input = $builder->select($name, $field['choices'], $value);
                $html = '<div class="select' . ($this->errors->has($name) ? ' is-danger' : '') . '">' . $input . '</div>';
                break;

            case 'textarea':
                $input = $builder->textarea($name, $value);
                $html = $this->errors->has($name) ? $input->class('textarea is-danger') : $input->class('textarea');
                break;

            case 'amount':
                $input = $builder->text('_' . $name . 'Placeholder');
                $input = $this->errors->has($name) ? $input->class('input is-danger amount-field__input') : $input->class('input amount-field__input');
                $html = '<div class="amount-field" id="amountField' . studly_case($name) . '">' . $builder->text($name, 0)->class('amount-field__value')->attribute('autocomplete', 'off') . $input . '<span class="amount-field__currency"></span></div>';
                break;

            case 'checkbox':
                $checked = (isset($field['checked']) && $field['checked']);
                $html = '<label class="checkbox"><input name="' . $name . '" type="hidden" value="0">' . $builder->checkbox($name, $checked) . ' ' . __('general.yes') . '</label>';
                break;

            case 'datetime':
                $input = $builder->text($name, $value);
                $html = $this->errors->has($name) ? $input->class('input datetime is-danger') : $input->class('input datetime');
                break;

            case 'file':
                $html = '<div class="file is-primary has-name is-fullwidth">
                    <label class="file-label">
                        <input class="file-input" type="file" name="' . $name . '">
                        <span class="file-cta">
                            <span class="file-icon"><i class="fa fa-upload"></i></span>
                            <span class="file-label">' . __('general.choose_a_file') . '...</span>
                        </span>
                        <span class="file-name"></span>
                    </label>
                </div>';

                if(!is_null($this->model) && $info = json_decode($this->model->{$name}))
                {
                    $html .= '<div class="file-links level">
                        <div class="level-left"><a href="' . $this->model->{camel_case($name) . 'DownloadLink'} . '"><i class="fa fa-download"></i> ' . $info->name . '</a></div>
                        <div class="level-right"><a class="has-text-danger delete-option" data-message="' . __('general.confirm_delete') . '" href="' . $this->model->{camel_case($name) . 'DeleteLink'} . '">' . __('general.delete') . ' <i class="fa fa-trash"></i></a></div>
                    </div>';
                }
                break;

            case 'relation':
                $html = '<div class="relation" data-searchurl="' . route($field['search']) . '">
                    <div class="subcontents">' .
                        ((!is_null($this->model) && !is_null($this->model->{$name})) ? '<div class="subcontents__item subcontents__item--form">' . $this->model->{$field['relation_key']}->name . '<a href="#" class="delete relation-detach"></a></div>' : '') .
                    '</div>
                    <div class="searcher">' .
                        $builder->hidden($name)->class('relation-input') . '
                        <input type="hidden" name="_exclude" value="' . ((!is_null($this->model) && !is_null($this->model->{$name})) ? json_encode([$this->model->{$name}]) : '') . '">
                        <input type="hidden" name="_additional" value="">
                        <input type="text" name="_searcher" autocomplete="off" placeholder="' . __('general.search') . '" class="input">

                        <ul class="searcher__results"></ul>
                    </div>
                </div>';
                break;

            default:
                $input = $builder->input($field['type'], $name, $value);
                $html = $this->errors->has($name) ? $input->class('input is-danger') : $input->class('input');
        }

        if(array_key_exists('icon', $field))
        {
            $html .= '<span class="icon is-small is-left"><i class="fa fa-' . $field['icon'] . '"></i></span>';
        }

        return $html;
    }

    /**
     * Builds the end of a field
     *
     * @param string $name
     * @param array $field
     * @return string
     */
    public function buildFieldEnd($name, array $field)
    {
        $hint = '';

        if($field['type'] == 'password' && array_key_exists('meter', $field) && $field['type'])
        {
            $hint .= '<div class="password-meter"><div class="password-meter__inner"> </div></div>';
        }

        $hint .= '</div>';

        if($this->errors->has($name))
        {
            $hint .= '<p class="help is-danger">';

            foreach($this->errors->get($name) as $error) {
                $hint .= $error . '<br>';
            }

            $hint .= '</p>';
        }
        elseif(array_key_exists('hint', $field))
        {
            $hint .= '<p class="help">' . (trans()->has($field['hint']) ? __($field['hint']) : (trans()->has('hints.' . $field['hint']) ? __('hints.' . $field['hint']) : $field['hint'])) . '</p>';
        }

        return $hint . '</div></div></div>';
    }

    /**
     * Builds a submit button
     *
     * @param string $text
     * @param string $icon
     * @return string
     */
    public function buildSubmitButton($text, $icon = null)
    {
        $html = '<button type="submit" class="button is-primary is-overlay">';

        if(!is_null($icon))
        {
            $html .= '<i class="fa fa-' . $icon . '"></i>&nbsp;&nbsp;<span>';
        }

        return $html . __($text) . '</span></button>';
    }

    /**
     * Returns a label translated
     *
     * @param string $name
     * @param array $field
     * @return string
     */
    public function translateLabel($name, array $field)
    {
        return array_key_exists('label', $field) ?
            (trans()->has($field['label']) ? __($field['label']) : $field['label']) :
            (trans()->has('validation.attributes.' . $name) ? __('validation.attributes.' . $name) : str_replace('_', ' ', title_case($name)));
    }

}
