<?php

namespace App\Http\Controllers\API;

use App\Validation\Veevalidate\RulesTranslatorInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Validation\Veevalidate\SimpleRulesTranslator;

class UserController extends Controller
{
    /**
     * @var array validation rules
     */
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index()
    {
        return User::paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules);

        $user = new User();
        $data = $request->all();
        $user->fill($data);
        $user->save();
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @return array
     */
    public function show($id, Request $request)
    {
        $user = User::findOrFail($id);
        if($request->input('rules', false)) {
            return ['data' => $user, 'rules' => $this->rules];
        } else {
            return $user;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->rules);

        $user = User::find($id);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }

    /**
     * Return rules needed for VeeValidate to display errors
     *
     * @param Request $request
     * @return array
     */
    public function validationRules(Request $request)
    {
        if($request->input('action', 'update') === 'store') {
            return array_merge($this->rules, ['password' => 'required']);
        }
        return $this->rules;
    }
}
