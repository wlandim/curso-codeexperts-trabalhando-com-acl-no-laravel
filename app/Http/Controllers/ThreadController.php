<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadRequest;
use App\Models\{Channel, User, Thread};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ThreadController extends Controller
{
    private $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Channel $channel)
    {
        #$this->authorize('threads/index');
/*
        if (Gate::denies('access-index-thread')) {
            return dd('Não tem permissão');
        }
*/
        $channelParam = $request->channel;

        if (null !== $channelParam) {
            $threads = $channel->whereSlug($channelParam)->first()->threads()->paginate(15);
        } else {
            $threads = $this->thread->orderBy('created_at', 'DESC')->paginate(15);
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function create(Channel $channel)
    {
        return view('threads.create', [
            'channels' => $channel->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        try {

            $thread = $request->all();
            $thread['slug'] = Str::slug($thread['title']);

            $user = User::find(1);
            $thread = $user->threads()->create($thread);

            flash('Tópico criado com sucesso')->success();

            return redirect()->route('threads.show', $thread->slug);

        } catch (\Exception $e) {

            $message = env( 'APP_DEBUG') ? $e->getMessage() : 'Houve um erro ao criar o tópico.';
            flash($message)->warning();

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $thread = $this->thread->whereSlug($slug)->first();

        if(!$thread) return redirect()->route('threads.index');

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $thread = $this->thread->whereSlug($slug)->first();
        $this->authorize('update', $thread);

        return view('threads.edit', compact('thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ThreadRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ThreadRequest $request, $slug)
    {
        try {

            $thread = $this->thread->whereSlug($slug)->first();
            $thread->update($request->all());

            flash('Tópico atualizado com sucesso')->success();

            return redirect()->route('threads.show', $thread->slug);

        } catch (\Exception $e) {

            $message = env('APP_DEBUG') ? $e->getMessage() : 'Houve um erro ao atualizar o tópico.';
            flash($message)->warning();

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        try {

            $thread = $this->thread->whereSlug($slug)->first();
            $thread->delete();

            flash('Tópico removido com sucesso')->success();

            return redirect()->route('threads.index');

        } catch (\Exception $e) {

            $message = env('APP_DEBUG') ? $e->getMessage() : 'Houve um erro ao remover o tópico.';
            flash($message)->warning();

            return redirect()->back();
        }
    }
}
