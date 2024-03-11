<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;

use App\Exports\NotifyRequestExport;
use App\Models\Admodels\ContactModel;
use App\Models\Admodels\PostModel;
use App\Exports\ContactRequestExport;
use App\Exports\SubscriptionExport;
use App\Exports\ProjectInquiryExport;
use App\Exports\CareersRequestExport;
use App\Exports\OfferRequestExport;

use App\Models\Admodels\NewsletterModel;
use App\Models\Admodels\ProjectInquiryModel;
use App\Models\Admodels\ProjectModel;
use App\Models\Admodels\CareerModel;
use App\Models\Admodels\OfferRequestModel;
use File;
use Carbon\Carbon;


use App\Http\Controllers\Admin\Base\AdminBaseController;

class ContactController extends AdminBaseController {


	protected $roleNames;
	public function __construct(Request $request){

		parent::__construct($request);
		$this->module = 'Contact';
		
	}

	
	public function index(Request $request){
		
		$this->data['contactUsDetails'] =ContactModel::filter($request)
													   ->orderBy('contact_created_at','desc')
													   ->paginate(20);
		
		$this->data['filterDOM']=ContactModel::getFilterDom($request);
	    return view('admin.contact.contact_list',$this->data);
    }

    public function download(Request $request){
    	$export = new ContactRequestExport($request);
		ob_end_clean();
		return Excel::download($export, 'Contact Request '.date('Y-m-d').'.xlsx');

    }

	public function subscriptions(Request $request)
	{
			
		$this->data['subscriptionList'] =NewsletterModel::orderBY('ns_created_at','desc')
		                                                 ->when($request->input('email'),function($q) use($request){
															$q->where('ns_email','LIKE','%'.$request->input('email').'%');
														 })
		                                                 ->paginate(20);
	    return view('admin.contact.subscriptions',$this->data);

	}
	public function subscriptionsDownload(Request $request){
    	$export = new SubscriptionExport($request);
		return Excel::download($export, 'Subscription list'.date('Y-m-d').'.xlsx');

    }

	public function projectInquiry(Request $request)
	{
        
		$this->data['projects']=ProjectModel::orderBy('project_title','asc')->select('project_id','project_title')->get();


		$this->data['inquiryList']=ProjectInquiryModel::orderBy('created_at','desc')
		                                               ->when($request->input('project'), function($q) use($request){
														   $q->whereHas('project',function($q) use($request){
															   $q->where('project_id',$request->input('project'));
														   });
													   })
													   ->when($request->input('name'), function($q) use($request){
																$q->where('full_name','LIKE','%'.$request->input('name').'%');
														})
													    ->when($request->input('email'), function($q) use($request){
															$q->where('user_email','LIKE','%'.$request->input('email').'%');
													    })
													    ->when($request->input('phone_number'), function($q) use($request){
															$q->where('phone_number',$request->input('phone_number'));
												        })
													   ->when($request->input('from_date'), function($q) use($request){
																$q->where('created_at','>=',date('Y-m-d',strtotime($request->input('from_date'))).' 00:00:00');
														})
														->when($request->input('to_date'), function($q) use($request){
															$q->where('created_at','<=',date('Y-m-d',strtotime($request->input('to_date'))).' 23:59:59');
													   })
		                                               ->paginate(20);

		return view('admin.projects.inquiry_list',$this->data);
	}
	public function inquiryDownload(Request $request){
    	$export = new ProjectInquiryExport($request);
		return Excel::download($export, 'project-inquiry'.date('Y-m-d').'.xlsx');

    }
	public function projectRequestDelete($id)
	{
        $projectInquiry=ProjectInquiryModel::find($id);
	
		if(!empty($projectInquiry)){
			$projectInquiry->delete();
			return redirect()->back()->with('userMessage','Removed Successfully');
		}
		return redirect()->back()->with('errorMessage','Invalid Request');
	}
	public function projectRequestEdit($id, Request $request){

		$projectInquiry=ProjectInquiryModel::find($id);
		
		if($request->input('updatebtnsubmit')){

			$this->validate($request, [
                'full_name' => 'required',
                'user_email' => 'required|email',
                'phone_number' => 'required',
                'how_to_reach_you' => 'required',
                'message' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);

		    $projectInquiry->full_name=$request->input('full_name');
			$projectInquiry->user_email=$request->input('user_email');
			$projectInquiry->phone_number=(int) $request->input('phone_number');
			$projectInquiry->how_to_reach_you=$request->input('how_to_reach_you');
			$projectInquiry->message=$request->input('message');
			$projectInquiry->date =Carbon::parse($request->input('date'))->format('Y-m-d');
			$projectInquiry->time=Carbon::parse($request->input('time'))->format('H:i:s');
            $projectInquiry->save();
			$projectInquiry->refresh();
			$this->data['userMessage']="Update Successfully";
		}
		
		$this->data['projectInquiry']=$projectInquiry;
        return view('admin.projects.inquiry_request_edit',$this->data);
	}
	public function careersRequest(Request $request)
	{
        
		$this->data['careers']=PostModel::where('post_type','careers')
		                       ->orderBy('post_title','asc')
							   ->select('post_id','post_title')->active()->get();


		$this->data['careerList']=CareerModel::orderBy('created_at','desc')
		                                               ->when($request->input('job_id'), function($q) use($request){
														   $q->whereHas('job',function($q) use($request){
															   $q->where('post_id',$request->input('job_id'));
														   });
													   })
													   ->when($request->input('name'), function($q) use($request){
																$q->where('full_name','LIKE','%'.$request->input('name').'%');
														})
													    ->when($request->input('email'), function($q) use($request){
															$q->where('user_email','LIKE','%'.$request->input('email').'%');
													    })
													    ->when($request->input('phone_number'), function($q) use($request){
															$q->where('phone_number',$request->input('phone_number'));
												        })
													   ->when($request->input('from_date'), function($q) use($request){
																$q->where('created_at','>=',date('Y-m-d',strtotime($request->input('from_date'))).' 00:00:00');
														})
														->when($request->input('to_date'), function($q) use($request){
															$q->where('created_at','<=',date('Y-m-d',strtotime($request->input('to_date'))).' 23:59:59');
													   })
		                                               ->paginate(20);

		return view('admin.careers.career_request',$this->data);
	}
	
	public function careersRequestDownload(Request $request){
    	$export = new CareersRequestExport($request);
		return Excel::download($export, 'job-request-'.date('Y-m-d').'.xlsx');

    }
	/**
     * download CV
     * @param Object $request
     * @param String $type
     * @param String $lang
     * @return View
    */
    public function downloadCv($id, Request $request)
    {

            $CrRequest = CareerModel::find($id);
			if(!empty($CrRequest)){
                $fileName=$CrRequest->getData('career_cv_file');
				$type=$CrRequest->getData('full_name');
				$ext = pathinfo($fileName, PATHINFO_EXTENSION);
				if(File::exists(storage_path('app' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'career_cv' . DIRECTORY_SEPARATOR .$fileName))){
					return \Response::download(storage_path('app' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'career_cv' . DIRECTORY_SEPARATOR .$fileName),$type.'.'.$ext);
				}
				die('storage');
	
				
			}
            return redirect()->back();
           
        
        
    }
	public function offerRequest(Request $request)
	{
        
		$this->data['offers']=PostModel::where('post_type','offers')
		                       ->orderBy('post_title','asc')
							   ->select('post_id','post_title')->active()->get();


		$this->data['requestList']=OfferRequestModel::orderBy('created_at','desc')
		                                               ->when($request->input('offer_id'), function($q) use($request){
														   $q->whereHas('offer',function($q) use($request){
															   $q->where('post_id',$request->input('offer_id'));
														   });
													   })
													   ->when($request->input('name'), function($q) use($request){
																$q->where('full_name','LIKE','%'.$request->input('name').'%');
														})
													    ->when($request->input('email'), function($q) use($request){
															$q->where('user_email','LIKE','%'.$request->input('email').'%');
													    })
													    ->when($request->input('phone_number'), function($q) use($request){
															$q->where('phone_number',$request->input('phone_number'));
												        })
													   ->when($request->input('from_date'), function($q) use($request){
																$q->where('created_at','>=',date('Y-m-d',strtotime($request->input('from_date'))).' 00:00:00');
														})
														->when($request->input('to_date'), function($q) use($request){
															$q->where('created_at','<=',date('Y-m-d',strtotime($request->input('to_date'))).' 23:59:59');
													   })
		                                               ->paginate(20);

		return view('admin.offers.offer_request',$this->data);
	}
	public function offerDownload(Request $request){
    	$export = new OfferRequestExport($request);
		return Excel::download($export, 'offer-request-'.date('Y-m-d').'.xlsx');

    }
	public function offerRequestDelete($id)
	{
        $offer=OfferRequestModel::find($id);
		if(!empty($offer)){
			$offer->delete();
			return redirect()->back()->with('userMessage','Removed Successfully');
		}
		return redirect()->back()->with('errorMessage','Invalid Request');
	}
	public function offerRequestEdit($id, Request $request){

		$offerRequest=OfferRequestModel::find($id);
		if($request->input('updatebtnsubmit')){

			$this->validate($request, [
                'full_name' => 'required',
                'user_email' => 'required|email',
                'phone_number' => 'required',
                'how_to_reach_you' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);

		    $offerRequest->full_name=$request->input('full_name');
			$offerRequest->user_email=$request->input('user_email');
			$offerRequest->phone_number=(int) $request->input('phone_number');
			$offerRequest->how_to_reach_you=$request->input('how_to_reach_you');
			$offerRequest->date =Carbon::parse($request->input('date'))->format('Y-m-d');
			$offerRequest->time=Carbon::parse($request->input('time'))->format('H:i:s');
            $offerRequest->save();
			$offerRequest->refresh();
			$this->data['userMessage']="Update Successfully";
		}
		
		$this->data['offer_request']=$offerRequest;
        return view('admin.offers.offer_request_edit',$this->data);
	}
}
