<?php

namespace App\Services;

use App\Models\Martian;
use App\Models\Supply;

class SupplyService
{
    public function list(string $search)
    {
        return Supply::filterSupply($search)
            ->paginate(15);
    }

    public function findById(int $id): Supply
    {
        return Supply::find($id);
    }

    public function findByName(string $name): Supply
    {
        return Supply::where('name', '=', $name)->firstOrFail();
    }

    public function findMartianSuppliesByName(Martian $martian, string $name): ?Supply
    {
        if (is_null($martian->supplies())) return null;

        return $martian->supplies->firstWhere('name', '=', $name);
    }

    public function create(Martian $martian, array $data = []): Supply
    {
        if ($supply = $this->findMartianSuppliesByName($martian, $data['name'])) {
            $data['quantity'] += $supply->quantity;
            $supply->update($data);
            return $supply;
        }

        return $martian->supplies()->create($data);
    }

    public function update(Supply $supply, array $data = []): Supply
    {
        $supply->update($data);

        return $supply->fresh();
    }

    public function delete(Supply $supply): bool
    {
        if (is_null($supply)) {
            return false;
        }

        return $supply->delete();
    }

    public function insufficientSupply(Martian $martian, array $data): bool
    {
        foreach ($data as $supply) {
            if ($martianSupply = $martian->supplies->firstWhere('name', '=', $supply['supply'])) {
                return $martianSupply->quantity < $supply['quantity'];
            }

            if (is_null($martianSupply)) {
                return true;
            }
        }

        return false;
    }
}
