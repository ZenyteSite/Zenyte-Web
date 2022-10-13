<?php

namespace App\Http\Controllers\ModCP;

use App\Helpers\InvisionAPI;
use App\Models\ModCP\DuelLog;
use App\Models\ModCP\PunishmentAction;
use App\Models\ModCP\PunishmentActionProof;
use App\Models\ModCP\TradeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LoggingController extends Controller
{
    protected $forumInstance;

    public function __construct()
    {
        $this->forumInstance = InvisionAPI::getInstance();
    }

    /**
     * Displays our modcp page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $type = lcfirst($request->input('type'));
        //Use a switch statement so we can easily add more stuff
        switch ($type) {
            case 'duel':
                $logs = DuelLog::query();
                $title = 'Duel';
                break;
            case 'trade':
            default: //Default to trade logs
                $logs = TradeLog::query();
                $title = 'Trade';
                break;
        }
        if ($request->isMethod('post')) {
            $search = $request->input('search_input');
            $logs->where('user', $search)
                ->orWhere('user_ip', $search);
            switch ($type) {
                case 'duel':
                    $logs->orWhere('opponent', $search)
                        ->orWhere('opponent_ip', $search);
                    break;
                case 'trade':
                default:
                    $logs->orWhere('partner', $search)
                        ->orWhere('partner_ip', $search);
                    break;
            }
        }

        return view('modcp.logging.index', [
            'logs' => $logs->paginate(20),
            'action' => $title,
        ]);
    }

    /*
     * Our differences between logs are a bit too much to try and have one template, so we'll just use seperate templates for each log type
     */
    public function view(Request $request, $log)
    {

        switch ($request->input('type')) {
            case 'Duel':
                $duel = DuelLog::where('id', $log)->firstOrFail();
                return view('modcp.logging.view.duel', [
                    'duel' => $duel,
                ]);
            case 'Trade':
            default: //Default to trade logs
                $trade = TradeLog::where('id', $log)->firstOrFail();
                return view('modcp.logging.view.trade', [
                    'trade' => $trade,
                ]);
        }
    }

    public function uploadProof(Request $request, PunishmentAction $punishmentAction)
    {
        $files = $request->file('files');
        $notes = $request->input('notes');
        $uploadLimit = 20000000; //Measure it in bytes
        $proof = PunishmentActionProof::create([
            'action_id' => $punishmentAction->id,
            'notes' => $notes,
            'staff_member' => $this->forumInstance->getCachedMember()->getName(),
            'timestamp' => Carbon::now(),
        ]);
        foreach ($files as $file) {
            if (!in_array($file->getClientOriginalExtension(), config('modcp.accepted_punishment_file_types'))) {
                Session::flash('upload_error', 'The file you have uploaded is of a type that is not supported for uploading. Please refer to the accepted file types.');
                return redirect()->back();
            }
            if ($file->getSize() > $uploadLimit) {
                Session::flash('upload_error', 'The file you have uploaded is too big. We only support files that are less than' . $uploadLimit * 1000000 . ' megabytes in size.');
                return redirect()->back();
            }
            Storage::disk('s3')->put(config('modcp.punishment_proof_bucket') . '/' . $punishmentAction->id . '/' . $proof->id, $file);
        }
        return redirect()->back();
    }

    public function deleteProof(Request $request, PunishmentAction $punishmentAction)
    {
        $proofId = $request->input('proofId');
        PunishmentActionProof::find($proofId)->delete();
        Storage::disk('s3')->deleteDirectory(config('modcp.punishment_proof_bucket') . '/' . $punishmentAction->id . '/' . $proofId);
        return redirect()->back();
    }
}