<?php

namespace App\Http\Controllers;

abstract class Controller
{
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


    protected function setLink($model, string $modelId, string $relationship, string $id, bool $link)
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
                $instance->{$relationship}()->attach([
                    $id => ['created_at' => now(), 'updated_at' => now(),]
                ]);
            }
            catch (\Exception $e)
            {
                return $this->getError($e, "Failed to create link with {$relationship}", 500);
            }
        }
        else {
            $instance->{$relationship}()->detach($id);
        }

        return $this->getSuccess($instance, "Link on {$relationship} deleted successfully", 200);
    }
}
