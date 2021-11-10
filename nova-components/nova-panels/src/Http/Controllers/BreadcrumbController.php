<?php

namespace Akka\Nova\Http\Controllers;

use App\Models\Machine;
use Illuminate\Database\Query\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;
use \Illuminate\Http\JsonResponse;
use Laravel\Nova\Nova;

class BreadcrumbController
{

    public $tree = [
        "managed-articles",
        "components",
        "machines",
        "plants",
        "establishments",
        "customers",
    ];

    public $key = 0;

    public $breadcrumb = [];

    /**
     * @param NovaRequest $request
     * @return JsonResponse
     */
    public function index(NovaRequest $request)
    {
        $params = $request->get('params');
        $query = $request->get('query');
        if(!empty($params)) {
            if(isset($params['resourceId'])) {

                $element = $this->getBreadcrumb($params['resourceName'], $params['resourceId']);
                if($element && method_exists($element, 'getParent')) {
                    $this->getParents($element);
                }
            } elseif(isset($params['resourceName'])) {
                $this->breadcrumb[] = [
                    'url' => "/resources/{$params['resourceName']}",
                    'label' => $params['resourceName']
                ];
            }

        }
        if(!empty($query) && isset($query['viaResource'])) {
            $element = $this->getBreadcrumb($query['viaResource'], $query['viaResourceId']);
            $this->getParents($element);
        }
        return response()->json([
            'breadcrumb' => array_reverse($this->breadcrumb)
        ]);
    }

    public function getBreadcrumb($resourceName, $resourceId) {
        if($resourceName !== 'roles') {
            $this->setKey(array_search($resourceName, $this->tree));
            $resource = Nova::resourceForKey($resourceName);
            $model_name = str_replace('Nova', 'Models', $resource);
            $model_name = str_replace('App', '\App', $model_name);
            $element = $model_name::find($resourceId);
            if ($element && method_exists($element, 'getName')) {
                $this->setBreadCrumb([
                    'url' => "/resources/{$resourceName}/{$resourceId}",
                    'label' => $element->getName()
                ]);
            }
            return $element;
        }

        return null;
    }

    public function setKey($value){
        $this->key = $value;
    }

    public function setBreadCrumb($value){
        array_push($this->breadcrumb,$value);
    }

    public function getParents( $element)
    {
        for($i = $this->key; $i < count($this->tree) - 1 ; $i++){
            if($element && method_exists($element, 'getParent')) {
                $element = $element->getParent();
                if ($element && method_exists($element, 'getName')) {
                    $this->setBreadCrumb([
                        'url' => "/resources/{$this->tree[$i+1]}/{$element->id}",
                        'label' => $element->getName()
                    ]);
                }
            }
        }
    }

}
