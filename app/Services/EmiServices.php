<?php

namespace App\Services;

use App\Repositories\EmiRepositoryInterface;

class EmiServices
{
    public function __construct(
        protected EmiRepositoryInterface $emiRepository
    ) {
    }

    public function all()
    {
        return $this->emiRepository->all();
    }

    public function emidetails()
    {
        return $this->emiRepository->emidetails();
    }

}

?>