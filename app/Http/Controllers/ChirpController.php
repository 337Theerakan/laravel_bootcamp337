<?php
//ควบคุมการทำงาน เช่น สร้าง อ่าน แก้ไข และลบ Chirps:
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Chirp;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     * ใช้สำหรับแสดงข้อมูลในส่วนของ Frontend
     * ดึงข้อมูลของ Chirp โดยมีความสัมพันธ์กับ User (ผู้โพสต์) ซึ่งจะดึงแค่ id และ name ของผู้ใช้
     */
    public function index(): Response
    {
        //return response('Hello, World!');
        return Inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->latest()->get(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     * รอสร้าง เพิ่ม
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * บันทึกลงในฐานข้อมูล
     * ดึงข้อมูลผู้ใช้ จาก  $request->user() ซึ่งดึงข้อมูลที่ล็อกอิน)
     * เมื่อบันทึกเสร็จแล้ว ไปที่หน้ารายการ ___Chirp.index
     */
    public function store(Request $request): RedirectResponse
    {
        //
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * ฟังก์ชันนี้ ใช้สำหรับอัพเดต Chirp ที่มีอยู่แล้ว

     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * สั่งให้ไป ลบ (ข้อความ) the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse

    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
        }

}
