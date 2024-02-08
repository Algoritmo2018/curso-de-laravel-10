<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Replies\CreateReplyDTO;
use Illuminate\Http\Request;
use App\Services\SupportService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupportRequest;
use App\Services\ReplySupportService;

class ReplySupportController extends Controller
{
    public function __construct(
        protected SupportService $supportService,
        protected ReplySupportService $replyService,
    ) {
    }
    public function index(string $id)
    {

        if (!$support = $this->supportService->findOne($id)) {
            return back();
        }
        $replies = $this->replyService->getAllBySupportId($id);
        return view('admin.supports.replies.replies', compact('support', 'replies'));
    }

    public function store(StoreReplySupportRequest $request){
        $this->replyService->createNew(
            CreateReplyDTO::makeFromRequest($request)
        );

        return redirect()->route('replies.index', $request->support_id)
        ->with('message', 'Cadastrado com sucesso!');
    }
    public function destroy(string $supportId,string $id){
        $this->replyService->delete($id);
        return redirect()->route('replies.index', $supportId)
        ->with('message', 'deletado com sucesso!');
    }
}
