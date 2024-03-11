<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\AdminBaseController;
use App\Models\User as User;
use App\Models\Admodels\CategoryModel;
use Illuminate\Http\Request;
use Carbon\Carbon; // Date formatting class
use Illuminate\Support\Facades\Storage;
use Nestable;

class CategoryController extends AdminBaseController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function index(Request $request) {
        $this->data['categoryList'] =   CategoryModel::
                                        when($request->input('name'), function ($q) use ($request) {
                                            return $q->where('category_title', 'LIKE', "%".$request->input('name')."%");
                                        })
                                        ->when($request->input('status'), function ($q) use ($request) { 
                                            return $q->where('category_status', '=', $request->input('status'));
                                        })
                                        ->orderBy('category_parent_id', 'asc')
                                        ->orderBy('category_priority', 'asc')
                                        ->paginate(20);
        return view('admin.category.list', $this->data);
    }

    public function create(Request $request) {
       
        if ($request->input('createbtnsubmit') ) {
            $this->validate($request, [
                'category_title' => 'required',
                'category_title_arabic' => 'required',
               // 'category_parent_id' => 'required',
            ]);

        
            $arr = array(
                'category_title' => $request->input('category_title'),
                'category_title_arabic' => $request->input('category_title_arabic'),
                'category_parent_id' => $request->input('category_parent_id'),
                'category_created_by' => \Auth::user()->id,
                'category_updated_by' => \Auth::user()->id,
                'category_status' => $request->input('category_status'),
                'category_priority' => $request->input('category_priority')
            );
            
            $category = CategoryModel::create($arr);
			
            $userMessage=$this->custom_message('Category saved successfully.', 'success');
            return back()->with('userMessage',$userMessage );
        }
		$this->data['categoryList'] = CategoryModel::orderBy('category_title', 'asc')
											->where('category_status',1)
                                            ->get();
        return view('admin.category.add', $this->data);
    }

    public function update($editID, Request $request) {

        if (empty($editID)) {
            return redirect()->to(apa('category_manager'));
        }

        $this->data['messages'] = '';

        if ($request->input('updatebtnsubmit')) {
          
            $this->validate($request, [
                'category_title' => 'required',
                'category_title_arabic' => 'required',
            ]);


            $arr = array(
                'category_title' => $request->input('category_title'),
                'category_title_arabic' => $request->input('category_title_arabic'),
                'category_parent_id' => $request->input('category_parent_id'),
                'category_created_by' => \Auth::user()->id,
                'category_updated_by' => \Auth::user()->id,
                'category_status' => $request->input('category_status'),
                'category_priority' => $request->input('category_priority')
            );

            CategoryModel::where('category_id', $editID)->update($arr);

            $this->data['userMessage'] = $this->custom_message('Category updated successfully', 'success');
        }

        $this->data['categoryDetails'] = CategoryModel::find($editID);
        if (empty($this->data['categoryDetails'])) {
            return apa('category_manager')->with('userMessage', 'Category not found');
        }
        $this->data['categoryList'] = CategoryModel::where('category_status', '=', 1)->get();
        return view('admin.category.edit', $this->data);
    }

    public function changestatus($categoryID) {
        $categoryDetails = CategoryModel::find($categoryID);
        
        if (empty($categoryDetails)) {
            return redirect()->to(apa('category_manager'))->with('success', 'Record not found');
        }
        $currentStatus = ( $categoryDetails->category_status == 2 ) ? 1 : 2;
        $currentStatusdatas = array("category_status" => $currentStatus);
        $details = CategoryModel::where('category_id', '=', $categoryID)->update($currentStatusdatas);
        $categoryDetails = CategoryModel::find($categoryID);
        return redirect()->to(apa('category_manager'))->with('success', 'Status changed');
    }

}
