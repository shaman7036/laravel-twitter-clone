<?php

namespace App\Repositories;

abstract class AbstractRepository
{
    protected $model = '';

    /**
     * create a new row or toggle the activity of the existed row
     *
     * @param array $where
     * @return bool $isActive
     */
    public function createOrToggleActivity($where)
    {
        // search the row including the soft deleted one
        $row = $this->model::withTrashed()
            ->where($where)->first();
        $isActive = false;

        if (!isset($row)) {
            // create a new row if not existed
            $this->model::create($where);
            $isActive = true;
        } else {
            if ($row->deleted_at) {
                // active the row with saving
                $row->deleted_at = null;
                $row->save();
                $isActive = true;
            } else {
                // inactive the row with soft deleting
                $row->delete();
                $isActive = false;
            }
        }

        return $isActive;
    }
}
