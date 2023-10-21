<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Jobs;
use App\Http\Requests\StoreJobsRequest;
use App\Http\Requests\UpdateJobsRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return JobResource::collection(Jobs::orderBy('id', 'desc')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobsRequest $request)
    {
        $job = Jobs::create($request->validated());

        return JobResource::make($job);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jobs $job)
    {
        return JobResource::make($job);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobsRequest $request, Jobs $job)
    {
        $job->update($request->validated());

        return JobResource::make($job);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jobs $job)
    {
        $job->delete();

        return response()->noContent();
    }
}
