<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Requests\AnalyzeCvRequest;
use App\Services\CvAnalysisService;
use App\Http\Resources\CandidateResource;
use Illuminate\Http\JsonResponse;

class AnalyzeCvController extends Controller
{
    use ApiResponse;
    
    public function __construct(
        protected CvAnalysisService $cvAnalysisService
    ) {}

    public function __invoke(AnalyzeCvRequest $request): JsonResponse
    {
        try {
            $candidate = $this->cvAnalysisService->analyze(
                $request->file('cv_file')
            );

            return $this->success(
                new CandidateResource($candidate),
                'CV analyzed successfully'
            );
        } catch (\Exception $e) {
            return $this->error('Analysis failed: ' . $e->getMessage(), $e->getCode(), [], true, 60);
        }
    }
}
