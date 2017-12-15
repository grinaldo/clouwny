<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\User as Model;
use Yajra\Datatables\Datatables;

class DatatablesController extends Controller
{
    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        return view('datatables.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        // return Datatables::of(Model::query())->make(true);
        // $models = Model::select(['id', 'name', 'email', 'password', 'created_at', 'updated_at']);

        return Datatables::of(Model::query())
            ->addColumn('action', function ($model) {
                return '<a href="'.$model->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->removeColumn('password')
            ->make(true);
    }
}