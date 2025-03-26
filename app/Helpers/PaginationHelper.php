<?php
 namespace App\Helpers;

use Illuminate\Http\Resources\Json\JsonResource;

 class PaginationHelper {
    public static function formatPaginate($paginateQuery, $resource)
    {
        $data['paginate_data'] = $resource::collection($paginateQuery);
        $data['paginate_links'] = [
            'current_page' => $paginateQuery->currentPage(),
            'last_page' => $paginateQuery->lastPage(),
            'per_page' => $paginateQuery->perPage(),
            'total' => $paginateQuery->total(),
            'next_page_url' => $paginateQuery->nextPageUrl(),
            'prev_page_url' => $paginateQuery->previousPageUrl(),
        ];

        return $data;
    }
 }