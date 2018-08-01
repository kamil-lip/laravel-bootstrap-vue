<?php

namespace App\Http\Controllers\API;

use App\Validation\Veevalidate\SimpleRulesTranslator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Validation\Veevalidate\RulesTranslatorInterface;

class UserController extends Controller
{
    /**
     * @var array validation rules which applies to both: create and update
     */
    protected $rules = [
        'name' => 'required|min:5',
        'email' => 'required|email'
    ];

    /**
     * @var array rules which only applies to new records.
     */
    protected $createRules = [
        'password' => 'required|min:8'
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->rules['email'] .= '|unique:users';

        $request->validate(array_merge($this->rules, $this->createRules));

        $user = new User();
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user->fill($data);
        $user->save();
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @param Request $request
     * @param SimpleRulesTranslator $rulesTranslator
     * @return array
     */
    public function show($id, Request $request, SimpleRulesTranslator $rulesTranslator)
    {
        $user = User::findOrFail($id);
        if ($request->input('rules', false)) {
            $rules = $rulesTranslator->translate($this->rules);
            return ['data' => $user, 'rules' => $rules];
        } else {
            return $user;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
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
     * @param  int $id
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
     * @param SimpleRulesTranslator $rulesTranslator
     * @return \App\Validation\Veevalidate\Array
     */
    public function validationRules(Request $request, SimpleRulesTranslator $rulesTranslator)
    {
        if ($request->input('action', 'update') === 'create') {
            $rules = array_merge($this->rules, $this->createRules);
        } else {
            $rules = $this->rules;
        }
        return $rulesTranslator->translate($rules);
    }
}
