<?php

\Form::macro('backendField', function ($for, $label, $input, $classes = '', array $option = []) {
    $error_name = str_replace('[', '.', $for);
    $error_name = str_replace(']', '', $error_name);
    $error = Session::has('error')?Session::get('error')->first($error_name):null;
    $is_error = !empty($error);

    if (isset($option['info'])) {
        $info = $option['info'];
    }

    $result =
        '<div class="form-group' . ($is_error?' has-error':'') . '">'
            . '<label class="control-label col-md-3 col-sm-3 col-xs-12" for="' . generateID($for) . '">' . (!is_null($label)?$label:'') . '</label>
            <div class="col-md-8 col-sm-8 col-xs-12 '.$classes.'">'
              . $input .
              (isset($info)?'<span class="help-block">'.$info.'</span>':'') .
              ($is_error ? '<ul class="parsley-errors-list filled">
                    <li class="parsley-required">'.
                        $error.
                    '</li>
                </ul>' : '') . '
            </div>
        </div>';

    if (isset($option['thumbnail'])) {
        $url = $option['thumbnail'];
        $result .= "
            <div class=\"row\">
                <label class=\"control-label col-md-3 col-sm-3 col-xs-12\"></label>
                <div class=\"col-md-8 col-sm-8 col-xs-12\">
                    <a href=\"$url\" target=\"_blank\" class=\"thumbnail\" style=\"width: 40%\">
                        <img src=\"$url\" alt=\"$url\">
                    </a>
                </div>
            </div>
        ";
    }

    if (isset($option['gmap'])) {
        $containerId = generateID($for) . '-map-canvas';
        $result .= "
            <div class=\"row\">
                <div class=\"col-md-offset-2 col-md-10\">
                  <div id=\"$containerId\" style=\"height:500px;\"> </div>
                </div>
            </div>
        ";
    }
    return $result;
});

\Form::macro('backendSection', function ($label) {
    return "<h3 class=\"form-section\">$label</h3>";
});

\Form::macro('backendText', function ($name, $label, $value = null, $attributes = array()) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control', $attributes);
    addStringToArray('placeholder', "Enter $label", $attributes, true);

    return \Form::backendField($name, $label, \Form::text($name, $value, $attributes), '', $attributes);
});

\Form::macro('backendNumber', function ($name, $label, $value = null, $attributes = array()) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control', $attributes);
    addStringToArray('placeholder', "Enter $label", $attributes, true);

    return \Form::backendField($name, $label, \Form::input('number', $name, $value, $attributes), '', $attributes);
});

Form::macro('backendUrl', function ($name, $label, $value = null, $attributes = []) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control', $attributes);
    addStringToArray('placeholder', "Enter $label", $attributes, true);

    return Form::backendField($name, $label, Form::input('url', $name, $value, $attributes), '', $attributes);
});

Form::macro('backendEmail', function ($name, $label, $value = null, $attributes = []) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control', $attributes);
    addStringToArray('placeholder', "Enter $label", $attributes, true);

    return Form::backendField($name, $label, Form::input('email', $name, $value, $attributes), '', $attributes);
});

\Form::macro('backendTextarea', function ($name, $label, $value = null, $attributes = array()) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control', $attributes);
    addStringToArray('placeholder', "Enter $label", $attributes, true);
    addStringToArray('rows', 5, $attributes, true);

    return \Form::backendField($name, $label, \Form::textarea($name, $value, $attributes), '', $attributes);
});

\Form::macro('backendPassword', function ($name, $label, $attributes = array()) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control', $attributes);
    addStringToArray('placeholder', "Enter $label", $attributes, true);

    return \Form::backendField($name, $label, \Form::password($name, $attributes), '', $attributes);
});

\Form::macro('backendOpen', function (array $attributes = array()) {
    addStringToArray('class', 'form-horizontal', $attributes);
    return \Form::open($attributes);
});

\Form::macro('backendModel', function ($model, array $attributes = array()) {
    addStringToArray('class', 'form-horizontal', $attributes);
    return \Form::model($model, $attributes);
});

\Form::macro('backendSelect', function ($name, $label, $lists = array(), $placeholder = null, $value = null, $attributes = array()) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control select2me', $attributes);
    addStringToArray('data-placeholder', $placeholder, $attributes, true);

    if (!empty($attributes['data-placeholder'])) {
        $lists = ['' => ''] + $lists;
    }

    return \Form::backendField($name, $label, \Form::select($name, $lists, $value, $attributes), '', $attributes);
});

\Form::macro('backendMultiSelect', function ($name, $label, $lists = array(), $placeholder = null, $value = null, $attributes = array()) {
    $attributes['multiple'] = true;
    return \Form::backendSelect($name, $label, $lists, $placeholder, $value, $attributes);
});

\Form::macro('backendTokenField', function ($name, $label, $value = null, $attributes = array()) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control select2tag', $attributes);
    addStringToArray('data-placeholder', isset($attributes['placehoder'])?$attributes['placehoder']:"Enter $label", $attributes, true);

    return \Form::backendField($name, $label, \Form::hidden($name, $value, $attributes), '', $attributes);
});

\Form::macro('backendSubmit', function ($value = null, $name = null, $attributess = array()) {
    addStringToArray('class', 'btn btn-success', $attributes);
    return \Form::input('submit', $name, $value, $attributes);
});

\Form::macro('backendReset', function ($value = null, $attributess = array()) {
    addStringToArray('class', 'btn btn-warning', $attributes);
    return \Form::reset($value, $attributes);
});

\Form::macro('backendFileInput', function ($name, $label) {
    $input = "
            <div class=\"fileinput fileinput-new\" data-provides=\"fileinput\">
                <div class=\"input-group input-large\">
                    <div class=\"form-control uneditable-input span3\" data-trigger=\"fileinput\">
                        <i class=\"fa fa-file fileinput-exists\"></i>&nbsp; <span class=\"fileinput-filename\">
                        </span>
                    </div>
                    <span class=\"input-group-addon btn default btn-file\">
                        <span class=\"fileinput-new\">Select file </span>
                        <span class=\"fileinput-exists\"> Change </span>
                        <input type=\"file\" name=\"$name\">
                    </span>
                    <a href=\"#\" class=\"input-group-addon btn default fileinput-exists\" data-dismiss=\"fileinput\">
                        Remove
                    </a>
                </div>
            </div>
    ";
    return \Form::backendField($name, $label, $input);
});

\Form::macro('backendDate', function ($name, $label, $value = null, $attributes = array()) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control date-picker', $attributes);
    $inputText = \Form::text($name, $value, $attributes);
    $input = "
        <div class=\"input-group date\" data-date-format=\"yyyy-mm-dd\">
            <span class=\"input-group-btn\">
                <button class=\"btn default\" type=\"button\"><i class=\"fa fa-calendar\"></i></button>
            </span>
            $inputText
        </div>
    ";
    return \Form::backendField($name, $label, $input);
});

\Form::macro('backendDateTime', function ($name, $label, $value = null, $attributes = array()) {
    addStringToArray('id', $name, $attributes, true);
    addStringToArray('class', 'form-control  datetime-picker', $attributes);
    $inputText = \Form::text($name, $value, $attributes);
    $input = "
        <div class=\"input-group date datetime-picker\">
            <span class=\"input-group-addon\">
                <span class=\"fa fa-calendar\"></span>
            </span>
            $inputText
        </div>
    ";
    return \Form::backendField($name, $label, $input);
});

\Form::macro('backendFileBrowser', function ($name, $label, $value = null, $attributes = array()) {
    $id = generateID($name);
    addStringToArray('id', $id, $attributes, true);
    addStringToArray('class', 'form-control', $attributes);
    addStringToArray('placeholder', "Browse from server or Enter Url.", $attributes, true);

    $inputText = \Form::text($name, $value, $attributes);
    $input = "
        <div class=\"input-group\">
            <span class=\"input-group-btn popup_selector\" data-inputid=\"$id\" style=\"cursor:pointer;\">
                <button class=\"btn default\" type=\"button\"><i class=\"fa fa-folder-open-o\"></i></button>
            </span>
            $inputText
        </div>
    ";
    $value = \Form::getValueAttribute($name, $value);

    if (!empty($value)) {
        $url = asset($value);
        $attributes['thumbnail'] = $url;
    }
    return \Form::backendField($name, $label, $input, '', $attributes);
});

\Form::macro('backendWysiwyg', function ($name, $label, $value = null, $type = 'basic', $attributes = array()) {
    addStringToArray('class', "editor", $attributes);
    if (!isset($attributes['rows'])) {
        $attributes['rows'] = 15;
    }
    return \Form::backendTextarea($name, $label, $value, $attributes);
});

\Form::macro('backendSingleCheckbox', function ($name, $label, $checked = false, $value = 1, $attributes = array()) {
    addStringToArray('id', generateID($name), $attributes, true);
    addStringToArray('class', 'form-control', $attributes);
    return \Form::backendField($name, $label, \Form::checkbox($name, $value, $checked, $attributes), 'checkbox-inline');
});

\Form::macro('backendMap', function ($name, $label, $value = null, $attributes = array()) {
    $attributes['data-inputid'] = $name;
    $attributes['data-location'] = \Form::getValueAttribute($name, $value);
    $attributes['gmap'] = true;
    addStringToArray('class', 'google-map', $attributes);

    return \Form::backendText($name, $label, $value, $attributes);
});

\Form::macro('backendBack', function ($name = 'Back', $url = null) {
    if (is_null($url)) {
        $url = \URL::previous();
    }
    return "<a href=\"$url\" class=\"btn btn-danger\">$name</a>";
});


if (!function_exists('generateID')) {
    function generateID($name) {
        $id = preg_replace('/(\]\[|\[)/', '_', $name);
        $id = preg_replace('/\]/', '', $id);
        return $id;
    }
}
