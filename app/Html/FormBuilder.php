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

        return $this;
    }

    /**
     * Configures the form builder
     *
     * @param ViewErrorBag $errors
     * @param string $form
     * @param $model
     */
    public function configure(ViewErrorBag $errors, $form, $model = null)
    {
        $this->setErrors($errors)->setFields(config('forms.' . $form, []));

        if(!is_null($model))
        {
            $this->setModel($model);
        }
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
            return $this->$htmlBuilder->hidden($name);
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
        if($field['type'] == 'select')
        {
            $input = $this->htmlBuilder->select($name, $field['choices']);

            $html = '<div class="select' . ($this->errors->has($name) ? ' is-danger' : '') . '">' . $input . '</div>';
        } elseif($field['type'] == 'textarea') {
            $input = $this->htmlBuilder->textarea($name);

            $html = $this->errors->has($name) ? $input->class('textarea is-danger') : $input->class('textarea');
        } else {
            $input = $this->htmlBuilder->input($field['type'], $name);

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
        $html = '<button type="submit" class="button is-primary is-action">';

        if(!is_null($icon))
        {
            $html .= '<i class="fa fa-' . $icon . '"></i>&nbsp;&nbsp;';
        }

        return $html . __($text) . '</button>';
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
            (trans()->has('validation.attributes.' . $name) ? __('validation.attributes.' . $name) : ucfirst($name));
    }

}
