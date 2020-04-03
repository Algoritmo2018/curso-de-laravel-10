<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateSupport;
use App\Models\Support;
use Illuminate\Http\Request;
use App\DTO\CreateSupportDTO;
use App\DTO\UpdateSupportDTO;
use GuzzleHttp\Promise\Create;
use App\Services\SupportService;

class SupportController extends Controller
{

    public function __construct(
        protected SupportService $service
    ) {}


    public function index(Request $request)
    {
        $supports = $this->service->getAll($request->filter);

        dd($supports);

        return view('admin/supports/index', compact('supports'));
    }

    public function show(int|string $id)
    {
        // Support::find($id)
        // Support::where('id', $id)->first();
        // Support::where('id', '!=', $id)->first()
        if (!$support = $this->service->findOne($id)) {
            return back();
        }

        return view('admin/supports/show', compact('support'));
    }



    public function create()
    {

        return view('admin/supports/create');
    }

    public function store(StoreUpdateSupport $request, Support $support)
    {
        $this->service->new(CreateSupportDTO::makeFromRequest($request));


        return redirect()->route('supports.index');
    }

    public function edit(string $id)
    {
        // if (!$support = $support->where('id', $id)->first())
        if (!$support = $this->service->findOne($id)) {
            return back();
        }

        return view('admin/supports.edit', compact('support'));
    }

    public function update(StoreUpdateSupport $request, Support $support, string $id)
    {

        $support = $this->service->update(
            UpdateSupportDTO::makeFromRequest($request),
        );

        if (!$support) {
            return back();
        }

        return redirect()->route('supports.index');
    }

    public function destroy(string $id)
    {
      $this->service->delete($id);

      $support->delete();

        return redirect()->route('supports.index');

    }
}
