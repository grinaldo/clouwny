<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Form\Admin\Form;
use App\Model\BaseModel;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Yajra\Datatables\Datatables;

abstract class ResourceController extends Controller
{
    protected $defaultRow = 10;

    /**
     * Model instance
     * @var \App\Model\BaseModel
     */
    protected $model;

    /**
     * BaseForm instance
     * @var \App\Http\Form\Admin\BaseForm
     */
    protected $form;

    /**
     * Custom view prefix
     * @var string
     */
    protected $viewPrefix;

    /**
     * Custom route prefix
     * @var string
     */
    protected $routePrefix;

    /**
     * Custom page name
     * @var string
     */
    protected $pageName;

    /**
     * Rules
     * @var array
     */
    protected $rules = [];

    /**
     * Columns to be rendered as raw
     */
    protected $rawColumns = [
        'published_at', 
        'action',
    ];

    /**
     * Add other columns
     * also add column_name in rawColumn
     * ['column_name', 'column value']
     *
     */
    protected $addColumns = [];

    /**
     * Column Edit
     * ['column_name', 'edit value']
     *
     * @var array
     */
    protected $columnEdit = [];

    /**
     * Eloquent Eager Loading
     * ['relation_name', 'belongs_table_name.*']
     *
     * @var array
     */
    protected $eagerLoad = [];

    /**
     * Custom Form Action Addition 
     *
     * @var  string
     */
    protected $formAddition;

    public function __construct(BaseModel $model)
    {
        $this->model = $model;
        $this->form = app(Form::class);

        view()->share('routePrefix', $this->getRoutePrefix());
        view()->share('viewPrefix', $this->getViewPrefix());
        view()->share('pageName', $this->getPageName());
        view()->share('nav'. $this->getControllerName(), true);
    }

    /**
     * Index
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        return view('admins.'.$this->getViewPrefix().'.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        $rawColumns = $this->rawColumns;
        $modelDatatable = $this->model;

        if (count($this->eagerLoad)) {
            foreach ($this->eagerLoad as $relationship) {
                $modelDatatable = $modelDatatable->with($relationship[0])
                                                 ->select($relationship[1]);
            }
        } else {
            $modelDatatable = $modelDatatable->query();
        }

        $datatable = Datatables::of($modelDatatable)
            ->addColumn('action', function ($model) {
                return '<a href="'.$this->getRoutePrefix().'/'.$model->getUrlKey().'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a><form method="POST" action="'.$this->getRoutePrefix().'/'.$model->getUrlKey().'"><button type="submit" class="btn btn-xs btn-danger" onClick="if (!confirm(\'Are you sure?\')) return false;"><i class="fa fa-trash-o"></i> Delete</button><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="'.csrf_token().'"></form>' . $this->formAddition;
            })
            ->editColumn('id', 'id: {{$id}}')
            ->editColumn('published_at', function ($model) {
                return !empty($model->published_at)?'<span class="label label-success">Published</span>':'<span class="label label-warning">Unpublished</span>';
            });
        if (count($this->columnEdit)) {
            foreach ($this->columnEdit as $column) {
                $datatable->editColumn($column[0], $column[1]);
                $rawColumns[] = $column[0];
            }
        }
        return $datatable->rawColumns($rawColumns)
                         ->removeColumn('password')
                         ->make(true);
    }

    /**
     * Create
     * @return \Illuminate\View\View
     */
    protected function create()
    {
        $this->formData();
        return view('admins.'.$this->getViewPrefix().'.create')
                ->with('model', $this->model);
    }
    /**
     * Store
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    protected function store()
    {
        $this->beforeValidate();
        if (!$this->form->validate()) {
            return redirect()->back();
        }
        $this->afterValidate();

        $this->model = $this->model->newInstance();
        $this->model->fill($this->form->all());

        $this->doSave();

        session()->flash(NOTIF_SUCCESS, 'New '.$this->getControllerName().' information created.');
        return $this->redirectIndex();
    }

    protected function redirectIndex()
    {
        return redirect()->route('backend.'.$this->getRoutePrefix().'.index');
    }

    /**
     * Edit
     * @param  string $key
     * @return \Illuminate\View\View|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function edit($key)
    {
        $this->model = $this->find($key);
        if (empty($this->model)) {
            session()->flash(NOTIF_DANGER, 'Not Found!');
            return $this->redirectIndex();
        }
        $this->formData();

        return view('admins.'.$this->getViewPrefix().'.edit')
                ->with('model', $this->model);
    }

    /**
     * Update
     * @param  string $key
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    protected function update($key)
    {
        $this->model = $this->find($key);

        $this->beforeValidate();
        if (!$this->form->validate()) {
            return redirect()->back();
        }
        $this->afterValidate();

        $this->model->fill($this->form->all());
        $this->doSave();

        session()->flash(NOTIF_SUCCESS, ''.$this->getControllerName().' information Updated.');
        return $this->redirectIndex();
    }

    /**
     * Destory
     * @param  string $key
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    protected function destroy($key)
    {
        $this->model = $this->find($key);

        if (empty($this->model)) {
            session()->flash(NOTIF_DANGER, 'Not Found!');
            return $this->redirectIndex();
        }

        $this->doDelete();
        session()->flash(NOTIF_SUCCESS, ''.$this->getControllerName().' information deleted.');
        return $this->redirectIndex();
    }

    /**
     * Process before validation is being done. Override this method
     * to pass data to baseForm for form requirement,
     * @return void
     */
    protected function beforeValidate()
    {
        $this->formRules();
    }

    protected function formRules()
    {
        $translateRules = [];
        if ($this->model instanceof TranslateModel) {
            $translateFields = $this->model->getTranslateField();
            foreach ($translateFields as $field) {
                if (isset($this->rules[$field])) {
                    $translateRules[$field] = $this->rules[$field];
                    unset($this->rules[$field]);
                }
            }
        }

        $arrayRules = [];
        foreach ($this->rules as $field => $rule) {
            $fieldSegments = explode('.*.', $field);
            if (count($fieldSegments) == 2) {
                $arrayFieldName = $fieldSegments[0];
                $itemFieldName = $fieldSegments[1];
                if (!isset($arrayRules[$arrayFieldName])) {
                    $arrayRules[$arrayFieldName] = [];
                }
                $arrayRules[$arrayFieldName][$itemFieldName] = $rule;
                unset($this->rules[$field]);
            }
        }

        $this->form->setRules($this->rules);
        if (!empty($translateRules)) {
            $this->form->addTranslateRules($translateRules);
        }
        foreach ($arrayRules as $fieldName => $rule) {
            $this->form->addArrayRules($fieldName, $rule);
        }
    }

    /**
     * Process after validation is being done. Override this method
     * for additional process from request input.
     * @return [type] [description]
     */
    protected function afterValidate()
    {

    }

    /**
     * Save Process
     * @return void
     */
    protected function doSave()
    {
        $this->model->save();
    }

    /**
     * Delete Process
     * @return void
     */
    protected function doDelete()
    {
        $this->model->delete();
    }

    /**
     * Get Controller name without 'Controller' postfix
     * @return string
     */
    protected function getControllerName()
    {
        return preg_replace("/(.*)[\\\\](.*)(Controller)/", '$2', get_class($this));
    }

    /**
     * Get View Prefix. By default the value is plurar from and snake case of controller name
     * @return string
     */
    protected function getViewPrefix()
    {
        if (!is_null($this->viewPrefix)) {
            return $this->viewPrefix;
        }

        return str_plural(snake_case($this->getControllerName()));
    }

    /**
     * Get Route Prefix. By default the value is plurar from and snake case of controller name
     * @return string
     */
    protected function getRoutePrefix()
    {
        if (!is_null($this->routePrefix)) {
            return $this->routePrefix;
        }

        return str_plural(snake_case($this->getControllerName(), '-'));
    }

    /**
     * Get Page header for page title.  By default the value is uppercase word and snake case of controller name
     * @return [type] [description]
     */
    protected function getPageName()
    {
        if (!is_null($this->pageName)) {
            return $this->pageName;
        }

        $name = snake_case($this->getControllerName(), '-');
        $name = implode(' ', explode('-', $name));
        return ucwords($name);
    }

    protected function paginateQuery()
    {
        return $this->model->newQuery();
    }

    /**
     * Find operation
     * @param  string $key
     * @return void
     */
    protected function find($key)
    {
        return $this->paginateQuery()->findOrFailByUrlKey($key);
    }

    /**
     * Data which is needed to be used on form view
     * @return void
     */
    protected function formData()
    {
    }

    /**
     * implode specified data into coma-separated string
     * @param  array $data
     * @return string
     */
    protected function implode($attribute)
    {
        return implode(',', $attribute);
    }
}
