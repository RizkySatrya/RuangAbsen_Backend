<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ImageStorage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AttendanceController extends Controller
{
    use ImageStorage;

    /**
     * Store presence status
     * @param Request $request
     * @return JsonResponse|void
     * @throws InvalidFormatException
     * @throws BindingResolutionException
     */
    public function store(Request $request)
    {
        $request->validate([
            'long' => ['required'],
            'lat' => ['required'],
            'address' => ['required'],
            'type' => ['in:in,out', 'required'],
            'photo' => ['required']
        ]);

        $photo = $request->file('photo');
        $attendanceType = $request->type;
        $userAttendanceToday = $request->user()
            ->attendances()
            ->whereDate('created_at', Carbon::today())
            ->first();

        // is presence type equal with 'in' ?
        if ($attendanceType == 'in') {
            // is $userPresenceToday not found?
            if (! $userAttendanceToday) {
                $attendance = $request
                    ->user()
                    ->attendances()
                    ->create(
                        [
                            'status' => false
                        ]
                    );

                $attendance->detail()->create(
                    [
                        'type' => 'in',
                        'long' => $request->long,
                        'lat' => $request->lat,
                        'photo' => $this->uploadImage($photo, $request->user()->name, 'attendance'),
                        'address' => $request->address
                    ]
                );

                return response()->json(
                    [
                        'message' => 'Sukses'
                    ],
                    Response::HTTP_CREATED
                );
            }

            // else show user has been checked in
            return response()->json(
                [
                    'message' => 'Pengguna sudah melakukan check in',
                ],
                Response::HTTP_OK
            );
        }

        if ($attendanceType == 'out') {
            if ($userAttendanceToday) {

                if ($userAttendanceToday->status) {
                    return response()->json(
                        [
                            'message' => 'Pengguna sudah melakukan check out',
                        ],
                        Response::HTTP_OK
                    );
                }

                $userAttendanceToday->update(
                    [
                        'status' => true
                    ]
                );

                $userAttendanceToday->detail()->create(
                    [
                        'type' => 'out',
                        'long' => $request->long,
                        'lat' => $request->lat,
                        'photo' => $this->uploadImage($photo, $request->user()->name, 'attendance'),
                        'address' => $request->address
                    ]
                );

                return response()->json(
                    [
                        'message' => 'Sukses'
                    ],
                    Response::HTTP_CREATED
                );
            }

            return response()->json(
                [
                    'message' => 'Silahkan check in terlebih dahulu',
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    /**
     * Get List Presences by User
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function history(Request $request)
    {
        $request->validate(
            [
                'from' => ['required'],
                'to' => ['required'],
            ]
        );

        $history = $request->user()->attendances()->with('detail')
            ->whereBetween(
                DB::raw('DATE(created_at)'),
                [
                    $request->from, $request->to
                ]
            )->get();

        return response()->json(
            [
                'message' => "Daftar presensi oleh pengguna",
                'data' => $history,
            ],
            Response::HTTP_OK
        );
    }
}