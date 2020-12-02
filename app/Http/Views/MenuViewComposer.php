<?php


namespace App\Http\Views;


use App\Models\Module;

class MenuViewComposer
{
    private $module;

    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function compose($view)
    {
        $user = auth()->user();

        $filteredModules = session()->get('modules') ?: [];

        if (!$filteredModules) {

            if ($user->isAdmin()) {

                $filteredModules = ($this->getModules($this->module))->toArray();

            } else {

                $modules = $this->getModules($user->role->modules());

                foreach ($modules as $key => $module) {
                    $filteredModules[$key]['name'] = $module->name;

                    foreach ($module->resources as $k => $resource) {
                        if ($resource->roles->contains($user->role)) {
                            $filteredModules[$key]['resources'][$k]['name'] = $resource->name;
                            $filteredModules[$key]['resources'][$k]['resource'] = $resource->resource;
                        }
                    }
                }
            }

            session()->put('modules', $filteredModules);
        }

        /*
        $menus = auth()->user()
            ->role->resources()
            ->where('is_menu', true)->
            get();
        */
        return $view->with('modules', $filteredModules);
    }

    public function getModules($module)
    {
        return $module->with(['resources' => function($queryBuilder) {
                return $queryBuilder->where('is_menu', true);
            }])->get();
    }

}
