<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AntrianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public $status;
    public $message;
    public static $wrap = '';
    public function __construct($status,$message,$resource)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->message = $message;
    }
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'metadata'=>array(
                'code'=>$this->status,
                'message'=>$this->message
            ),
            'response'=>$this->resource
        ];
    }
}
