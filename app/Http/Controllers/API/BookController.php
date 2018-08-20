<?php

namespace App\Http\Controllers\API;

use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validation\Veevalidate\RulesTranslatorInterface;
use App\Validation\Veevalidate\SimpleRulesTranslator;

class BookController extends Controller
{
    /**
     * @var array validation rules which applies to both: create and update
     */
    protected $rules = [
        'name' => 'required|max:255'
    ];

    /**
     * @var array rules which only applies to new records.
     */
    protected $createRules = [

    ];

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $columns = $request->input('columns', ['*']);

        $query = Book::query();

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            // TODO: replace it with scout compatible solution
            $query = $query->where('name', 'LIKE', "%$filter%");
        }

        if ($request->has('with')) {
            $query = $query->with($request->input('with'));
        }

        return $request->input('paginate', true) ? $query->paginate(20, $columns) : $query->get($columns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(array_merge($this->rules, $this->createRules));

        $book = new Book();
        $data = $request->all();

        $book->fill($data);
        $book->save();
        return $book;
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
        $book = Book::findOrFail($id);
        if ($request->input('rules', false)) {
            $rules = $rulesTranslator->translate($this->rules);
            return ['data' => $book, 'rules' => $rules];
        } else {
            return $book;
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

        $book = Book::find($id);
        $book->update($request->all());
        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();
        return $book;
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
