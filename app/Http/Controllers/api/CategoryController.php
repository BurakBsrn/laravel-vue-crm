<?php

namespace App\Http\Controllers\api;

use App\Filters\CategoryFilters;
use App\Helpers\FlashMessage\FlashMessageParameters;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @param  CategoryFilters  $filters
     * @return JsonResponse
     */
    public function index(Request $request, CategoryFilters $filters): JsonResponse
    {
        $pagination = (int)$request->get('paginate', 10);

        /** @var Category $category */
        $categories = Category::query()->filter($filters)->paginate($pagination);

        return FlashMessageParameters::paginate($categories, CategoryResource::class)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCategoryRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $attributes = collect($request->validated());

        throw_unless($user->categories()->create($attributes->toArray()),
            \Exception::class, 'Kategori bilgisi girilirken bir problem oluştu');

        return FlashMessageParameters::success([
            'message' => 'Kategori başarılı bir şekilde girilmiştir.'
        ])->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  Category  $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return FlashMessageParameters::success([
            'id' => $category->id,
            'name' => $category->name
        ])->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest  $request
     * @param  Category  $category
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $attributes = collect($request->validated());

        throw_unless($user->categories()->where('categories.id', $category->id)->update($attributes->toArray()),
            \Exception::class, 'Kategori bilgisi güncellenirken bir problem oluştu');

        return FlashMessageParameters::success([
            'message' => 'Kategori başarılı bir şekilde güncellendi.'
        ])->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Category  $category
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(Category $category)
    {
        throw_unless($category->delete(),
            \Exception::class, 'Kategori silinirken bir problem oluştu');

        return FlashMessageParameters::success([
            'message' => 'Kategori başarılı bir şekilde silindi.'
        ])->toJson();
    }
}
