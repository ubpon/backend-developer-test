<?php

namespace App\Http\Controllers;

use App\Http\Requests\MartianCreateRequest;
use App\Http\Requests\MartianUpdateRequest;
use App\Http\Resources\MartianResource;
use App\Http\Resources\SupplyResource;
use App\Models\Martian;
use App\Models\Supply;
use App\Services\MartianService;
use Illuminate\Http\Request;

class MartianController extends Controller
{
    private MartianService $martianService;

    public function __construct(MartianService $martianService)
    {
        $this->martianService = $martianService;
    }

    public function index(Request $request)
    {
        return $this->martianService->list($request->input('filter') ?? '');
    }

    public function store(MartianCreateRequest $request): MartianResource
    {
        return new MartianResource(
            $this->martianService->create($request->validated())
        );
    }

    public function update(MartianUpdateRequest $request, Martian $martian)
    {
        return new MartianResource(
            $this->martianService->update($martian, $request->validated())
        );
    }

    public function show(Martian $martian): MartianResource
    {
        return new MartianResource($martian);
    }

    public function destroy(Martian $martian)
    {
        if ($this->martianService->delete($martian)) {
            return response()->noContent();
        }

        return response()->json(['data' => 'Martian not found.'], 404);
    }

    public function showMartianSupply(int $id)
    {
        $supplies = Supply::where('martian_id', $id)->get();

        return SupplyResource::collection($supplies);
    }
}
