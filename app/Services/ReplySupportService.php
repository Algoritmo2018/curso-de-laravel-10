<?php

namespace App\Services;

use stdClass;
use App\DTO\Replies\CreateReplyDTO;
use App\Events\SupportReplied;
use Illuminate\Support\Facades\Gate;
use App\Repositories\Contracts\ReplyRepositoryInterface;

class ReplySupportService
{

    public function __construct(
        protected ReplyRepositoryInterface $repository,
    ) {
    }

    public function getAllBySupportId(string $supportId): array
    {
        return $this->repository->getAllBySupportId($supportId);
    }

    public function createNew(CreateReplyDTO $dto): stdClass
    {

        $reply = $this->repository->createNew($dto);

        SupportReplied::dispatch($reply);

        return $reply;
    }


    public function delete(string $id): bool
    {

        return $this->repository->delete($id);
    }
}
