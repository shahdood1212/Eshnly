<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ShipFilter
{
    protected $request;
    protected $query;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($query)
    {
        $this->query = $query;

        $this->filterByFrom()
            ->filterByTo()
            ->filterByStatus()
            ->filterByCreatedBy()
            ->filterByTripId();

        return $this->query;
    }

    protected function filterByFrom()
    {
        if ($this->request->filled('from')) {
            $this->query->where('from', 'LIKE', '%' . $this->request->input('from') . '%');
        }
        return $this;
    }

    protected function filterByTo()
    {
        if ($this->request->filled('to')) {
            $this->query->where('to', 'LIKE', '%' . $this->request->input('to') . '%');
        }
        return $this;
    }

    protected function filterByStatus()
    {
        if ($this->request->filled('status')) {
            $this->query->where('status', $this->request->input('status'));
        }
        return $this;
    }

    protected function filterByCreatedBy()
    {
        if ($this->request->filled('created_by')) {
            $this->query->where('created_by', $this->request->input('created_by'));
        }
        return $this;
    }

    protected function filterByTripId()
    {
        if ($this->request->filled('trip_id')) {
            $this->query->where('trip_id', $this->request->input('trip_id'));
        }
        return $this;
    }
}
