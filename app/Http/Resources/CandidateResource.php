<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'summary' => $this->summary,
            'score' => $this->score,
            'skills' => $this->skills,
            'technical_skills' => $this->technical_skills,
            'soft_skills' => $this->soft_skills,
            'tools' => $this->tools,
            'in_demand_skills' => $this->in_demand_skills,
            'job_matches' => $this->job_matches,
            'recommendation' => $this->recommendation,
            'cv_recommendation' => $this->cv_recommendation,
        ];
    }
}
