<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\City;
use App\Models\Brand;
use App\Models\State;
use App\Models\Company;
use App\Models\Country;
use App\Models\Category;
use App\Models\TaxClass;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use function PHPUnit\Framework\assertIsNotArray;
use App\Http\Requests\AxiosRequests\GetBrandRequest;
use App\Http\Requests\AxiosRequests\GetModelRequest;
use App\Http\Requests\AxiosRequests\GetSubCategoryRequest;
use App\Http\Requests\AxiosRequests\GetTaxRateRequest;

class AxiosRequestController extends Controller
{
    public function getStates(Request $request): JsonResponse
    {

        $country_id = $request->country_id;
        if ($country_id) {
            $country = Country::with('states')->findOrFail($country_id);
            return response()->json([
                'states' => $country->activeStates,
                'message' => "States fetched successfully!",
            ]);
        }
        return response()->json([
            'states' => [],
            'message' => "States not found!",
        ]);
    }


    public function getStatesOrCities(Request $request): JsonResponse
    {

        $country_id = $request->country_id;
        if ($country_id) {
            $country = Country::with(['states', 'cities'])->withCount(['activeStates', 'activeCities'])->findOrFail($country_id);
            if ($country->active_states_count > 0) {
                return response()->json([
                    'states' => $country->activeStates,
                    'message' => "States fetched successfully!",
                ]);
            }
            if ($country->active_cities_count > 0) {
                return response()->json([
                    'cities' => $country->activeCities,
                    'message' => "Cities fetched successfully!",
                ]);
            }
        }
        return response()->json([
            'message' => "States or Cities not found!",
        ]);
    }

    public function getCities(Request $request): JsonResponse
    {
        $state_id = $request->state_id;
        if ($state_id) {
            $state = State::with('activeCities')->findOrFail($state_id);
            return response()->json([
                'cities' => $state->activeCities,
                'message' => "States fetched successfully!",
            ]);
        }
        return response()->json([
            'message' => "Cities not found!",
        ]);
    }
    public function getOperationAreas(Request $request): JsonResponse
    {
        $city_id = $request->city_id;
        if ($city_id) {
            $city = City::with('operationAreas')->findOrFail($city_id);
            return response()->json([
                'operation_areas' => $city->activeOperationAreas,
                'message' => "States fetched successfully!",
            ]);
        }
        return response()->json([
            'message' => "Operation areas not found!",
        ]);
    }

    public function getSubCategories(Request $request): JsonResponse
    {
        $parent_id = $request->parent_id;
        if ($parent_id) {
            $parent = Category::with('activeChildrens')->findOrFail($parent_id);
            return response()->json([
                'childrens' => $parent->activeChildrens,
                'message' => "Childrens fetched successfully!",
            ]);
        }
        return response()->json([
            'childrens' => [],
            'message' => "Childrens not found!",
        ]);
    }

    public function getSubChildCategories(Request $request): JsonResponse
    {
        $parent_id = $request->parent_id;
        if ($parent_id) {
            $parent = Category::with('activeChildrens')->findOrFail($parent_id);
            return response()->json([
                'sub_childrens' => $parent->activeChildrens,
                'message' => "Sub Child Categories fetched successfully!",
            ]);
        }
        return response()->json([
            'sub_childrens' => [],
            'message' => "Sub Child Categories not found!",
        ]);
    }

    public function getTaxRates(GetTaxRateRequest $request): JsonResponse
    {
        $tax_class_id = $request->tax_class_id;
        if ($tax_class_id) {
            $tax_class = TaxClass::with('activeTaxRates')->findOrFail($tax_class_id);
            return response()->json([
                'tax_rates' => $tax_class->activeTaxRates,
                'message' => "Tax Rates fetched successfully!",
            ]);
        }
        return response()->json([
            'tax_rates' => [],
            'message' => "Tax Rates not found!",
        ]);
    }


    public function getBrands(GetBrandRequest $request): JsonResponse
    {
        $company_id = $request->validated()["company_id"];
        if ($company_id) {
            $company = Company::with('activeBrands')->findOrFail($company_id);
            return response()->json([
                'brands' => $company->activeBrands,
                'message' => "Brands fetched successfully!",
            ]);
        }
        return response()->json([
            'brands' => [],
            'message' => "Brands not found!",
        ]);
    }

    public function getModels(GetModelRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $brand_id = $validated['brand_id'] ?? null;
        $company_id = $validated['company_id'] ?? null;

        if ($brand_id) {
            $brand = Brand::with('activeModels')->findOrFail($brand_id);
            return response()->json([
                'models' => $brand->activeModels,
                'message' => "Models fetched successfully!",
            ]);
        }

        if ($company_id) {
            $company = Company::with('activeModels')->findOrFail($company_id);
            return response()->json([
                'models' => $company->activeModels,
                'message' => "Models fetched successfully!",
            ]);
        }

        return response()->json([
            'models' => [],
            'message' => "Models not found!",
        ]);
    }
}
