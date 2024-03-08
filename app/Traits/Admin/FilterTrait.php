<?php
namespace App\Traits\Admin;
use Illuminate\Support\Facades\Request;

trait FilterTrait {

    public static function getFilterDom() {

        $filters = self::$filters;

        foreach ($filters as $key => &$filter) {
            if ($filter['type'] == 'select') {

                $filter['data'] = (!empty($filter['data'])) ? $filter['data'] : [];

                $modelArr = $filter['model'];

                if (!empty($modelArr)) {
                    $modelName = isset($modelArr['src']) ? $modelArr['src'] : null;
                    $modelArrSrc = isset($modelArr['arr']) ? $modelArr['arr'] : null;
                    $modelTitleKey = isset($modelArr['title_key']) ? $modelArr['title_key'] : null;
                    $postCollectionKey = isset($modelArr['post_collection']) ? $modelArr['post_collection'] : null;

                    if ($modelName) {
                        if ($postCollectionKey) {
                            $dataModel = $modelName::where('post_type', $postCollectionKey)->get();
                        } else {
                            $dataModel = $modelName::orderBy($modelArr['title_key'], $modelArr['sortOrder'])->get();
                        }
                    }
                    $selectArr = [];
                    if (!empty($dataModel) && !empty(($modelTitleKey))) {
                        foreach ($dataModel as $d) {
                            $selectArr[$d->getKey()] = (!empty($d->getData($modelTitleKey))) ? $d->getData($modelTitleKey) : lang($modelTitleKey);
                        }

                    } else if (!empty($modelArrSrc)) {
                        foreach ($modelArrSrc as $key => $item) {
                            $selectArr[$key] = $item;
                        }
                    }
                    $filter['data'] = $selectArr;
                }
            }
        }

        $data['filters'] = $filters;
        return View('admin.common.filters', $data)->render();

    }

    function scopefilter($query, $func = null, $request = null) {

        $filters = self::$filters;
        $request = (empty($request)) ? request() : $request;

        foreach ($request->all() as $key => $value) {

            $filterKey = str_replace('_to', '', $key);
            if (isset($filters[$filterKey]) && !empty($value)) {
                $realKey = str_replace('filter_', '', $key);

                switch ($filters[$filterKey]['q']) {
                    case 'like':

                        $query->where($realKey, $filters[$key]['q'], '%' . $value . '%');

                        break;
                    case 'like_arabic':

                        $query->where($realKey, $filters[$key]['q'], '%' . $value . '%');
                        $query->orWhere($realKey . "_arabic", $filters[$key]['q'], '%' . $value . '%');
                        break;
                    case 'datetime':
                        // $query->where($realKey ,$filters[$key]['q'],'%'.$value.'%');
                        break;
                    case 'date_range':

                        $filterKey = str_replace('_to', '', $key);

                        if ($filters[$filterKey]['type'] == 'date_range') {
                            $value = date('Y-m-d', strtotime($value));
                        }

                        if ($key == $filterKey . '_to') {

                            $realKey = str_replace('filter_', '', $filterKey);
                            $toDate = $value . ' 23:59:59';

                            $query->where($realKey, '<=', $toDate);
                        } else {

                            $query->where($realKey, '>=', $value);
                        }

                        break;

                    case 'custom':
                        if ($func) {
                            return $func($query, $filters[$key], $value);
                        } else {
                            die('runtime function must be passed for custom query, with in the filter function');
                        }
                        break;
                    case 'relations':
                        if ($filters[$key]['model'] && $filters[$key]['model']['foreign']) {
                            $model = $filters[$key]['model']['src'];
                            $relation = $filters[$key]['model']['relation'];
                            $title_key = $filters[$key]['model']['search_key'];

                            $query->whereHas($relation, function ($q) use ($value, $title_key) {
                                $q->where($title_key, '=', $value);
                            });
                        } else {
                            $query->where($realKey, '=', $value);
                        }
                        break;
                    default:
                         if (!empty($filters[$key]['model']) && $filters[$key]['model']['foreign']) {
                           $model = $filters[$key]['model']['src'];

                            $modelData = $model::find($value);
                            $query->whereHas($realKey, function ($q) use ($value, $modelData) {
                                $q->where($modelData->getKeyName(), '=', $value);
                            });
                        } else {
                            $query->where($realKey, '=', $value);
                        }
                        break;
                }
            }
        }

    }

}
?>