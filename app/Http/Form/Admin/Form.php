<?php
namespace App\Http\Form\Admin;

use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Http\Request;
use Illuminate\Session\Store as Session;

class Form
{

    /**
     * error messages
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Application request
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Validator instance to be used for validating input
     * @var \Illuminate\Contracts\Validation\Factory
     */
    protected $validator;

    /**
     * Session implementation
     * @var \Illuminate\Session\Store
     */
    protected $session;

    /**
     * Rules definition
     * @var array
     */
    protected $rules= [];

    /**
     * Custom error messages definition
     * @var array
     */
    protected $errorMessages = [];

    /**
     * Custom attribute names definition
     * @var array
     */
    protected $attributeNames = [];

    /**
     * Create new Form
     * @param \Illuminate\Http\Request   $request
     * @param \Illuminate\Contracts\Validation\Factory $validator
     * @param \Illuminate\Session\Store   $session
     */
    public function __construct(Request $request, Validator $validator, Session $session)
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->session = $session;
    }

    /**
     * Set rules attribute
     * @param array $rules
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Append translation rules
     * @param array $rules
     */
    public function addTranslateRules(array $rules)
    {
        $additionalRules = [];
        foreach (array_keys(suitLangs()) as $lang) {
            $additionalRules[$lang] = 'required|array';
            foreach ($rules as $key => $rule) {
                $additionalRules["{$lang}.{$key}"] = $rule;
            }
        }
        $this->rules += $additionalRules;
    }

    /**
     * Append rules for $inputName child
     * @param string $inputName
     * @param array $rules
     */
    public function addArrayRules($inputName, array $rules)
    {
        $additionalRules = [];
        $inputNames = $this->get($inputName, []);
        if (is_array($inputNames)) {
            foreach (array_keys($inputNames) as $key) {
                foreach ($rules as $ruleKey => $rule) {
                    $additionalRules["$inputName.$key.$ruleKey"] = $rule;
                }
            }
        }
        $this->rules += $additionalRules;
    }

    /**
     * Custom error messages definition
     * @return array
     */
    public function setErrorMessages(array $messages)
    {
        $this->errorMessages = $messages;
    }

    /**
     * Custom attribute name for error message
     * @return array
     */
    public function setAttributeNames(array $attributes)
    {
        $this->attributeNames = $attributes;
    }

    /**
     * Get all input
     * @return array
     */
    public function all()
    {
        return array_only($this->request->all(), array_keys($this->rules()));
    }

    /**
     * Get certain input
     * @return array
     */
    public function input($args)
    {
        return $this->request->input($args);
    }

    /**
     * Get error messages
     * @return \Illuminate\Support\MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Do validation
     * @return boolean
     */
    public function validate()
    {
        $validator = $this->validator->make($this->all(), $this->rules(), $this->errorMessages, $this->attributeNames);
        if ($validator->passes()) {
            return true;
        }
        $this->session->flash('error', $validator->errors());
        $this->session->flash(NOTIF_WARNING, $validator->errors()->first());
        $this->session->flashInput($this->request->input());
        $this->errors = $validator->errors();
        return false;
    }

    /**
     * Rules which are applied on this class
     * @return array
     */
    protected function rules()
    {
        return $this->rules;
    }

    /**
     * filter input using defined closure on input keys
     * @param  string|closure$closure
     * @param  array  $keys
     * @return \App\Http\Form\Admin\BaseForm
     */
    public function filterInput($closure, array $keys)
    {
        $this->merge(array_map($closure, $this->only($keys)));
        return $this;
    }

    /**
     * implode specified object attribute name into coma-separated string
     * @param  string $attribute
     * @return string
     */
    protected function implode($attribute)
    {
        if (!is_array($this->$attribute)) {
            throw new \Exception("Attribute $attribute cannot be implode because not an array.");
        }
        return implode(',', $this->$attribute);
    }

    public function __get($key)
    {
        $this->request->input($key);
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->request, $method], $parameters);
    }
}
