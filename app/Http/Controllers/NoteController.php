<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    /**
     * @var array
     */
    private $array = ['error' => '', 'result' => []];

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function all()
    {
        $notes = Note::all();

        foreach ($notes as $note) {
            $this->array['result'][] = [
                'id' => $note->id,
                'title' => $note->title
            ];
        }

        return $this->array;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return array
     */
    public function one($id)
    {
        $note = Note::find($id);

        if ($note) {
            $this->array['result'] = $note;
        } else {
            $this->array['error'] = 'ID não encontrado!';
        }

        return $this->array;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $title = $request->input('title');
        $body = $request->input('body');

        if ($title and $body) {

            $note = new Note();
            $note->title = $title;
            $note->body = $body;
            $note->save();

            $this->array['result'] = [
                'id' => $note->id,
                'title' => $note->title,
                'body' => $note->body
            ];

        } else{
            $this->array['error'] = 'Campo não enviados!';
        }

        return $this->array;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function edit(Request $request, $id)
    {

        $title = $request->input('title');
        $body = $request->input('body');

        if ($id and $title and  $body) {

            $note = Note::find($id);

            if ($note) {

                $note->title = $title;
                $note->body = $body;
                $note->save();

                $this->array['result'] = [
                    'id' => $id,
                    'title' => $title,
                    'body' => $body
                ];

            } else {
                $this->array['error'] = 'ID inexistente!';
            }

        } else {
            $this->array['error'] = 'Campos não enviados!';
        }


        return $this->array;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return array
     */
    public function delete($id)
    {
        $note = Note::find($id);

        if ($note) {
            $note->delete();
        } else {
            $this->array['error'] = 'ID inexistente!';
        }

        $note->delete();

        return $this->array;
    }
}
