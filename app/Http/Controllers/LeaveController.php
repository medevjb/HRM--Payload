<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller {
    /**
     * Display a listing of the resource.
     */

    public function leavePage() {
        return view( 'Frontend.pages.dashboard.leave' );
    }

    public function getMyHistory( Request $request ) {
        $user_id = $request->header( 'id' );

        $leaveHistory = Leave::where( 'user_id', '=', $user_id )->get();

        if ( $leaveHistory->count() > 0 ) {
            return response()->json( [
                'status'  => 'success',
                'message' => 'Data Get Successfull',
                'data'    => $leaveHistory,
            ] );
        } else {
            return response()->json( [
                'status'  => 'error',
                'message' => 'No Leave History',
                'data'    => null,
            ] );
        }
    }

    public function createLeave( Request $request ) {
        $user_id = $request->header( 'id' );
        // $id = $request->input( 'id' ) ? $request->input( 'id' ) : null;

        // return $request->input( 'id' );

        $validator = Validator::make( $request->all(), [

            'leave_type' => 'required|string|max:30',
            'start_date' => 'required|string|max:100',
            'end_date'   => 'required|string|max:100',
            'reason'     => 'required|string|max:20',
        ] );

        if ( $validator->fails() ) {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Invallid Input',
                'error'   => $validator->errors(),
            ] );
        } else {
            $createLeave = Leave::updateOrCreate(
                ['id' => $request->input( 'id' )],
                [
                    'user_id'    => $user_id,
                    'leave_type' => $request->leave_type,
                    'start_date' => $request->start_date,
                    'end_date'   => $request->end_date,
                    'reason'     => $request->reason,
                    'status'     => 'pending',
                ],

            );

            if ( $createLeave ) {
                return response()->json( [
                    'status'  => 'success',
                    'message' => 'Application Created',
                    'data'    => $createLeave,
                ] );
            } else {
                return response()->json( [
                    'status'  => 'failed',
                    'message' => 'Something Went Wrong',
                    'data'    => null,
                ] );
            }
        }
    }

    // GEt Single User Data

    public function getSingleRecord( Request $request ) {
        $user_id = $request->header( 'id' );
        $id = $request->input( 'id' );

        $singleHistory = Leave::where( 'user_id', '=', $user_id )->where( 'id', '=', $id )->first();

        if ( $singleHistory ) {
            return response()->json( [
                'status'  => 'success',
                'message' => 'Data Get Successfull',
                'data'    => $singleHistory,
            ] );
        } else {
            return response()->json( [
                'status'  => 'error',
                'message' => 'No Leave History',
                'data'    => null,
            ] );
        }
    }

    public function deleteLeaveApplication( Request $request ) {

        $user_id = $request->header( 'id' );
        $id = $request->input( 'id' );

        $leaveData = Leave::where( 'user_id', '=', $user_id )->where( 'id', '=', $id )->first();

        if ( $leaveData ) {
            if ( $leaveData->status != 'approved' ) {
                $leaveData->delete();

                return response()->json( [
                    'status'  => 'success',
                    'message' => 'Application Cancled.',
                    'data'    => null,
                ] );

            } else {
                return response()->json( [
                    'status'  => 'failed',
                    'message' => 'This Application Already Approved.',
                    'data'    => null,
                ] );
            }
        } else {
            return response()->json( [
                'status'  => 'failed',
                'message' => 'Application Not Found',
                'data'    => null,
            ] );
        }

    }

    public function appprove( Request $request ) {
        $id = $request->input( 'id' );

        try {
            $application = Leave::where( 'id', '=', $id )->first();
            if ( $application->count() > 0 ) {

                if ( $application->status == 'approved' ) {
                    return response()->json( [
                        'status'  => 'error',
                        'message' => "Application Already Approved",
                    ] );
                } else {
                    $application->update( [
                        'status' => 'approved',
                    ] );
                    return response()->json( [
                        'status'  => 'success',
                        'message' => 'Application Approved',
                        'data'    => $application,
                    ] );
                }

            }
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'error',
                'message' => $e,
            ] );
        }

    }
    public function rejected( Request $request ) {
        $id = $request->input( 'id' );

        try {
            $application = Leave::where( 'id', '=', $id )->first();
            if ( $application->count() > 0 ) {

                if ( $application->status == 'approved' ) {
                    return response()->json( [
                        'status'  => 'error',
                        'message' => "Application Already Approved",
                    ] );
                } else if ( $application->status == 'rejected' ) {
                    return response()->json( [
                        'status'  => 'error',
                        'message' => "Application Already Rejected",
                    ] );
                } else {
                    $application->update( [
                        'status' => 'rejected',
                    ] );
                    return response()->json( [
                        'status'  => 'success',
                        'message' => 'Application Rejected',
                        'data'    => $application,
                    ] );
                }

            }
        } catch ( Exception $e ) {
            return response()->json( [
                'status'  => 'error',
                'message' => $e,
            ] );
        }

    }


    public function TestHeader(Request $request){
        return $request->header('role');
    }

}
