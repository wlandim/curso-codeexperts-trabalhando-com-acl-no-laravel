<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ReplyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyRequest $request)
    {
        try {

            $reply = $request->all();
            $reply['user_id'] = 1;

            $thread = Thread::find($request->thread_id);
            $thread->replies()->create($reply);

            flash('Resposta criada com sucesso.')->success();

            return redirect()->back();

        } catch (\Exception $e) {

            $message = env('APP_DEBUG') ? $e->getMessage() : 'Houve um erro ao criar a resposta.';
            flash($message)->warning();

            return redirect()->back();

        }
    }
}
