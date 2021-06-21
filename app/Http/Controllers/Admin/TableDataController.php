<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\DailyIncome;
use App\Models\GenerationIncome;
use App\Models\LevelIncome;
use App\Models\MoneyExchange;
use App\Models\Notice;
use App\Models\Page;
use App\Models\SendIncomeBalance;
use App\Models\SendShopBalance;
use App\Models\ShareIncome;
use App\Models\SiteIncome;
use App\Models\SponsorIncome;
use App\Models\User;
use App\Models\Video;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TableDataController extends Controller
{    
    /**
     * get notice data
     *
     * @param  mixed $request
     * @return void
     */
    public function getNoticeData(Request $request)
    {
        if ($request->ajax()) {

            $notices = Notice::latest('id')->get();

            return DataTables::of($notices)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $action = '<div class="btn-group">';
                    $action .= '<a href="/admin/notice/'.$data->id.'/status" title="Status" id="dataStatus" class="btn btn-success btn-sm"><i class="fas fa-thumbs-up"></i></a>';
                    $action .= '<a href="/admin/notice/'.$data->id.'" title="Show" id="showData" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>';
                    $action .= '<a href="/admin/notice/'.$data->id.'" title="Edit" id="editData" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $action .= '<a href="/admin/notice/'.$data->id.'" title="Delete" id="deleteData" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('photo', function ($data) {
                    return '<img src="/uploads/notice/'.$data->image.'" alt="Notice Image" width="50px" />';
                })
                ->addColumn('status', function ($data) {
                    if ($data->status) {
                        return '<span class="badge badge-primary">Active</span>';
                    
                    } else {
                        return '<span class="badge badge-danger">Disable</span>';
                    }
                })
                ->rawColumns(['action', 'photo', 'status'])
                ->toJson();
        }
    }

    /**
     * get staff data
     *
     * @param  mixed $request
     * @return void
     */
    public function getStaffData(Request $request)
    {
        if ($request->ajax()) {

            $staffs = User::where('is_admin', true)->latest('id')->get();

            return DataTables::of($staffs)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $action = '<div class="btn-group">';
                    $action .= '<a href="/admin/staff/'.$data->id.'" title="Edit" id="editData" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $action .= '<a href="/admin/staff/'.$data->id.'" title="Delete" id="deleteData" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                    $action .= '</div>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
    }

    /**
     * get page data
     *
     * @param  mixed $request
     * @return void
     */
    public function getPageData(Request $request)
    {
        if ($request->ajax()) {

            $pages = Page::latest('id')->get();

            return DataTables::of($pages)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $action = '<div class="btn-group">';
                    $action .= '<a href="/admin/page/'.$data->id.'/status" title="Status" id="dataStatus" class="btn btn-success btn-sm"><i class="fas fa-thumbs-up"></i></a>';
                    $action .= '<a href="/admin/page/'.$data->id.'" title="Show" id="showData" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>';
                    $action .= '<a href="/admin/page/'.$data->id.'" title="Edit" id="editData" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $action .= '<a href="/admin/page/'.$data->id.'" title="Delete" id="deleteData" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status) {
                        return '<span class="badge badge-primary">Active</span>';
                    
                    } else {
                        return '<span class="badge badge-danger">Disable</span>';
                    }
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        }
    }

        
    /**
     * get user data by status
     *
     * @param  mixed $request
     * @param  mixed $status
     * @return void
     */
    public function getUserData(Request $request, $status)
    {
        if ($status == 'un_approved') {
            $users = User::where('is_admin', false)->where('is_approved', false)->latest('id')->get();
        
        } elseif ($status == 'block') {
            $users = User::where('is_admin', false)->where('status', false)->latest('id')->get();
        
        }  elseif ($status == 'approved') {
            $users = User::where('is_admin', false)->where('is_approved', true)->latest('id')->get();
        
        } else {
            $users = User::where('is_admin', false)->latest('id')->get();
        }

        if ($request->ajax()) {

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $action = '<div class="btn-group">';
                    if ($data->is_approved) {
                        $action .= '<a href="/admin/user/'.$data->id.'/approved" title="Already Approved" id="workMultiple" class="btn btn-warning btn-sm disabled"><i class="fas fa-thumbs-up"></i></a>';
                    } else {
                        $action .= '<a href="/admin/user/'.$data->id.'/approved" title="Approved Now" id="workMultiple" class="btn btn-warning btn-sm"><i class="fas fa-thumbs-down"></i></a>';
                    }
                    if ($data->status) {
                        $action .= '<a href="/admin/user/'.$data->id.'/status" title="Block" id="workMultiple" class="btn btn-danger btn-sm"><i class="fas fa-lock-open"></i></a>';
                    
                    } else {
                        $action .= '<a href="/admin/user/'.$data->id.'/status" title="Unblock" id="workMultiple" class="btn btn-danger btn-sm"><i class="fas fa-lock"></i></a>';
                    }
                    $action .= '<a href="/admin/user/'.$data->id.'" title="Show" id="showData" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                    $action .= '<a href="/admin/user/'.$data->id.'/edit" title="Edit" id="editData" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $action .= '<a href="/admin/user/'.$data->id.'" title="Delete" id="deleteData" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                    $action .= '</div>';
                    return $action;
                })
                ->editColumn('joining_date', function ($data) {
                    return date('d M Y', strtotime($data->joining_date));
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        }
    }

    /**
     * get video data
     *
     * @param  mixed $request
     * @return void
     */
    public function getVideoData(Request $request)
    {
        if ($request->ajax()) {

            $videos = Video::latest('id')->get();

            return DataTables::of($videos)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $action = '<div class="btn-group">';
                    $action .= '<a href="/admin/video/'.$data->id.'/edit" title="Update Status" id="dataStatus" class="btn btn-success btn-sm"><i class="fas fa-thumbs-up"></i></a>';
                    $action .= '<a href="/admin/video/'.$data->id.'" title="Edit" id="editData" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    $action .= '<a href="/admin/video/'.$data->id.'" title="Delete" id="deleteData" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status) {
                        return '<span class="badge badge-success">Active</span>';
                    
                    } else {
                        return '<span class="badge badge-danger">Disable</span>';
                    }
                })
                ->addColumn('link', function ($data) {
                    return '<a href="'.$data->link.'" target="_blank">'.$data->link.'</a>';
                })
                ->editColumn('views', function ($data) {
                    return $data->users->count();
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'link'])
                ->toJson();
        }
    }

    /**
     * get withdraw data
     *
     * @param  mixed $request
     * @return void
     */
    public function getWithdrawData(Request $request)
    {
        if ($request->ajax()) {

            $withdraws = Withdraw::with(array('user' => function($query) {
                                        $query->select('id', 'username', 'name', 'referer_id');
                                    }))->latest('id')->get();

            return DataTables::of($withdraws)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $action = '<div class="btn-group">';
                    if ($data->status) {
                        $action .= '<a href="javascript:void(0)" class="btn btn-success btn-sm disabled"><i class="fas fa-thumbs-down"></i></a>';
                        $action .= '<a href="javascript:void(0)" class="btn btn-primary btn-sm disabled"><i class="fas fa-edit"></i></a>';
                    } else {
                        $action .= '<a href="/admin/withdraw/approved/'.$data->id.'" title="Approve Withdraw" id="approvedData" class="btn btn-success btn-sm"><i class="fas fa-thumbs-up"></i></a>';
                        $action .= '<a href="/admin/withdraw/'.$data->id.'" title="Edit" id="editData" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
                    }
                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('status', function ($data) {
                    if ($data->status) {
                        return '<span class="badge badge-success">Paid</span>';
                    
                    } else {
                        return '<span class="badge badge-danger">Pending</span>';
                    }
                })
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        }
    }

    /**
     * get sponsor income data
     *
     * @param  mixed $request
     * @return void
     */
    public function getSponsorIncomeData(Request $request)
    {
        if ($request->ajax()) {

            $sponsors = SponsorIncome::with(array('user' => function($query) {
                                        $query->select('id', 'username', 'name', 'referer_id');
                                    }))->latest('id')->get();

            return DataTables::of($sponsors)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->toJson();
        }
    }

    /**
     * get generation income data
     *
     * @param  mixed $request
     * @return void
     */
    public function getGenerationIncomeData(Request $request)
    {
        if ($request->ajax()) {

            $generations = GenerationIncome::with(array('user' => function($query) {
                                        $query->select('id', 'username', 'name', 'referer_id');
                                    }))->latest('id')->get();

            return DataTables::of($generations)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->toJson();
        }
    }

    /**
     * get level income data
     *
     * @param  mixed $request
     * @return void
     */
    public function getLevelIncomeData(Request $request)
    {
        if ($request->ajax()) {

            $levels = LevelIncome::with(array('user' => function($query) {
                                    $query->select('id', 'username', 'name', 'referer_id');
                                }))->latest('id')->get();

            return DataTables::of($levels)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->toJson();
        }
    }

    /**
     * get site income data
     *
     * @param  mixed $request
     * @return void
     */
    public function getSiteIncomeData(Request $request)
    {
        if ($request->ajax()) {

            $sites = SiteIncome::with(array('user' => function($query) {
                                    $query->select('id', 'username', 'name', 'referer_id');
                                }))->latest('id')->get();

            return DataTables::of($sites)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->toJson();
        }
    }

    /**
     * get share income data
     *
     * @param  mixed $request
     * @return void
     */
    public function getShareIncomeData(Request $request)
    {
        if ($request->ajax()) {

            $shares = ShareIncome::with(array('user' => function($query) {
                                $query->select('id', 'username', 'name', 'referer_id');
                            }))->latest('id')->get();

            return DataTables::of($shares)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->toJson();
        }
    }

    /**
     * get share income data
     *
     * @param  mixed $request
     * @return void
     */
    public function getDailyIncomeData(Request $request)
    {
        if ($request->ajax()) {

            $dailies = DailyIncome::with(array('user' => function($query) {
                                    $query->select('id', 'username', 'name', 'referer_id');
                                }))->latest('id')->get();

            return DataTables::of($dailies)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->toJson();
        }
    }

    /**
     * get money exchnage data
     *
     * @param  mixed $request
     * @return void
     */
    public function getMoneyExchangeData(Request $request)
    {
        if ($request->ajax()) {

            $exchanges = MoneyExchange::with(array('user' => function($query) {
                                        $query->select('id', 'username', 'name');
                                    }))->latest('id')->get();

            return DataTables::of($exchanges)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status) {
                        return '<span class="badge badge-success">Paid</span>';
                    
                    } else {
                        return '<span class="badge badge-danger">Pending</span>';
                    }
                })
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->rawColumns(['status'])
                ->toJson();
        }
    }

    /**
     * get shop balance data
     *
     * @param  mixed $request
     * @return void
     */
    public function getShopBalanceData(Request $request)
    {
        if ($request->ajax()) {
            $exchanges = SendShopBalance::with(
                            array(
                                'user' => function($query) {
                                    $query->select('id', 'username', 'name');
                                },
                                'parent_user' => function($query) {
                                    $query->select('id', 'username', 'name');
                                }
                            )
                        )->latest('id')->get();

            return DataTables::of($exchanges)
                ->addIndexColumn()
                ->editColumn('date', function ($data) {
                    return date('d M Y', strtotime($data->date));
                })
                ->toJson();
        }
    }

    /**
     * get contact data
     *
     * @param  mixed $request
     * @return void
     */
    public function getContactData(Request $request)
    {
        if ($request->ajax()) {
            $contacts = Contact::with(array('user' => function($query) {
                $query->select('id', 'username', 'name');
            }))->latest('id')->get();

            return DataTables::of($contacts)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    if ($data->status) {
                        return '<span class="badge badge-success">Seen</span>';
                    
                    } else {
                        return '<span class="badge badge-danger">Pending</span>';
                    }
                })
                ->addColumn('action', function ($data) {
                    $action = '<div class="btn-group">';
                    $action .= '<a href="/admin/connection/contact/'.$data->id.'" title="Show Details" id="showData" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                    $action .= '<a href="/admin/connection/contact/'.$data->id.'" title="Reply" id="replyData" class="btn btn-primary btn-sm"><i class="fas fa-location-arrow"></i></a>';
                    $action .= '<a href="/admin/connection/contact/'.$data->id.'" title="Delete" id="deleteData" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>';
                    $action .= '</div>';
                    return $action;
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->rawColumns(['status', 'action'])
                ->toJson();
        }
    }

    /**
     * get share income data
     *
     * @param  mixed $request
     * @return void
     */
    public function getIncomeBalanceData(Request $request)
    {
        if ($request->ajax()) {

            $dailies = SendIncomeBalance::with(array('user' => function($query) {
                                    $query->select('id', 'username', 'name', 'referer_id');
                                }))->latest('id')->get();

            return DataTables::of($dailies)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return date('d M Y', strtotime($data->created_at));
                })
                ->addColumn('action', function ($data) {
                    return '<a href="/admin/withdraw/income/balance/'.$data->id.'" title="Show Details" id="showData" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                })
                ->toJson();
        }
    }
}
