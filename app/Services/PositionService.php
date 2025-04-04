<?php

namespace App\Services;

use App\Http\Resources\PositionResource;
use App\Repositories\PositionRepository;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Collection;

class PositionService
{
    protected PositionRepository $positionRepository;

    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function list()
    {
        return PositionResource::collection($this->positionRepository->getAll());
    }
}
