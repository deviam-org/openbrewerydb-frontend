<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Exceptions\Request\FatalRequestException;
use App\Http\Integrations\BackendConnector\BackendConnector;
use App\Http\Integrations\BackendConnector\Requests\Brewery\ListBreweries;

class BreweryController extends Controller
{
    public function __construct(protected BackendConnector $backendConnector)
    {
    }

    public function index()
    {
        return view('breweries.index');
    }

    public function ajax(
        Request $request,
    ): JsonResponse {
        if (null !== $request->json('sort')) {
            Session::put('breweries.sort', $request->json('sort'));
        }
        if (null !== $request->json('dir')) {
            Session::put('breweries.dir', $request->json('dir'));
        }
        if (null !== $request->json('page')) {
            Session::put('breweries.page', $request->json('page'));
        }
        if (null !== $request->json('limit')) {
            Session::put('breweries.limit', $request->json('limit'));
        }
        if (Session::get('breweries.filters') !== $request->json('filters')) {
            Session::put('breweries.filters', $request->json('filters'));
        }


        $request = new ListBreweries(
            page: (int) Session::get('breweries.page') ?? '1',
            perPage: (int) Session::get('breweries.limit') ?? '10',
            filters: $request->json('filters') ?? [],
            sort: Session::get('breweries.sort') ?? 'name',
            sortDirection: Session::get('breweries.dir') ?? 'desc',
        );

        try {
            $response = $this->backendConnector->send($request);

            if ($response->failed()) {
                if (429 === $response->status()) {
                    return $this->respondError(
                        message: 'Too many requests',
                    );
                } else {
                    return $this->respondError(
                        message: 'Error loading data',
                    );
                }
            }

            $data = $response->dto()->toArray()['data'];

            return response()->json([
                'html' => view('breweries.ajax', [
                    'data' => $data,
                ])->render(),
                'meta' => $response->dto()->toArray()['meta'],
            ]);
        } catch (FatalRequestException | RequestException $e) {
            return $this->respondError(
                message: 'Error loading data',
            );
        }
    }
}
