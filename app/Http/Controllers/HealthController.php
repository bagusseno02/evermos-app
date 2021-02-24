<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @OA\GET(
     *     path="/health",
     *     summarty="Check Health Service",
     * @OA\Parameter(name="page",
     *     in="query",
     *     required="false",
     * @OA\Schema(type="numbers"),
     * @OA\Response(
     *     response=200,
     *     description="OK"
     * )
     * )
     */
    public function health(): string
    {
        return "Server Up";
    }

    //
}
