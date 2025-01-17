<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


abstract class Controller
{
    use AuthorizesRequests;


    protected function getError($e, string $message, int $code)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error' => $e->getMessage(),
        ], $code);
    }

    protected function getSuccess($data, string $message, int $code)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }


    protected function setLink($model, string $modelId, string $relationship, $ids, bool $link)
    {
        try
        {
            $instance = app($model)::findOrFail($modelId);
        }
        catch (\Exception $e)
        {
            return $this->getError($e, "{$model} not found", 404);
        }

        if ($link) {
            try
            {
                foreach ($ids as $id)
                {
                    $instance->{$relationship}()->attach([
                        $id => ['created_at' => now(), 'updated_at' => now(),]
                    ]);
                }
            }
            catch (\Exception $e)
            {
                return $this->getError($e, "Failed to create link with {$relationship}", 500);
            }
        }
        else {
            foreach ($ids as $id)
            {
                $instance->{$relationship}()->detach($id);
            }
        }

        return $this->getSuccess($instance, "Link on {$relationship} " . ($link ? 'created' : 'deleted') . " successfully", 200);
    }
}
