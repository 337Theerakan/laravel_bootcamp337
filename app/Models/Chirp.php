<?php
//ใช้ namespace เพื่อจัดการโครงสร้าง
namespace App\Models;
//ใช้สำหรับเปิดใช้งาน Factory ของ Laravel . การดึงข้อมูล การบันทึกข้อมูล . กำหนดประเภทความสัมพันธ์ BelongsTo
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chirp extends Model
//เก็ยข้อมูล
{
    use HasFactory;

    protected $fillable = [
        'message',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
