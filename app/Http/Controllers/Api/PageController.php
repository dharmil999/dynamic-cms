<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\Common;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    use Common;

    private $delete_ids = [];

    public function index()
    {
        return $this->success(Page::getNestedPages());
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:pages,id',
            'content' => 'nullable|string',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->fail([], $validator->errors()->first());
        }

        Page::create($validator->validated());
        return $this->success([], 'Page created successfully');
    }

    public function show($path)
    {
        $slugs = explode('/', $path);
        $page = Page::findPageBySlug($slugs);
        if (!$page) {
            return $this->fail([],'Page not found',404);
        }

        return $this->success($page);
    }


    public function update(Request $request, Page $page)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:pages,id',
            'content' => 'nullable|string',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->fail([], $validator->errors()->first());
        }

        $page->update($validator->validated());
        return $this->success([], 'Page updated successfully');
    }

    public function destroy(Page $page)
    {
        $page->load('children');
        $this->getChildren($page);

        if (!empty($this->delete_ids)) {
            Page::destroy($this->delete_ids);
        }
        $page->delete();
        return $this->success([], 'Page deleted successfully');
    }

    private function getChildren(Page $page)
    {
        foreach ($page->children as $child) {
            $this->getChildren($child); // Recursively delete children
            $this->delete_ids[] = $child->id;
        }
    }
}
