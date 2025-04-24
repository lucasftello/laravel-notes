<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;


class NoteController extends Controller
{
    public function index()
    {
        $user_id = session('user.id');

        $notes = User::find($user_id)
            ->notes()
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        return view('notes', [
            'notes' => $notes,
        ]);
    }

    public function createNote()
    {
        return view('create-note');
    }

    public function handleCreateNote(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|min:3|max:255',
                'content' => 'required|min:3|max:3000',
            ],
            [
                'title.required' => 'O título é obrigatório.',
                'title.min' => 'O título deve ter pelo menos :min caracteres.',
                'title.max' => 'O título deve ter no máximo :max caracteres.',
                'content.required' => 'O conteúdo é obrigatório.',
                'content.min' => 'O conteúdo deve ter pelo menos :min caracteres.',
                'content.max' => 'O conteúdo deve ter no máximo :max caracteres.',
            ]
        );

        $user_id = session('user.id');

        $note = new Note();
        $note->user_id = $user_id;
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();

        return redirect()->route('notes');
    }

    public function editNote($note_id)
    {
        $note_id = Operations::decryptId($note_id);

        if ($note_id == null) {
            return redirect()->route('notes');
        }

        $note = Note::find($note_id);

        return view('edit-note', [
            'note' => $note,
        ]);
    }

    public function handleEditNote(Request $request, $note_id)
    {
        $request->validate(
            [
                'title' => 'required|min:3|max:255',
                'content' => 'required|min:3|max:3000',
            ],
            [
                'title.required' => 'O título é obrigatório.',
                'title.min' => 'O título deve ter pelo menos :min caracteres.',
                'title.max' => 'O título deve ter no máximo :max caracteres.',
                'content.required' => 'O conteúdo é obrigatório.',
                'content.min' => 'O conteúdo deve ter pelo menos :min caracteres.',
                'content.max' => 'O conteúdo deve ter no máximo :max caracteres.',
            ]
        );

        $note_id = Operations::decryptId($note_id);

        if ($note_id == null) {
            return redirect()->route('notes');
        }

        $note = Note::find($note_id);
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();

        return redirect()->route('notes');
    }

    public function deleteNote($note_id)
    {
        $note_id = Operations::decryptId($note_id);

        if ($note_id == null) {
            return redirect()->route('notes');
        }

        $note = Note::find($note_id);

        return view('delete-note', [
            'note' => $note,
        ]);
    }

    public function handleDeleteNote($note_id)
    {
        $note_id = Operations::decryptId($note_id);

        if ($note_id == null) {
            return redirect()->route('notes');
        }

        $note = Note::find($note_id);
        $note->delete();

        // If you want to permanently delete the note instead of soft deleting it, use the following line:
        // $note->forceDelete();

        return redirect()->route('notes');
    }
}
