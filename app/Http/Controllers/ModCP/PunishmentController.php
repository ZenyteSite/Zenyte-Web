<?php

namespace App\Http\Controllers\ModCP;

use App\Helpers\InvisionAPI;
use App\Models\ModCP\PunishmentAction;
use App\Models\ModCP\PunishmentActionProof;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PunishmentController extends Controller
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

        $punishments = PunishmentAction::query();
        if ($request->isMethod('post')) {
            $search = $request->input('search_input');
            $punishments = $punishments->where('mod_name', $search)
                ->orWhere('offender', $search)
                ->orWhere('ip_address', $search)
                ->orWhere('mac_address', $search);
        }
        $filter = $request->input('filter');
        if ($filter) {
            $punishments = $punishments->where('action_type', $filter);
        }
        return view('modcp.punishments.index', [
            'punishments' => $punishments->paginate(15),
        ]);
    }

    public function view(PunishmentAction $punishmentAction)
    {
        $proof = PunishmentActionProof::where('action_id', $punishmentAction->id)
            ->get()
            ->map(function($individualProof) {
            $individualProof->seo_member_name = Str::slug($individualProof->staff_member);
            return $individualProof;
        });
        return view('modcp.punishments.view',[
           'punishment' => $punishmentAction,
           'proof' => $proof
        ]);
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
        foreach($files as $file) {
            if(!in_array($file->getClientOriginalExtension(), config('modcp.accepted_punishment_file_types'))) {
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